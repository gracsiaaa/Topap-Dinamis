<?php
include 'config.php';

// Ambil nomor invoice dari URL
$inv = isset($_GET['inv']) ? $_GET['inv'] : '';

// Cari data pesanan di database
$query = mysqli_query($conn, "SELECT * FROM transactions WHERE invoice_id = '$inv'");
$data = mysqli_fetch_assoc($query);

// Jika invoice tidak ditemukan, kembalikan ke home
if (!$data) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - <?php echo $inv; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            padding-top: 40px;
        }

        .payment-container {
            max-width: 500px;
            margin: 0 auto;
            background: #16213e;
            padding: 30px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .total-pay {
            font-size: 1.8rem;
            color: #4ecca3;
            font-weight: bold;
            margin: 10px 0;
            background: rgba(78, 204, 163, 0.1);
            padding: 10px;
            border-radius: 10px;
        }

        .qris-img {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
            border: 5px solid white;
            margin: 20px 0;
        }

        .expiry-timer {
            color: #ff4500;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .detail-table {
            width: 100%;
            text-align: left;
            margin-bottom: 20px;
            color: #ccc;
            font-size: 0.9rem;
        }

        .detail-table td {
            padding: 5px 0;
        }

        .detail-table strong {
            color: white;
        }
    </style>
</head>

<body>

    <div class="payment-container">
        <h3>Selesaikan Pembayaran</h3>
        <p>Silakan scan QRIS di bawah ini</p>

        <div class="total-pay">
            Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?>
        </div>

        <table class="detail-table">
            <tr>
                <td>Order ID</td>
                <td style="text-align: right;"><strong>#<?php echo $data['invoice_id']; ?></strong></td>
            </tr>
            <tr>
                <td>Item</td>
                <td style="text-align: right;"><strong><?php echo $data['item']; ?></strong></td>
            </tr>
        </table>

        <img src="img/qris.jpg" alt="Scan QRIS" class="qris-img">

        <p style="font-size: 0.9rem; color: #aaa;">
            Setelah melakukan pembayaran, mohon klik tombol di bawah ini untuk mengecek status pesanan Anda.
        </p>

        <br>

        <a href="invoice.php?inv=<?php echo $inv; ?>" class="submit-button" style="display: block; text-decoration: none;">
            <i class="fas fa-check-circle"></i> Saya Sudah Bayar
        </a>
    </div>

</body>

</html>