<?php
include_once "zugriffskontrolle.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Neuer Teilnehmer hinzufügen</title>
    <link rel="stylesheet" type="text/css" href="style_teilnehmer.css">
</head>
<body>
<?php include('menu.php'); ?>
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["neuer_teilnehmer"])) {
        $rehanr = $_POST["rehanr"];
        $vorname = $_POST["vorname"];
        $nachname = $_POST["nachname"];
        $kurs = $_POST["kurs"];

        // Einfügen des neuen Teilnehmers in die Datenbank
        $insert_sql = "INSERT INTO rehabilitandinnen (rehanr, vorname, nachname, kurs) VALUES ('$rehanr', '$vorname', '$nachname', '$kurs')";
        if ($conn->query($insert_sql) === TRUE) {
            $successMessage = "Neuer Teilnehmer erfolgreich hinzugefügt.";
        } else {
            echo "Fehler beim Hinzufügen des Teilnehmers: " . $conn->error;
        }
    }
    ?>
 <div class="content">
    <div class="container">
    <h1>Neuen Teilnehmer hinzufügen</h1>
    
    <?php
    // Erfolgsmeldung anzeigen, wenn sie gesetzt ist
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="rehanr">Rehabilitandinnen Nummer:</label>
        <input type="text" name="rehanr" required><br>
        <label for="vorname">Vorname:</label>
        <input type="text" name="vorname" required><br>
        <label for="nachname">Nachname:</label>
        <input type="text" name="nachname" required><br>
        <label for="kurs">Kurs:</label>
        <input type="text" name="kurs" required><br>
        <input type="submit" name="neuer_teilnehmer" value="Speichern">
    </form>
    
    <br>
    <a href="teilnehmer.php">zurück</a>
    </div>
    </div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
