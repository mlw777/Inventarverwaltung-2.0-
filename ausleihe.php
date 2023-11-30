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

// SQL-Abfrage für Inventarliste (nur verfügbares Inventar)
$sql = "SELECT inventarid, bezeichnung, seriennr, kategorie FROM inventar WHERE status = 'verfügbar'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventarverwaltung</title>
    <link rel="stylesheet" type="text/css" href="style_ausleihe.css">
</head>
<body>
<?php include('menu.php'); ?>
<div class="content">
    <div class="container">
    <h2>Verfügbares Inventar</h2>
    <table>
        <tr>
            <th>Inventar ID</th>
            <th>Bezeichnung</th>
            <th>Seriennummer</th>
            <th>Kategorie</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["inventarid"] . "</td>";
                echo "<td>" . $row["bezeichnung"] . "</td>";
                echo "<td>" . $row["seriennr"] . "</td>";
                echo "<td>" . $row["kategorie"] . "</td>";
                echo "<td>";
                // Hier fügst du den Link zur ausleihvorgang.php-Seite hinzu
                echo "<a href='ausleihvorgang.php?id=" . $row["inventarid"] . "'><img src='ausleihe.png' alt='Ausleihen'></a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Kein verfügbares Inventar gefunden.</td></tr>";
        }
        ?>
    </table>
    </div>
    </div>
    <!-- Weitere Optionen oder Links hier hinzufügen, falls erforderlich -->
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
