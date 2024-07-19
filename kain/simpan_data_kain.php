<?php

require_once 'koneksi.php';

header('Content-Type: application/json');

// Memeriksa apakah semua data POST diterima
if (isset($_POST['nama_kain'], $_POST['deskripsi'])) {

    $id = uniqid('pel_'); // Menghasilkan ID unik dengan prefix 'pel_'
    $nama_kain  = $_POST['nama_kain']; 
    $deskripsi = $_POST['deskripsi'];
    
   

    // Melarikan input pengguna untuk mencegah SQL injection
    $id = mysqli_real_escape_string($db, $id);
    $nama_kain = mysqli_real_escape_string($db, $nama_kain);
    $deskripsi = mysqli_real_escape_string($db, $deskripsi);

    
    

    // Query SQL yang dikoreksi
    $sql = "INSERT INTO kain (id_kain, nama_kain, deskripsi) 
            VALUES ('$id', '$nama_kain', '$deskripsi')";

    $query = mysqli_query($db, $sql);

    if ($query) {
        echo json_encode(array('status' => 'data_tersimpan', 'id_kain' => $id));
    } else {
        echo json_encode(array('status' => 'gagal_tersimpan', 'error' => mysqli_error($db)));
    }

} else {
    echo json_encode(array('status' => 'data_tidak_lengkap', 'received' => $_POST));
}

mysqli_close($db);
