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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventarliste drucken</title>
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
    <h1>Inventarliste</h1>
    <table>
        <tr>
            <th>Inventar ID</th>
            <th>Bezeichnung</th>
            <th>Seriennummer</th>
            <th>Kategorie</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["inventarid"] . "</td>";
                echo "<td>" . $row["bezeichnung"] . "</td>";
                echo "<td>" . $row["seriennr"] . "</td>";
                echo "<td>" . $row["kategorie"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Kein Inventar gefunden.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
