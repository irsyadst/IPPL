<?php
include __DIR__ . "/../server/database.php";
session_start();

if (!isset($_GET['id'])) {
    header("Location: kelola_menu.php");
    exit;
}

$id_menu = (int) $_GET['id'];

// Hapus menu berdasarkan id
$stmt = $db->prepare("DELETE FROM menu WHERE id_menu = ?");
$stmt->bind_param("i", $id_menu);
$stmt->execute();

header("Location: kelola_menu.php");
exit;
?>
