<?php


$hostname = 'localhost';
$username = 'root';
$password = '';

// 1. connect 
$db = new mysqli($hostname, $username, $password);


// cek konek
if($db -> connect_error)
{
    die("Gagal Terkoneksi:" . $db->connect_error);
}

// 2. buat database
$sql_buat_db = "CREATE DATABASE kajian";
$eksekusi_buat_db = $db->query($sql_buat_db);

if($eksekusi_buat_db)
{
    echo 'Buat db hafalan berhasil'. '<br>';
}

// 3. masuk database
$sql_masuk_db = "USE kajian";
$eksekusi_masuk_db = $db->query($sql_masuk_db);

if($eksekusi_masuk_db)
{
    echo 'Sudah masuk ke Database' . '<br>';
}

// 4. buat table user
$sql_buat_table_user = "CREATE TABLE IF NOT EXISTS user(
id_user INT AUTO_INCREMENT PRIMARY KEY,
nama_user VARCHAR(255) NOT NULL,
nomor_wa VARCHAR (15) NOT NULL,
daerah VARCHAR (255) NOT NULL

);";

$eksekusi_buat_table_user = $db->query($sql_buat_table_user);

if($eksekusi_buat_table_user)
{
    echo 'Tabel user Berhasil dibuat'. '<br>';
}

// 5. buat tabel kajian
$sql_buat_table_kajian = "CREATE TABLE IF NOT EXISTS kajian(
id_kajian INT AUTO_INCREMENT PRIMARY KEY,
pengisi VARCHAR(255) NOT NULL,
tema VARCHAR(255)NOT NULL,
tempat VARCHAR(255) NOT NULL,
tanggal_kajian DATE NOT NULL,
foto TEXT ,
deskripsi TEXT,
user_id INT,
FOREIGN KEY (user_id) REFERENCES user(id_user)
)";

$eksekusi_buat_table_kajian = $db->query($sql_buat_table_kajian);

if($eksekusi_buat_table_kajian)
{
    echo 'Tabel kajian Berhasil dibuat' . '<br>';
}

$db -> close();