<?php

require_once 'koneksi.php';

header('Content-Type: application/json');

// Memeriksa apakah semua data POST diterima
if (isset($_POST['nama'], $_POST['email'], $_POST['alamat'], $_POST['no_telpon'])) {

    $id = uniqid('pel_'); // Menghasilkan ID unik dengan prefix 'pel_'
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telpon = $_POST['no_telpon'];
   

    // Melarikan input pengguna untuk mencegah SQL injection
    $id = mysqli_real_escape_string($db, $id);
    $nama = mysqli_real_escape_string($db, $nama);
    $email = mysqli_real_escape_string($db, $email);
    $alamat = mysqli_real_escape_string($db, $alamat);
    $no_telpon = mysqli_real_escape_string($db, $no_telpon);

    

    // Query SQL yang dikoreksi
    $sql = "INSERT INTO pelanggan (id_pelanggan, nama, email, alamat, no_telpon) 
            VALUES ('$id', '$nama', '$email', '$alamat', '$no_telpon')";

    $query = mysqli_query($db, $sql);

    if ($query) {
        echo json_encode(array('status' => 'data_tersimpan', 'id_pelanggan' => $id));
    } else {
        echo json_encode(array('status' => 'gagal_tersimpan', 'error' => mysqli_error($db)));
    }

} else {
    echo json_encode(array('status' => 'data_tidak_lengkap', 'received' => $_POST));
}

mysqli_close($db);
