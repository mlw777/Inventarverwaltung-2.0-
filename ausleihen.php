<?php
include_once "zugriffskontrolle.php";

// Hier sollte der eingeloggte Benutzername aus der Session geladen werden
$eingeloggterBenutzer = $_SESSION["benutzername"]; // Annahme, dass "benutzername" in der Session gespeichert ist

// Stelle sicher, dass eine Inventar-ID übergeben wurde
if (isset($_POST["inventarid"])) {
    $inventarId = $_POST["inventarid"];
    $teilnehmerId = $_POST["teilnehmer"];

    // Aktuelles Datum und Uhrzeit abrufen
    $ausleiheDatumUhrzeit = date("Y-m-d H:i:s");

    // Verbindung zur Datenbank herstellen
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "inventardb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
    }

    // SQL-Abfrage, um einen Eintrag in die Tabelle "ausleihe" einzufügen
    $sqlAusleihe = "INSERT INTO ausleihe (mitarbeiterid, rehanr, inventarid, ausleihe) VALUES (?, ?, ?, ?)";
    $stmtAusleihe = $conn->prepare($sqlAusleihe);
    $stmtAusleihe->bind_param("ssss", $_SESSION["mitarbeiterId"], $teilnehmerId, $inventarId, $ausleiheDatumUhrzeit);

    if ($stmtAusleihe->execute()) {
        // Eintrag in "ausleihe" erfolgreich eingefügt

        // Aktualisieren Sie den Status des Inventars auf "verliehen" in der Tabelle "inventar"
        $sqlUpdateStatus = "UPDATE inventar SET status = 'verliehen' WHERE inventarid = ?";
        $stmtUpdateStatus = $conn->prepare($sqlUpdateStatus);
        $stmtUpdateStatus->bind_param("s", $inventarId);

        if ($stmtUpdateStatus->execute()) {
            // Status erfolgreich aktualisiert
            $ausleiheErfolgreich = true;
        } else {
            $ausleiheErfolgreich = false;
        }
    } else {
        $ausleiheErfolgreich = false;
    }

    // Schließe die Verbindung zur Datenbank
    $stmtAusleihe->close();
    $stmtUpdateStatus->close();
    $conn->close();
} else {
    // Wenn keine Inventar-ID übergeben wurde, zeige eine Fehlermeldung oder leite um
    header("Location: fehlerseite.php");
    exit();
}
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

    <?php if ($ausleiheErfolgreich):
        echo '<div class = "alert alert-success">' . "Ausleihe erfolgreich" . '</div>'; ?>
    
    

    <!-- Schaltfläche "Drucken" hinzufügen -->
    <form action="print_ausleihe.php" method="post" target="_blank">
        <input type="hidden" name="inventarid" value="<?php echo $inventarId; ?>">
        <input type="hidden" name="teilnehmerId" value="<?php echo $teilnehmerId; ?>">
        <input type="hidden" name="mitarbeiterId" value="<?php echo $_SESSION["mitarbeiterId"]; ?>">
        <input type="hidden" name="ausleiheDatumUhrzeit" value="<?php echo $ausleiheDatumUhrzeit; ?>">
        <input type="submit" name="drucken" value="Drucken">
    </form>

    <?php else: ?>
    <!-- Fehlermeldung anzeigen, wenn die Ausleihe fehlgeschlagen ist -->
    <p>Fehler beim Ausleihen.</p>

    <?php endif; ?>

    <!-- Schaltfläche "Zurück zur Ausleihe" hinzufügen -->
    <form action="ausleihe.php" method="get">
        <input type="hidden" name="id" value="<?php echo $inventarId; ?>">
        <input type="submit" name="zurueck" value="Zurück zur Ausleihe">
    </form>
    </div>
    </div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
