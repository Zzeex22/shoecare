<?php
require 'koneksi.php';

// Jika sudah login, lempar ke dashboard masing-masing
if (isset($_SESSION['user_id'])) {
    header("Location: " . ($_SESSION['role'] == 'admin' ? 'dashboard_admin.php' : 'dashboard_pelanggan.php'));
    exit;
}

// Proses Login
if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['nama'] = $row['nama_lengkap'];
        header("Location: " . ($row['role'] == 'admin' ? 'dashboard_admin.php' : 'dashboard_pelanggan.php'));
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - ShoeCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{mahogany:'#C04000',shoeBlue:'#1E3A8A'}}}}</script>
</head>
<body class="bg-blue-50 flex items-center justify-center h-screen px-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-shoeBlue">ShoeCare Login</h2>
            <?php if(isset($error)) echo "<p class='text-red-500 text-sm mt-2'>$error</p>"; ?>
        </div>
        <form method="POST" action="">
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-1">Username</label>
                <input type="text" name="username" required class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-mahogany outline-none bg-gray-50">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-mahogany outline-none bg-gray-50">
            </div>
            <button type="submit" name="login" class="w-full bg-mahogany text-white font-bold py-3 rounded-lg hover:bg-[#A63300] transition">Masuk</button>
        </form>
        <div class="mt-4 text-center text-sm"><a href="index.php" class="text-gray-500 hover:text-shoeBlue">&larr; Kembali ke Beranda</a></div>
    </div>
</body>
</html>