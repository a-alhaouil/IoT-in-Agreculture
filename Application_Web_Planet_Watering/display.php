<?php
 

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
    // Get the temperature and humidity values from the POST data
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $moisture = $_POST['moisture'];


    // Prepare the SQL statement to insert data into the table
    $sql = "INSERT INTO dht_table (temperature, humidity; moisture) VALUES ('$temperature', '$humidity', '$moisture')";

    if ($conn->query($sql) === TRUE) {
        echo "Data saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch the latest record from the database
$sql = "SELECT * FROM dht_table ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

// Fetch the first row for the initial values
if ($result->num_rows > 0) {
    $initialRow = $result->fetch_assoc();
} else {
    // Set default values if no data is available
    $initialRow = ['temperature' => 0, 'humidity' => 0,'moisture'=>0 ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <style>
    .chart {
      width: 100%;
      min-height: 450px;
    }
    .row {
      margin: 0 !important;
    }
  </style>
</head>
<body>
        <h1>Real Time value Humidity & Temperature</h1>
    
    <div class="card">
        <div class="card-body">
    <div class="row">
    <h1 class="text-center">Real-Time Humidity | Temperature | Moisture</h1>
      <div class="col-md-12 text-center">
        
      </div>
      <div class="clearfix"></div>

      <div class="col-md-4">
        <div id="chart_temperature" class="chart"></div>
      </div>

      <div class="col-md-4">
        <div id="chart_humidity" class="chart"></div>
      </div>

      <div class="col-md-4">
        <div id="chart_moisture" class="chart"></div>
      </div>
    </div>
    </div>
    </div>
  <script>
    google.charts.load('current', {'packages':['gauge']});
    google.charts.setOnLoadCallback(drawTemperatureChart);

    function drawTemperatureChart() {
      var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['T_Curr', <?php echo $initialRow['temperature']; ?>],
      ]);

      var options = {
        width: 800,
        height: 400,
        redFrom: 70,
        redTo: 100,
        yellowFrom: 40,
        yellowTo: 70,
        greenFrom: 0,
        greenTo: 40,
        minorTicks: 5
      };

      var chart = new google.visualization.Gauge(document.getElementById('chart_temperature'));
      chart.draw(data, options);
    }

    google.charts.load('current', {'packages':['gauge']});
    google.charts.setOnLoadCallback(drawHumidityChart);

    function drawHumidityChart() {
      var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['H_Curr', <?php echo $initialRow['humidity']; ?>],
      ]);

      var options = {
        width: 800,
        height: 400,
        redFrom: 70,
        redTo: 100,
        yellowFrom: 40,
        yellowTo: 70,
        greenFrom: 0,
        greenTo: 40,
        minorTicks: 5
      };

      var chart = new google.visualization.Gauge(document.getElementById('chart_humidity'));
      chart.draw(data, options);
    }

    $(window).resize(function(){
      drawTemperatureChart();
      drawHumidityChart();
    });



    google.charts.load('current', {'packages':['gauge']});
    google.charts.setOnLoadCallback(drawMoistureChart);


    function drawMoistureChart() {
      var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['M_Curr', <?php echo $initialRow['moisture']; ?>],
      ]);

      var options = {
        width: 800,
        height: 400,
        redFrom: 70,
        redTo: 100,
        yellowFrom: 40,
        yellowTo: 70,
        greenFrom: 0,
        greenTo: 40,
        minorTicks: 5
      };

      var chart = new google.visualization.Gauge(document.getElementById('chart_moisture'));
      chart.draw(data, options);
    }

  </script>
</body>
</html>
