<?php
// Replace with your database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iotdb";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if data was received
if (isset($_POST['temperature']) && isset($_POST['humidity'])&& isset($_POST['moisture'])) {
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $moisture = $_POST['moisture'];

    // Prepare and execute SQL query to insert data into the table
    $sql = "INSERT INTO dht_table (temperature, humidity,moisture) VALUES ('$temperature', '$humidity';'moisture')";
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve data from the table
$sql = "SELECT * FROM dht_table";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Sensor Data</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h1>Sensor Data</h1>
    <table>
        <tr>
            <th>Timestamp</th>
            <th>Temperature</th>
            <th>Humidity</th>            
            <th>moisture</th>
        </tr>
        <?php
        // Display data in HTML table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['timestamp'] . "</td>";
                echo "<td>" . $row['temperature'] . "</td>";
                echo "<td>" . $row['humidity'] . "</td>";
                echo "<td>" . $row['moisture'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data available</td></tr>";
        }
        ?>
    </table>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>