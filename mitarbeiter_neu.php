<?php
include_once "zugriffskontrolle.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Neuer Mitarbeiter hinzufügen</title>
    <link rel="stylesheet" type="text/css" href="style_mitarbeiter.css">
</head>
<body>
<?php include('menu.php'); ?>
<div class= "content">
    <div class="container">
    <?php
    // Verbindung zur Datenbank herstellen
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "inventardb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
    }
    $successMessage = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["neuer_mitarbeiter"])) {
        $mitarbeiterid = $_POST["mitarbeiterid"];
        $vorname = $_POST["vorname"];
        $nachname = $_POST["nachname"];
        $abteilung = $_POST["abteilung"];
        $benutzername = $_POST["benutzername"];
        $passwort = $_POST["passwort"];

        // Sicheres Hashen des Passworts
        $hashed_passwort = password_hash($passwort, PASSWORD_DEFAULT);

        // Einfügen des neuen Mitarbeiters in die Datenbank
        $insert_sql = "INSERT INTO mitarbeiterinnen (mitarbeiterid, vorname, nachname, abteilung, benutzername, passwort) VALUES ('$mitarbeiterid', '$vorname', '$nachname', '$abteilung', '$benutzername', '$hashed_passwort')";
        if ($conn->query($insert_sql) === TRUE) {
            $successMessage = "Neuer Mitarbeiter erfolgreich hinzugefügt.";
        } else {
            echo "Fehler beim Hinzufügen des Mitarbeiters" . $conn->error;
        }

        
    }
    ?>

    <h1>Neuen Mitarbeiter hinzufügen</h1>
    <?php
    // Erfolgsmeldung anzeigen, wenn sie gesetzt ist
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="mitarbeiterid">Mitarbeiter ID:</label>
        <input type="text" name="mitarbeiterid" required><br>
        <label for="vorname">Vorname:</label>
        <input type="text" name="vorname" required><br>
        <label for="nachname">Nachname:</label>
        <input type="text" name="nachname" required><br>
        <label for="abteilung">Abteilung:</label>
        <input type="text" name="abteilung" required><br>
        <label for="benutzername">Benutzername:</label>
        <input type="text" name="benutzername" required><br>
        <label for="passwort">Passwort:</label>
        <input type="password" name="passwort" required><br>
        <input type="submit" name="neuer_mitarbeiter" value="Speichern">
    </form>
    
    <br>
    <a href="mitarbeiter.php">Abbrechen</a>
</div>
</div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
