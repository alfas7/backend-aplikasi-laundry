<?php
include '../koneksi.php'; // Ensure this path is correct

// Check if id_pengajuan_sewa is sent via POST
if (isset($_POST['id_pesan'])) {
    $id_pesan = mysqli_real_escape_string($db, $_POST['id_pesan']);

    // Prepare the SQL query to delete the record based on id_pesan
    $sql = "DELETE FROM pesan_jasa WHERE id_pesan = '$id_pesan'";
    $query = mysqli_query($db, $sql);

    // Check if the query was successfully executed
    if ($query) {
        // Return a success response in JSON format
        echo json_encode(array('status' => 'success', 'message' => 'Data berhasil dihapus'));
    } else {
        // Return an error message in JSON format if the query failed
        echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus data: ' . mysqli_error($db)));
    }
} else {
    // Return an error message in JSON format if id_pengajuan_sewa is not sent
    echo json_encode(array('status' => 'error', 'message' => 'ID pengajuan sewa tidak dikirim'));
}
?>
