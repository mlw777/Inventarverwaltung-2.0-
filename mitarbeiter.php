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

    // SQL-Abfrage für Mitarbeiterliste
    $sql = "SELECT mitarbeiterid, vorname, nachname, abteilung FROM mitarbeiterinnen";
    $result = $conn->query($sql);
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Inventarverwaltung</title>
        <link rel="stylesheet" type="text/css" href="style_mitarbeiter.css">
    <!-- Fügen Sie das folgende Skript im Head-Bereich ein -->
    <script>
        function openPrintPreview() {
            var printWindow = window.open('print_mitarbeiter.php', '_blank');
            printWindow.onload = function () {
                printWindow.print();
            };
        }
    </script>
</head>
<body>
<?php include('menu.php'); ?>
<div class= "content">
    <div class="container">
    
    <h2>Übersicht der Mitarbeiter</h2>
    <table>
        <tr>
            <th>Mitarbeiter ID</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Abteilung</th>
            <th>Aktionen</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["mitarbeiterid"] . "</td>";
                echo "<td>" . $row["vorname"] . "</td>";
                echo "<td>" . $row["nachname"] . "</td>";
                echo "<td>" . $row["abteilung"] . "</td>";
                echo "<td>";
                echo "<a href='mitarbeiter_bearbeiten.php?id=" . $row["mitarbeiterid"] . "'><img src='edit.png' alt='Bearbeiten'></a>";
                echo "<a href='mitarbeiter_loeschen.php?id=" . $row["mitarbeiterid"] . "'><img src='delete.png' alt='Löschen'></a>";
                echo "<a href='mitarbeiter_passwort.php?id=" . $row["mitarbeiterid"] . "'><img src='pw.png' alt='Passwort'></a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Keine Mitarbeiter gefunden.</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="mitarbeiter_neu.php">Neuer Mitarbeiter</a>
    
    <br>
    <a href="export_mitarbeiter.php">Mitarbeiterliste als CSV exportieren</a>
    <br>
    <!-- Fügen Sie den folgenden Link ein, um die Druckvorschau zu öffnen -->
    <a href="javascript:void(0);" onclick="openPrintPreview();">Mitarbeiterliste drucken</a>
    <br>
    <br>
    <a href="upload_admin_mitarbeiter.php">CSV-Datei hochladen</a>
    </div>
    </div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
