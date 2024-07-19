<?php

include "../koneksi.php";

$sql = "SELECT pesan_jasa.id_pesan, petugas.nama_petugas, pelanggan.nama, layanan.nama_layanan, kain.nama_kain, pesan_jasa.tanggal_pesan, pesan_jasa.tanggal_ambil,  pesan_jasa.jumlah, pesan_jasa.status_pesan
        FROM pesan_jasa 
        JOIN petugas ON pesan_jasa.id_petugas = petugas.id_petugas
        JOIN pelanggan ON pesan_jasa.id_pelanggan = pelanggan.id_pelanggan
        JOIN layanan ON pesan_jasa.id_layanan = layanan.id_layanan
        JOIN kain ON pesan_jasa.id_kain = kain.id_kain";

$query = $db->query($sql);
$list_data = array();
while ($row = $query->fetch_assoc()) {
    $list_data[] = $row;

}
echo json_encode(array('data' => $list_data));
?>
