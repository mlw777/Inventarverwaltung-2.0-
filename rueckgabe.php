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

// SQL-Abfrage, um verliehenes Inventar abzurufen
$sqlVerliehenesInventar = "SELECT r.nachname AS teilnehmer_nachname, a.rehanr, a.mitarbeiterid, m.nachname AS mitarbeiter_nachname, i.inventarid, i.bezeichnung, i.kategorie, a.ausleihe
                           FROM ausleihe AS a
                           JOIN rehabilitandinnen AS r ON a.rehanr = r.rehanr
                           JOIN mitarbeiterinnen AS m ON a.mitarbeiterid = m.mitarbeiterid
                           JOIN inventar AS i ON a.inventarid = i.inventarid
                           WHERE i.status = 'verliehen'";
$resultVerliehenesInventar = $conn->query($sqlVerliehenesInventar);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Rückgabe</title>
    <link rel="stylesheet" type="text/css" href="style_rueckgabe.css">
</head>
<body>
<?php include('menu.php'); ?>
<div class="content">
    <div class="container">
    <h1>Rückgabe</h1>

    <table>
        <thead>
            <tr>
                <th>Teilnehmer Nachname</th>
                <th>Teilnehmer Rehanr</th>
                <th>Mitarbeiter ID</th>
                <th>Mitarbeiter Nachname</th>
                <th>Inventar ID</th>
                <th>Bezeichnung</th>
                <th>Kategorie</th>
                <th>Verliehen am</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultVerliehenesInventar->num_rows > 0) {
                while ($row = $resultVerliehenesInventar->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["teilnehmer_nachname"] . "</td>";
                    echo "<td>" . $row["rehanr"] . "</td>";
                    echo "<td>" . $row["mitarbeiterid"] . "</td>";
                    echo "<td>" . $row["mitarbeiter_nachname"] . "</td>";
                    echo "<td>" . $row["inventarid"] . "</td>";
                    echo "<td>" . $row["bezeichnung"] . "</td>";
                    echo "<td>" . $row["kategorie"] . "</td>";
                    echo "<td>" . $row["ausleihe"] . "</td>";
                    echo '<td><a href="rueckgabe1.php?inventarid=' . $row["inventarid"] . '"><img src="rueckgabe.png" alt="Rückgabe" class="action-icon"></a></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Kein verliehenes Inventar gefunden.</td></tr>";
            }
            ?>
        </tbody>
    </table>
        </div>
        </div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>

<?php
// Datenbankverbindung schließen
$conn->close();
?>
