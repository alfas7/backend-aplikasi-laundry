<?php
include '../koneksi.php'; // Ensure this path is correct

// Check if id_pengembalian_sewa is sent via POST
if (isset($_POST['id_pembayaran'])) {
    $id_pembayaran = mysqli_real_escape_string($db, $_POST['id_pembayaran']);

    // Prepare the SQL query to delete the record based on id_pembayaran
    $sql = "DELETE FROM pembayaran WHERE id_pembayaran = '$id_pembayaran'";
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
    // Return an error message in JSON format if id_pengembalian_sewa is not sent
    echo json_encode(array('status' => 'error', 'message' => 'ID pengembalian_sewa tidak dikirim'));
}
?>
