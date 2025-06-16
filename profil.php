<?php
session_start();
require 'database.php';
$db = new Database();
$con = $db->connection();

if (!isset($_SESSION["Email_Pengguna"])) {
  header("Location: index.php");
  exit();
}

$email = $_SESSION["Email_Pengguna"];

$stmt = $con->prepare("SELECT * FROM t_pengguna WHERE Email_Pengguna = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle update biodata
if (isset($_POST['update'])) {
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $telepon = $_POST['telepon'];
  $gender = $_POST['gender'];

  $update = $con->prepare("UPDATE t_pengguna SET 
  Nama_pengguna = :nama,
  Alamat_Pengguna = :alamat,
  NoTelp_Pengguna = :telepon,
  JenisKelamin = :gender
  WHERE Email_Pengguna = :email");

  $update->execute([
    ':nama' => $nama,
    ':alamat' => $alamat,
    ':telepon' => $telepon,
    ':gender' => $gender,
    ':email' => $email
  ]);


  if ($update) {
    header("Location: profil.php");
    exit();
  }
}

// Handle logout
if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,
100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
  <style>
    body,
    html {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    .boxx,
    .ggroupp,
    .ovverlap-grooup {
      width: 100%;
      height: 382px;
      position: relative;
    }

    .gbanner {
      position: absolute;
      width: 100%;
      height: 382px;
      top: 0;
      left: 0;
      opacity: 0.05;
    }

    .ikiBG {
      width: 100%;
      height: 396px;
      object-fit: cover;
      position: absolute;
      top: -3px;
      left: 0;
    }

    .text-wrapper {
      position: absolute;
      top: 118px;
      left: 50%;
      width: 50%;
      transform: translateX(-50%);
      font-size: 96px;
      font-weight: 700;
      color: #927e74;
      -webkit-text-stroke: 1px #000;
      line-height: normal;
      text-align: center;
    }

    .body-wrapper {
      width: 100%;
      background-color: #FFFFFF;
      margin-top: 158px;
      padding-top: 20px;
    }

    .content {
      display: flex;
      flex-direction: row;
      padding: 80px 100px;
      gap: 60px;
    }

    .sidebar {
      display: flex;
      flex-direction: column;
      gap: 40px;
    }

    .button {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 6px #00000030;
      padding: 24px;
      width: 250px;
      text-align: center;
      font-weight: bold;
      cursor: pointer;
    }

    .button.active {
      background-color: #927e74;
      color: white;
    }

    .button:hover {
      background-color: #e0e0e0;
    }

    .button.active:hover {
      background-color: #a69187;
    }

    .profil-section {
      display: flex;
      flex-direction: column;
      align-items: center;
      flex-grow: 1;
    }

    .avatar-wrapper {
      position: relative;
      width: 200px;
      height: 200px;
      margin-bottom: 60px;
    }

    .avatar-circle {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background-color: white;
      box-shadow: 0 4px 6px #00000030;
    }

    .avatar-img {
      position: absolute;
      top: 10px;
      left: 10px;
      width: 180px;
      height: 180px;
      object-fit: cover;
      border-radius: 50%;
    }

    .bio {
      width: 600px;
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .bio-row {
      display: flex;
      flex-direction: column;
    }

    .bio-label {
      font-weight: bold;
      font-size: 18px;
      color: #333;
      margin-bottom: 5px;
    }

    .bio-box {
      background-color: #fff;
      border-radius: 8px;
      border: 1px solid #ccc;
      height: 40px;
      padding: 10px;
      font-size: 16px;
      outline: none;
    }

    .edit-btn {
      margin-top: 60px;
      background-color: #a69187;
      border-radius: 10px;
      padding: 12px 32px;
      color: white;
      font-weight: bold;
      text-align: center;
      box-shadow: 0 4px 8px #00000030;
      cursor: pointer;
    }

    .edit-btn:hover {
      background-color: #927e74;
    }

    .modal-overlay {
      display: none;
      position: fixed;
      z-index: 9999;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(2px);
      justify-content: center;
      align-items: center;
    }

    .modal-box {
      background-color: #ffffff;
      border-radius: 16px;
      padding: 30px 32px;
      max-width: 420px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
      animation: fadeIn 0.3s ease-in-out;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .modal-box h2 {
      font-size: 24px;
      font-weight: bold;
      color: #927e74;
      text-align: center;
      margin-bottom: 10px;
    }

    .modal-box label {
      font-size: 14px;
      font-weight: bold;
      color: #333;
      margin-bottom: 5px;
    }

    .modal-box input {
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 15px;
      width: 100%;
      box-sizing: border-box;
    }

    .modal-box input:focus {
      border-color: #927e74;
      outline: none;
    }

    .submit-btn {
      margin-top: 10px;
      background-color: #927e74;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      font-size: 16px;
    }

    .submit-btn:hover {
      background-color: #927e74;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
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

    @media (max-width: 768px) {
      .content {
        flex-direction: column;
        padding: 20px;
        gap: 20px;
      }

      .text-wrapper {
        font-size: 48px;
        top: 80px;
      }

      .bio {
        width: 100%;
      }

      .button {
        width: 100%;
      }
    }

    header.atas {
      background: #fff;
      padding: 1rem 0;
      border-bottom: 2px solid #d0c2b9;
      text-align: center;
    }

    .tengah {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .tengah img {
      width: 50px;
      margin-bottom: 0.5rem;
    }

    .tengah span {
      font-weight: bold;
      font-size: 1.2rem;
      color: #113311;
    }

    .navigasi {
      background-color: #a08878;
      text-align: center;
      padding: 0.7rem 0;
    }

    .navigasi a {
      margin: 0 1.5rem;
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 1rem;
    }
  </style>
</head>

<body>
  <header class="atas">
    <div class="tengah">
      <img src="gambar/Logo.png" alt="logo">
      <span>AGEN TELUR BERKAH JAYA</span>
    </div>
  </header>

  <nav class="navigasi">
    <a href="beranda.php">Beranda</a>
    <a href="keranjangbelanja.php">Keranjang</a>
    <a href="profil.php">Profile</a>
    <a href="produk.php">Produk</a>
  </nav>
  <form action="produk.php" method="GET" class="search-form">
    </button>
  </form>
  </div>
  </nav>


  <div class="body-wrapper">
    <div class="content">
      <div class="sidebar">
        <div class="button active">Informasi Pribadi</div>
        <div class="button" id="logoutBtn">Keluar</div>
      </div>

      <div class="profil-section">
        <div class="avatar-wrapper">
          <div class="avatar-circle"></div>
          <img class="avatar-img" src="gambar/profile.jpg" alt="Foto Profil" />
        </div>

        <div class="bio">
          <div class="bio-row">
            <div class="bio-label">Nama</div>
            <input class="bio-box" type="text" value="<?= htmlspecialchars($data['Nama_pengguna']) ?>" readonly />
          </div>
          <div class="bio-row">
            <div class="bio-label">Alamat</div>
            <input class="bio-box" type="text" value="<?= htmlspecialchars($data['Alamat_Pengguna']) ?>" readonly />
          </div>
          <div class="bio-row">
            <div class="bio-label">No. Telepon</div>
            <input class="bio-box" type="text" value="<?= htmlspecialchars($data['NoTelp_Pengguna']) ?>" readonly />
          </div>
          <div class="bio-row">
            <div class="bio-label">E-mail</div>
            <input class="bio-box" type="email" value="<?= htmlspecialchars($data['Email_Pengguna']) ?>" readonly />
          </div>
          <div class="bio-row">
            <div class="bio-label">Jenis Kelamin</div>
            <input class="bio-box" type="text" value="<?= htmlspecialchars($data['JenisKelamin']) ?>" readonly />
          </div>
        </div>
        <div class="edit-btn" id="openModalBtn">Perbarui</div>
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

  </div>

  <!-- Modal Update Biodata -->
  <div id="modal" class="modal-overlay" style="display: none;">
    <div class="modal-box">
      <h2>Perbarui Biodata</h2>
      <form method="POST">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['Nama_pengguna']) ?>" required />

        <label>Alamat:</label>
        <input type="text" name="alamat" value="<?= htmlspecialchars($data['Alamat_Pengguna']) ?>" required />

        <label>No. Telepon:</label>
        <input type="text" name="telepon" value="<?= htmlspecialchars($data['NoTelp_Pengguna']) ?>" required />

        <label>Jenis Kelamin:</label>
        <input type="text" name="gender" value="<?= htmlspecialchars($data['JenisKelamin']) ?>" required />

        <button type="submit" name="update" class="submit-btn">Simpan</button>
      </form>
    </div>
  </div>

  <!-- Modal Logout -->
  <div id="logoutModal" class="modal-overlay" style="display: none;">
    <div class="modal-box">
      <h2>Anda yakin ingin keluar?</h2>
      <form method="POST" style="display: flex; gap: 10px; justify-content: center;">
        <button type="submit" name="logout" class="submit-btn">Ya</button>
        <button type="button" id="cancelLogout" class="submit-btn" style="background-color: grey;">Tidak</button>
      </form>
    </div>

  </div>
  <script>
    document.getElementById('openModalBtn').addEventListener('click', () => {
      document.getElementById('modal').style.display = 'flex';
    });

    document.getElementById('logoutBtn').addEventListener('click', () => {
      document.getElementById('logoutModal').style.display = 'flex';
    });

    document.getElementById('cancelLogout').addEventListener('click', () => {
      document.getElementById('logoutModal').style.display = 'none';
    });
  </script>
</body>

</html>