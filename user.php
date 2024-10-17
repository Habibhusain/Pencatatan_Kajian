<?php
require "config/config.php";
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_user = $_POST['nama_user'];
    $nomor_wa = $_POST['nomor_wa'];
    $daerah = $_POST['daerah'];

    // Panggil fungsi untuk menambah pengguna
    $hasil = tambah_user($nama_user, $nomor_wa, $daerah);
    if ($hasil === TRUE) {
        echo "<script>
        alert('User berhasil ditambahkan!');
        window.location='login.php';
        </script>";
    } else {
        echo "<script>
        alert('$hasil');
        window.location='user.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengguna</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="box-user">
        <div class="box-user-judul">
    <h1>Daftar Pengguna</h1>
    </div>
    <div class="box-user-form">
    <form method="POST">
        <label for="nama_user">Nama Pengguna:</label>
        <input type="text" name="nama_user" required autofocus>
        
        <label for="nomor_wa">Nomor WhatsApp:</label>
        <input type="text" name="nomor_wa" required>
        
        <label for="daerah">Daerah:</label>
        <input type="text" name="daerah" required>
        
        <input type="submit" value="Daftar">
        <a href="login.php">Sudah punya akun</a>
    </form>
    </div>
    </div>
</body>
</html>
