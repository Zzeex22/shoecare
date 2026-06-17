<?php
require 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'pelanggan') { header("Location: login.php"); exit; }

// Handle Form Pemesanan
if (isset($_POST['buat_pesanan'])) {
    $user_id = $_SESSION['user_id'];
    $layanan = $conn->real_escape_string($_POST['layanan']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $pembayaran = $conn->real_escape_string($_POST['pembayaran']);
    $harga = ($layanan == 'Cuci Reguler') ? 35000 : (($layanan == 'Cuci Express') ? 50000 : 80000);
    $kode = "SC-" . rand(1000, 9999);
    
    $conn->query("INSERT INTO orders (user_id, kode_order, jenis_layanan, alamat_jemput, metode_pembayaran, harga, status) VALUES ('$user_id', '$kode', '$layanan', '$alamat', '$pembayaran', '$harga', 'Menunggu Konfirmasi')");
    header("Location: dashboard_pelanggan.php?pg=riwayat&msg=success"); exit;
}

$pg = $_GET['pg'] ?? 'dashboard';
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Member Area - ShoeCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{mahogany:'#C04000',shoeBlue:'#1E3A8A'}}}}</script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">

    <!-- SIDEBAR PELANGGAN -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between hidden md:flex z-10">
        <div>
            <div class="p-6 border-b border-gray-100 flex items-center gap-3">
                <span class="text-2xl bg-shoeBlue text-white p-2 rounded-xl shadow-sm">👟</span>
                <div><h1 class="font-extrabold text-lg text-shoeBlue tracking-wide">ShoeCare.</h1></div>
            </div>
            <nav class="p-4 space-y-2 mt-2">
                <a href="?pg=dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition <?= $pg=='dashboard' ? 'bg-blue-50 text-shoeBlue border-r-4 border-shoeBlue' : 'text-gray-500 hover:bg-gray-50' ?>">🏠 Beranda Member</a>
                <a href="?pg=pesan" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition <?= $pg=='pesan' ? 'bg-blue-50 text-shoeBlue border-r-4 border-shoeBlue' : 'text-gray-500 hover:bg-gray-50' ?>">🛵 Buat Pesanan Baru</a>
                <a href="?pg=riwayat" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition <?= $pg=='riwayat' ? 'bg-blue-50 text-shoeBlue border-r-4 border-shoeBlue' : 'text-gray-500 hover:bg-gray-50' ?>">📜 Riwayat Pesanan</a>
                <a href="?pg=profil" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition <?= $pg=='profil' ? 'bg-blue-50 text-shoeBlue border-r-4 border-shoeBlue' : 'text-gray-500 hover:bg-gray-50' ?>">⚙️ Pengaturan Profil</a>
            </nav>
        </div>
        <div class="p-6 border-t border-gray-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-shoeBlue text-white rounded-full flex items-center justify-center font-bold"><?= substr($_SESSION['nama'],0,1) ?></div>
                <div class="text-sm"><p class="font-bold text-gray-800 truncate"><?= $_SESSION['nama'] ?></p><p class="text-xs text-gray-500">Pelanggan</p></div>
            </div>
            <a href="logout.php" class="block w-full text-center border border-red-200 text-red-500 hover:bg-red-50 py-2 rounded-lg transition text-sm font-bold">Logout</a>
        </div>
    </aside>

    <!-- MAIN CONTENT PELANGGAN -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-5 flex items-center justify-between sticky top-0 z-10">
            <h2 class="text-xl font-bold text-gray-800 capitalize"><?= str_replace('_', ' ', $pg) ?></h2>
            <?php if($pg != 'pesan'): ?>
                <a href="?pg=pesan" class="bg-mahogany text-white px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-[#A63300] transition">+ Pesan Layanan</a>
            <?php endif; ?>
        </header>

        <div class="p-8 max-w-5xl">
            <?php 
            // ==========================================
            // HALAMAN DASHBOARD USER
            // ==========================================
            if ($pg == 'dashboard'): 
            ?>
                <div class="bg-gradient-to-r from-shoeBlue to-blue-900 rounded-3xl p-8 text-white shadow-lg mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="text-3xl font-extrabold mb-2">Selamat Datang, <?= explode(' ', $_SESSION['nama'])[0] ?>!</h2>
                        <p class="text-blue-200 mb-6 max-w-md text-sm leading-relaxed">Saatnya percayakan perawatan sepatu Anda kepada kami. Layanan antar-jemput profesional siap membantu keseharian Anda.</p>
                        <a href="?pg=pesan" class="bg-white text-shoeBlue px-6 py-3 rounded-full font-bold shadow-md hover:bg-gray-50 transition">Buat Pesanan Sekarang</a>
                    </div>
                    <div class="text-8xl hidden md:block opacity-90 drop-shadow-2xl">👟</div>
                </div>

            <?php 
            // ==========================================
            // HALAMAN BUAT PESANAN BARU
            // ==========================================
            elseif ($pg == 'pesan'): 
            ?>
                <div class="bg-white rounded-2xl shadow-sm border p-8">
                    <h3 class="font-extrabold text-xl text-shoeBlue mb-6 border-b pb-4">Formulir Layanan Antar-Jemput</h3>
                    <form method="POST" action="" class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Jenis Layanan Pencucian</label>
                                <select name="layanan" required class="w-full border-2 border-gray-200 rounded-xl p-3 text-gray-700 focus:border-mahogany outline-none bg-gray-50 transition">
                                    <option value="" disabled selected>-- Pilih Layanan --</option>
                                    <option value="Cuci Reguler">Cuci Reguler (Estimasi 3 Hari) - Rp 35.000</option>
                                    <option value="Cuci Express">Cuci Express (1 Hari Selesai) - Rp 50.000</option>
                                    <option value="Premium Treatment">Premium Treatment (Bahan Khusus) - Rp 80.000</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Metode Pembayaran</label>
                                <select name="pembayaran" required class="w-full border-2 border-gray-200 rounded-xl p-3 text-gray-700 focus:border-mahogany outline-none bg-gray-50 transition">
                                    <option value="COD (Bayar ke Kurir)">Bayar Tunai ke Kurir (COD)</option>
                                    <option value="Transfer Bank / QRIS">Transfer Bank / E-Wallet (QRIS)</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap Penjemputan</label>
                            <textarea name="alamat" rows="3" required placeholder="Contoh: Jl. Pancing Raya No.12 (Kost Biru, Kamar 4), Medan. Patokan depan Indomaret." class="w-full border-2 border-gray-200 rounded-xl p-3 text-gray-700 focus:border-mahogany outline-none bg-gray-50 transition"></textarea>
                            <p class="text-xs text-mahogany font-medium mt-1">*Mohon sertakan patokan yang jelas untuk memudahkan kurir.</p>
                        </div>
                        <button type="submit" name="buat_pesanan" class="w-full bg-mahogany text-white font-bold py-4 rounded-xl hover:bg-[#A63300] transition shadow-lg text-lg">Konfirmasi & Panggil Kurir Sekarang</button>
                    </form>
                </div>

            <?php 
            // ==========================================
            // HALAMAN RIWAYAT PESANAN
            // ==========================================
            elseif ($pg == 'riwayat'): 
                if(isset($_GET['msg']) && $_GET['msg'] == 'success') {
                    echo "<div class='bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold border border-green-200'>✅ Pesanan berhasil dibuat! Menunggu verifikasi admin.</div>";
                }
                $orders = $conn->query("SELECT * FROM orders WHERE user_id=$user_id ORDER BY id DESC");
            ?>
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-600 border-b"><tr><th class="p-5 font-bold uppercase text-xs">ID Pesanan</th><th class="p-5 font-bold uppercase text-xs">Rincian Layanan</th><th class="p-5 font-bold uppercase text-xs">Total Biaya</th><th class="p-5 font-bold uppercase text-xs">Status Terkini</th></tr></thead>
                        <tbody class="divide-y text-gray-700">
                            <?php if($orders->num_rows > 0): while($row = $orders->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5 font-extrabold text-shoeBlue text-base">#<?= $row['kode_order'] ?></td>
                                <td class="p-5 font-semibold"><?= $row['jenis_layanan'] ?><br><span class="font-normal text-xs text-gray-500"><?= date('d M Y H:i', strtotime($row['tanggal_masuk'])) ?></span></td>
                                <td class="p-5 font-bold">Rp <?= number_format($row['harga'],0,',','.') ?></td>
                                <td class="p-5">
                                    <?php 
                                        $bg = 'bg-gray-100 text-gray-700 border-gray-200';
                                        if($row['status'] == 'Menunggu Konfirmasi') $bg = 'bg-yellow-50 text-yellow-700 border-yellow-200';
                                        if($row['status'] == 'Menunggu Pickup') $bg = 'bg-orange-50 text-orange-700 border-orange-200';
                                        if($row['status'] == 'Sedang Dicuci') $bg = 'bg-blue-50 text-blue-700 border-blue-200';
                                        if($row['status'] == 'Selesai') $bg = 'bg-green-50 text-green-700 border-green-200';
                                        if($row['status'] == 'Dibatalkan Admin') $bg = 'bg-red-50 text-red-700 border-red-200';
                                    ?>
                                    <span class="<?= $bg ?> px-3 py-1.5 rounded-full text-xs font-bold border"><?= $row['status'] ?></span>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                            <tr><td colspan="4" class="p-8 text-center text-gray-400 font-medium">Anda belum memiliki riwayat pesanan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php 
            elseif ($pg == 'profil'):
                echo "<div class='bg-white p-8 rounded-2xl shadow border text-center text-gray-500'>Halaman Pengaturan Profil (Under Construction)</div>";
            endif; 
            ?>
        </div>
    </main>
</body>
</html>