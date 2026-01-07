<?php
include 'config.php';

$query_hot = mysqli_query($conn, "SELECT * FROM categories WHERE is_popular = 1 ORDER BY id ASC");
$hot_games = [];
while ($row = mysqli_fetch_assoc($query_hot)) {
    $hot_games[] = $row;
}

$query_all = mysqli_query($conn, "SELECT * FROM categories ORDER BY nama_game ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopapStore - Top Up Game Termurah</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        .section-title {
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 1.3rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .fire-icon {
            color: #ff4500;
            filter: drop-shadow(0 0 5px orange);
        }

        .swiper {
            width: 100%;
            padding-bottom: 20px;
            padding-left: 5px;
            padding-right: 5px;
        }

        .swiper-slide {
            width: 140px;
            background-position: center;
            background-size: cover;
            border-radius: 15px;
            display: block;
            position: relative;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 15px;
            pointer-events: none;
        }

        .game-title {
            margin-top: 8px;
            text-align: center;
            font-size: 0.85rem;
            color: white;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: white;
            background: rgba(0, 0, 0, 0.6);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            backdrop-filter: blur(4px);
            top: 40%;
            z-index: 10;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 14px;
            font-weight: bold;
        }

        .all-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 15px;
        }

        .game-card-static {
            display: block;
            transition: transform 0.3s;
        }

        .game-card-static img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 15px;
        }

        .game-card-static:hover {
            transform: translateY(-5px);
        }
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
        </div>
    </header>

    <main class="container">

        <h2 class="section-title"><i class="fas fa-fire fire-icon"></i> Populer</h2>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php
                for ($i = 0; $i < 5; $i++) {
                    foreach ($hot_games as $game) : ?>
                        <a href="detail.php?id=<?php echo $game['id']; ?>" class="swiper-slide">
                            <img src="img/<?php echo $game['gambar_banner']; ?>" alt="<?php echo $game['nama_game']; ?>">
                            <div class="game-title"><?php echo $game['nama_game']; ?></div>
                        </a>
                <?php endforeach;
                }
                ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <h2 class="section-title"><i class="fas fa-gamepad"></i> Semua Game</h2>
        <div class="selection-grid all-grid" id="game-list-container">
            <?php while ($game = mysqli_fetch_assoc($query_all)) : ?>
                <a href="detail.php?id=<?php echo $game['id']; ?>" class="game-card-static">
                    <img src="img/<?php echo $game['gambar_banner']; ?>" alt="<?php echo $game['nama_game']; ?>">
                    <div class="game-title"><?php echo $game['nama_game']; ?></div>
                </a>
            <?php endwhile; ?>
        </div>

    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-left">
                    <h3>TopapStore</h3>
                    <p>&copy; 2025 All Rights Reserved.</p>
                </div>
                <div class="footer-contact">
                    <a href="https://wa.me/6281357316942"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                    <a href="https://instagram.com/gracsiaaa"><i class="fab fa-instagram"></i> Instagram</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: "auto",
            spaceBetween: 15,

            loop: true,

            centeredSlides: false,

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
        });
    </script>

</body>

</html>