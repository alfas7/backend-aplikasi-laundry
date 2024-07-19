<?php
include '../koneksi.php';

$id_kain = $_POST['id_kain'];

// Mengecek apakah id_pelanggan_bulanan dikirim melalui POST
    $id_kain = mysqli_real_escape_string($db, $_POST['id_kain']);

    // Mempersiapkan query SQL untuk menghapus data berdasarkan id_pelanggan_bulanan
    $sql = "DELETE FROM kain WHERE id_kain = '$id_kain'";
    $query = mysqli_query($db, $sql);

    // Memeriksa apakah query berhasil dijalankan
    if ($query) {
        // Mengembalikan respons sukses dalam format JSON
        echo json_encode(array('status' => 'success', 'message' => 'data_berhasil_di_hapus'));
    } else {
        // Mengembalikan pesan kesalahan dalam format JSON jika query gagal
        echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus data: ' . mysqli_error($db)));
    }

