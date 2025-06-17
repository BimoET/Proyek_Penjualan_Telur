<?php
session_start();
if (!isset($_SESSION["Email_Admin"])) {
    header("Location: index.php");
    exit();
}
require_once 'database.php';
$db = (new Database())->connection();
$stmt = $db->query("SELECT * FROM produk");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$no = 1;


if (isset($_GET["Id_Produk"])){

    $id = $_GET["Id_Produk"];

    $query = "DELETE FROM produk WHERE Id_Produk = ?";
    $statement = $db->prepare($query);

    if ($statement->execute([$id])) {
        header("location:manajemen_produk.php");
        exit();
    } else {
        $errorInfo = $statement->errorInfo();
        die("Error saat menghapus data: " . $errorInfo[2]);
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,
100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        background-color: #fff;
    }

    table thead tr {
        background-color: #f2f2f2;
    }

    table th,
    table td {
        border: 1px solid #ddd;
        padding: 10px 12px;
        text-align: left;
        vertical-align: middle;
    }

    table tbody tr:hover {
        background-color: #e9f5e9;
    }

    table img {
        max-width: 80px;
        height: auto;
        border-radius: 5px;
        display: block;
    }

    a.action-link {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
        margin-right: 8px;
    }
  
    a.action-link:hover {
        text-decoration: underline;
    }
    .admin-navbar a{
        text-decoration: none;
        border: 1px solid black;
        padding: 6px;
        border-radius: 5px;
        color: black;
    }
    .edit{
        background-color: #a69187; 
        padding:6px; 
        text-decoration: none;
         border-radius: 5px; 
         color: #FFFFFF;
    }
    .edit:hover{
        background-color:#927e74;
    }
    .delete{
        background-color:rgb(244, 31, 31); 
        padding:6px; 
        text-decoration: none;
         border-radius: 5px; 
         color: #FFFFFF;
    }
    .delete:hover{
        background-color:rgb(255, 0, 0);
    }
    footer {
  background: #222;
  color: #ccc;
  text-align: center;
  padding: 2rem 1rem;
  font-size: 0.9rem;
}

footer a {
  color: #fff;
  text-decoration: none;
}

.footer-info {
  max-width: 6000px;
  margin: 0 auto;
  text-align: left;
  padding-left: 1rem;
}

</style>

<body>

    <body>
        <div class="banner">
                <h1>Dashboard Admin</h1>
            </div>

        </div>

        <div style="display: flex; min-height: 100vh; margin-top:200px">
            <div class="admin-navbar" style="width: 220px; padding: 20px; background: #f8f8f8;">
                <a href="dashboard.php">Dashboard</a><br><br>
                <a href="manajemen_produk.php">Manajemen Produk</a><br><br>
                <a href="logout.php" style= "border: 1px solid #927e74; background-color: #927e74; color: #FFFFFF;">Keluar    </a>
            </div>

            <!-- Konten kanan -->
          <div style="flex: 1; padding: 20px;">
                <h2 style="text-align: left;">Manajemen Produk</h2>
                <div style="text-align: right; margin-bottom: 10px;">
                    <a href="tambah-produk.php" style="background-color: #927e74; color: white; padding: 10px 16px; border-radius: 5px; text-decoration: none;">+ Tambah Produk</a>
                </div>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Alamat Pengguna</th>
                        <th>Sub Total</th>
                        <th>Total Pembayaran</th>
                    </tr>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?php if (!empty($row['gambar'])): ?>
                                    <img src="gambar/<?= $row['gambar']; ?>" alt="Gambar Produk">
                                <?php else: ?>
                                    (Tidak ada gambar)
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['Nama_Produk']); ?></td>
                            <td>
                                <?= number_format((float)$row['Harga_Produk'], 0, ',', '.'); ?>
                            </td>
                            <td>
                                <a class="edit" href="edit-produk.php?Id_Produk=<?= $row['Id_Produk']; ?>">Edit</a> 
                                <a class="delete" href="manajemen_produk.php?Id_Produk=<?= $row['Id_Produk']; ?>"onclick="return confirm('Hapus produk ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
<footer>
  <div class="footer-info">
    <h3>Tentang Agen Telur Berkah Jaya</h3>
    <p>Agen Telur amanah, terpercaya dan menyediakan telur yang berkualitas tinggi.</p>
    <p>(+62) 81328030520 | <a href="mailto:agenberkahj@gmail.com">agenberkah@gmail.com</a></p>
    <p style="margin-top: 2rem;">© 2025 Agen Telur Berkah Jaya. All Rights Reserved</p>
  </div>
</footer>

    </body>


</html>