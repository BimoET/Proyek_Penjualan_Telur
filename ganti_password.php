<?php
require_once "database.php";

// Mulai session
session_start();

$db = (new Database())->connection();

if (!isset($_GET['email'])) {
    die("Link tidak valid.");
}

$email = $_GET['email'];

// Pastikan email masih ada di database
$stmt = $db->prepare("SELECT * FROM t_pengguna WHERE Email_Pengguna = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Email tidak ditemukan.");
}


$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass1 = $_POST['password'];
    $pass2 = $_POST['konfirmasi'];

    if (empty($pass1) || empty($pass2)) {
        $error = "Password tidak boleh kosong.";
    } elseif ($pass1 !== $pass2) {
        $error = "Password dan konfirmasi tidak cocok.";
    } else {
        // Hash password
        $hash = password_hash($pass1, PASSWORD_DEFAULT);

        // Update password dan hapus token
        $stmt = $db->prepare("UPDATE t_pengguna SET Password = :password, token_ganti = NULL WHERE Email_Pengguna = :email");
        $stmt->execute([
            'password' => $hash,
            'email' => $email
        ]);

        // Redirect ke login
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ganti Password</title>
    <style>
        body {
            font-family: Poppins, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #927e74;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            width: 300px;
        }
        input[type="password"], input[type="submit"] {
            width: 100%;
            margin: 10px 0;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #a08878;
            color: white;
            cursor: pointer;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="post">
        <h2>Ganti Password</h2>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <label>Password Baru</label>
        <input type="password" name="password" required>
        <label>Konfirmasi Password</label>
        <input type="password" name="konfirmasi" required>
        <input type="submit" value="Simpan Password">
    </form>
</body>
</html>