<?php
include_once "zugriffskontrolle.php";

// Hier sollte der eingeloggte Benutzername aus der Session geladen werden
$eingeloggterBenutzer = $_SESSION["benutzername"]; // Annahme, dass "benutzername" in der Session gespeichert ist

// Stelle sicher, dass eine Inventar-ID übergeben wurde
if (isset($_GET["id"])) {
    $inventarId = $_GET["id"];

    // Verbindung zur Datenbank herstellen
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "inventardb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
    }

    // SQL-Abfrage, um das ausgewählte Inventar abzurufen
    $sql = "SELECT inventarid, bezeichnung, seriennr, kategorie FROM inventar WHERE inventarid = ?";
    
    // Vorbereiten der Abfrage
    $stmt = $conn->prepare($sql);
    
    // Parameter binden
    $stmt->bind_param("s", $inventarId);
    
    // Abfrage ausführen
    $stmt->execute();
    
    // Ergebnis abrufen
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $inventarId = $row["inventarid"];
        $bezeichnung = $row["bezeichnung"];
        $seriennr = $row["seriennr"];
        $kategorie = $row["kategorie"];
    }

    // Schließe die Verbindung zur Datenbank
    $conn->close();
} else {
    // Wenn keine Inventar-ID übergeben wurde, zeige eine Fehlermeldung oder leite um
    header("Location: fehlerseite.php");
    exit();
}

// Mitarbeiter-ID basierend auf dem Benutzernamen abrufen
$benutzername = $_SESSION["benutzername"];

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// SQL-Abfrage, um die Mitarbeiter-ID abzurufen
$sqlMitarbeiter = "SELECT mitarbeiterid FROM mitarbeiterinnen WHERE benutzername = ?";
$stmtMitarbeiter = $conn->prepare($sqlMitarbeiter);
$stmtMitarbeiter->bind_param("s", $benutzername);
$stmtMitarbeiter->execute();
$resultMitarbeiter = $stmtMitarbeiter->get_result();

if ($resultMitarbeiter->num_rows == 1) {
    $rowMitarbeiter = $resultMitarbeiter->fetch_assoc();
    $mitarbeiterId = $rowMitarbeiter["mitarbeiterid"];
    
    // Speichere die Mitarbeiter-ID in der Session
    $_SESSION["mitarbeiterId"] = $mitarbeiterId;
}

// Schließe die Verbindung zur Datenbank
$stmtMitarbeiter->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ausleihvorgang</title>
    <link rel="stylesheet" type="text/css" href="style_ausleihe.css">
</head>
<body>
<?php include('menu.php'); ?>
<div class="content">
    <div class="container">
    <h1>Ausleihvorgang</h1>

    <h2>Inventarinformationen</h2>
    <p><strong>Inventar ID:</strong> <?php echo $inventarId; ?></p>
    <p><strong>Bezeichnung:</strong> <?php echo $bezeichnung; ?></p>
    <p><strong>Seriennummer:</strong> <?php echo $seriennr; ?></p>
    <p><strong>Kategorie:</strong> <?php echo $kategorie; ?></p>

    <h2>Eingeloggter Benutzer</h2>
    <p><strong>Eingeloggter Benutzer:</strong> <?php echo $eingeloggterBenutzer; ?></p>
    
    <!-- Anzeige der Mitarbeiter-ID -->
    <p><strong>Mitarbeiter ID:</strong> <?php echo $mitarbeiterId; ?></p>

    <h2>Teilnehmer auswählen</h2>
    <form action="ausleihen.php" method="post">
        <input type="hidden" name="inventarid" value="<?php echo $inventarId; ?>">
        <label for="teilnehmer">Teilnehmer:</label>
        <select name="teilnehmer" id="teilnehmer" style="width: 100%;">
    <?php
    // Hier sollte die Liste der Teilnehmer aus deiner Datenbank geladen werden
    // Zum Beispiel aus der Tabelle "rehabilitandinnen"
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "inventardb"; // Korrekter Datenbankname

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
    }

    // SQL-Abfrage, um Vorname und Nachname der Teilnehmer abzurufen
    $sql = "SELECT rehanr, vorname, nachname FROM rehabilitandinnen";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["rehanr"] . "'>" . $row["vorname"] . " " . $row["nachname"] . "</option>";
        }
    }

    // Schließe die Verbindung zur Datenbank
    $conn->close();
    ?>
</select>

        <br>
        <input type="submit" name="ausleihen" value="Ausleihen">
        <input type="submit" name="abbrechen" value="Abbrechen" disabled>
    </form>
    </div>
    </div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
