<?php
require_once 'koneksi.php';

header('Content-Type: application/json');

// Mengambil data dari POST
$id = isset($_POST['id_pelanggan']) ? $_POST['id_pelanggan'] : '';
$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
$no_telpon = isset($_POST['no_telpon']) ? $_POST['no_telpon'] : '';



// Mengecek apakah ada ID pelanggan bulanan yang dikirimkan
if (!empty($id)) {
    // Jika ada ID maka proses untuk update data
    $sql = "UPDATE pelanggan SET nama='" . $nama . "', email='" . $email . "', alamat='" . $alamat . "' , no_telpon='" . $no_telpon . "'  WHERE id_pelanggan='" . $id . "'";
} else {
    // Jika tidak ada ID maka proses untuk insert data baru
    $sql = "INSERT INTO pelanggan (nama, email, alamat, no_telpon, gender) VALUES ('" . $nama . "','" . $email . "','" . $alamat . "','" . $no_telpon . "' )";
}

// Eksekusi query ke database
$query = mysqli_query($db, $sql);

// Mengecek apakah query berhasil dieksekusi
if ($query) {
    // Jika berhasil, kirimkan status 'data_tersimpan'
    echo json_encode(array('status' => 'data_tersimpan'));
} else {
    // Jika gagal, kirimkan status 'gagal_tersimpan'
    echo json_encode(array('status' => 'gagal_tersimpan'));
}

