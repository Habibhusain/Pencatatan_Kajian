<?php
require "config/config.php";

function connect_db(){
    $db = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    return $db;
}

function cek_nomor_wa($nomor_wa) {
    $sql_cek_nomor_wa = "SELECT nomor_wa FROM user WHERE nomor_wa = '$nomor_wa'";
    $result = connect_db()->query($sql_cek_nomor_wa);

    return $result->num_rows > 0;
}

function tambah_user($nama_user, $nomor_wa, $daerah) {
    

    if (cek_nomor_wa($nomor_wa)) {
        return "Nomor WhatsApp sudah terdaftar.";
    }

    $sql_tambah_user = "INSERT INTO user (nama_user, nomor_wa, daerah) VALUES ('$nama_user', '$nomor_wa', '$daerah')";
    
    if (connect_db()->query($sql_tambah_user)) {
        return TRUE;
    } else {
        return "Terjadi kesalahan saat menambah pengguna.";
    }
}

function login_user($nama_user, $nomor_wa) {
    

    $sql_login_user = "SELECT * FROM user WHERE nama_user = '$nama_user' AND nomor_wa = '$nomor_wa'";
    $result = connect_db()->query($sql_login_user);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id_user'];
        return $user;
    } else {
        return false;
    }
}

function upload_dokumentasi_kajian() {
    $ambil_ukuran_file = $_FILES['foto']['size'];
    $ukuran_diizinkan = 10000000;

    if ($ambil_ukuran_file > $ukuran_diizinkan) {
        echo 'Ukuran file maksimal 10 MB !!';
        exit();
    }

    $ambil_nama_file = $_FILES['foto']['name'];
    $ambil_ektensi_file = pathinfo($ambil_nama_file, PATHINFO_EXTENSION);
    $extensi_diizinkan = ['jpg', 'jpeg', 'png', 'svg', 'JPG', 'avif'];

    if (in_array($ambil_ektensi_file, $extensi_diizinkan)) {
        $ambil_tmp_file = $_FILES['foto']['tmp_name'];
        $tujuan_folder = "image/";
        $target_file = $tujuan_folder . basename($ambil_nama_file);

        if (move_uploaded_file($ambil_tmp_file, $target_file)) {
            return $ambil_nama_file;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}

function ambil_semua_kajian_dengan_user() {
    
    $sql_ambil_semua_kajian_dengan_user = "
        SELECT 
            kajian.pengisi, 
            kajian.tema, 
            kajian.tempat, 
            kajian.deskripsi, 
            kajian.tanggal_kajian, 
            kajian.foto, 
            user.nama_user 
        FROM 
            kajian 
        JOIN 
            user ON kajian.user_id = user.id_user
    ";
    $eksekusi = connect_db()->query($sql_ambil_semua_kajian_dengan_user);
    $result = array();

    while($row = $eksekusi->fetch_assoc())
    {
        $result[]= $row;
    }
    return $result;
}

function tambah_kajian($pengisi, $tema, $tempat, $tanggal_kajian, $foto, $deskripsi, $user_id) {
    

    $sql_tambah_kajian = "INSERT INTO kajian (pengisi, tema, tempat, tanggal_kajian, foto, deskripsi, user_id) 
                          VALUES ('$pengisi', '$tema', '$tempat', '$tanggal_kajian', '$foto', '$deskripsi', $user_id)";
    
    return connect_db()->query($sql_tambah_kajian);
}

function update_kajian($get_id, $get_pengisi, $get_tema, $get_tempat, $get_tanggal_kajian, $get_foto, $get_user_id) {
    

    $sql_update_kajian = "UPDATE kajian SET pengisi = '$get_pengisi', tema = '$get_tema', tempat = '$get_tempat', 
                        tanggal_kajian = '$get_tanggal_kajian', foto = '$get_foto', user_id = $get_user_id 
                        WHERE id_kajian = $get_id";
    
    return connect_db()->query($sql_update_kajian);
}

function ambil_kajian($id_kajian) {
    
    $sql_ambil_kajian = "SELECT * FROM kajian WHERE id_kajian = $id_kajian";
    $eksekusi = connect_db()->query($sql_ambil_kajian);
    $result = array();

     return $eksekusi->fetch_assoc();
    
}

function ambil_kajian_user($user_id) {
    
    $sql_ambil_kajian_user = "SELECT * FROM kajian WHERE user_id = $user_id";
    $eksekusi = connect_db()->query($sql_ambil_kajian_user);
    while($row=$eksekusi->fetch_assoc())
    {
            $result[]=$row;
    }

    return $result;
}

function delete_kajian($get_id) {
    
    $sql_delete_kajian = "DELETE FROM kajian WHERE id_kajian = $get_id";
    return connect_db()->query($sql_delete_kajian);
}
?>
