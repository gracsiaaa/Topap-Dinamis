<?php
include 'config.php';
$inv = $_GET['inv'];
$query = mysqli_query($conn, "SELECT * FROM transactions WHERE invoice_id = '$inv'");
$data = mysqli_fetch_assoc($query);

if (!$data) { echo "Pesanan tidak ditemukan"; exit; }

// Warna Status Badge
$status_color = 'orange'; // Pending
if($data['status'] == 'Sukses') $status_color = '#4ecca3';
if($data['status'] == 'Gagal') $status_color = '#e94560';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Invoice <?php echo $inv; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { text-align: center; padding-top: 50px; }
        .invoice-box {
            background: #16213e; padding: 30px; border-radius: 15px;
            max-width: 500px; margin: 0 auto; border: 1px solid rgba(255,255,255,0.1);
        }
        .status-badge {
            background: <?php echo $status_color; ?>;
            color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold;
        }
        .detail-row {
            display: flex; justify-content: space-between; margin: 15px 0; border-bottom: 1px solid #333; padding-bottom: 10px;
        }
        .detail-row span:first-child { color: #aaa; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <i class="fas fa-check-circle" style="font-size: 3rem; color: #4ecca3; margin-bottom: 20px;"></i>
        <h2>Terima Kasih!</h2>
        <p>Pesanan Anda telah dibuat.</p>
        <br>
        
        <div class="detail-row">
            <span>Nomor Invoice</span>
            <strong>#<?php echo $data['invoice_id']; ?></strong>
        </div>
        <div class="detail-row">
            <span>Status</span>
            <span class="status-badge"><?php echo $data['status']; ?></span>
        </div>
        <div class="detail-row">
            <span>Game</span>
            <strong><?php echo $data['nama_game']; ?></strong>
        </div>
        <div class="detail-row">
            <span>Item</span>
            <strong><?php echo $data['item']; ?></strong>
        </div>
        <div class="detail-row">
            <span>User ID</span>
            <strong><?php echo $data['user_id']; ?></strong>
        </div>
        <div class="detail-row">
            <span>Total Bayar</span>
            <strong style="color: #4ecca3; font-size: 1.2rem;">Rp <?php echo number_format($data['harga'],0,',','.'); ?></strong>
        </div>

        <a href="index.php" class="submit-button" style="display:block; text-decoration:none; margin-top:20px;">Kembali ke Beranda</a>
    </div>
</body>
</html>