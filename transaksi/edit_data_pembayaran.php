<?php
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Tampilkan data POST yang diterima
    error_log(print_r($_POST, true));

    // Pastikan semua kunci yang diperlukan ada dalam array POST
    $required_keys = ['id_pesan', 'nama', 'jumlah_bayar', 'metode_bayar', 'tanggal_bayar', 'id_pembayaran'];
    foreach ($required_keys as $key) {
        if (!isset($_POST[$key])) {
            echo json_encode(array('status' => 'error', 'message' => "Key '$key' tidak ditemukan dalam request"));
            exit;
        }
    }

    // Ambil nilai dari POST
    $id_pembayaran = $_POST['id_pembayaran'];
    $id_pesan = trim($_POST['id_pesan']);
    $nama = trim($_POST['nama']);
    $jumlah_bayar = trim($_POST['jumlah_bayar']);
    $metode_bayar = trim($_POST['metode_bayar']);
    $tanggal_bayar = trim($_POST['tanggal_bayar']);

    // Mendapatkan id berdasarkan id_pesan dari tabel pesan_jasa
    $sql_pesan_jasa = "SELECT id_pesan FROM pesan_jasa WHERE BINARY id_pesan = ?";
    $stmt_pesan_jasa = $db->prepare($sql_pesan_jasa);
    if ($stmt_pesan_jasa === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
        exit;
    }
    $stmt_pesan_jasa->bind_param('s', $id_pesan);
    $stmt_pesan_jasa->execute();
    $result_pesan_jasa = $stmt_pesan_jasa->get_result();

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

    if ($result_pesan_jasa->num_rows > 0 && $result_pelanggan->num_rows > 0) {
        $pesan_jasa_data = $result_pesan_jasa->fetch_assoc();
        $pelanggan_data = $result_pelanggan->fetch_assoc();
        $id_pesan = $pesan_jasa_data['id_pesan'];
        $id_pelanggan = $pelanggan_data['id_pelanggan'];

        // Update data di tabel pembayaran
        $sql_update = "UPDATE pembayaran SET jumlah_bayar = ?, metode_bayar = ?, tanggal_bayar = ?, id_pesan = ?, id_pelanggan = ? WHERE id_pembayaran = ? ";
        $stmt_update = $db->prepare($sql_update);
        if ($stmt_update === false) {
            echo json_encode(array('status' => 'error', 'message' => 'Prepare statement gagal: ' . $db->error));
            exit;
        }
        $stmt_update->bind_param('sssiii', $jumlah_bayar, $metode_bayar, $tanggal_bayar, $id_pesan, $id_pelanggan, $id_pembayaran );

        if ($stmt_update->execute()) {
            echo json_encode(array('status' => 'success', 'message' => 'Data berhasil diperbarui'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Update gagal: ' . $stmt_update->error));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'ID pesan atau nama pelanggan tidak ditemukan di tabel terkait'));
    }

    // Tutup semua pernyataan untuk melepaskan sumber daya
    // $stmt_pesan_jasa->close();
    // $stmt_pelanggan->close();
    // $stmt_update->close();
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Permintaan tidak valid'));
}

// Tutup koneksi
$db->close();
?>
