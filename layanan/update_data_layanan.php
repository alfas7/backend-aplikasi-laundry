<?php
require_once 'koneksi.php';

header('Content-Type: application/json');

// Mengambil data dari POST
$id_layanan = isset($_POST['id_layanan']) ? $_POST['id_layanan'] : '';
$nama_layanan = isset($_POST['nama_layanan']) ? $_POST['nama_layanan'] : '';
$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
$harga = isset($_POST['harga']) ? $_POST['harga'] : '';
$durasi = isset($_POST['durasi']) ? $_POST['durasi'] : '';

if (!empty($id_layanan)) {
    $sql = "UPDATE layanan SET nama_layanan='" . $nama_layanan . "', deskripsi='" . $deskripsi . "', harga='" . $harga . "',  durasi='" . $durasi . "' WHERE id_layanan='" . $id_layanan . "'";
} else {
    $sql = "INSERT INTO layanan (nama_layanan, deskripsi, harga, durasi) VALUES ('" . $nama_layanan . "', '" . $deskripsi . "', '" . $harga . "','" . $durasi . "')";
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

