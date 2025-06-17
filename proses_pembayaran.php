<?php
session_start();
require_once 'database.php';

$db = (new Database())->connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengguna = $_POST['Id_Pengguna'];
    $subtotal = $_POST['Subtotal_Produk'];
    $total = $_POST['Total_Pembayaran'];

    // Simpan ke tabel pembayaran
    $stmt = $db->prepare("INSERT INTO pembayaran (Subtotal_Produk, Total_Pembayaran, Id_Pengguna) VALUES (?, ?, ?)");
    $stmt->execute([$subtotal, $total, $id_pengguna]);
    $id_pembayaran = $db->lastInsertId();

    // Update transaksi
    $update = $db->prepare("UPDATE transaksi SET Id_Pembayaran = ? WHERE Id_Pengguna = ? AND Id_Pembayaran IS NULL");
    $update->execute([$id_pembayaran, $id_pengguna]);

    // Redirect ke detail pembayaran
    header("Location: detail.php?id=$id_pembayaran");
    exit;
} else {
    echo "Permintaan tidak valid.";
}