<?php session_start();
require "functions.php";

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $nama_user = $_POST['nama_user'];
    $nomor_user = $_POST['nomor_wa'];
    
    $user = login_user($nama_user, $nomor_user);

    if($user) {
        $_SESSION['user']= $user;
        echo "<script>
                alert('Berhasil Login');
                window.location = 'dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Nama pengguna atau nomor WhatsApp salah.');
                window.location = 'login.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-login">
    <div class="container-judul-login">
    <h1>Form Login</h1>
    <div class="container-form-login">
    <form method="POST">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_user" placeholder="Masukan Nama" autofocus required>
        <label>Nomor Whatsapp</label>
        <input type="number" name="nomor_wa" placeholder="Masukan Nomor" autofocus required>
        <div class="submit-login">
            <input type="submit" name="submit" value="Login">
            <a href="index.php">Kembali</a>
        </div>
    </form>
    </div>
    </div>
</body>
</html>