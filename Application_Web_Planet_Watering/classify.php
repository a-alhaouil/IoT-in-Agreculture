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

$manualValues = [
    'temperature' => '',
    'humidity' => '',
    'moisture' => '',
    'classification' => ''
];

$automaticValues = [
    'avtemperature' => '',
    'avhumidity' => '',
    'avmoisture' => '',
    'avclassification' => ''
];

$manualValues = [];
$automaticValues = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    // Manual mode
        $temperature = $_POST['temperature'];
        $humidity = $_POST['humidity'];
        $moisture = $_POST['moisture'];

        // Execute the Python script to get the classification
        $command = escapeshellcmd("python C:\\Users\\abdes\\Desktop\\IoT-in-Agreculture\\Application_Web_Planet_Watering\\predict.py $moisture $temperature $humidity");
        $classificationResult = shell_exec($command);

        // Convert the result to readable format
        $classification = trim($classificationResult);

        // Set values to display
        $manualValues = [
            'temperature' => $temperature,
            'humidity' => $humidity,
            'moisture' => $moisture,
            'classification' => $classification
        ];
    

        // Automatic mode
        // Get the average values for the last day
        $averageQuery = "
            SELECT AVG(temperature) as avg_temp, AVG(humidity) as avg_humidity, AVG(moisture) as avg_moisture 
            FROM dht_table 
            WHERE timestamp >= NOW() - INTERVAL 1 DAY";
        $result = $conn->query($averageQuery);
        if ($result->num_rows > 0) {
            $averageData = $result->fetch_assoc();
            $averageTemperature = round($averageData['avg_temp'], 2);
            $averageHumidity = round($averageData['avg_humidity'], 2);
            $averageMoisture = round($averageData['avg_moisture'], 2);

            // Execute the Python script to get the classification
            $commandauto = escapeshellcmd("python C:\\Users\\abdes\\Desktop\\IoT-in-Agreculture\\Application_Web_Planet_Watering\\predict.py $averageMoisture $averageTemperature $averageHumidity");
            $avclassificationResult = shell_exec($commandauto);

            // Convert the result to readable format
            $averageClassification = trim($avclassificationResult);

            // Set values to display
            $automaticValues = [
                'avtemperature' => $averageTemperature,
                'avhumidity' => $averageHumidity,
                'avmoisture' => $averageMoisture,
                'avclassification' => $averageClassification
            ];
        } else {
            $automaticValues = [
                'avtemperature' => 'No data',
                'avhumidity' => 'No data',
                'avmoisture' => 'No data',
                'avclassification' => 'No data'
            ];
        }
    
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Planet Watering Classification</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .btn {
            width: 100%;
            background-color: #5F9EA0;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
        }
        .btn:hover {
            background-color: #4e857e;
        }
        .form-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="logo-details">
        <i class='bx bxl-c-plus-plus'></i>
        <span class="logo_name">IoT in Agriculture</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="dash.php">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="tables.php">
                <i class='bx bx-box'></i>
                <span class="links_name">Tables</span>
            </a>
        </li>
        <li>
            <a href="charts.php">
                <i class='bx bx-list-ul'></i>
                <span class="links_name">Charts</span>
            </a>
        </li>
        <li>
            <a href="classify.php" class="active">
                <i class='bx bx-pie-chart-alt-2'></i>
                <span class="links_name">Planet Watering</span>
            </a>
        </li>
        <li class="log_out">
            <a href="login.php">
                <i class='bx bx-log-out'></i>
                <span class="links_name">Log out</span>
            </a>
        </li>
    </ul>
</div>
<section class="home-section">
    <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard">Planet Watering Classification</span>
        </div>
        <div class="profile-details">
            <img src="images/profile.jpg" alt="">
            <span class="admin_name">Iotirrigation</span>
            <i class='bx bx-chevron-down'></i>
        </div>
    </nav>


    <div class="home-content">
        <div class="form-container">
            <form action="classify.php" method="post">
                <div class="form-group">
                    <label for="mode">Mode:</label>
                    <select id="mode" name="mode" class="form-control" onchange="toggleMode(this.value)">
                        <option value="manual">Manual</option>
                        <option value="automatic">Automatic</option>
                    </select>
                </div>
                    <div id="manual-inputs" style="display: block;">
                        <div class="form-group">
                            <label for="temperature">Temperature:</label>
                            <input type="number" id="temperature" name="temperature" class="form-control" step="0.1" required>
                        </div>
                        <div class="form-group">
                            <label for="humidity">Humidity:</label>
                            <input type="number" id="humidity" name="humidity" class="form-control" step="0.1" required>
                        </div>
                        <div class="form-group">
                            <label for="moisture">Moisture:</label>
                            <input type="number" id="moisture" name="moisture" class="form-control" step="0.1" required>
                        </div>
                        <button type="submit" class="btn">Classify</button>
                        <div class="result">
                        <h2>Classification Result:</h2>
                        <?php if (!empty($manualValues['classification'])): ?>

                            <p>Temperature: <?php echo htmlspecialchars($manualValues['temperature']); ?>°C</p>
                            <p>Humidity: <?php echo htmlspecialchars($manualValues['humidity']); ?>%</p>
                            <p>Moisture: <?php echo htmlspecialchars($manualValues['moisture']); ?>%</p>
                            <p>Classification: <?php echo htmlspecialchars($manualValues['classification']); ?></p>
                            <?php endif; ?>

                        </div>
                    </div>


                    <div id="auto-res" style="display: none;">
                        <div class="result">
                            <h2>auto Classification Result:</h2>
                            <?php if (!empty($automaticValues['avclassification'])): ?>

                                <p>Temperature: <?php echo htmlspecialchars($automaticValues['avtemperature']); ?>°C</p>
                                <p>Humidity: <?php echo htmlspecialchars($automaticValues['avhumidity']); ?>%</p>
                                <p>Moisture: <?php echo htmlspecialchars($automaticValues['avmoisture']); ?>%</p>
                                <p>Classification: <?php echo htmlspecialchars($automaticValues['avclassification']); ?></p>
                                <?php endif; ?>

                            </div>
                    </div>

            </form>
        </div>
    </div>
</section>

<script>
    function toggleMode(value) {
        var manualInputs = document.getElementById('manual-inputs');
        var autores = document.getElementById('auto-res');

        if (value === 'automatic') {
            autores.style.display = 'block';

        } else{
            autores.style.display  = 'none';

        }
        if(value=='manual') {
            manualInputs.style.display = 'block';
        }else{
            manualInputs.style.display = 'none';

        }
    }
</script>
</body>
</html>

<?php
$conn->close();
?>
