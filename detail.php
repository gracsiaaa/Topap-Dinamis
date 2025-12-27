<?php
include 'config.php';

// 1. Tangkap ID dari URL (contoh: detail.php?id=1)
$id_game = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// 2. Ambil data kategori game tersebut
$query_cat = mysqli_query($conn, "SELECT * FROM categories WHERE id = '$id_game'");
$data_game = mysqli_fetch_assoc($query_cat);

// 3. Jika ID tidak valid, lempar balik ke home
if (!$data_game) {
  header("Location: index.php");
  exit;
}

// 4. Ambil produk yang hanya milik game ini
$query_prod = mysqli_query($conn, "SELECT * FROM products WHERE category_id = '$id_game'");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Top Up <?php echo $data_game['nama_game']; ?> - TopapStore</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <header class="navbar">
    <div class="header-container">
      <a href="index.php" class="logo">TopapStore</a>
      <nav><a href="index.php">Home</a></nav>
    </div>
  </header>

  <main class="container">
    <div class="content-wrapper">
      <section class="game-header">
        <img src="img/bproduct.jpeg" alt="Banner">
        <h2><?php echo $data_game['nama_game']; ?></h2>
        <p>Top Up <?php echo $data_game['nama_game']; ?> Instan dan Murah.</p>
      </section>

      <form id="order-form" action="payment.php" method="POST">
        <section class="form-section">
          <h3 class="section-title"><span>1</span>Lengkapi Data Akun</h3>
          <div class="input-group">
            <div class="input-field">
              <label for="user_id">User ID</label>
              <input type="number" id="user_id" name="user_id" placeholder="Masukkan ID" required>
            </div>
            <div class="input-field">
              <label for="zone_id">Zone ID</label>
              <input type="number" id="zone_id" name="zone_id" placeholder="Zone ID" required>
            </div>
          </div>
        </section>

        <section class="form-section">
          <h3 class="section-title"><span>2</span>Pilih Nominal</h3>
          <div class="selection-grid" id="nominal-grid">
            <?php while ($row = mysqli_fetch_assoc($query_prod)) : ?>
              <input type="radio" id="prod_<?php echo $row['id']; ?>" name="nominal"
                value="<?php echo $row['id']; ?>"
                data-price="<?php echo $row['harga']; ?>"
                data-name="<?php echo $row['nama_produk']; ?>" required>
              <label for="prod_<?php echo $row['id']; ?>" class="grid-item">
                <span class="item-title"><?php echo $row['nama_produk']; ?></span>
                <span class="item-price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
              </label>
            <?php endwhile; ?>
          </div>
        </section>

        <section class="form-section">
          <h3 class="section-title"><span>3</span>Pilih Pembayaran</h3>
          <div class="selection-grid" id="payment-grid">
            <input type="radio" id="pay_qris" name="payment" value="qris" data-name="QRIS" required>
            <label for="pay_qris" class="grid-item">
              <span class="item-title">QRIS</span>
              <span class="item-price">(Semua e-wallet)</span>
            </label>
          </div>
        </section>

        <section class="form-section">
          <h3 class="section-title"><span>4</span>Beli</h3>
          <div class="summary">
            <span>Total Bayar:</span>
            <strong id="total-price">Rp 0</strong>
          </div>
          <button type="submit" class="submit-button">Lanjut ke Checkout</button>
        </section>
      </form>
    </div>
  </main>

  <script src="script.js"></script>
</body>

</html>