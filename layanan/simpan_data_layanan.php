<?php

require_once 'koneksi.php';

header('Content-Type: application/json');

// Memeriksa apakah semua data POST diterima
if (isset($_POST['nama_layanan'], $_POST['deskripsi'], $_POST['harga'], $_POST['durasi'])) {

    $id = uniqid('pel_'); // Menghasilkan ID unik dengan prefix 'pel_'
    $nama_layanan  = $_POST['nama_layanan']; 
    $deskripsi  = $_POST['deskripsi']; 
    $harga  = $_POST['harga']; 
    $durasi  = $_POST['durasi']; 
    
   

    // Melarikan input pengguna untuk mencegah SQL injection
    $id = mysqli_real_escape_string($db, $id);
    $nama_layanan = mysqli_real_escape_string($db, $nama_layanan);
    $deskripsi = mysqli_real_escape_string($db, $deskripsi);
    $harga = mysqli_real_escape_string($db, $harga);
    $durasi = mysqli_real_escape_string($db, $durasi);
    
    

    // Query SQL yang dikoreksi
    $sql = "INSERT INTO layanan (id_layanan, nama_layanan, deskripsi, harga, durasi) 
            VALUES ('$id', '$nama_layanan', '$deskripsi', '$harga','$durasi')";

    $query = mysqli_query($db, $sql);

    if ($query) {
        echo json_encode(array('status' => 'data_tersimpan', 'id_layanan' => $id));
    } else {
        echo json_encode(array('status' => 'gagal_tersimpan', 'error' => mysqli_error($db)));
    }

} else {
    echo json_encode(array('status' => 'data_tidak_lengkap', 'received' => $_POST));
}

mysqli_close($db);
