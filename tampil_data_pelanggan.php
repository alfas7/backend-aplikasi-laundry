<?php
require_once 'koneksi.php';
// Mempersiapkan query SQL untuk mengambil data dari tabel pelanggan_hutang_bulanan
$sql = "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC";
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
        'id_pelanggan' => $data['id_pelanggan'],
        'nama' => $data['nama'],
        'email' => $data['email'],
        'alamat' => $data['alamat'],
        'no_telpon' => $data['no_telpon'],
    );
}
header('Content-Type: application/json');

// Mengembalikan data dalam format JSON
echo json_encode(array('data' => $list_data));

