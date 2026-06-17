<?php
require 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') { header("Location: login.php"); exit; }

// Handle Update Status Operasional
if (isset($_GET['action']) && $_GET['action'] == 'update_status') {
    $id = (int)$_GET['id'];
    $status = $conn->real_escape_string($_GET['status']);
    $conn->query("UPDATE orders SET status='$status' WHERE id=$id");
    
    $redirect = $_GET['pg'] ?? 'operasional';
    header("Location: dashboard_admin.php?pg=$redirect"); exit;
}

// Handle Tambah SDM (Karyawan/Kurir)
if (isset($_POST['tambah_sdm'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $user = $conn->real_escape_string($_POST['username']);
    $pass = $_POST['password']; // Ingat: untuk real app pakai password_hash()
    $role_sdm = $conn->real_escape_string($_POST['role_sdm']);
    
    $conn->query("INSERT INTO users (nama_lengkap, username, password, role) VALUES ('$nama', '$user', '$pass', '$role_sdm')");
    header("Location: dashboard_admin.php?pg=sdm&msg=success"); exit;
}

// Handle Hapus SDM
if (isset($_GET['action']) && $_GET['action'] == 'hapus_sdm') {
    $id = (int)$_GET['id'];
    if($id != $_SESSION['user_id']) { // Cegah admin hapus dirinya sendiri
        $conn->query("DELETE FROM users WHERE id=$id");
    }
    header("Location: dashboard_admin.php?pg=sdm"); exit;
}

$pg = $_GET['pg'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Panel - ShoeCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Tema Baru: Fresh, Clean, and Soft (Kalem di mata)
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        freshGreen: { DEFAULT: '#10B981', hover: '#059669', light: '#D1FAE5' }, // Emerald
                        darkSlate: { DEFAULT: '#1E293B', light: '#334155' } // Slate
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800 font-sans">

    <!-- SIDEBAR ADMIN (Dark Slate - Elegan & Gak Bikin Sakit Mata) -->
    <aside class="w-64 bg-darkSlate text-slate-300 flex flex-col justify-between hidden md:flex shadow-2xl z-10">
        <div>
            <div class="p-6 border-b border-slate-700 flex items-center gap-3">
                <span class="text-2xl bg-freshGreen text-white p-2 rounded-xl shadow-lg">👟</span>
                <div>
                    <h1 class="font-extrabold text-lg tracking-wide text-white">ShoeCare.</h1>
                    <p class="text-xs text-slate-400 font-medium">Control Panel</p>
                </div>
            </div>
            <nav class="p-4 space-y-1 mt-2">
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-4">Statistik</p>
                <a href="?pg=dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition <?= $pg=='dashboard' ? 'bg-freshGreen text-white shadow-md' : 'hover:bg-darkSlate-light hover:text-white' ?>">📊 Dashboard</a>
                
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-6">Manajemen Cuci</p>
                <a href="?pg=verifikasi" class="flex items-center justify-between px-4 py-3 rounded-xl font-medium transition <?= $pg=='verifikasi' ? 'bg-freshGreen text-white shadow-md' : 'hover:bg-darkSlate-light hover:text-white' ?>">
                    <div class="flex items-center gap-3">✅ Verifikasi</div>
                    <?php 
                        $cek_pending = $conn->query("SELECT COUNT(id) as c FROM orders WHERE status='Menunggu Konfirmasi'")->fetch_assoc()['c'];
                        if($cek_pending > 0) echo "<span class='bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full'>$cek_pending</span>";
                    ?>
                </a>
                <a href="?pg=operasional" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition <?= $pg=='operasional' ? 'bg-freshGreen text-white shadow-md' : 'hover:bg-darkSlate-light hover:text-white' ?>">🛵 Operasional</a>
                
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-6">Administrasi</p>
                <a href="?pg=sdm" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition <?= $pg=='sdm' ? 'bg-freshGreen text-white shadow-md' : 'hover:bg-darkSlate-light hover:text-white' ?>">👥 Data Karyawan</a>
                <a href="?pg=keuangan" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition <?= $pg=='keuangan' ? 'bg-freshGreen text-white shadow-md' : 'hover:bg-darkSlate-light hover:text-white' ?>">💰 Rekap Keuangan</a>
            </nav>
        </div>
        <div class="p-6 border-t border-slate-700">
            <a href="logout.php" class="block w-full text-center bg-slate-800 border border-slate-600 text-slate-300 hover:bg-red-500 hover:text-white py-2.5 rounded-xl transition text-sm font-bold shadow">Keluar Akun</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-200 px-8 py-5 flex justify-between items-center sticky top-0 z-10">
            <h2 class="text-xl font-extrabold text-slate-800 capitalize"><?= str_replace('_', ' ', $pg) ?></h2>
            <div class="flex items-center gap-3 bg-slate-100 px-4 py-2 rounded-full border border-slate-200 shadow-sm">
                <div class="w-2 h-2 bg-freshGreen rounded-full animate-pulse"></div>
                <span class="font-bold text-xs text-slate-600">Admin: <?= $_SESSION['nama'] ?></span>
            </div>
        </header>

        <div class="p-8 max-w-7xl mx-auto w-full">
            <?php 
            // ==========================================
            // HALAMAN DASHBOARD
            // ==========================================
            if ($pg == 'dashboard'): 
                $tot_pendapatan = $conn->query("SELECT SUM(harga) as t FROM orders WHERE status='Selesai'")->fetch_assoc()['t'] ?? 0;
                $tot_pesanan = $conn->query("SELECT COUNT(id) as c FROM orders")->fetch_assoc()['c'] ?? 0;
                $tot_karyawan = $conn->query("SELECT COUNT(id) as c FROM users WHERE role IN ('admin', 'kurir')")->fetch_assoc()['c'] ?? 0;
            ?>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center">
                        <div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Pesanan</p><h3 class="text-3xl font-extrabold text-slate-700 mt-1"><?= $tot_pesanan ?></h3></div>
                        <div class="text-3xl bg-blue-50 p-3 rounded-2xl">📦</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center">
                        <div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Perlu Verifikasi</p><h3 class="text-3xl font-extrabold text-orange-500 mt-1"><?= $cek_pending ?></h3></div>
                        <div class="text-3xl bg-orange-50 p-3 rounded-2xl">⏳</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center">
                        <div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Staf/Kurir</p><h3 class="text-3xl font-extrabold text-indigo-500 mt-1"><?= $tot_karyawan ?></h3></div>
                        <div class="text-3xl bg-indigo-50 p-3 rounded-2xl">👥</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center">
                        <div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Pendapatan Bersih</p><h3 class="text-2xl font-extrabold text-freshGreen mt-1">Rp <?= number_format($tot_pendapatan,0,',','.') ?></h3></div>
                        <div class="text-3xl bg-freshGreen-light p-3 rounded-2xl">💰</div>
                    </div>
                </div>

            <?php 
            // ==========================================
            // HALAMAN VERIFIKASI PESANAN
            // ==========================================
            elseif ($pg == 'verifikasi'): 
                $orders = $conn->query("SELECT o.*, u.nama_lengkap FROM orders o JOIN users u ON o.user_id = u.id WHERE o.status='Menunggu Konfirmasi' ORDER BY o.id ASC");
            ?>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50"><h3 class="font-bold text-slate-700">Antrean Pesanan Menunggu ACC</h3></div>
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500 border-b border-slate-200"><tr><th class="p-4 font-bold uppercase text-xs">Detail Pelanggan</th><th class="p-4 font-bold uppercase text-xs">Layanan & Harga</th><th class="p-4 font-bold uppercase text-xs">Pembayaran</th><th class="p-4 font-bold uppercase text-xs text-center">Aksi Verifikasi</th></tr></thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            <?php if($orders->num_rows > 0): while($row = $orders->fetch_assoc()): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4">
                                    <div class="font-bold text-slate-800">#<?= $row['kode_order'] ?> - <?= htmlspecialchars($row['nama_lengkap']) ?></div>
                                    <div class="text-xs text-slate-500 mt-1 max-w-xs leading-relaxed">📍 <?= htmlspecialchars($row['alamat_jemput']) ?></div>
                                </td>
                                <td class="p-4"><span class="font-bold text-slate-700"><?= $row['jenis_layanan'] ?></span><br><span class="text-xs text-freshGreen font-bold">Rp <?= number_format($row['harga'],0,',','.') ?></span></td>
                                <td class="p-4"><span class="bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg text-xs font-bold"><?= $row['metode_pembayaran'] ?></span></td>
                                <td class="p-4 text-center space-x-2">
                                    <a href="?action=update_status&pg=verifikasi&id=<?= $row['id'] ?>&status=Menunggu Pickup" class="inline-block bg-freshGreen text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-freshGreen-hover shadow-sm transition">Terima & Jadwalkan</a>
                                    <a href="?action=update_status&pg=verifikasi&id=<?= $row['id'] ?>&status=Dibatalkan Admin" class="inline-block bg-red-50 text-red-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-100 transition">Tolak</a>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                            <tr><td colspan="4" class="p-10 text-center text-slate-400 font-medium bg-slate-50/30">Semua pesanan sudah diverifikasi. Kosong nih lek! 🎉</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            <?php 
            // ==========================================
            // HALAMAN MANAJEMEN OPERASIONAL
            // ==========================================
            elseif ($pg == 'operasional'): 
                $orders = $conn->query("SELECT o.*, u.nama_lengkap FROM orders o JOIN users u ON o.user_id = u.id WHERE o.status IN ('Menunggu Pickup', 'Sedang Dicuci') ORDER BY o.id ASC");
            ?>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50"><h3 class="font-bold text-slate-700">Tracking Proses Pencucian Aktif</h3></div>
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500 border-b border-slate-200"><tr><th class="p-4 font-bold uppercase text-xs">ID Pesanan</th><th class="p-4 font-bold uppercase text-xs">Pelanggan</th><th class="p-4 font-bold uppercase text-xs">Status Terkini</th><th class="p-4 font-bold uppercase text-xs">Aksi Update</th></tr></thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            <?php while($row = $orders->fetch_assoc()): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 font-extrabold text-slate-800">#<?= $row['kode_order'] ?></td>
                                <td class="p-4 font-medium text-slate-700"><?= htmlspecialchars($row['nama_lengkap']) ?><br><span class="text-xs text-slate-400"><?= $row['jenis_layanan'] ?></span></td>
                                <td class="p-4">
                                    <span class="px-3 py-1.5 rounded-full text-[10px] uppercase tracking-wider font-extrabold 
                                        <?= $row['status'] == 'Menunggu Pickup' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                                <td class="p-4">
                                    <?php if($row['status'] == 'Menunggu Pickup'): ?>
                                        <a href="?action=update_status&pg=operasional&id=<?= $row['id'] ?>&status=Sedang Dicuci" class="bg-blue-500 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-600 shadow-sm transition">Tandai Tiba (Mulai Cuci)</a>
                                    <?php elseif($row['status'] == 'Sedang Dicuci'): ?>
                                        <a href="?action=update_status&pg=operasional&id=<?= $row['id'] ?>&status=Selesai" class="bg-freshGreen text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-freshGreen-hover shadow-sm transition">Pencucian Selesai</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            <?php 
            // ==========================================
            // HALAMAN MANAJEMEN SDM & KURIR
            // ==========================================
            elseif ($pg == 'sdm'): 
                if(isset($_GET['msg']) && $_GET['msg'] == 'success') {
                    echo "<div class='bg-freshGreen-light text-freshGreen-hover p-4 rounded-xl mb-6 font-bold border border-freshGreen'>✅ Karyawan baru berhasil ditambahkan!</div>";
                }
                $sdm_data = $conn->query("SELECT * FROM users WHERE role IN ('admin', 'kurir') ORDER BY role ASC, id DESC");
            ?>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Form Tambah Karyawan -->
                    <div class="md:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 h-fit">
                        <h3 class="font-bold text-slate-800 mb-5 pb-3 border-b border-slate-100">Tambah Staf Baru</h3>
                        <form method="POST" action="" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1 uppercase tracking-wide">Nama Lengkap</label>
                                <input type="text" name="nama" required class="w-full border border-slate-200 p-2.5 rounded-xl bg-slate-50 focus:border-freshGreen outline-none transition text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1 uppercase tracking-wide">Username Akun</label>
                                <input type="text" name="username" required class="w-full border border-slate-200 p-2.5 rounded-xl bg-slate-50 focus:border-freshGreen outline-none transition text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1 uppercase tracking-wide">Password Default</label>
                                <input type="password" name="password" required class="w-full border border-slate-200 p-2.5 rounded-xl bg-slate-50 focus:border-freshGreen outline-none transition text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1 uppercase tracking-wide">Posisi / Role</label>
                                <select name="role_sdm" required class="w-full border border-slate-200 p-2.5 rounded-xl bg-slate-50 focus:border-freshGreen outline-none transition text-sm font-semibold">
                                    <option value="kurir">Kurir (Operasional)</option>
                                    <option value="admin">Admin (Kantor/Toko)</option>
                                </select>
                            </div>
                            <button type="submit" name="tambah_sdm" class="w-full bg-slate-800 text-white font-bold py-3 rounded-xl hover:bg-slate-700 transition shadow-md mt-2">Simpan Data Staf</button>
                        </form>
                    </div>

                    <!-- Tabel Daftar Karyawan -->
                    <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50"><h3 class="font-bold text-slate-700">Daftar Karyawan Aktif</h3></div>
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-500 border-b border-slate-200"><tr><th class="p-4 font-bold uppercase text-xs">Nama Staf</th><th class="p-4 font-bold uppercase text-xs">Username</th><th class="p-4 font-bold uppercase text-xs">Posisi</th><th class="p-4 font-bold uppercase text-xs text-center">Aksi</th></tr></thead>
                            <tbody class="divide-y divide-slate-100 text-slate-600">
                                <?php while($row = $sdm_data->fetch_assoc()): ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-4 font-bold text-slate-800"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                                    <td class="p-4 font-mono text-slate-500 text-xs">@<?= $row['username'] ?></td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-extrabold 
                                            <?= $row['role'] == 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-200 text-slate-700' ?>">
                                            <?= $row['role'] ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <?php if($row['id'] != $_SESSION['user_id']): ?>
                                            <a href="?action=hapus_sdm&pg=sdm&id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus staf ini?')" class="text-xs text-red-500 font-bold hover:underline bg-red-50 px-3 py-1.5 rounded-lg">Pecat / Hapus</a>
                                        <?php else: ?>
                                            <span class="text-xs text-slate-400 font-medium italic">Akun Anda</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php 
            // ==========================================
            // HALAMAN LAPORAN KEUANGAN
            // ==========================================
            elseif ($pg == 'keuangan'): 
                $orders = $conn->query("SELECT kode_order, tanggal_masuk, jenis_layanan, metode_pembayaran, harga FROM orders WHERE status='Selesai' ORDER BY tanggal_masuk DESC");
            ?>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800">Buku Besar: Transaksi Selesai</h3>
                        <button class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 text-xs font-bold rounded-xl shadow-sm transition">⬇️ Unduh CSV</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-100 text-slate-600 border-b border-slate-300">
                                <tr>
                                    <th class="p-4 border-r border-slate-200 font-extrabold uppercase text-[10px] tracking-wider">No. Order</th>
                                    <th class="p-4 border-r border-slate-200 font-extrabold uppercase text-[10px] tracking-wider">Tgl. Selesai</th>
                                    <th class="p-4 border-r border-slate-200 font-extrabold uppercase text-[10px] tracking-wider">Kategori Layanan</th>
                                    <th class="p-4 border-r border-slate-200 font-extrabold uppercase text-[10px] tracking-wider">Tipe Pembayaran</th>
                                    <th class="p-4 font-extrabold uppercase text-[10px] tracking-wider text-right">Nominal Masuk (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-700">
                                <?php 
                                $total_calc = 0;
                                while($row = $orders->fetch_assoc()): 
                                    $total_calc += $row['harga'];
                                ?>
                                <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                                    <td class="p-4 border-r border-slate-100 font-mono text-xs font-bold text-slate-600">#<?= $row['kode_order'] ?></td>
                                    <td class="p-4 border-r border-slate-100 text-xs"><?= date('d/m/Y H:i', strtotime($row['tanggal_masuk'])) ?></td>
                                    <td class="p-4 border-r border-slate-100 font-medium"><?= $row['jenis_layanan'] ?></td>
                                    <td class="p-4 border-r border-slate-100 text-xs font-semibold text-slate-500"><?= $row['metode_pembayaran'] ?></td>
                                    <td class="p-4 text-right font-mono text-sm font-bold text-freshGreen bg-freshGreen-light/10">
                                        <?= number_format($row['harga'],0,',','.') ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot class="bg-slate-50 border-t-2 border-slate-200">
                                <tr>
                                    <td colspan="4" class="p-4 font-extrabold text-right text-slate-600 uppercase tracking-wider text-xs">Total Pendapatan Terkalkulasi :</td>
                                    <td class="p-4 font-bold text-right text-freshGreen font-mono text-lg bg-freshGreen-light/30">Rp <?= number_format($total_calc,0,',','.') ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>