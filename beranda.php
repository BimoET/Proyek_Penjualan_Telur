<?php
session_start();
if (!isset($_SESSION["Email_Pengguna"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
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
            grid-template-columns: repeat(4, 1fr);
            /* 4 kolom per baris */
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
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);

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
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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

    <div class="bagian-utama">
        <div class="teks">
            <h1>Sehat dan bergizi, awali harimu dengan telur!</h1>
            <p>Berkah Jaya Agen Telur menyediakan telur segar dan berkualitas. Cocok untuk kebutuhan rumah tangga, usaha kuliner, atau grosir. Kami siap melayani Anda dengan sepenuh hati!</p>
        </div>
        <img src="gambar/Image.png" alt="Gambar Telur">
    </div>

    <div class="produk-kami">
        <h2>PRODUK KAMI</h2> <br>
        <div class="daftar-produk">
            <div class="kartu-produk">
                <img src="gambar/TelurKampung.png" alt="Telur Ayam Kampung">
                <h3>Telur Ayam Kampung</h3>
            </div>
            <div class="kartu-produk">
                <img src="gambar/TelurNegeri.png" alt="Telur Ayam Negeri">
                <h3>Telur Ayam Negeri</h3>
            </div>
            <div class="kartu-produk">
                <img src="gambar/TelurOrganik.png" alt="Telur Ayam Organik">
                <h3>Telur Ayam Organik</h3>
            </div>
            <div class="kartu-produk">
                <img src="gambar/TelurOmega.png" alt="Telur Ayam Omega">
                <h3>Telur Ayam Omega</h3>
            </div>
            <div class="kartu-produk">
                <img src="gambar/TelurBebek.png" alt="Telur Bebek">
                <h3>Telur Bebek</h3>
            </div>
            <div class="kartu-produk">
                <img src="gambar/TelurPuyuh.png" alt="Telur Puyuh">
                <h3>Telur Puyuh</h3>
            </div>
            <div class="kartu-produk">
                <img src="gambar/TelurAngsa.png" alt="Telur Angsa">
                <h3>Telur Angsa</h3>
            </div>
            <div class="kartu-produk">
                <img src="gambar/TelurAyamMutiara.png" alt="Telur Ayam Mutiara">
                <h3>Telur Ayam Mutiara</h3>
            </div>
        </div>
    </div>

    <div class="testimoni-section">
        <h2>TESTIMONI PELANGGAN</h2>
        <div class="testimoni-container">
            <div class="testimoni-card">
                <p>"Mantappp poll!!!"</p>
                <div class="profil">
                    <img src="https://i.pravatar.cc/100?img=1" alt="Foto Robert">
                    <div>
                        <strong>Robert Fox</strong><br><span>Customer</span>
                    </div>
                </div>
                <div class="rating">★★★★★</div>
            </div>
            <div class="testimoni-card">
                <p>"Telur masih segar dan kondisinya baik"</p>
                <div class="profil">
                    <img src="https://i.pravatar.cc/100?img=2" alt="Foto Dianne">
                    <div>
                        <strong>Dianne Russell</strong><br><span>Customer</span>
                    </div>
                </div>
                <div class="rating">★★★★★</div>
            </div>
            <div class="testimoni-card">
                <p>"Telurr omegan-nya mantep bangettt"</p>
                <div class="profil">
                    <img src="https://i.pravatar.cc/100?img=3" alt="Foto Eleanor">
                    <div>
                        <strong>Eleanor Pena</strong><br><span>Customer</span>
                    </div>
                </div>
                <div class="rating">★★★★★</div>
            </div>
            <div class="testimoni-card">
                <p>"Telur masih segar dan kondisinya baik"</p>
                <div class="profil">
                    <img src="https://i.pravatar.cc/100?img=2" alt="Foto Dianne">
                    <div>
                        <strong>Dianne Russell</strong><br><span>Customer</span>
                    </div>
                </div>
                <div class="rating">★★★★★</div>
            </div>
            <div class="testimoni-card">
                <p>"Telur masih segar dan kondisinya baik"</p>
                <div class="profil">
                    <img src="https://i.pravatar.cc/100?img=2" alt="Foto Dianne">
                    <div>
                        <strong>Dianne Russell</strong><br><span>Customer</span>
                    </div>
                </div>
                <div class="rating">★★★★★</div>
            </div>

            <!-- Tambahan 3 testimoni baru -->
            <div class="testimoni-card">
                <p>"Pelayanannya ramah dan cepat, sukses selalu!"</p>
                <div class="profil">
                    <img src="https://i.pravatar.cc/100?img=4" alt="Foto Guy Hawkins">
                    <div>
                        <strong>Guy Hawkins</strong><br><span>Customer</span>
                    </div>
                </div>
                <div class="rating">★★★★☆</div>
            </div>
            <div class="testimoni-card">
                <p>"Produknya bagus, sudah langganan tiap minggu."</p>
                <div class="profil">
                    <img src="https://i.pravatar.cc/100?img=5" alt="Foto Leslie Alexander">
                    <div>
                        <strong>Leslie Alexander</strong><br><span>Customer</span>
                    </div>
                </div>
                <div class="rating">★★★★★</div>
            </div>
            <div class="testimoni-card">
                <p>"Kualitas terjamin, pengemasan rapi dan aman."</p>
                <div class="profil">
                    <img src="https://i.pravatar.cc/100?img=6" alt="Foto Jenny Wilson">
                    <div>
                        <strong>Jenny Wilson</strong><br><span>Customer</span>
                    </div>
                </div>
                <div class="rating">★★★★★</div>
            </div>
            <footer>

            </footer>
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