<?php
include_once "zugriffskontrolle.php";
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style_mitarbeiter.css">
    <title>Mitarbeiter bearbeiten</title>
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
    $mitarbeiterid = "";
    $vorname = "";
    $nachname = "";
    $abteilung = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mitarbeiterid = $_POST["mitarbeiterid"];
        $vorname = $_POST["vorname"];
        $nachname = $_POST["nachname"];
        $abteilung = $_POST["abteilung"];

        $update_sql = "UPDATE mitarbeiterinnen SET vorname='$vorname', nachname='$nachname', abteilung='$abteilung' WHERE mitarbeiterid='$mitarbeiterid'";
        $conn->query($update_sql);
        $successMessage = "Daten erfolgreich gespeichert.";
    }

    $row = []; // Initialisieren Sie $row als leeres Array

    if (isset($_GET["id"])) {
        $mitarbeiterid = $_GET["id"];

        $select_sql = "SELECT mitarbeiterid, vorname, nachname, abteilung FROM mitarbeiterinnen WHERE mitarbeiterid='$mitarbeiterid'";
        $result = $conn->query($select_sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            // Hier können Sie eine Benachrichtigung ausgeben, dass kein Mitarbeiter gefunden wurde
        }
    }
    ?>

    <h1>Mitarbeiter bearbeiten</h1>
    <?php
    // Erfolgsmeldung anzeigen, wenn sie gesetzt ist
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="mitarbeiterid" value="<?php echo isset($row["mitarbeiterid"]) ? $row["mitarbeiterid"] : ''; ?>">
        <label for="vorname">Vorname:</label>
        <input type="text" name="vorname" value="<?php echo isset($row["vorname"]) ? $row["vorname"] : ''; ?>"><br>
        <label for="nachname">Nachname:</label>
        <input type="text" name="nachname" value="<?php echo isset($row["nachname"]) ? $row["nachname"] : ''; ?>"><br>
        <label for="abteilung">Abteilung:</label>
        <input type="text" name="abteilung" value="<?php echo isset($row["abteilung"]) ? $row["abteilung"] : ''; ?>"><br>
        <input type="submit" value="Speichern">
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
