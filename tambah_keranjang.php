<?php
session_start();
require_once 'database.php';

$db = (new Database())->connection();

if (!isset($_SESSION['Id_Pengguna'])) {
    die("⚠ Silakan login terlebih dahulu.");
}

$id_pengguna = $_SESSION['Id_Pengguna'];
$id_produk = $_POST['Id_Produk'] ?? null;
$jumlah = 1;


$cekUser = $db->prepare("SELECT * FROM t_pengguna WHERE Id_Pengguna = ?");
$cekUser->execute([$id_pengguna]);


$stmt = $db->prepare("SELECT * FROM transaksi WHERE Id_Pengguna = ? AND Id_Produk = ? AND Id_Pembayaran IS NULL");
$stmt->execute([$id_pengguna, $id_produk]);
$data = $stmt->fetch();

if ($data) {
    $update = $db->prepare("UPDATE transaksi SET Jumlah = Jumlah + ? WHERE Id_Pengguna = ? AND Id_Produk = ? AND Id_Pembayaran IS NULL");
    $update->execute([$jumlah, $id_pengguna, $id_produk]);
} else {
    $insert = $db->prepare("INSERT INTO transaksi(Id_Pengguna, Id_Produk, Jumlah, Id_Pembayaran) VALUES (?, ?, ?, NULL)");
    $insert->execute([$id_pengguna, $id_produk, $jumlah]);
}


header("Location: produk.php");
exit;


?>