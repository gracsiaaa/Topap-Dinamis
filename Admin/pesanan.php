<?php
include '../config.php';

// --- LOGIKA UPDATE STATUS PESANAN ---
if (isset($_POST['update_status'])) {
  $id = $_POST['id'];
  $status = $_POST['status'];

  // Update status di database
  mysqli_query($conn, "UPDATE transactions SET status='$status' WHERE id='$id'");

  // Refresh halaman agar data terupdate
  header("Location: pesanan.php");
}

// Ambil Semua Data Transaksi (Terbaru di atas)
$query = mysqli_query($conn, "SELECT * FROM transactions ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Kelola Pesanan - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">

  <style>
    /* CSS MENU NAVIGASI (Sama seperti index.php) */
    .admin-nav {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 30px;
    }

    .nav-card {
      background: rgba(255, 255, 255, 0.05);
      padding: 25px;
      border-radius: 15px;
      text-decoration: none;
      color: white;
      display: flex;
      align-items: center;
      gap: 20px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.3s ease;
    }

    .nav-card i {
      font-size: 2rem;
      color: #6C63FF;
    }

    .nav-card h3 {
      margin: 0;
      font-size: 1.2rem;
    }

    .nav-card p {
      margin: 5px 0 0;
      font-size: 0.8rem;
      color: #aaa;
    }

    .nav-card:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateY(-5px);
      border-color: #6C63FF;
    }

    /* CARD ACTIVE (Menandakan kita sedang di halaman Pesanan) */
    .nav-card.active {
      background: linear-gradient(135deg, rgba(108, 99, 255, 0.2), rgba(108, 99, 255, 0.05));
      border-color: #6C63FF;
    }

    .nav-card.active i {
      color: #fff;
      text-shadow: 0 0 10px #6C63FF;
    }

    /* Styling Badge Status di Tabel */
    .badge {
      padding: 5px 10px;
      border-radius: 8px;
      font-size: 0.85rem;
      font-weight: 600;
      display: inline-block;
      min-width: 80px;
      text-align: center;
    }

    .bg-pending {
      background: #ff9800;
      color: #000;
    }

    .bg-proses {
      background: #2196f3;
      color: #fff;
    }

    .bg-sukses {
      background: #4ecca3;
      color: #000;
      box-shadow: 0 0 10px rgba(78, 204, 163, 0.4);
    }

    .bg-gagal {
      background: #f44336;
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1>Admin <span>TopapStore</span></h1>
    <a href="../index.php" class="back-btn"><i class="fas fa-home"></i> Ke Website Utama</a>
  </div>

  <div class="admin-nav">
    <a href="index.php" class="nav-card">
      <i class="fas fa-gamepad"></i>
      <div>
        <h3>Kelola Game</h3>
        <p>Tambah & Edit Produk</p>
      </div>
    </a>

    <a href="pesanan.php" class="nav-card active">
      <i class="fas fa-shopping-cart"></i>
      <div>
        <h3>Data Pesanan</h3>
        <p>Cek Status & Transaksi</p>
      </div>
    </a>
  </div>

  <div class="glass-panel">
    <h3>Daftar Transaksi Masuk</h3>
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Invoice / Tanggal</th>
            <th>Detail Akun</th>
            <th>Item & Harga</th>
            <th>Metode</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($query)) : ?>
            <tr>
              <td>
                <strong style="color: #6C63FF;">#<?php echo $row['invoice_id']; ?></strong><br>
                <span style="font-size:0.8rem; color:#888;"><?php echo $row['tanggal']; ?></span>
              </td>

              <td>
                <b><?php echo $row['nama_game']; ?></b><br>
                <span style="color:#ccc; font-size:0.9rem;">ID: <?php echo $row['user_id']; ?></span>
                <?php if ($row['no_whatsapp'] != '-'): ?>
                  <br><a href="https://wa.me/<?php echo $row['no_whatsapp']; ?>" target="_blank" style="color:#25D366; font-size:0.8rem; text-decoration:none;"><i class="fab fa-whatsapp"></i> Hubungi</a>
                <?php endif; ?>
              </td>

              <td>
                <?php echo $row['item']; ?><br>
                <span style="color: #4ecca3;">Rp <?php echo number_format($row['harga']); ?></span>
              </td>

              <td><?php echo $row['metode_pembayaran']; ?></td>

              <td>
                <?php
                $status_class = 'bg-pending';
                if ($row['status'] == 'Proses') $status_class = 'bg-proses';
                if ($row['status'] == 'Sukses') $status_class = 'bg-sukses';
                if ($row['status'] == 'Gagal') $status_class = 'bg-gagal';
                ?>
                <span class="badge <?php echo $status_class; ?>">
                  <?php echo $row['status']; ?>
                </span>
              </td>

              <td>
                <form method="POST" style="display:flex; align-items:center; gap:5px;">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <select name="status" style="padding:8px; border-radius:5px; background:#222; color:white; border:1px solid #555; cursor:pointer;">
                    <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Proses" <?php if ($row['status'] == 'Proses') echo 'selected'; ?>>Proses</option>
                    <option value="Sukses" <?php if ($row['status'] == 'Sukses') echo 'selected'; ?>>Sukses</option>
                    <option value="Gagal" <?php if ($row['status'] == 'Gagal') echo 'selected'; ?>>Gagal</option>
                  </select>
                  <button type="submit" name="update_status" class="action-btn edit-btn" title="Simpan Perubahan"><i class="fas fa-save"></i></button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="script.js"></script>
</body>

</html>