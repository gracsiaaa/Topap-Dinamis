<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // 1. Ambil Data
  $user_id = $_POST['user_id'];
  $zone_id = isset($_POST['zone_id']) ? $_POST['zone_id'] : '';
  $full_id = $zone_id ? "$user_id ($zone_id)" : $user_id;

  $product_id = $_POST['nominal'];
  $payment = $_POST['payment'];
  $no_wa = isset($_POST['no_wa']) ? $_POST['no_wa'] : '-';

  // 2. Ambil Detail Produk & Game
  $q_prod = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
  $prod = mysqli_fetch_assoc($q_prod);

  $q_game = mysqli_query($conn, "SELECT nama_game FROM categories WHERE id = '" . $prod['category_id'] . "'");
  $game = mysqli_fetch_assoc($q_game);

  // 3. Buat Invoice & Simpan
  $invoice = "INV-" . rand(10000, 99999);
  $nama_game = $game['nama_game'];
  $item_name = $prod['nama_produk'];
  $harga = $prod['harga'];

  $sql = "INSERT INTO transactions (invoice_id, nama_game, user_id, item, harga, metode_pembayaran, no_whatsapp, status) 
            VALUES ('$invoice', '$nama_game', '$full_id', '$item_name', '$harga', '$payment', '$no_wa', 'Pending')";

  if (mysqli_query($conn, $sql)) {
    // --- PERUBAHAN DISINI ---
    // Arahkan ke halaman Payment dulu, bawa nomor invoice-nya
    header("Location: payment.php?inv=$invoice");
  } else {
    echo "Error: " . mysqli_error($conn);
  }
} else {
  header("Location: index.php");
}
