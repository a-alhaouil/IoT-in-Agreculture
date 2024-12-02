<?php
// Récupérer les valeurs de température et d'humidité depuis les paramètres GET
$temperature = $_GET['temperature'];
$humidity = $_GET['humidity'];
$moisture = $_GET['moisture'];


// Effectuer la connexion à votre base de données MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iotdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Insérer les données dans votre table
$sql = "INSERT INTO dht_table (temperature, humidity,moisture) VALUES ($temperature, $humidity, $moisture)";

if ($conn->query($sql) === TRUE) {
    echo "Données insérées avec succès dans la base de données";
} else {
    echo "Erreur lors de l'insertion des données : " . $conn->error;
}

$conn->close();
