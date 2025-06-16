<?php
require_once 'database.php';
$db = (new Database())->connection();

if (isset($_POST["input"])) {

    //membuat variable untuk mnampung data dari form

    $namaProduk = $_POST['Nama_Produk'];
    $harga = $_POST['Harga_Produk'];
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

    $query = "INSERT INTO produk (Nama_Produk,Harga_Produk,gambar) VALUES (?, ?,?)";
    $statement = $db->prepare($query);


    if ($statement->execute([$namaProduk, $harga, $gambar])) {
        header("location:dashboard.php");
        exit;
    } else {
        die("Error saat insert data");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
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

        h1 {
            text-align: center;
        }

        button:hover {
            background-color: #927e74;
        }
    </style>
</head>

<body>

    <div class="container">
        <form id="form_produk" action="tambah-produk.php" method="post" enctype="multipart/form-data">
            <h1>Input Data</h1>
            <p>
                <label for="nama">Nama Produk</label>
                <input type="text" name="Nama_Produk" id="Nama_Produk">
            </p>
            <p>
                <label for="Harga_Produk"> Harga </label>
                <input type="text" name="Harga_Produk" id="noHP">
            </p>
            <p>
                <label>Gambar Produk</label><br>
                <input type="file" name="gambar" accept="image/*">
            </p>
            </fieldset>
            <p>
                <button type="submit" name="input">Simpan</button>
            </p>
        </form>
    </div>
</body>

</html>