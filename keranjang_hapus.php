<?php
session_start();
require_once 'database.php';

$db = (new Database())->connection();
if ($_POST['aksi'] === 'hapus') {
    $stmt = $db->prepare("DELETE FROM transaksi WHERE Id_Pengguna = ? AND Id_Produk = ? AND Id_Pembayaran IS NULL");
    $stmt->execute([$_SESSION['Id_Pengguna'], $_POST['Id_Produk']]);
    header('Location: keranjangbelanja.php');
    exit;
}
?>