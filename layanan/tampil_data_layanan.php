<?php
require_once 'koneksi.php';

// Mempersiapkan query SQL untuk mengambil data dari tabel layanan
$sql = "SELECT * FROM layanan ORDER BY id_layanan DESC";
$query = mysqli_query($db, $sql);

// Memeriksa apakah query berhasil dijalankan
if (!$query) {
    // Mengembalikan pesan kesalahan dalam format JSON jika query gagal
    echo json_encode(array('status' => 'error', 'message' => 'Query failed: ' . mysqli_error($db)));
    exit;
}

// Membuat array untuk menyimpan data yang diambil
$list_data = array();

// Mengambil data dari hasil query dan menyimpannya dalam array
while ($data = mysqli_fetch_assoc($query)) {
    $list_data[] = array(
        'id_layanan' => $data['id_layanan'],
        'nama_layanan' => $data['nama_layanan'],
        'deskripsi' => $data['deskripsi'],
        'harga' => $data['harga'],
        'durasi' => $data['durasi'],
        
    );
}

// Mengatur header agar browser mengetahui bahwa respons berformat JSON
header('Content-Type: application/json');

// Mengembalikan data dalam format JSON
echo json_encode(array('data' => $list_data));

