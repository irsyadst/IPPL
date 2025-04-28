<?php
include __DIR__ . "/../server/database.php";
session_start();

if (!isset($_GET['id'])) {
    header("Location: kelola_menu.php");
    exit;
}

$id_menu = (int) $_GET['id'];

// Ambil data menu berdasarkan id
$stmt = $db->prepare("SELECT * FROM menu WHERE id_menu = ?");
$stmt->bind_param("i", $id_menu);
$stmt->execute();
$result = $stmt->get_result();
$menu = $result->fetch_assoc();

if (!$menu) {
    header("Location: kelola_menu.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_menu = trim($_POST['nama_menu']);
    $harga = (int) $_POST['harga'];
    $gambar = $menu['gambar']; // default gambar lama

    // Cek apakah upload file baru
    if (!empty($_FILES['gambar']['name'])) {
        $upload_dir = __DIR__ . '/../assets/img/';
        $gambar = 'menu_' . time() . '_' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $gambar);
    }

    $stmt = $db->prepare("UPDATE menu SET nama_menu = ?, harga = ?, gambar = ? WHERE id_menu = ?");
    $stmt->bind_param("sisi", $nama_menu, $harga, $gambar, $id_menu);
    $stmt->execute();

    header("Location: kelola_menu.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="/../assets/style/admin.css">
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
    <div class="admin-dashboard">
        <h1>✏️ Edit Menu</h1>

        <form method="POST" enctype="multipart/form-data">
            <label for="nama_menu">Nama Menu:</label><br>
            <input type="text" name="nama_menu" id="nama_menu" value="<?= htmlspecialchars($menu['nama_menu']) ?>" required><br><br>

            <label for="harga">Harga:</label><br>
            <input type="number" name="harga" id="harga" value="<?= htmlspecialchars($menu['harga']) ?>" required><br><br>

            <label for="gambar">Ganti Gambar (optional):</label><br>
            <input type="file" name="gambar" id="gambar"><br><br>

            <button type="submit">Update Menu</button>
        </form>

        <p><a href="kelola_menu.php">← Kembali ke Kelola Menu</a></p>
    </div>
</body>

</html>