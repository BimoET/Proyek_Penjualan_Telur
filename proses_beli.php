<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    
    

    echo "<h2>Transaksi Berhasil!</h2>";
    echo "<p>Produk: <strong>$nama_produk</strong></p>";
    echo "<p>Harga: <strong>Rp " . number_format($harga, 0, ',', '.') . "</strong></p>";
    echo "<p>Terima kasih telah berbelanja di Agen Telur Berkah Jaya!</p>";
    echo "<a href='belanja.html'>Kembali ke Toko</a>";
} else {
    echo "Akses tidak valid.";
}
?>