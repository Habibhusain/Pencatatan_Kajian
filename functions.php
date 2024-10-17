<?php
require "config/config.php";

function cek_nomor_wa($nomor_wa) {
    global $conn;
    $stmt = $conn->prepare("SELECT nomor_wa FROM user WHERE nomor_wa = ?");
    $stmt->bind_param("s", $nomor_wa);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function tambah_user($nama_user, $nomor_wa, $daerah) {
    global $conn;

    if (cek_nomor_wa($nomor_wa)) {
        return "Nomor WhatsApp sudah terdaftar.";
    }

    $stmt = $conn->prepare("INSERT INTO user (nama_user, nomor_wa, daerah) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama_user, $nomor_wa, $daerah);

    if ($stmt->execute()) {
        return TRUE;
    } else {
        return "Terjadi kesalahan saat menambah pengguna.";
    }
}

function login_user($nama_user, $nomor_wa) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM user WHERE nama_user = ? AND nomor_wa = ?");
    $stmt->bind_param("ss", $nama_user, $nomor_wa);
    $stmt->execute();
    $result = $stmt->get_result();

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
    global $conn;
    $stmt = $conn->prepare("
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
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function tambah_kajian($pengisi, $tema, $tempat, $tanggal_kajian, $foto, $deskripsi, $user_id) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO kajian (pengisi, tema, tempat, tanggal_kajian, foto, deskripsi, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $pengisi, $tema, $tempat, $tanggal_kajian, $foto, $deskripsi, $user_id);

    return $stmt->execute();
}


function update_kajian($get_id, $get_pengisi, $get_tema, $get_tempat, $get_tanggal_kajian, $get_foto, $get_user_id) {
    global $conn;

    $stmt = $conn->prepare("UPDATE kajian SET pengisi = ?, tema = ?, tempat = ?, tanggal_kajian = ?, foto = ?, user_id = ? WHERE id_kajian = ?");
    $stmt->bind_param("ssssssi", $get_pengisi, $get_tema, $get_tempat, $get_tanggal_kajian, $get_foto, $get_user_id, $get_id);

    return $stmt->execute();
}

function ambil_kajian($get_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM kajian WHERE id_kajian = ?");
    $stmt->bind_param("i", $get_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function ambil_kajian_user($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM kajian WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function delete_kajian($get_id) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM kajian WHERE id_kajian = ?");
    $stmt->bind_param("i", $get_id);
    
    return $stmt->execute();
}
?>