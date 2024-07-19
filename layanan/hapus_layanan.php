<?php
include '../koneksi.php';

$id_layanan = $_POST['id_layanan'];

    $id_layanan = mysqli_real_escape_string($db, $_POST['id_layanan']);

    $sql = "DELETE FROM layanan WHERE id_layanan = '$id_layanan'";
    $query = mysqli_query($db, $sql);

    // Memeriksa apakah query berhasil dijalankan
    if ($query) {
        // Mengembalikan respons sukses dalam format JSON
        echo json_encode(array('status' => 'success', 'message' => 'data_berhasil_di_hapus'));
    } else {
        // Mengembalikan pesan kesalahan dalam format JSON jika query gagal
        echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus data: ' . mysqli_error($db)));
    }

