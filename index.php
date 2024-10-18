<?php
session_start();
require "functions.php"; 

// Ambil semua kajian dengan user
$data_kajian = ambil_semua_kajian_dengan_user();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wellcome">
        <h1>Selamat Datang di Aplikasi Kajian</h1>
        <p>Yuk Sharing Kajian Kalian dengan Daftar dan Login Terlebih Dahulu</p>
        <a href="login.php">Login</a> | <a href="user.php">Daftar Pengguna</a>
    </div>
    
    <div class="content-kajian">
        <h2>Daftar Kajian</h2>
        <table>
            <tr>
                <th>Pengirim</th>
                <th>Pengisi</th>
                <th>Tema</th>
                <th>Tempat</th>
                <th>Deskripsi</th>
                <th>Tanggal Kajian</th>
                <th>Dokumentasi</th>
            </tr>
            <?php foreach ($data_kajian as $kajian): ?>
            <tr>
                <td><?php echo $kajian['nama_user']; ?></td> <!-- Nama pengguna dari tabel user -->
                <td><?php echo $kajian['pengisi']; ?></td>
                <td><?php echo $kajian['tema']; ?></td>
                <td><?php echo $kajian['tempat']; ?></td>
                <td><?php echo $kajian['deskripsi']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($kajian['tanggal_kajian'])); ?></td>
                <td><img src="image/<?php echo $kajian['foto']; ?>" alt="Foto Dokumentasi" width="100px" height="auto"></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <footer>
        <p>&copy; 2024 by Habib Husain Nurrohim. All rights reserved.</p>
    </footer>
</body>
</html>
