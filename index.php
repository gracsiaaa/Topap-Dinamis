<?php
include 'config.php';
// Query Hot Games
$query_hot = mysqli_query($conn, "SELECT * FROM categories WHERE is_popular = 1 ORDER BY id ASC");
// Query All Games
$query_all = mysqli_query($conn, "SELECT * FROM categories ORDER BY nama_game ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopapStore - Top Up Termurah</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .section-title { margin: 40px 0 20px; font-size: 1.5rem; color: white; display: flex; align-items: center; gap: 10px; }
        .fire-icon { color: #ff4500; filter: drop-shadow(0 0 5px orange); }
        /* Grid Hot (Lebih Besar) */
        .hot-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px; }
        /* Grid All (Lebih Kecil) */
        .all-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 15px; }
        .game-card img { width: 100%; height: 100%; object-fit: cover; border-radius: 15px; transition: 0.3s; }
        .game-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="header-container">
            <a href="index.php" class="logo">TopapStore</a>
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="Cari game...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <nav><a href="index.php">Home</a></nav>
        </div>
    </header>

    <main class="container">
        <h2 class="section-title"><i class="fas fa-fire fire-icon"></i> Populer Sekarang</h2>
        <div class="selection-grid hot-grid">
            <?php while($game = mysqli_fetch_assoc($query_hot)) : ?>
                <a href="detail.php?id=<?php echo $game['id']; ?>" class="game-card">
                    <img src="img/<?php echo $game['gambar_banner']; ?>" alt="<?php echo $game['nama_game']; ?>">
                    <div class="game-title"><?php echo $game['nama_game']; ?></div>
                </a>
            <?php endwhile; ?>
        </div>

        <h2 class="section-title"><i class="fas fa-gamepad"></i> Semua Game</h2>
        <div class="selection-grid all-grid" id="game-list-container">
            <?php while($game = mysqli_fetch_assoc($query_all)) : ?>
                <a href="detail.php?id=<?php echo $game['id']; ?>" class="game-card">
                    <img src="img/<?php echo $game['gambar_banner']; ?>" alt="<?php echo $game['nama_game']; ?>">
                    <div class="game-title"><?php echo $game['nama_game']; ?></div>
                </a>
            <?php endwhile; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container"><p>&copy; 2025 TopapStore. All Rights Reserved.</p></div>
    </footer>
    <script src="script.js"></script>
</body>
</html>