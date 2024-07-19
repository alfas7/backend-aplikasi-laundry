<?php
require_once 'koneksi.php';

header('Content-Type: application/json');

// Mengambil data dari POST
$id = isset($_POST['id_petugas']) ? $_POST['id_petugas'] : '';
$nama_petugas = isset($_POST['nama_petugas']) ? $_POST['nama_petugas'] : '';
$jabatan = isset($_POST['jabatan']) ? $_POST['jabatan'] : '';
$no_telpon = isset($_POST['no_telpon']) ? $_POST['no_telpon'] : '';



// Mengecek apakah ada ID pelanggan bulanan yang dikirimkan
if (!empty($id)) {
    $sql = "UPDATE petugas SET nama_petugas='" . $nama_petugas . "', jabatan='" . $jabatan . "', no_telpon='" . $no_telpon . "'   WHERE id_petugas='" . $id . "'";
} else {
    $sql = "INSERT INTO petugas (nama_petugas, jabatan, no_telpon) VALUES ('" . $nama_petugas . "','" . $jabatan . "','" . $no_telpon . "')";
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

