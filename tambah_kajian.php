<?php
session_start();
require "functions.php";
// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>
    alert('Login Terlebih Dahulu'); 
    window.location='login.php';
    </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pengisi = $_POST['pengisi'];
    $tema = $_POST['tema'];
    $tempat = $_POST['tempat'];
    $tanggal_kajian = $_POST['tanggal_kajian'];
    $foto = upload_dokumentasi_kajian();
    $deskripsi = $_POST['deskripsi'];
    $user_id = $_SESSION['user_id'];

    $tambah_data_kajian = tambah_kajian($pengisi, $tema, $tempat, $tanggal_kajian, $foto, $deskripsi, $user_id);

    if($tambah_data_kajian)
    {
        echo "<script>
        alert('Data Kajian Berhasil di Tambah');
        window.location = 'dashboard.php';
        </script>";
    }else{
        echo "<script>
        alert('Data Kajian Gagal di Tambah');
        window.location = 'tambah_kajian.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kajian</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content-tambah">
    <div class="content-tambah-judul">
    <h1>Tambah Kajian</h1>
    </div>
    <div class="content-tambah-form">
    <form method="post" enctype="multipart/form-data">
        <label for="pengisi">Pengisi:</label>
        <input type="text" name="pengisi" required autofocus>
        
        <label for="tema">Tema:</label>
        <input type="text" name="tema" required>
        
        <label for="tempat">Tempat:</label>
        <input type="text" name="tempat" required>
        
        <label for="tanggal_kajian">Tanggal:</label>
        <input type="date" name="tanggal_kajian" required>
        
        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" required></textarea>
        
        <label for="foto">Foto:</label>
        <input type="file" name="foto" required>
        
        <input type="submit" value="Tambah Kajian">
    </form>
    </div>
    <a href="dashboard.php">Kembali</a>
    </div>
</body>
</html>
