<?php
session_start();
require "functions.php"; 

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Login Terlebih Dahulu'); window.location='login.php';</script>";
    exit();
}

// Ambil data kajian berdasarkan ID
if (isset($_GET['id'])) {
    $id_kajian = $_GET['id'];
    $kajian = ambil_kajian($id_kajian);

    if (!$kajian) {
        echo "<script>alert('Kajian tidak ditemukan!'); window.location='dashboard.php';</script>";
        exit();
    }
} else {
    header("Location: dashboard.php");
    exit();
}

// Proses update data kajian
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pengisi = $_POST['pengisi'];
    $tema = $_POST['tema'];
    $tempat = $_POST['tempat'];
    $tanggal_kajian = $_POST['tanggal_kajian'];
    $user_id = $_SESSION['user_id'];
    
    // Gunakan foto lama jika tidak ada foto baru yang diupload
    $foto = $kajian['foto']; 

    // Cek apakah ada foto baru yang diupload
    if ($_FILES['foto']['error'] != UPLOAD_ERR_NO_FILE) {
        $upload_foto = upload_dokumentasi_kajian();
        if ($upload_foto) {
            $foto = $upload_foto; // Ganti foto lama dengan yang baru jika ada
        }
    }

    // Perbarui kajian
    if (update_kajian($id_kajian, $pengisi, $tema, $tempat, $tanggal_kajian, $foto, $user_id)) {
        echo "<script>alert('Kajian berhasil diperbarui!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui kajian.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kajian</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="container-judul">
        <header>
            <h1>Edit Kajian</h1>
        </header>
    </div>
    <div class="container-form">
        <form method="POST" enctype="multipart/form-data">
            <label for="pengisi">Pengisi</label>
            <input type="text" name="pengisi" id="pengisi" value="<?php echo htmlspecialchars($kajian['pengisi']); ?>" required>

            <label for="tema">Tema</label>
            <input type="text" name="tema" id="tema" value="<?php echo htmlspecialchars($kajian['tema']); ?>" required>

            <label for="tempat">Tempat</label>
            <input type="text" name="tempat" id="tempat" value="<?php echo htmlspecialchars($kajian['tempat']); ?>" required>

            <label for="tanggal_kajian">Tanggal Kajian</label>
            <input type="date" name="tanggal_kajian" id="tanggal_kajian" value="<?php echo htmlspecialchars($kajian['tanggal_kajian']); ?>" required>
            
            <label for="foto">Dokumentasi (Foto)</label><br>
            <img src="image/<?php echo htmlspecialchars($kajian['foto']); ?>" alt="Foto Bukti" width="100">
            <input type="file" name="foto" id="foto">

            <input type="submit" value="Simpan Perubahan">
            <a href="dashboard.php">kembali</a>
        </form>
    </div>
</div>
</body>
</html>