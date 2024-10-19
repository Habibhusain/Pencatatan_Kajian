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

$user_id = $_SESSION['user_id'];
$data_kajian = ambil_kajian_user($user_id);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content-dashboard">
        <div class="content-dashboard-judul">
    <h1>Dashboard</h1>
    <a href="tambah_kajian.php">Tambah Kajian</a>
    <h2>Daftar Kajian</h2>
    </div>
    <div class="content-dahsboard-table">
    <table>
        <tr>
            <th>ID</th>
            <th>Pengisi</th>
            <th>Tema</th>
            <th>Tempat</th>
            <th>Tanggal Kajian</th>
            <th>Dokumentasi</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($data_kajian as $kajian): ?>
        <tr>
            <td><?php echo $kajian['id_kajian']; ?></td>
            <td><?php echo $kajian['pengisi']; ?></td>
            <td><?php echo $kajian['tema']; ?></td>
            <td><?php echo $kajian['tempat']; ?></td>
            <td><?php echo date('d-m-Y', strtotime($kajian['tanggal_kajian'])); ?></td>
            <td><img src="image/<?php echo $kajian['foto']; ?>" alt="Foto Dokumentasi" width="100px" height="auto"></td>
            <td>
                <a href="edit_kajian.php?id_kajian=<?php echo $kajian['id_kajian']; ?>">Edit</a> |
                <a href="hapus_kajian.php?id_kajian=<?php echo $kajian['id_kajian']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kajian ini?');">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <a href="logout.php" onclick="return confirm('Yakin Mau logout???')">Logout</a>
    </div>

</body>
</html>
