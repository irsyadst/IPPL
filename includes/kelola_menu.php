<?php
include __DIR__ . "/../server/database.php";
session_start();

// Ambil semua data menu
$result = mysqli_query($db, "SELECT * FROM menu");
$menus = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Menu</title>
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
        <h1>🛠️ Kelola Menu</h1>
        <a href="tambah_menu.php" class="add-btn">+ Tambah Menu</a>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menus as $menu): ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($menu['gambar']) ?>" alt="<?= htmlspecialchars($menu['nama_menu']) ?>" width="80">
                        </td>
                        <td><?= htmlspecialchars($menu['nama_menu']) ?></td>
                        <td>Rp. <?= number_format($menu['harga'], 0, ',', '.') ?></td>
                        <td>
                            <a href="edit_menu.php?id=<?= $menu['id_menu'] ?>">Edit</a> |
                            <a href="hapus_menu.php?id=<?= $menu['id_menu'] ?>" onclick="return confirm('Yakin mau hapus menu ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>

</html>

<?php $db->close(); ?>