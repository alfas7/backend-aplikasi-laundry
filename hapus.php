<?php
require_once 'koneksi.php';

$id_pelanggan = $_POST['id_pelanggan'];

// Mengecek apakah id_pelanggan dikirim melalui POST
    $id_pelanggan = mysqli_real_escape_string($db, $_POST['id_pelanggan']);

    // Mempersiapkan query SQL untuk menghapus data berdasarkan id_pelanggan
    $query = mysqli_query($db, $sql);

    // Memeriksa apakah query berhasil dijalankan
    if ($query) {
        // Mengembalikan respons sukses dalam format JSON
        echo json_encode(array('status' => 'success', 'message' => 'data_berhasil_di_hapus'));
    } else {
        // Mengembalikan pesan kesalahan dalam format JSON jika query gagal
        echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus data: ' . mysqli_error($db)));
    }

