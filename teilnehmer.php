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
    <title>Teilnehmerverwaltung</title>
    <link rel="stylesheet" type="text/css" href="style_teilnehmer.css">
    <script>
        function openPrintPreview() {
            var printWindow = window.open('print_teilnehmer.php', '_blank');
            printWindow.onload = function () {
                printWindow.print();
            };
        }
    </script>
</head>
<body>
<?php include('menu.php'); ?>
  <div class="content">
    <div class="container">
    
    <h2>Übersicht der Teilnehmer</h2>
    <table>
        <tr>
            <th>Rehanr</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Kurs</th>
            <th>Aktionen</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["rehanr"] . "</td>";
                echo "<td>" . $row["vorname"] . "</td>";
                echo "<td>" . $row["nachname"] . "</td>";
                echo "<td>" . $row["kurs"] . "</td>";
                echo "<td>";
                echo "<a href='teilnehmer_bearbeiten.php?id=" . $row["rehanr"] . "'><img src='edit.png' alt='Bearbeiten'></a>";
                echo "<a href='teilnehmer_loeschen.php?id=" . $row["rehanr"] . "'><img src='delete.png' alt='Löschen'></a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Keine Teilnehmer gefunden.</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="teilnehmer_neu.php">Neuer Teilnehmer</a>
    
    <br>
    <a href="export_teilnehmer.php">Teilnehmerliste als CSV exportieren</a>
    <br>
     <!-- Fügen Sie den folgenden Link ein, um die Druckvorschau zu öffnen -->
     <a href="javascript:void(0);" onclick="openPrintPreview();">Teilnehmerliste drucken</a>
    <br>
    <br>
    <a href="upload_admin_teilnehmer.php">CSV-Datei hochladen</a>
    </div>
    </div>
     <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
