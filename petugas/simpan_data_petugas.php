<?php

require_once 'koneksi.php';

header('Content-Type: application/json');

// Memeriksa apakah semua data POST diterima
if (isset($_POST['nama_petugas'], $_POST['jabatan'], $_POST['no_telpon'])) {

    $id = uniqid('pel_'); // Menghasilkan ID unik dengan prefix 'pel_'
    $nama_petugas  = $_POST['nama_petugas']; 
    $jabatan = $_POST['jabatan'];
    $no_telpon = $_POST['no_telpon'];
    
   

    // Melarikan input pengguna untuk mencegah SQL injection
    $id = mysqli_real_escape_string($db, $id);
    $nama_petugas = mysqli_real_escape_string($db, $nama_petugas);
    $jabatan = mysqli_real_escape_string($db, $jabatan);
    $no_telpon = mysqli_real_escape_string($db, $no_telpon);
    
    

    // Query SQL yang dikoreksi
    $sql = "INSERT INTO petugas (id_petugas, nama_petugas, jabatan, no_telpon) 
            VALUES ('$id', '$nama_petugas', '$jabatan', '$no_telpon')";

    $query = mysqli_query($db, $sql);

    if ($query) {
        echo json_encode(array('status' => 'data_tersimpan', 'id_petugas' => $id));
    } else {
        echo json_encode(array('status' => 'gagal_tersimpan', 'error' => mysqli_error($db)));
    }

} else {
    echo json_encode(array('status' => 'data_tidak_lengkap', 'received' => $_POST));
}

mysqli_close($db);
