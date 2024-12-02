<!-- <h3>test model</h3>

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
$temperature = $_POST['temperature'];
$humidity = $_POST['humidity'];
$moisture = $_POST['moisture'];


$command = escapeshellcmd("python predict.py $moisturePercentage $temperature $humidity");
$classificationResult = shell_exec($command);
echo  $classificationResult;

}
?>

<form action="testtt.php" method="post">

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
                </div>
                <button type="submit" class="btn">Classify</button>
                </div>  
                <p>Classification: <?php echo  $classificationResult; ?></p>
              


            </form> -->


            <h3>test model</h3>

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
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $moisture = $_POST['moisture'];

    // Construct the command with escapeshellcmd and escapeshellarg for safety
    $command = escapeshellcmd("python predict.py") . " " . escapeshellarg($moisture) . " " . escapeshellarg($temperature) . " " . escapeshellarg($humidity);
    $classificationResult = shell_exec($command);
    echo $classificationResult;
}
?>

<form action="testtt.php" method="post">
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
    <p>Classification: <?php if(isset($classificationResult)) echo $classificationResult; ?></p>
</form>
