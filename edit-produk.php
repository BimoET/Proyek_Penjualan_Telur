<?php
require_once 'database.php';
$db = (new Database())->connection();


if (!isset($_GET['Id_Produk'])) {
    header("Location: dashboard.php");
    exit;
}

$IdProduk = $_GET['Id_Produk'];

$stmt = $db->prepare("SELECT * FROM produk WHERE Id_Produk = ?");
$stmt->execute([$IdProduk]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    die("Produk tidak ditemukan.");
}

if (isset($_POST['edit'])) {
    $namaProduk = $_POST['namaProduk'];
    $hargaProduk = $_POST['hargaProduk'];

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'gambar/';
        $fileTmp = $_FILES['gambar']['tmp_name'];
        $fileName = $_FILES['gambar']['name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newName = md5(time() . $fileName) . '.' . $ext;
        $dest = $uploadDir . $newName;

        if (move_uploaded_file($fileTmp, $dest)) {
            $gambar = $newName;
        } else {
            $gambar = $data['gambar'];
        }
    } else {
        $gambar = $data['gambar']; 
    }

    $sql = "UPDATE produk SET Nama_Produk = ?, Harga_Produk = ?, gambar = ? WHERE Id_Produk = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$namaProduk, $hargaProduk, $gambar, $IdProduk]);

    header("Location: manajemen_produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Edit Produk</title>
<link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,
100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<style>
body {
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Poppins', sans-serif;
}

.container {
    background-color: #ffffff;
    width: 500px;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

label {
    font-size: 16px;
    font-weight: 500;
}

input[type="text"],
input[type="number"],
input[type="file"] {
    font-size: 16px;
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    font-size: 16px;
    width: 100%;
    padding: 10px;
    background-color: #a69187;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color:#927e74;
}


</style>
</head>
<body>

<div class="container">
    <h1 style="text-align: center;">Edit Produk</h1>
    <form method="post" enctype="multipart/form-data">
    <p>
        <label>Nama Produk:</label><br>
        <input type="text" name="namaProduk" value="<?= htmlspecialchars($data['Nama_Produk']) ?>" required>
    </p>
    <p>
        <label>Harga Produk:</label><br>
        <input type="number" name="hargaProduk" value="<?= htmlspecialchars($data['Harga_Produk']) ?>" required>
    </p>
    <p>
        <label>Gambar Produk (kosongkan jika tidak ganti):</label><br>
        <input type="file" name="gambar" accept="image/*">
    </p>
    <p>
        <button type="submit" name="edit">Update Data</button>
        
    </p>
</form>
</div>

</body>
</html>