<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventardb";

$fehlermeldung = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $benutzername = $_POST["benutzername"];
    $passwort = $_POST["passwort"];

    // Verbindung zur Datenbank herstellen
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
    }

    $mitarbeiter_sql = "SELECT * FROM mitarbeiterinnen WHERE benutzername = '$benutzername'";
    $mitarbeiter_result = $conn->query($mitarbeiter_sql);

    if ($mitarbeiter_result) {
        if ($mitarbeiter_result->num_rows > 0) {
            $mitarbeiter_row = $mitarbeiter_result->fetch_assoc();
            $hash_passwort = $mitarbeiter_row["passwort"];

            if (password_verify($passwort, $hash_passwort)) {
                $_SESSION["eingeloggt"] = true;
                $_SESSION["mitarbeiterid"] = $mitarbeiter_row["mitarbeiterid"];
                $_SESSION["nachname"] = $mitarbeiter_row["nachname"];
                $_SESSION["benutzername"] = $mitarbeiter_row["benutzername"];
                $_SESSION["vorname"] = $mitarbeiter_row["vorname"];
                header("Location: index.php"); // Ändere dies auf die entsprechende Seite
                exit();
            } else {
                $fehlermeldung = "Ungültige Anmeldedaten";
            }
        } else {
            $fehlermeldung = "Ungültige Anmeldedaten";
        }
    } else {
        $fehlermeldung = "Fehler bei der Abfrage: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style_home.css"> 
    
</head>
<body>
    <div class="logo-container">
        <img src="logo.png" alt="Logo" class="logo">
    </div>
    <div class="login-container">
        <h1>Login</h1>
        <?php if ($fehlermeldung) echo "<p>$fehlermeldung</p>"; ?>
        <form method="POST" action="" class="login-form">
            <div class="form-group">
                <label for="benutzername">Benutzername:</label>
                <input type="text" name="benutzername" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="passwort">Passwort:</label>
                <input type="password" name="passwort" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Anmelden</button>
        </form>
    </div>
    <div class="footer fixed-bottom">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>

    <!-- Bootstrap JavaScript und Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>
</html>