<?php
session_start();
require_once "database.php";

// Import PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function kirim_email($email_penerima, $nama_penerima, $subjek, $isi) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'pandusagalang2@gmail.com';
        $mail->Password   = 'dyif sypn moxg oadc';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('pandusagalang2@gmail.com', 'Admin Toko');
        $mail->addAddress($email_penerima, $nama_penerima);
        $mail->isHTML(true);
        $mail->Subject = $subjek;
        $mail->Body    = $isi;

        $mail->send();
    } catch (Exception $e) {
        echo "Gagal kirim email. Mailer Error: {$mail->ErrorInfo}";
    }
}

$db = (new Database())->connection();

$error = "";
$sukses = "";

if (isset($_POST['tombol'])) {
    $email = $_POST['Email_Pengguna'];

    if ($email == '') {
        $error = "Email tidak boleh kosong";
    } else {
        $stmt = $db->prepare("SELECT * FROM t_pengguna WHERE Email_Pengguna = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $error = "Email tidak ditemukan";
        } else {
            $otp = rand(100000, 999999);

            $stmt = $db->prepare("UPDATE t_pengguna SET token_ganti = ? WHERE Email_Pengguna = ?");
            $stmt->execute([$otp, $email]);

            $judul_email = "Kode OTP Reset Password";
            $isi_email = "Ini kode OTP untuk reset password kamu: <b>$otp</b>";

            kirim_email($email, $email, $judul_email, $isi_email);

            header("Location: verifikasi_otp.php?email=" . urlencode($email));
            exit();
        }
    }
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
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
        input[type="email"] {
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
        <h2>Lupa Password</h2>
        <label for="Email_Pengguna">Masukkan Email:</label>
        <input type="email" name="Email_Pengguna" required>
        <input type="submit" name="tombol" value="Kirim OTP">
        <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    </form>
</body>
</html>