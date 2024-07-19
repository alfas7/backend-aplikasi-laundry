<?php
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Tampilkan data POST yang diterima
    error_log(print_r($_POST, true));

    // Pastikan semua kunci yang diperlukan ada dalam array POST
    $required_keys = ['nama_petugas', 'nama', 'nama_layanan', 'nama_kain', 'tanggal_pesan', 'tanggal_ambil', 'jumlah', 'status_pesan'];
    foreach ($required_keys as $key) {
        if (!isset($_POST[$key])) {
            echo json_encode(array('status' => 'error', 'message' => "Key '$key' tidak ditemukan dalam request"));
            exit;
        }
    }

    // Ambil nilai dari POST
    $id_pesan = $_POST['id_pesan'];
    $nama_petugas = trim($_POST['nama_petugas']);
    $nama = trim($_POST['nama']);
    $nama_layanan = trim($_POST['nama_layanan']);
    $nama_kain = trim($_POST['nama_kain']);
    $tanggal_pesan = trim($_POST['tanggal_pesan']);
    $tanggal_ambil = trim($_POST['tanggal_ambil']);
    $jumlah =  trim($_POST['jumlah']);
    $status_pesan = trim($_POST['status_pesan']);

    // Mendapatkan id berdasarkan nama dari tabel petugas
    $sql_petugas = "SELECT id_petugas FROM petugas WHERE BINARY nama_petugas = ?";
    $stmt_petugas = $db->prepare($sql_petugas);
    if ($stmt_petugas === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
        exit;
    }
    $stmt_petugas->bind_param('s', $nama_petugas);
    $stmt_petugas->execute();
    $result_petugas = $stmt_petugas->get_result();

    // Mendapatkan id berdasarkan nama dari tabel pelanggan
    $sql_pelanggan = "SELECT id_pelanggan FROM pelanggan WHERE BINARY nama = ?";
    $stmt_pelanggan = $db->prepare($sql_pelanggan);
    if ($stmt_pelanggan === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
        exit;
    }
    $stmt_pelanggan->bind_param('s', $nama);
    $stmt_pelanggan->execute();
    $result_pelanggan = $stmt_pelanggan->get_result();

    // Mendapatkan id berdasarkan nama dari tabel layanan
    $sql_layanan = "SELECT id_layanan FROM layanan WHERE BINARY nama_layanan = ?";
    $stmt_layanan = $db->prepare($sql_layanan);
    if ($stmt_layanan === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
        exit;
    }
    $stmt_layanan->bind_param('s', $nama_layanan);
    $stmt_layanan->execute();
    $result_layanan = $stmt_layanan->get_result();

    // Mendapatkan id berdasarkan nama dari tabel kain
    $sql_kain = "SELECT id_kain FROM kain WHERE BINARY nama_kain = ?";
    $stmt_kain = $db->prepare($sql_kain);
    if ($stmt_kain === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
        exit;
    }
    $stmt_kain->bind_param('s', $nama_kain);
    $stmt_kain->execute();
    $result_kain = $stmt_kain->get_result();

    if ($result_petugas->num_rows > 0 && $result_pelanggan->num_rows > 0 && $result_layanan->num_rows > 0 && $result_kain->num_rows > 0) {
        $petugas_data = $result_petugas->fetch_assoc();
        $pelanggan_data = $result_pelanggan->fetch_assoc();
        $layanan_data = $result_layanan->fetch_assoc();
        $kain_data = $result_kain->fetch_assoc();
        $id_petugas = $petugas_data['id_petugas'];
        $id_pelanggan = $pelanggan_data['id_pelanggan'];
        $id_layanan = $layanan_data['id_layanan'];
        $id_kain = $kain_data['id_kain'];

        // Simpan data ke tabel pesan_jasa
        $sql_insert = "UPDATE pesan_jasa SET id_petugas=?, id_pelanggan=?, id_layanan=?, id_kain=?, tanggal_pesan=?, tanggal_ambil=?, jumlah=?, status_pesan=? WHERE id_pesan = '$id_pesan'";
        $stmt_insert = $db->prepare($sql_insert);
        if ($stmt_insert === false) {
            echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
            exit;
        }
        $stmt_insert->bind_param('iiiissis', $id_petugas, $id_pelanggan, $id_layanan, $id_kain, $tanggal_pesan, $tanggal_ambil, $jumlah, $status_pesan);

        if ($stmt_insert->execute()) {
            echo json_encode(array('status' => 'success', 'message' => 'Data berhasil disimpan'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Simpan gagal: ' . $stmt_insert->error));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Nama petugas, nama pelanggan, nama layanan, atau nama kain tidak ditemukan di tabel terkait'));
    }

    // // Tutup semua pernyataan untuk melepaskan sumber daya
    // $stmt_petugas->close();
    // $stmt_pelanggan->close();
    // $stmt_layanan->close();
    // $stmt_kain->close();
    // $stmt_check->close();
    // $stmt_insert->close();
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Permintaan tidak valid'));
}

// Tutup koneksi
$db->close();
?>
