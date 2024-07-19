<?php
// Koneksi ke database
$server = "localhost";
$user = "root";
$password = "";
$nama_db = "dblaundry";

$db = new mysqli($server, $user, $password, $nama_db);

// Periksa koneksi
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

?>



