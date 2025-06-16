<?php
session_start();
require_once "database.php";

$db = (new Database())->connection();

$error = "";
$email = $_GET['email'] ?? "";

if (isset($_POST['verif_otp'])) {
    $email = $_POST['email'];
    $otp_input = $_POST['otp'];

    $stmt = $db->prepare("SELECT * FROM t_pengguna WHERE Email_Pengguna = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error = "Email tidak ditemukan";
    } elseif ($user['token_ganti'] != $otp_input) {
        $error = "Kode OTP salah";
    } else {
        header("Location: ganti_password.php?email=" . urlencode($email));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ece7e1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #927e74;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #a69187;
        }
        .error {
            text-align: center;
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <form method="post">
        <h2>Verifikasi OTP</h2>
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <label>Masukkan Kode OTP:</label>
        <input type="text" name="otp" maxlength="6" required>
        <input type="submit" name="verif_otp" value="Verifikasi">
        <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    </form>
</body>
</html>