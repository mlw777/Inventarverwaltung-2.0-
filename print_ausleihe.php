<?php
// Stellen Sie sicher, dass Sie die erforderlichen Daten aus der POST-Anfrage abrufen
if (isset($_POST["inventarid"]) && isset($_POST["teilnehmerId"]) && isset($_POST["mitarbeiterId"])) {
    $inventarId = $_POST["inventarid"];
    $teilnehmerId = $_POST["teilnehmerId"];
    $mitarbeiterId = $_POST["mitarbeiterId"];
} else {
    die("Fehler: Informationen zur Ausleihe konnten nicht abgerufen werden.");
}

// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "inventardb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// SQL-Abfrage, um die Kategorie und Bezeichnung des Inventars abzurufen
$sqlInventarDetails = "SELECT kategorie, bezeichnung FROM inventar WHERE inventarid = ?";
$stmtInventarDetails = $conn->prepare($sqlInventarDetails);
$stmtInventarDetails->bind_param("s", $inventarId);
$stmtInventarDetails->execute();
$resultInventarDetails = $stmtInventarDetails->get_result();
$inventarDetails = $resultInventarDetails->fetch_assoc();

// SQL-Abfrage, um Vorname, Nachname und Kurs des Teilnehmers abzurufen
$sqlTeilnehmerDetails = "SELECT vorname, nachname, kurs FROM rehabilitandinnen WHERE rehanr = ?";
$stmtTeilnehmerDetails = $conn->prepare($sqlTeilnehmerDetails);
$stmtTeilnehmerDetails->bind_param("s", $teilnehmerId);
$stmtTeilnehmerDetails->execute();
$resultTeilnehmerDetails = $stmtTeilnehmerDetails->get_result();
$teilnehmerDetails = $resultTeilnehmerDetails->fetch_assoc();

// SQL-Abfrage, um Vorname und Nachname des Mitarbeiters abzurufen
$sqlMitarbeiterDetails = "SELECT vorname, nachname FROM mitarbeiterinnen WHERE mitarbeiterid = ?";
$stmtMitarbeiterDetails = $conn->prepare($sqlMitarbeiterDetails);
$stmtMitarbeiterDetails->bind_param("s", $mitarbeiterId);
$stmtMitarbeiterDetails->execute();
$resultMitarbeiterDetails = $stmtMitarbeiterDetails->get_result();
$mitarbeiterDetails = $resultMitarbeiterDetails->fetch_assoc();

// SQL-Abfrage, um das Datum und die Uhrzeit der Ausleihe abzurufen
$sqlAusleiheDatum = "SELECT ausleihe FROM ausleihe WHERE inventarid = ?";
$stmtAusleiheDatum = $conn->prepare($sqlAusleiheDatum);
$stmtAusleiheDatum->bind_param("s", $inventarId);
$stmtAusleiheDatum->execute();
$resultAusleiheDatum = $stmtAusleiheDatum->get_result();
$ausleiheDatum = $resultAusleiheDatum->fetch_assoc();

// Schließen Sie die Verbindung zur Datenbank
$stmtInventarDetails->close();
$stmtTeilnehmerDetails->close();
$stmtMitarbeiterDetails->close();
$stmtAusleiheDatum->close(); // Schließen Sie das Statement für das Ausleihedatum
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Details zur Ausleihe</title>
    <link rel="stylesheet" type="text/css" href="style_print_ausleihe.css">
</head>
<body>
    <img src="logo.png" alt="Logo" class="logo">
    <div class="container">
        <h1>Details zur Ausleihe</h1>
        

        <div class="form-container">
            <div class="form-section">
                <h2>Inventar Details</h2>
                <p><strong>Inventar ID:</strong> <?php echo $inventarId; ?></p>
                <p><strong>Kategorie:</strong> <?php echo $inventarDetails["kategorie"]; ?></p>
                <p><strong>Bezeichnung:</strong> <?php echo $inventarDetails["bezeichnung"]; ?></p>
            </div>

            <div class="form-section">
                <h2>Teilnehmer Details</h2>
                <p><strong>Teilnehmer ID:</strong> <?php echo $teilnehmerId; ?></p>
                <p><strong>Vorname Teilnehmer:</strong> <?php echo $teilnehmerDetails["vorname"]; ?></p>
                <p><strong>Nachname Teilnehmer:</strong> <?php echo $teilnehmerDetails["nachname"]; ?></p>
                <p><strong>Kurs Teilnehmer:</strong> <?php echo $teilnehmerDetails["kurs"]; ?></p>
            </div>

            <div class="form-section">
                <h2>Mitarbeiter Details</h2>
                <p><strong>Mitarbeiter ID:</strong> <?php echo $mitarbeiterId; ?></p>
                <p><strong>Vorname Mitarbeiter:</strong> <?php echo $mitarbeiterDetails["vorname"]; ?></p>
                <p><strong>Nachname Mitarbeiter:</strong> <?php echo $mitarbeiterDetails["nachname"]; ?></p>
            </div>
        </div>

        <div class="signatures">
    <div class="signature">
        <p>Unterschrift des Teilnehmers</p>
        <p>Datum: _______________</p>
    </div>
    <div class="signature">
        <p>Unterschrift des Mitarbeiters</p>
        <p>Datum: _______________</p>
    </div>
</div>



    <script>
        // Automatisches Drucken der Seite, wenn sie geladen wird
        window.onload = function () {
            window.print();
        }
    </script>
</body>
</html>
