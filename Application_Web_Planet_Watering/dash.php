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
    // Get the temperature and humidity values from the POST data
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $moisture = $_POST['moisture'];


    // Prepare the SQL statement to insert data into the table
    $sql = "INSERT INTO dht_table (temperature, humidity,moisture ) VALUES ('$temperature', '$humidity';'$moisture')";

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
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Responsiive Admin Dashboard | CodingLab </title>
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">IoT in Agreculture</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="dash.php" class="active">
            <i class='bx bx-grid-alt' ></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="tables.php">
            <i class='bx bx-box' ></i>
            <span class="links_name">Tables</span>
          </a>
        </li>
        <li>
          <a href="charts.php">
            <i class='bx bx-list-ul' ></i>
            <span class="links_name">Charts</span>
          </a>
        </li>
        <li>
        <a href="classify.php">
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
        <span class="dashboard">Dashboard</span>
      </div>
       
      <div class="profile-details">
        <img src="images/profile.jpg" alt="">
        <span class="admin_name">Iotirrigation</span>
        <i class='bx bx-chevron-down' ></i>
      </div>
    </nav>

     

      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">Recent Sales</div>
          <div class="sales-details" >
         
          </div>
           
        </div>
    <div  >   <?php include 'display.php'; ?> </div>
       
       
        
      </div>
    </div>
  </section>

  <script>
   let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}
 </script>

</body>
</html>