<?php
session_start();
require "functions.php"; // Memanggil file functions.php

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Login Terlebih Dahulu'); window.location='login.php';</script>";

    exit();
}

// Hapus kajian berdasarkan ID
if (isset($_GET['id'])) {
    $id_kajian = $_GET['id'];
    
    if (delete_kajian($id_kajian)) {
        echo "<script>
        alert('Kajian berhasil dihapus!'); 
        window.location='dashboard.php';
        </script>";
    } else {
        echo "<script>
        alert('Terjadi kesalahan saat menghapus kajian.');
         window.location='dashboard.php';
         </script>";
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>
