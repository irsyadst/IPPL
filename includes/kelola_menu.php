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
    <style>
        .add-btn, .edit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            margin: 5px 0;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .add-btn {
            background-color: #2ecc71;
        }

        .edit-btn {
            background-color: #f39c12;
        }

        .add-btn:hover, .edit-btn:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }
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
    <div class="admin-dashboard">
        <h1>🛠️ Kelola Menu</h1>

        <!-- Tombol Tambah Menu -->
        <a href="tambah_menu.php" class="add-btn">+ Tambah Menu</a>

        <!-- Tabel Daftar Menu -->
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Status</th>
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
                            <form method="POST" action="update_status.php">
                                <input type="hidden" name="id_menu" value="<?= $menu['id_menu'] ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="aktif" <?= $menu['status'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="nonaktif" <?= $menu['status'] === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <!-- Hanya tombol Edit -->
                            <form method="get" action="edit_menu.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $menu['id_menu'] ?>">
                                <button type="submit" class="edit-btn">Edit</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php $db->close(); ?>
