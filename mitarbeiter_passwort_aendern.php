<?php
include_once "zugriffskontrolle.php";

// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "inventardb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["id"])) {
    $mitarbeiterid = $_GET["id"];
    $neues_passwort = $_POST["neues_passwort"];
    $neues_passwort_bestätigen = $_POST["neues_passwort_bestätigen"];

    if ($neues_passwort == $neues_passwort_bestätigen) {
        $hashed_passwort = password_hash($neues_passwort, PASSWORD_DEFAULT);

        $update_sql = "UPDATE mitarbeiterinnen SET passwort = '$hashed_passwort' WHERE mitarbeiterid = '$mitarbeiterid'";
        if ($conn->query($update_sql) === TRUE) {
            header("Location: mitarbeiter.php");
            exit();
        } else {
            echo "Fehler beim Aktualisieren des Passworts: " . $conn->error;
        }
    } else {
        echo "Die neuen Passwörter stimmen nicht überein.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Passwort ändern</title>
    <link rel="stylesheet" type="text/css" href="style_mitarbeiter.css">
</head>
<body>
<?php include('menu.php'); ?>
<div class= "content">
    <div class="container">
    <h1>Passwort ändern</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $_GET["id"]; ?>">
        <label for="neues_passwort">Neues Passwort:</label>
        <input type="password" name="neues_passwort" required><br>
        <label for="neues_passwort_bestätigen">Neues Passwort bestätigen:</label>
        <input type="password" name="neues_passwort_bestätigen" required><br>
        <input type="submit" value="Speichern">
        <a href="mitarbeiter.php">Abbrechen</a>
    </form>
</div>
</div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>

