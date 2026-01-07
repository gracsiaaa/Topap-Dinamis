<?php
include '../config.php';

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $res = mysqli_query($conn, "SELECT gambar_banner FROM categories WHERE id='$id'");
    $row = mysqli_fetch_assoc($res);
    if($row['gambar_banner']) unlink("../img/".$row['gambar_banner']);
    mysqli_query($conn, "DELETE FROM categories WHERE id = '$id'");
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_game'];
    $slug = $_POST['slug'];
    $tipe = $_POST['tipe_input'];
    $is_popular = isset($_POST['is_popular']) ? 1 : 0; 
    
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    
    if ($nama_file) {
        move_uploaded_file($tmp_file, "../img/" . $nama_file);
        $gambar = $nama_file;
    } else {
        $gambar = $_POST['gambar_lama'];
    }

    if ($id) {
        mysqli_query($conn, "UPDATE categories SET nama_game='$nama', slug='$slug', gambar_banner='$gambar', tipe_input='$tipe', is_popular='$is_popular' WHERE id='$id'");
    } else {
        mysqli_query($conn, "INSERT INTO categories (nama_game, slug, gambar_banner, tipe_input, is_popular) VALUES ('$nama', '$slug', '$gambar', '$tipe', '$is_popular')");
    }
    header("Location: index.php");
}

$edit_data = null;
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $res_edit = mysqli_query($conn, "SELECT * FROM categories WHERE id = '$id_edit'");
    $edit_data = mysqli_fetch_assoc($res_edit);
}

$query = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - TopapStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>Admin <span>TopapStore</span></h1>
        <a href="../index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="dashboard-grid">
        <div class="glass-panel">
            <h3><i class="fas <?php echo $edit_data ? 'fa-edit' : 'fa-plus-circle'; ?>"></i> <?php echo $edit_data ? 'Edit Game' : 'Tambah Game'; ?></h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $edit_data['id'] ?? ''; ?>">
                <input type="hidden" name="gambar_lama" value="<?php echo $edit_data['gambar_banner'] ?? ''; ?>">
                
                <div class="form-group">
                    <label>Nama Game</label>
                    <input type="text" name="nama_game" value="<?php echo $edit_data['nama_game'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Slug URL</label>
                    <input type="text" name="slug" value="<?php echo $edit_data['slug'] ?? ''; ?>" required>
                </div>

                <div class="form-group">
                    <label>Tipe Data Akun</label>
                    <select name="tipe_input" style="width:100%; padding:12px; background:rgba(0,0,0,0.3); border:1px solid var(--glass-border); color:white; border-radius:10px;">
                        <option value="id_server" <?php echo ($edit_data['tipe_input'] ?? '') == 'id_server' ? 'selected' : ''; ?>>ID & Server (MLBB)</option>
                        <option value="id_only" <?php echo ($edit_data['tipe_input'] ?? '') == 'id_only' ? 'selected' : ''; ?>>ID Only (FF, Roblox)</option>
                    </select>
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="is_popular" id="popCheck" style="width: 20px;" <?php echo ($edit_data['is_popular'] ?? 0) == 1 ? 'checked' : ''; ?>>
                    <label for="popCheck" style="margin:0; cursor:pointer; color: #ffeb3b;">Jadikan "Hot Game" 🔥</label>
                </div>
                
                <div class="form-group">
                    <label>Banner Game</label>
                    <input type="file" name="gambar" accept="image/*" id="imgInput">
                </div>

                <button type="submit" name="submit" class="btn btn-primary"><?php echo $edit_data ? 'Update' : 'Simpan'; ?></button>
                <?php if($edit_data): ?> <a href="index.php" class="btn-cancel">Batal</a> <?php endif; ?>
            </form>
        </div>

        <div class="glass-panel">
            <h3>Daftar Game</h3>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Img</th>
                            <th>Game</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($query)) : ?>
                        <tr>
                            <td><img src="../img/<?php echo $row['gambar_banner']; ?>" width="50" style="border-radius:5px;"></td>
                            <td>
                                <b><?php echo $row['nama_game']; ?></b><br>
                                <span style="font-size:0.8em; color:#888;"><?php echo $row['slug']; ?></span>
                            </td>
                            <td>
                                <?php if($row['is_popular'] == 1): ?>
                                    <span style="color:#ff4500; font-weight:bold;">🔥 Hot</span>
                                <?php else: ?>
                                    <span style="color:#888;">Normal</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?edit=<?php echo $row['id']; ?>" class="action-btn edit-btn"><i class="fas fa-pen"></i></a>
                                <a href="?hapus=<?php echo $row['id']; ?>" class="action-btn del-btn"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>