<?php
include __DIR__ . "/../server/database.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /server/login.php");
    exit;
}

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($fullname && $username && $email && $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Format email tidak valid.";
        } else {
            $check = $db->prepare("SELECT id_user FROM user WHERE username = ? OR email = ?");
            $check->bind_param("ss", $username, $email);
            $check->execute();
            $result = $check->get_result();

            if ($result && $result->num_rows > 0) {
                $error = "Username atau email sudah digunakan.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO user (fullname, username, email, password, role) VALUES (?, ?, ?, ?, 'admin')");
                $stmt->bind_param("ssss", $fullname, $username, $email, $hashedPassword);
                $stmt->execute();

                $success = $stmt->affected_rows > 0;
                if (!$success) $error = "Gagal menambahkan admin.";
            }
        }
    } else {
        $error = "Semua field wajib diisi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Admin</title>
    <link rel="stylesheet" href="/../assets/style/admin.css">
    <style>
        
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php">📋 Pesanan</a>
        <a href="tambah_admin.php">➕ Tambah Admin</a>
        <a href="kelola_menu.php">🛠️ Kelola Menu</a>
        <a href="laporan_keuangan.php">📊 Laporan Keuangan</a>
        <a href="/server/logout.php">🚪 Logout</a>
    </div>

    <div class="content">
        <h1>➕ Tambah Admin Baru</h1>

        <?php if ($success): ?>
            <p class="msg">✅ Admin berhasil ditambahkan!</p>
        <?php elseif ($error): ?>
            <p class="error">❌ <?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="tambah_admin.php">
            <div class="form-group">
                <label for="fullname">Nama Lengkap:</label><br>
                <input type="text" name="fullname" id="fullname" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label><br>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Tambah Admin</button>
        </form>
    </div>
</body>
</html>
