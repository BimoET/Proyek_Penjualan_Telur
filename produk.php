<?php

require_once "database.php";
 
$db = (new Database())->connection();

$sql = "SELECT * FROM produk";
$stmt = $db->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = isset($_POST['Nama_Produk']) ? $_POST['Nama_Produk'] : null;
    $harga = isset($_POST['Harga_Produk']) ? $_POST['Harga_Produk'] : null;
    $gambar = isset($_FILES['gambar']['name']) ? $_FILES['gambar']['name'] : null;
    $tmp = isset($_FILES['gambar']['tmp_name']) ? $_FILES['gambar']['tmp_name'] : null;

    $folder = "gambar/";
    move_uploaded_file($tmp, $folder . $gambar);


    $stmt = $db->prepare("INSERT INTO produk (Nama_Produk, Harga_Produk, gambar) VALUES (?, ?, ?)");
    $stmt->bindParam('sss', $nama, $harga, $gambar);
    $stmt->execute([$nama, $harga, $gambar]);


    echo "Produk berhasil ditambahkan!";
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
        }

        .bagian-atas {
            background: white;
            padding: 20px 0;
            text-align: center;
            border-bottom: 2px solid #A38F85;
        }

        .bagian-atas img {
            width: 50px;
        }

        .bagian-atas .nama-toko {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }

    .menu-utama {
    background: #A38F85;
    padding: 10px 0;
    text-align: center;
}

.menu-utama a {
    color: white;
    margin: 0 15px;
    text-decoration: none;
    font-weight: bold;
    padding: 8px 16px;
    border-radius: 6px;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.menu-utama a:hover {
    background-color: #8c786c;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    cursor: pointer;
}


        .bagian-utama {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 100px;
            background: white;
        }

        .bagian-utama .teks {
            max-width: 50%;
        }

        .bagian-utama h1 {
            font-size: 32px;
            color: #222;
            margin-bottom: 15px;
        }

        .bagian-utama p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .bagian-utama img {
            max-width: 30%;
            border-radius: 10px;
        }

        .tombol {
            background: #A38F85;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .tombol:hover {
            background: #CDC6C3;
        }

        .produk-kami {
            padding: 50px;
            text-align: center;
            background: white;
        }

        .produk-kami h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .daftar-produk {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 4 kolom per baris */
        gap: 20px;
        padding: 0 5%;
        }


        .kartu-produk {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .kartu-produk img {
            width: 100%;
            aspect-ratio: 1 / 1; 
            object-fit: cover;  
            display: block;
        }
        .kartu-produk:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}   


        .kartu-produk h3 {
            padding: 10px;
            font-size: 16px;
            background: #f4f4f4;
        }



        @media (max-width: 768px) {
            .bagian-utama {
                flex-direction: column;
                text-align: center;
            }

            .bagian-utama .teks,
            .bagian-utama img {
                max-width: 100%;
            }

            .daftar-produk {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .daftar-produk {
                grid-template-columns: 1fr;
            }
        }

        .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 20px;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
    text-align: center;
    position: relative;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    
    opacity: 0;
    transform: scale(0.9);
    transition: all 0.3s ease;
}


.modal-content img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
}

.modal-content h3 {
    margin-bottom: 10px;
}

.modal-content .close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
}
.modal.show .modal-content {
    opacity: 1;
    transform: scale(1);
}

.testimoni-section {
    background: #eef2ee;
    padding: 60px 20px;
    text-align: center;
}

.testimoni-section h2 {
    font-size: 28px;
    margin-bottom: 30px;
    color: #222;
}

.testimoni-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
}

.testimoni-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    width: 300px;
    text-align: left;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.testimoni-card:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.testimoni-card p {
    font-style: italic;
    color: #333;
    margin-bottom: 20px;
}

.testimoni-card .profil {
    display: flex;
    align-items: center;
    gap: 10px;
}

.testimoni-card .profil img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
}

.testimoni-card .profil strong {
    color: #000;
}

.testimoni-card .rating {
    margin-top: 10px;
    color: orange;
    font-size: 18px;
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
</head>
<body>
    <div class="bagian-atas">
        <img src="gambar/Logo.png" alt="Logo">
        <div class="nama-toko">AGEN TELUR BERKAH JAYA</div>
    </div>

    <div class="menu-utama">
        <a href="beranda.php">Beranda</a>
        <a href="keranjangbelanja.php">Keranjang</a>
        <a href="profil.php">Profile</a>
        <a href="produk.php">Produk</a>

    </div>

    <div class="produk-kami">
        <h2>PRODUK KAMI</h2> <br>
        <div class="daftar-produk">
            <?php foreach ($result as $row): ?>
    <div class="kartu-produk">
        <img src="gambar/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['Nama_Produk']) ?>">
        <h3>
            <?= htmlspecialchars($row['Nama_Produk']) ?><br>
            1 kg<br>
            <span>Rp.<?= number_format($row['Harga_Produk'], 0, ',', '.') ?></span>
        </h3>
        <form action="tambah_keranjang.php" method="POST" style="margin-bottom: 10px;">
            <input type="hidden" name="Id_Produk" value="<?= $row['Id_Produk'] ?>">
            <button type="submit" class="tombol">Tambah ke Keranjang</button>
        </form>
    </div>
<?php endforeach; ?>

        </div>
    </div>

    </div>
</div>


    <div id="modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <img id="modal-img" src="" alt="" />
        <h3 id="modal-title"></h3>
        <p id="modal-desc"></p>
    </div>
</div>

<script>
    const modal = document.getElementById("modal");
    const modalImg = document.getElementById("modal-img");
    const modalTitle = document.getElementById("modal-title");
    const modalDesc = document.getElementById("modal-desc");
    const closeBtn = document.querySelector(".modal .close");

    const produkData = {
        "Telur Ayam Kampung": "Telur dari ayam kampung yang kaya akan nutrisi dan memiliki rasa gurih alami.",
        "Telur Ayam Negeri": "Telur hasil peternakan intensif, cocok untuk kebutuhan harian.",
        "Telur Ayam Organik": "Dihasilkan dari ayam yang diberi pakan organik tanpa bahan kimia.",
        "Telur Ayam Omega": "Kaya omega-3, baik untuk kesehatan jantung dan otak.",
        "Telur Bebek": "Telur berukuran besar dengan rasa yang lebih pekat, sering digunakan untuk kue.",
        "Telur Puyuh": "Kecil namun bergizi tinggi, cocok untuk cemilan atau lauk.",
        "Telur Angsa": "Ukuran besar dan jarang dijual, memiliki rasa yang khas.",
        "Telur Ayam Mutiara": "Dihasilkan dari ayam mutiara, langka dan unik."
    };

    document.querySelectorAll(".kartu-produk").forEach(card => {
    card.addEventListener("click", () => {
    const title = card.querySelector("h3").innerText;
    const imgSrc = card.querySelector("img").src;
    modalImg.src = imgSrc;
    modalTitle.innerText = title;
    modalDesc.innerText = produkData[title] || "Deskripsi belum tersedia.";

    modal.style.display = "flex";
    // Timeout agar CSS transition bisa diterapkan
    setTimeout(() => modal.classList.add("show"), 10);
});

    });

   closeBtn.onclick = () => {
    modal.classList.remove("show");
    setTimeout(() => modal.style.display = "none", 300); // match duration of transition
};

window.onclick = (e) => {
    if (e.target == modal) {
        modal.classList.remove("show");
        setTimeout(() => modal.style.display = "none", 300);
    }
};

</script>

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