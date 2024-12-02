x<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "iotdb";

    // Créer une connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données: " . $conn->connect_error);
    }

    // Récupérer les données du formulaire de connexion
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Préparer la requête SQL pour vérifier les informations d'identification
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Nom d'utilisateur et mot de passe corrects, créer une session
        $_SESSION['username'] = $username;
        header("Location: dash.php");
        exit;
    } else {
        // Nom d'utilisateur ou mot de passe incorrect
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
        header("Location: login.php");

    }

    $conn->close();
}
?>

<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--    <title>Connexion</title>-->
<!--    <style>-->
<!--        body {-->
            <!--background-color: black; /* Fond de la page en noir */-->
            <!--color: white; /* Couleur du texte en blanc */-->
<!--            font-family: Arial, sans-serif;-->
<!--        }-->

<!--        .container {-->
<!--            width: 300px;-->
<!--            margin: 0 auto;-->
<!--            margin-top: 100px;-->
<!--            padding: 20px;-->
<!--            background-color: #fff;-->
<!--            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);-->
<!--            border-radius: 5px;-->
<!--        }-->

<!--        h1 {-->
<!--            text-align: center;-->
            <!--color: #4CAF50; /* Couleur du titre en vert */-->
            <!--font-size: 24px; /* Taille du titre */-->
<!--        }-->

<!--        h2 {-->
<!--            text-align: center;-->
<!--            color: #333;-->
<!--        }-->

<!--        label {-->
<!--            display: block;-->
<!--            margin-bottom: 10px;-->
<!--            color: #333;-->
<!--        }-->

<!--        input[type="text"],-->
<!--        input[type="password"] {-->
<!--            width: 100%;-->
<!--            padding: 10px;-->
<!--            margin-bottom: 10px;-->
<!--            border-radius: 5px;-->
<!--            border: 1px solid #ccc;-->
<!--            box-sizing: border-box;-->
<!--        }-->

<!--        input[type="submit"] {-->
<!--            width: 100%;-->
<!--            padding: 10px;-->
<!--            background-color: #4CAF50;-->
<!--            color: white;-->
<!--            border: none;-->
<!--            border-radius: 5px;-->
<!--            cursor: pointer;-->
<!--        }-->

<!--        .error-message {-->
<!--            color: red;-->
<!--            font-weight: bold;-->
<!--            margin-bottom: 10px;-->
<!--        }-->

        <!--/* Ajout d'un style pour les images à gauche de la page */-->
<!--        .left-images {-->
<!--            position: absolute;-->
<!--            left: 20px;-->
<!--            top: 20px;-->
<!--            max-width: 50px;-->
<!--            max-height: 50px;-->
<!--        }-->
<!--    </style>-->
<!--</head>-->
<!--<body>-->
<!--    <img src="im/im1.jpg" alt="Image1" class="left-images"> <br> <br>-->
<!--    <img src="im/im4.jpg" alt="Image2" class="left-images">-->

<!--    <div class="container">-->
<!--        <h1>IoT in Agriculture</h1> <!-- Titre en haut de la page -->
<!--        <h2>Authentication</h2>-->

        <!--<?php if (isset($error_message)) { ?>-->
        <!--    <p class="error-message"><?php echo $error_message; ?></p>-->
        <!--<?php } ?>-->

<!--        <form method="POST" action="">-->
<!--            <label for="username">Username</label>-->
<!--            <input type="text" name="username" id="username" required>-->

<!--            <label for="password">Password</label>-->
<!--            <input type="password" name="password" id="password" required>-->

<!--            <input type="submit" value="Login">-->
<!--        </form>-->
<!--    </div>-->
<!--</body>-->
<!--</html>-->

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <style>
        body {
            background-color: #f1f1f1;
        }

        .container {
            width: 300px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Authentication</h2>

        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>

        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>