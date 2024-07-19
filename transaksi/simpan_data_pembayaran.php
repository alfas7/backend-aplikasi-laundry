<?php
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Tampilkan data POST yang diterima
    error_log(print_r($_POST, true));

    // Pastikan semua kunci yang diperlukan ada dalam array POST
    $required_keys = ['id_pesan', 'nama', 'jumlah_bayar', 'metode_bayar', 'tanggal_bayar'];
    foreach ($required_keys as $key) {
        if (!isset($_POST[$key])) {
            echo json_encode(array('status' => 'error', 'message' => "Key '$key' tidak ditemukan dalam request"));
            exit;
        }
    }

    // Ambil nilai dari POST
    $id_pesan = trim($_POST['id_pesan']);
    $nama = trim($_POST['nama']);
    $jumlah_bayar = trim($_POST['jumlah_bayar']);
    $metode_bayar = trim($_POST['metode_bayar']);
    $tanggal_bayar = trim($_POST['tanggal_bayar']);

    // Mendapatkan id berdasarkan id_pengajuan_sewa dari tabel pesan
    $sql_pesan_jasa = "SELECT id_pesan FROM pesan_jasa WHERE BINARY id_pesan = ?";
    $stmt_pesan_jasa = $db->prepare($sql_pesan_jasa);
    if ($stmt_pesan_jasa === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
        exit;
    }
    $stmt_pesan_jasa->bind_param('s', $id_pesan);
    $stmt_pesan_jasa->execute();
    $result_pesan_jasa = $stmt_pesan_jasa->get_result();

    // Mendapatkan id pelanggan berdasarkan nama dari tabel pelanggan
    $sql_pelanggan = "SELECT id_pelanggan FROM pelanggan WHERE BINARY nama = ?";
    $stmt_pelanggan = $db->prepare($sql_pelanggan);
    if ($stmt_pelanggan === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
        exit;
    }
    $stmt_pelanggan->bind_param('s', $nama);
    $stmt_pelanggan->execute();
    $result_pelanggan = $stmt_pelanggan->get_result();

    if ($result_pesan_jasa->num_rows > 0 && $result_pelanggan->num_rows > 0) {
        $pesan_jasa_data = $result_pesan_jasa->fetch_assoc();
        $pelanggan_data = $result_pelanggan->fetch_assoc();
        $id_pesan = $pesan_jasa_data['id_pesan'];
        $id_pelanggan = $pelanggan_data['id_pelanggan'];

        // Memastikan tidak ada entri duplikat di tabel pembayaran
        $sql_check = "SELECT COUNT(*) as count FROM pembayaran WHERE id_pesan = ? AND id_pelanggan = ? AND jumlah_bayar = ? AND metode_bayar = ? AND tanggal_bayar = ?";
        $stmt_check = $db->prepare($sql_check);
        if ($stmt_check === false) {
            echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
            exit;
        }
        $stmt_check->bind_param('iisss', $id_pesan, $id_pelanggan, $jumlah_bayar, $metode_bayar, $tanggal_bayar);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $check_data = $result_check->fetch_assoc();

        if ($check_data['count'] > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'Data sudah ada di tabel pembayaran'));
            exit;
        }

        // Simpan data ke tabel pembayaran
        $sql_insert = "INSERT INTO pembayaran (id_pesan, id_pelanggan, jumlah_bayar, metode_bayar, tanggal_bayar) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $db->prepare($sql_insert);
        if ($stmt_insert === false) {
            echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
            exit;
        }
        $stmt_insert->bind_param('iisss', $id_pesan, $id_pelanggan, $jumlah_bayar, $metode_bayar, $tanggal_bayar);

        if ($stmt_insert->execute()) {
            echo json_encode(array('status' => 'success', 'message' => 'Data berhasil disimpan'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Simpan gagal: ' . $stmt_insert->error));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'id_pesan, nama pelanggan, atau jenis pembayaran tidak ditemukan di tabel terkait'));
    }

    // Tutup semua pernyataan untuk melepaskan sumber daya
    // $stmt_pesan_jasa->close();
    // $stmt_pelanggan->close();
    // $stmt_insert->close();
    // $stmt_check->close();
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Permintaan tidak valid'));
}

// Tutup koneksi
$db->close();
?>
