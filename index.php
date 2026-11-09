<?php
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

$sql = "SELECT * FROM bank_sampah";
$result = $conn->query($sql);
echo "<a href='input/index.html'>Input</a>";

if ($result->num_rows > 0) {
    echo "<table border='1px'><tr> 
<th>Nama Objek</th>
<th>Jenis</th>
<th>Kecamatan</th>
<th>Longitude</th>
<th>Latitude</th>
<th colspan='2'>Aksi</th></tr>";

    // output data of each row 
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Nama Objek"] . "</td>" .
            "<td>" . $row["Jenis"] . "</td>" .
            "<td>" . $row["Kecamatan"] . "</td>" .
            "<td>" . $row["Longitude"] . "</td>" .
            "<td>" . $row["Latitude"] . "</td>" .
            "<td><a href='delete.php?id=" . $row["id"] . "'>hapus</a></td>" .
            "<td><a href='edit/index.php?id=" . $row["id"] . "'>edit</a></td>" .
            "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();