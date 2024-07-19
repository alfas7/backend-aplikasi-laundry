<?php
require_once 'koneksi.php';

header('Content-Type: application/json');

// Mengambil data dari POST
$id = isset($_POST['id_kain']) ? $_POST['id_kain'] : '';
$nama_kain = isset($_POST['nama_kain']) ? $_POST['nama_kain'] : '';
$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';



// Mengecek apakah ada ID pelanggan bulanan yang dikirimkan
if (!empty($id)) {
    // Jika ada ID mahasiswa, maka proses untuk update data
    $sql = "UPDATE kain SET nama_kain='" . $nama_kain . "', deskripsi='" . $deskripsi . "'  WHERE id_kain='" . $id . "'";
} else {
    // Jika tidak ada ID mahasiswa, maka proses untuk insert data baru
    $sql = "INSERT INTO kain (nama_kain, deskripsi) VALUES ('" . $nama_kain . "','" . $deskripsi . "')";
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

