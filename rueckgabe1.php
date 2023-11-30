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

if (isset($_GET["inventarid"])) {
    $inventarid = $_GET["inventarid"];

    // Aktualisieren Sie den Status des Inventars auf "verfügbar"
    $updateInventarStatusSQL = "UPDATE inventar SET status = 'verfügbar' WHERE inventarid = '$inventarid'";
    if ($conn->query($updateInventarStatusSQL) === TRUE) {
        // Erfolgreich aktualisiert
    } else {
        echo "Fehler beim Aktualisieren des Inventarstatus: " . $conn->error;
    }

    // Setzen Sie die Ausleihdatensatzspalte "zurueckgegeben" auf 1
    $updateAusleiheSQL = "UPDATE ausleihe SET zurueckgegeben = 1 WHERE inventarid = '$inventarid'";
    if ($conn->query($updateAusleiheSQL) === TRUE) {
        // Erfolgreich aktualisiert

        // Löschen Sie den Eintrag aus der Tabelle "ausleihe"
        $deleteAusleiheSQL = "DELETE FROM ausleihe WHERE inventarid = '$inventarid'";
        if ($conn->query($deleteAusleiheSQL) === TRUE) {
            // Erfolgreich gelöscht
        } else {
            echo "Fehler beim Löschen des Ausleihdatensatzes: " . $conn->error;
        }
    } else {
        echo "Fehler beim Aktualisieren des Ausleihdatensatzes: " . $conn->error;
    }

    // Optional: Weiterleiten zur Rückgabebestätigungsseite oder zur Seite "Rückgabebestätigung"
    header("Location: rueckgabe_bestaetigung.php");
}

// Datenbankverbindung schließen
$conn->close();
?>
