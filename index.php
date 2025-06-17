<?php
session_start();
require_once "database.php";

$db = (new Database())->connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['Email_Pengguna'];
    $password = $_POST['Password'];


    // Cek ADMIN
    $stmtAdmin = $db->prepare("SELECT * FROM t_admin WHERE Email_Admin = :email");
    $stmtAdmin->bindParam(':email', $email);
    $stmtAdmin->execute();
    $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['Password'])) {
        $_SESSION["Email_Admin" 
        ] = $email;
        $_SESSION["Id_Admin"] = $admin['Id_Admin']; // jika butuh
        header("Location:dashboard.php");
        exit();
    }

    // Cek PENGGUNA
    $stmtUser = $db->prepare("SELECT * FROM t_pengguna WHERE Email_Pengguna = :email");
    $stmtUser->bindParam(':email', $email);
    $stmtUser->execute();
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION["Email_Pengguna"] = $email;
        $_SESSION["Id_Pengguna"] = $user['Id_Pengguna'];
        header("Location:beranda.php");
        exit();
    }

    echo "<script>alert('Login gagal! Email atau Password salah.');</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #ece7e1;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-wrapper {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-wrapper img {
            width: 60px;
            margin-bottom: 10px;
        }

        .login-wrapper h2 {
            margin-bottom: 24px;
            font-weight: 600;
            color: #333;
        }

        .login-wrapper label {
            display: block;
            text-align: left;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .login-wrapper input[type="email"],
        .login-wrapper input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .login-wrapper input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #a69187;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .login-wrapper input[type="submit"]:hover {
            background-color:#927e74 ;
        }

        .login-wrapper a {
            display: block;
            margin-top: 12px;
            font-size: 13px;
            color: #555;
            text-decoration: none;
        }

        .login-wrapper a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-wrapper {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <img src="gambar/Logo.png" alt="Logo Berkah Jaya">
    <h2>Login</h2>
    <form method="post" action="index.php">
        <label for="Email_Pengguna">Email</label>
        <input type="email" id="Email_Pengguna" name="Email_Pengguna" placeholder="Masukkan Email Anda" required>

        <label for="Password">Password</label>
        <input type="password" id="Password" name="Password" placeholder="Masukkan Password Anda" required>

        <input type="submit" value="LOGIN">
    </form>
    <a href="lupapassword.php">Lupa Password?</a>
 <a href="daftar.php"><b>Belum punya akun?</b> Daftar</a>
</div>
</body>
</html>
