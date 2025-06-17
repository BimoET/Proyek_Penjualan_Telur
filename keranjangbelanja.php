<?php
session_start();
require_once 'database.php';
$db = (new Database())->connection();
if (!isset($_SESSION['Id_Pengguna'])) {
  die("⚠ Silakan login terlebih dahulu.");
}

$id_pengguna = $_SESSION['Id_Pengguna'];
$stmt = $db->prepare("
    SELECT t.Id_Produk, t.Jumlah, p.Nama_Produk, p.Harga_Produk, p.gambar
    FROM transaksi t
    JOIN produk p ON t.Id_Produk = p.Id_Produk
    WHERE t.Id_Pengguna = ? AND t.Id_Pembayaran IS NULL
");
$stmt->execute([$id_pengguna]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Keranjang Belanja - Agen Telur Berkah Jaya</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f2f2f2;
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

    main {
      padding: 2rem;
    }

    h2 {
      text-align: center;
      margin-bottom: 2rem;
    }

    .cart-container {
      display: flex;
      justify-content: center;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .cart-table,
    .cart-summary {
      background: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      width: 100%;
      max-width: 700px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 1rem;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background: #f7f7f7;
    }

    .product-img {
      width: 60px;
      height: 60px;
      border-radius: 10px;
      object-fit: cover;
      margin-right: 10px;
      vertical-align: middle;
    }

    .qty-control {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .qty-control button {
      padding: 0.2rem 0.5rem;
      cursor: pointer;
    }

    .cart-actions {
      display: flex;
      justify-content: flex-end;
      margin-top: 1rem;
    }

    .cart-actions button {
      padding: 0.5rem 1rem;
      background: #eee;
      border: 1px solid #ccc;
      border-radius: 5px;
      cursor: pointer;
    }

    .cart-summary {
      max-width: 300px;
      margin-top: 1.5rem;
    }

    .cart-summary div {
      display: flex;
      justify-content: space-between;
      margin-bottom: 1rem;
    }

    .checkout-button {
      background: #a08878;
      color: #fff;
      border: none;
      padding: 0.7rem 1rem;
      border-radius: 10px;
      width: 100%;
      font-weight: bold;
      cursor: pointer;
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

    .product-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }

    table td form {
      margin: 0;
    }

    button.hapus {
      background-color: #a08878;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
    }

    button.hapus:hover {
      background-color: rgb(108, 87, 72);
    }

    .product-card {
      display: flex;
      align-items: center;
      gap: 15px;
      min-width: 200px;
      max-width: 300px;
    }

    .product-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }

    .product-info {
      display: flex;
      flex-direction: column;
    }

    .product-name {
      font-weight: bold;
      font-size: 1rem;
      color: #333;
    }

    .product-desc {
      font-size: 0.85rem;
      color: #666;
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

  <main>
    <h2>Keranjang Belanja</h2>
    <div class="cart-container">

      <div class="cart-table">
        <table>
          <thead>
            <tr>
              <th>PRODUCT</th>
              <th>PRICE</th>
              <th>QUANTITY</th>
              <th>SUBTOTAL</th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0; ?>
            <?php if (!empty($items)): ?>
              <?php foreach ($items as $item):
                $subtotal = $item['Harga_Produk'] * $item['Jumlah'];
                $total += $subtotal;
              ?>
                <tr>
                  <td>
                    <div class="product-card">
                      <img src="gambar/<?= htmlspecialchars($item['gambar']) ?>" class="product-img" alt="produk">
                      <div class="product-info">
                        <div class="product-name"><?= htmlspecialchars($item['Nama_Produk']) ?></div>
                        <div class="product-desc"></div>
                      </div>
                    </div>
                  </td>
                  <td>Rp<?= number_format($item['Harga_Produk'], 0, ',', '.') ?></td>
                  <td><?= $item['Jumlah'] ?></td>
                  <td>Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
                  <td>
                    <form method="POST" action="keranjang_hapus.php">
                      <input type="hidden" name="Id_Produk" value="<?= $item['Id_Produk'] ?>">
                      <input type="hidden" name="aksi" value="hapus">
                      <button class="hapus" type="submit">Hapus</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>

            <?php else: ?>
              <tr>
                <td colspan="5" style="text-align: center">Keranjang kosong </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
        </tbody>
        </table>

        <?php if (!empty($items)): ?>
          <div class="cart-summary" style="margin-top: 1.5rem;">
            <div>
              <strong>Total:</strong>
              <span>Rp<?= number_format($total, 0, ',', '.') ?></span>
            </div>
            <a href="pembayaran1.php">
              <button class="checkout-button">Bayar Sekarang</button>
            </a>
          </div>
        <?php endif; ?>

        <div class="cart-actions">
        </div>
      </div>




    </div>
  </main>

  <footer>
    <div class="footer-info">
      <h3>Tentang Agen Telur Berkah Jaya</h3>
      <p>Agen Telur amanah, terpercaya dan menyediakan telur yang berkualitas tinggi.</p>
      <p>(+62) 81328030520 | <a href="mailto:agenberkahj@gmail.com">agenberkah@gmail.com</a></p>
      <p style="margin-top: 2rem;">© 2025 Agen Telur Berkah Jaya. All Rights Reserved</p>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const cartRows = document.querySelectorAll('tbody tr');
      const totalDisplay = document.getElementById('total-amount');
      const finalTotalDisplay = document.getElementById('final-total');

      function updateTotals() {
        let total = 0;
        cartRows.forEach(row => {
          const price = parseInt(row.dataset.price);
          const qty = parseInt(row.querySelector('.qty').textContent);
          const subtotal = price * qty;
          row.querySelector('.subtotal').textContent = 'Rp.' + subtotal.toLocaleString();
          total += subtotal;
        });
        totalDisplay.textContent = 'Rp.' + total.toLocaleString();
        finalTotalDisplay.textContent = 'Rp.' + total.toLocaleString();
      }

      document.querySelectorAll('.qty-control').forEach(control => {
        const qtySpan = control.querySelector('.qty');
        control.querySelectorAll('button').forEach(btn => {
          btn.addEventListener('click', () => {
            let qty = parseInt(qtySpan.textContent);
            if (btn.textContent === '+' && qty < 100) qty++;
            else if (btn.textContent === '-' && qty > 1) qty--;
            qtySpan.textContent = qty;
            updateTotals();
          });
        });
      });

      updateTotals();
    });
  </script>

</body>

</html>