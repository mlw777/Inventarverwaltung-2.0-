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

// SQL-Abfrage für Inventarliste
$sql = "SELECT inventarid, bezeichnung, seriennr, kategorie, status FROM inventar";
$result = $conn->query($sql);

// CSV-Datei erzeugen
$filename = "inventarliste.csv";
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=$filename");

$output = fopen("php://output", "w");
fputcsv($output, array("Inventar ID", "Bezeichnung", "Seriennummer", "Kategorie", "Status"));

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}

fclose($output);
?>
