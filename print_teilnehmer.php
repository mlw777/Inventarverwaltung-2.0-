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

// SQL-Abfrage für Teilnehmerliste
$sql = "SELECT rehanr, vorname, nachname, kurs FROM rehabilitandinnen";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teilnehmerliste</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Teilnehmerliste</h1>
    
    <table>
        <tr>
            <th>Rehabilitandinnen Nummer</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Kurs</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["rehanr"] . "</td>";
            echo "<td>" . $row["vorname"] . "</td>";
            echo "<td>" . $row["nachname"] . "</td>";
            echo "<td>" . $row["kurs"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Kein Teilnehmer gefunden.</td></tr>";
    }
        ?>
    </table>
    
    
</body>
</html>
