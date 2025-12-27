<?php
include 'config.php';

$query = "SELECT * FROM categories";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TopapStore - Top Up Game Terpercaya</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <header class="navbar">
    <div class="header-container">
      <div class="logo-and-nav">
        <a href="index.php" class="logo">TopapStore</a>
        <nav>
          <a href="index.php">Home</a>
        </nav>
      </div>

      <div class="search-bar">
        <input type="text" id="search-input" placeholder="Cari Game...">
        <button type="submit">Cari</button>
      </div>
    </div>
  </header>

  <main class="container">
    <section class="banner-section">
      <img src="/Topap/img/banner.jpeg" alt="Keuntungan Join Reseller" class="main-banner-image">
      <div class="banner-indicators">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
    </section>
    <div class="content-wrapper">
      <div style="padding: 25px;">
        <h3 class="section-title-index"><span>🔥</span>Game Populer</h3>

        <div class="selection-grid" id="game-list-container">
          <?php while ($game = mysqli_fetch_assoc($result)) : ?>
            <a href="detail.php?id=<?php echo $game['id']; ?>" class="game-card">
              <img src="img/<?php echo $game['gambar_banner']; ?>" alt="<?php echo $game['nama_game']; ?>">
              <div class="game-title">
                <?php echo $game['nama_game']; ?>
              </div>
            </a>
          <?php endwhile; ?>
        </div>
      </div>
    </div>

  </main>

  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 LifeStore (Gracsia Andhika). Semua hak cipta dilindungi.</p>
    </div>
  </footer>

  <script src="script.js"></script>
</body>

</html>