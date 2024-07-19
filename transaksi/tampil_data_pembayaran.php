<?php

include "../koneksi.php";

$sql = "SELECT pembayaran.id_pembayaran, pesan_jasa.id_pesan, pelanggan.id_pelanggan, pembayaran.jumlah_bayar, pembayaran.metode_bayar, pembayaran.tanggal_bayar       
        FROM pembayaran
        JOIN pesan_jasa ON pembayaran.id_pesan = pesan_jasa.id_pesan
        JOIN pelanggan ON pembayaran.id_pelanggan = pelanggan.id_pelanggan";

$query = $db->query($sql);

if (!$query) {
    die("Query failed: " . $db->error);
}

$list_data = array();
while ($row = $query->fetch_assoc()) {
    $list_data[] = $row;
}

echo json_encode(array('data' => $list_data));

?>
