<?php
include_once "zugriffskontrolle.php";

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="teilnehmerliste.csv"');

$output = fopen('php://output', 'w');

// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "inventardb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// SQL-Abfrage für Teilnehmerliste
$sql = "SELECT rehanr, vorname, nachname, kurs FROM rehabilitandinnen";
$result = $conn->query($sql);

// Schreibe die CSV-Überschriften
fputcsv($output, array('Rehabilitandinnen Nummer', 'Vorname', 'Nachname', 'Kurs'));

// Schreibe die Teilnehmerdaten in korrekter Formatierung
while ($row = $result->fetch_assoc()) {
    fputcsv($output, array_values($row));
}

fclose($output);
?>
