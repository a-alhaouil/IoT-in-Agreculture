<?php
session_start();

// Vérifie si l'utilisateur est déjà connecté, sinon redirige vers la page de connexion
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iotdb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the temperature, humidity, and moisture values from the POST data
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $moisture = $_POST['moisture'];

    // Prepare the SQL statement to insert data into the table
    $sql = "INSERT INTO dht_table (temperature, humidity, moisture) VALUES ('$temperature', '$humidity', '$moisture')";

    if ($conn->query($sql) === TRUE) {
        echo "Data saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch data from the table
$sql = "SELECT * FROM dht_table";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Temperature and Humidity and Soil Moisture Data</title>
    <style>
        .container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .photos {
            width: 25%;
            padding: 10px;
        }

        .content {
            width: 75%;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ccc;
            background-color: #f2f2f2;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #ffffff;
        }

        .sidebar-button {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .sidebar-button:hover {
            background-color: #0056b3;
        }
    </style>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="photos">
            <h3>IoT in Agriculture</h3>
            <!-- Add sidebar content with new button -->
            <a href="#planet-watering" class="sidebar-button">Planet Watering</a>
            <img src="im/im1.jpg" alt="Photo 1" width="200"> <br>
            <img src="im/im2.jpg" alt="Photo 2" width="200"><br>
            <img src="im/im3.png" alt="Photo 1" width="200"> <br>
            <img src="im/im1.jpg" alt="Photo 2" width="200"><br>
            <img src="im/im4.png" alt="Photo 1" width="200"> <br>
            <img src="im/im5.png" alt="Photo 2" width="200"><br>
            <img src="im/im1.jpg" alt="Photo 1" width="200"> <br>
            <img src="im/im2.jpg" alt="Photo 2" width="200"><br>
            <img src="im/im3.png" alt="Photo 1" width="200"> <br>
            <img src="im/im1.jpg" alt="Photo 2" width="200"><br>
            <img src="im/im4.png" alt="Photo 1" width="200"> <br>
            <img src="im/im5.png" alt="Photo 2" width="200"><br>
            <img src="im/im5.png" alt="Photo 2" width="200"><br>
            <img src="im/im1.jpg" alt="Photo 1" width="200"> <br>
            <img src="im/im2.jpg" alt="Photo 2" width="200"><br>
        </div>
        <div class="content">
            <h2>Temperature and Humidity and Soil Moisture Data</h2>
            <div class="row">
                <div class="col-md-6">
                    <canvas id="temperatureChart" width="400" height="250"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="humidityChart" width="400" height="250"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <canvas id="combinedChart" width="800" height="400"></canvas>
                </div>
            </div>
            <br>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>Temperature</th>
                        <th>Humidity</th>
                        <th>Moisture</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["timestamp"] . "</td>";
                            echo "<td>" . $row["temperature"] . "</td>";
                            echo "<td>" . $row["humidity"] . "</td>";
                            echo "<td>" . $row["moisture"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <form action="index.php" method="post">
                <h2>Planet Watering Classification</h2>
                <div class="form-group">
                    <label for="temperature">Temperature:</label>
                    <input type="number" id="temperature" name="temperature" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="humidity">Humidity:</label>
                    <input type="number" id="humidity" name="humidity" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="moisture">Moisture:</label>
                    <input type="number" id="moisture" name="moisture" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Classify</button>
            </form>
            <br>
            <br>
            <!-- Display classification results -->
            <div id="classification-results">
                <?php
                if (isset($_GET['classification'])) {
                    echo "<div class='alert alert-info'>Classification Result: " . htmlspecialchars($_GET['classification']) . "</div>";
                }
                if (isset($_POST['temperature']) && isset($_POST['humidity']) && isset($_POST['moisture'])) {
                    $temperature = $_POST['temperature'];
                    $humidity = $_POST['humidity'];
                    $moisture = $_POST['moisture'];

                    // Prepare the SQL statement to insert data into the table
                    $sql = "INSERT INTO dht_table (temperature, humidity, moisture) VALUES ('$temperature', '$humidity', '$moisture')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<p>Data inserted successfully into the database.</p>";

                        // Perform classification
                        // For demonstration, we use simple classification logic
                        // Replace this section with your actual classification logic
                        $classification = "Not classified"; // Replace with actual classification result
                        if ($moisture < 20) {
                            $classification = "Water needed";
                        } elseif ($moisture < 40) {
                            $classification = "Optimal moisture";
                        } else {
                            $classification = "Watering not needed";
                        }

                        echo "<p>Classification result based on temperature $temperature, humidity $humidity, and moisture $moisture: $classification</p>";
                    } else {
                        echo "<p>Error inserting data: " . $conn->error . "</p>";
                    }
                }
                ?>
            </div>
            <br>
            <form action="login.php" method="post">
                <button type="submit" class="btn btn-primary">LOG OUT</button>
            </form>
            <br>
            <form action="table.php" method="post">
                <button type="submit" class="btn btn-primary">TABLE</button>
            </form>
        </div>
    </div>

    <script>
        // Prepare data for temperature chart
        var temperatureData = {
            labels: [],
            datasets: [{
                label: 'Temperature',
                data: [],
                borderColor: 'rgb(75, 192, 192)',
                fill: false
            }]
        };

        // Prepare data for humidity chart
        var humidityData = {
            labels: [],
            datasets: [{
                label: 'Humidity',
                data: [],
                borderColor: 'rgb(255, 99, 132)',
                fill: false
            }]
        };

        // Prepare data for combined chart
        var combinedData = {
            labels: [],
            datasets: [{
                label: 'Temperature',
                data: [],
                borderColor: 'rgb(75, 192, 192)',
                fill: false
            },
            {
                label: 'Humidity',
                data: [],
                borderColor: 'rgb(255, 99, 132)',
                fill: false
            }]
        };

        <?php
        // Reset the result pointer to the beginning
        mysqli_data_seek($result, 0);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Add timestamp, temperature, and humidity to the JavaScript variables
                echo "temperatureData.labels.push('" . $row["timestamp"] . "');";
                echo "temperatureData.datasets[0].data.push(" . $row["temperature"] . ");";
                echo "humidityData.labels.push('" . $row["timestamp"] . "');";
                echo "humidityData.datasets[0].data.push(" . $row["humidity"] . ");";
                echo "combinedData.labels.push('" . $row["timestamp"] . "');";
                echo "combinedData.datasets[0].data.push(" . $row["temperature"] . ");";
                echo "combinedData.datasets[1].data.push(" . $row["humidity"] . ");";
            }
        }
        ?>

        // Create temperature chart
        var temperatureChartCtx = document.getElementById('temperatureChart').getContext('2d');
        var temperatureChart = new Chart(temperatureChartCtx, {
            type: 'line',
            data: temperatureData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Timestamp'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Temperature'
                        }
                    }
                }
            }
        });

        // Create humidity chart
        var humidityChartCtx = document.getElementById('humidityChart').getContext('2d');
        var humidityChart = new Chart(humidityChartCtx, {
            type: 'line',
            data: humidityData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Timestamp'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Humidity'
                        }
                    }
                }
            }
        });

        // Create combined chart
        var combinedChartCtx = document.getElementById('combinedChart').getContext('2d');
        var combinedChart = new Chart(combinedChartCtx, {
            type: 'line',
            data: combinedData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Timestamp'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
