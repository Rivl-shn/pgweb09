<!DOCTYPE html>
<html>

<body>
    <h2>Form Edit</h2>
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

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === false || $id === null || $id < 1) {
        echo "<p>Pilih data yang ingin diedit:</p>";
        $records = $conn->query("SELECT id, `Nama Objek` FROM bank_sampah");

        if ($records->num_rows > 0) {
            echo "<ul>";
            while ($record = $records->fetch_assoc()) {
                $recordId = (int) $record['id'];
                $namaObjek = htmlspecialchars($record['Nama Objek'], ENT_QUOTES, 'UTF-8');
                echo "<li><a href='?id=$recordId'>$namaObjek</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Belum ada data bank sampah untuk diedit.</p>";
        }

        $conn->close();
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM bank_sampah WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<form action='edit.php' onsubmit='return validateForm()' method='post'>";
        while ($row = $result->fetch_assoc()) {
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'><br>";
            echo "<label for='nama_objek'>Nama Objek:</label><br>";
            echo "<input type='text' id='nama_objek' name='nama_objek' value='" . htmlspecialchars($row['Nama Objek'], ENT_QUOTES, 'UTF-8') . "'><br>";
            echo "<label for='jenis'>Jenis:</label><br>";
            echo "<input type='text' id='jenis' name='jenis' value='" . htmlspecialchars($row['Jenis'], ENT_QUOTES, 'UTF-8') . "'><br>";
            echo "<label for='kec'>Kecamatan:</label><br>";
            echo "<input type='text' id='kec' name='kecamatan' value='" . htmlspecialchars($row['Kecamatan'], ENT_QUOTES, 'UTF-8') . "'><br>";
            echo "<label for='long'>Longitude:</label><br>";
            echo "<input type='text' id='long' name='longitude' value='" . $row['Longitude'] . "'><br>";
            echo "<label for='lat'>Latitude:</label><br>";
            echo "<input type='text' id='lat' name='latitude' value='" . $row['Latitude'] . "'><br><br>";
        }
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
    } else {
        echo "<p>Data dengan ID tersebut tidak ditemukan. Silakan kembali ke <a href='../index.php'>daftar bank sampah</a>.</p>";
    }
    $stmt->close();
    $conn->close();
    ?>

    <p id="informasi"></p>

    <script>
        function validateForm() {

            let longitude = document.getElementById("long").value;
            let latitude = document.getElementById("lat").value;
            let text = "";
            if (isNaN(longitude) || isNaN(latitude) || longitude === "" || latitude === "") {
                text = "Data longitude dan latitude harus berupa angka";
                // stop the form submission 
                event.preventDefault();
            }

            document.getElementById("informasi").innerHTML = text;
        }
    </script>
</body>

</html>