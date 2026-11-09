<?php
$id = $_POST['id'];
$nama_objek = $_POST['nama_objek'];
$jenis = $_POST['jenis'];
$kecamatan = $_POST['kecamatan'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];

// Sesuaikan dengan setting MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jakarta";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("UPDATE bank_sampah SET `Nama Objek`=?, Jenis=?, Kecamatan=?, 
    Longitude=?, Latitude=? 
    WHERE id=?");
$stmt->bind_param("sssddi", $nama_objek, $jenis, $kecamatan, $longitude, $latitude, $id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../index.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();