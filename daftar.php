<?php
require_once "database.php";
require_once "Query/pengguna.php";

$db = (new Database())->connection();
$Pengguna = new Pengguna($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Pengguna->Nama_Pengguna = $_POST['Nama_Pengguna'];
    $Pengguna->Email_Pengguna = $_POST['Email_Pengguna'];
    $Pengguna->NoTelp_Pengguna = $_POST['NoTelp_Pengguna'];
    $Pengguna->Alamat_Pengguna = $_POST['Alamat_Pengguna'];
    $Pengguna->JenisKelamin = $_POST['JenisKelamin'];

    $email = $_POST['Email_Pengguna'];

    $stmt = $db->prepare("SELECT COUNT(*) FROM t_pengguna WHERE Email_Pengguna = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $jumlah = $stmt->fetchColumn();

    if ($jumlah > 0) {
        echo "<script>alert('email sudah ada'); window.location.href='daftar.php';</script>";
        exit();
    }

    $hashedPassword = password_hash($_POST['Password'], PASSWORD_DEFAULT);
    $Pengguna->Password = $hashedPassword;

    if ($Pengguna->memasukan()) {
        echo "<script>('Pendaftaran berhasil!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Form Pendaftaran</title>
    <style>
        body {
            background-color: #EDE9E3;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        article {
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 500px;
            border-radius: 10px;
            text-align: center;
        }

        .logo {
            width: 100px;
            margin-bottom: 0px;
        }

        h1 {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }

        input,
        textarea,
        select {
            width: 100%;
            height: 35px;
            margin-bottom: 15px;
            padding: 5px 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            height: 80px;
            resize: vertical;
        }

        .radio-group {
            display: flex;
            gap: 30px;
            margin-bottom: 15px;
        }

        .radio-group label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: normal;
        }

        .radio-group input[type="radio"] {
            width: 18px;
            height: 18px;
        }

        button {
            width: 100%;
            height: 40px;
            background-color: #A38F85;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #685248;
        }
    </style>
</head>

<body>
    <article>
        <img src="gambar/Logo.png" alt="Logo" class="logo" style="width: 30%;">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <form method="post" action="daftar.php">
            <h1>Selamat Datang</h1>

            <label for="Email_Pengguna">Email*</label>
            <input type="email" name="Email_Pengguna" placeholder="Masukkan Email Anda" required>

            <label for="Nama_Pengguna">Nama Lengkap</label>
            <input type="text" name="Nama_Pengguna" placeholder="Masukkan Nama Anda" required>

            <label for="Alamat_Pengguna">Alamat</label>
            <textarea name="Alamat_Pengguna" placeholder="Masukkan Alamat Anda" required></textarea>

            <label for="NoTelp_Pengguna">No HP</label>
            <input type="number" name="NoTelp_Pengguna" placeholder="Masukkan No HP Anda" required>
            <label for="JenisKelamin">Jenis Kelamin</label>
            <select name="JenisKelamin" id="jk">
                <option value="pilih disini">pilih</option>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

            <label for="Password">Password*</label>
            <input type="password" name="Password" placeholder="Masukkan Password Anda" required>

            <button type="submit">DAFTAR</button>
            <div>
                <p style="margin-top: 15px; font-size: 14px;">
                    <span style="font-weight: bold; color: #333;">Sudah punya akun?</span>
                    <a href="index.php" style="color: #685248; text-decoration: none;"> Login</a>
                </p>

            </div>
        </form>
    </article>
</body>

</html>