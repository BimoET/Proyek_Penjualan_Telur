<?php
session_start();
if (!isset($_SESSION["Email_Admin"])) {
    header("Location: index.php");
    exit();
}
require_once 'database.php';
$db = (new Database())->connection();

$stmt = $db->prepare("
    SELECT 
        p.Id_Pembayaran,
        p.Total_Pembayaran,
        u.Nama_pengguna AS Nama,
        u.Alamat_Pengguna AS Alamat
    FROM pembayaran p
    JOIN t_pengguna u ON p.Id_Pengguna = u.Id_Pengguna
    ORDER BY p.Id_Pembayaran DESC
");
$stmt->execute();
$pembayaranList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,
100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>Dashboard</title>
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

        .admin-navbar a {
            text-decoration: none;
            border: 1px solid black;
            padding: 6px;
            border-radius: 5px;
            color: black;
        }

        .edit {
            background-color: #a69187;
            padding: 6px;
            text-decoration: none;
            border-radius: 5px;
            color: #FFFFFF;
        }

        .edit:hover {
            background-color: #927e74;
        }

        .delete {
            background-color: rgb(244, 31, 31);
            padding: 6px;
            text-decoration: none;
            border-radius: 5px;
            color: #FFFFFF;
        }

        .delete:hover {
            background-color: rgb(255, 0, 0);
        }
    </style>

<body>

    <body>
        <h1>Dashboard Admin</h1>
        </div>

        </div>

        <div style="display: flex; min-height: 100vh; margin-top:200px">
            <div class="admin-navbar" style="width: 220px; padding: 20px; background: #f8f8f8;">
                <a href="dashboard.php">Dashboard</a><br><br>
                <a href="manajemen_produk.php">Manajemen Produk</a><br><br>
                <a href="logout.php" style="border: 1px solid #927e74; background-color: #927e74; color: #FFFFFF;">Keluar </a>
            </div>

            <!-- Konten kanan -->
            <div style="flex: 1; padding: 20px;">
                <h2 style="text-align: left;">Detail Pembeli</h2>

                <table>
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th>Alamat</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>

                    <?php
                    $no = 1;
                    foreach ($pembayaranList as $pembayaran):
                        // Ambil setiap item produk untuk pembayaran ini
                        $stmtItem = $db->prepare("
        SELECT pr.Nama_Produk, pr.Harga_Produk, t.Jumlah
        FROM transaksi t
        JOIN produk pr ON t.Id_Produk = pr.Id_Produk
        WHERE t.Id_Pembayaran = ?
      ");
                        $stmtItem->execute([$pembayaran['Id_Pembayaran']]);
                        $items = $stmtItem->fetchAll(PDO::FETCH_ASSOC);

                        // Untuk setiap item, keluarkan satu baris
                        foreach ($items as $item):
                            $subTotal = $item['Harga_Produk'] * $item['Jumlah'];
                    ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($pembayaran['Nama']) ?></td>
                                <td><?= htmlspecialchars($pembayaran['Alamat']) ?></td>
                                <td><?= htmlspecialchars($item['Nama_Produk']) ?></td>
                                <td>Rp<?= number_format($item['Harga_Produk'], 0, ',', '.') ?></td>
                                <td><?= (int)$item['Jumlah'] ?></td>
                                <td>Rp<?= number_format($subTotal, 0, ',', '.') ?></td>
                            </tr>
                    <?php endforeach;
                    endforeach; ?>
                </table>

    </body>

</html>