<?php
include __DIR__ . "/../server/database.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /server/login.php");
    exit;
}

$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_menu = trim($_POST['nama_menu']);
    $harga = (int) $_POST['harga'];
    $gambar = $_FILES['gambar'];

    if (!empty($nama_menu) && $harga > 0 && $gambar['error'] === 0) {
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($gambar['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowedExt)) {
            $uploadDir = __DIR__ . '/../assets/img/menu/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = uniqid('menu_') . '.' . $ext;
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($gambar['tmp_name'], $filePath)) {
                // Simpan ke DB
                $gambar_path = "/assets/img/menu/" . $fileName;
                $sql = "INSERT INTO menu (nama_menu, harga, gambar) VALUES (?, ?, ?)";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("sis", $nama_menu, $harga, $gambar_path);

                if ($stmt->execute()) {
                    $success = true;
                } else {
                    $error = "Gagal menyimpan ke database.";
                }
            } else {
                $error = "Gagal mengupload gambar.";
            }
        } else {
            $error = "Format gambar tidak valid (jpg, jpeg, png, webp).";
        }
    } else {
        $error = "Semua field wajib diisi dan pilih gambar.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu</title>
    <link rel="stylesheet" href="/../assets/style/admin.css">
    <style>
        body {
            display: flex; /* Menjadikan body sebagai flex container */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 220px; 
            background-color: #2c3e50; 
            color: white;
            height: 100vh; /* Memastikan sidebar memiliki tinggi penuh */
            padding: 20px; 
            box-sizing: border-box;
            display: flex;
            flex-direction: column; /* Menata item di dalam sidebar secara vertikal */
        }

        .sidebar h2 {
            font-size: 24px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 15px 0;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: #34495e;
            padding-left: 10px;
        }

        .content {
            flex-grow: 1; /* Membuat konten mengisi ruang yang tersedia */
            margin-left: 240px; /* Memberikan jarak antara sidebar dan konten */
            padding: 30px;
            width: 100%;
            box-sizing: border-box;
        }

        form {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
        }

        label, input {
            display: block;
            margin-bottom: 10px;
            width: 100%;
        }

        input[type="text"], input[type="number"], input[type="file"] {
            padding: 8px;
        }

        button {
            background-color: #2ecc71;
            border: none;
            padding: 10px 20px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .success {
            color: green;
            margin-top: 10px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .back-btn {
            background-color: #3498db; /* Biru */
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            margin-left: 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .back-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php">📋 Pesanan</a>
        <a href="tambah_admin.php">➕ Tambah Admin</a>
        <a href="tambah_menu.php">🍜 Tambah Menu</a>
        <a href="laporan_keuangan.php">📊 Laporan Keuangan</a>
        <a href="/server/logout.php">🚪 Logout</a>
    </div>

    <div class="content">
        <h1>🍜 Tambah Menu</h1>

        <form method="POST" enctype="multipart/form-data">
            <label for="nama_menu">Nama Menu:</label>
            <input type="text" name="nama_menu" id="nama_menu" required>

            <label for="harga">Harga (Rp):</label>
            <input type="number" name="harga" id="harga" required>

            <label for="gambar">Upload Gambar Menu:</label>
            <input type="file" name="gambar" id="gambar" accept="image/*" required>

            <button type="submit">Simpan</button>

            <?php if ($success): ?>
                <p class="success">✅ Menu berhasil ditambahkan!</p>
            <?php elseif (!empty($error)): ?>
                <p class="error">❌ <?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </form>

        <!-- Tombol Kembali ke Kelola Menu -->
        <a href="kelola_menu.php" class="back-btn">← Kembali ke Kelola Menu</a>
    </div>
</body>
</html>

<?php
$db->close();
?>
