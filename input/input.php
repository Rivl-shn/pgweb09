<?php
$nama_objek = $_POST['nama_objek'];
$jenis = $_POST['jenis'];
$kecamatan = $_POST['kecamatan'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jakarta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO bank_sampah
(`Nama Objek`, Jenis, Kecamatan, Longitude, Latitude)
VALUES
(?, ?, ?, ?, ?)");
$stmt->bind_param("sssdd", $nama_objek, $jenis, $kecamatan, $longitude, $latitude);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: index.html");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();