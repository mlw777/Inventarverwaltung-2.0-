<?php
include_once "zugriffskontrolle.php";
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style_teilnehmer.css">
    <title>Teilnehmer bearbeiten</title>
</head>
<body>
<?php include('menu.php'); ?>
<div class="content">
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

    $rehanr = "";
    $vorname = "";
    $nachname = "";
    $kurs = "";
    $successMessage = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $rehanr = $_POST["rehanr"];
        $vorname = $_POST["vorname"];
        $nachname = $_POST["nachname"];
        $kurs = $_POST["kurs"];

        $update_sql = "UPDATE rehabilitandinnen SET vorname='$vorname', nachname='$nachname', kurs='$kurs' WHERE rehanr='$rehanr'";
        if ($conn->query($update_sql) === TRUE) {
            $successMessage = "Daten erfolgreich gespeichert.";
        } else {
            echo "Fehler beim Speichern der Daten: " . $conn->error;
        }
    }

    if (isset($_GET["id"])) {
        $rehanr = $_GET["id"];

        $select_sql = "SELECT rehanr, vorname, nachname, kurs FROM rehabilitandinnen WHERE rehanr='$rehanr'";
        $result = $conn->query($select_sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $vorname = $row["vorname"];
            $nachname = $row["nachname"];
            $kurs = $row["kurs"];
        } else {
            // Hier können Sie eine Benachrichtigung ausgeben, dass keine Teilnehmer gefunden wurden
        }
    }
    ?>

    <h1>Teilnehmer bearbeiten</h1>
    <?php
    // Erfolgsmeldung anzeigen, wenn sie gesetzt ist
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="rehanr" value="<?php echo $rehanr; ?>">
        <label for="vorname">Vorname:</label>
        <input type="text" name="vorname" value="<?php echo $vorname; ?>"><br>
        <label for="nachname">Nachname:</label>
        <input type="text" name="nachname" value="<?php echo $nachname; ?>"><br>
        <label for="kurs">Kurs:</label>
        <input type="text" name="kurs" value="<?php echo $kurs; ?>"><br>
        <input type="submit" value="Speichern">
    </form>
    <br>
    <a href="teilnehmer.php">Zurück</a>
</div>
</div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
