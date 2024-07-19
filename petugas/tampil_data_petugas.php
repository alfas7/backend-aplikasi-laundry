<?php
require_once 'koneksi.php';

$sql = "SELECT * FROM petugas ORDER BY id_petugas DESC";
$query = mysqli_query($db, $sql);

// Memeriksa apakah query berhasil dijalankan
if (!$query) {

    echo json_encode(array('status' => 'error', 'message' => 'Query failed: ' . mysqli_error($db)));
    exit;
}
$list_data = array();

while ($data = mysqli_fetch_assoc($query)) {
    $list_data[] = array(
        'id_petugas' => $data['id_petugas'],
        'nama_petugas' => $data['nama_petugas'],
        'jabatan' => $data['jabatan'],
        'no_telpon' => $data['no_telpon'],
        
    );
}

// Mengatur header agar browser mengetahui bahwa respons berformat JSON
header('Content-Type: application/json');

// Mengembalikan data dalam format JSON
echo json_encode(array('data' => $list_data));

