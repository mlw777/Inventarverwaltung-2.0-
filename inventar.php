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
    <title>Inventarverwaltung</title>
    <link rel="stylesheet" type="text/css" href="style_inventar2.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
    <!-- Fügen Sie das folgende Skript im Head-Bereich ein -->
    <script>
     function toggleActions() {
        var actionsList = document.getElementById('actions-list');
        var actionsTitle = document.getElementById('actions-title');
        var actionsIcon = document.getElementById('actions-icon');
        var card = document.getElementById('actions-card');

        if (actionsList.style.display === 'none' || actionsList.style.display === '') {
            actionsList.style.display = 'block';
            actionsTitle.innerText = 'Aktionen';
            actionsIcon.src = 'up.png'; // Ändert das Icon auf up.png, wenn Aktionen angezeigt werden
            card.style.width = '200px'; // Breite erhöhen, wenn Aktionen angezeigt werden
        } else {
            actionsList.style.display = 'none';
            actionsTitle.innerText = 'Aktionen anzeigen';
            actionsIcon.src = 'down.png'; // Ändert das Icon auf down.png, wenn Aktionen ausgeblendet werden
            card.style.width = '160px'; // Breite verringern, wenn Aktionen ausgeblendet werden
        }
    }
        function openPrintPreview() {
            var printWindow = window.open('print_inventar.php', '_blank');
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
        <h2>Übersicht des Inventars</h2>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Inventar ID</th>
                <th>Bezeichnung</th>
                <th>Seriennummer</th>
                <th>Kategorie</th>
                <th>Status</th>
                <th>Aktionen</th>
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
                    echo "<td>";
                    echo "<a href='inventar_bearbeiten.php?id=" . $row["inventarid"] . "'><img src='edit.png' alt='Bearbeiten'></a>";
                    echo "<a href='inventar_loeschen.php?id=" . $row["inventarid"] . "'><img src='delete.png' alt='Löschen'></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Kein Inventar gefunden.</td></tr>";
            }
            ?>
        </table>
        <br>
<!-- Bootstrap-Karte für Optionen mit Inline-CSS und JavaScript-Steuerung -->
<div id="actions-card" class="card" style="width: 160px; position: fixed; top: 70px; left: 20px;">
    <div class="card-body" style="padding: 8px;">
        <div id="actions-toggle" onclick="toggleActions()" style="cursor: pointer;">
            <img id="actions-icon" src="down.png" alt="Down Arrow" style="vertical-align: middle; margin-right: 5px;">
            <span id="actions-title" class="card-title" style="font-size: 14px; margin-bottom: 0.5px; padding: 0.5px;">Aktionen anzeigen</span>
        </div>
        <ul id="actions-list" class="list-group" style="display: none; padding: 10px;">
            <li class="list-group-item" style="font-size: 14px; padding: 5px;"><a href="inventar_neu.php" class="text-danger">Neues Inventar hinzufügen</a></li>
            <li class="list-group-item" style="font-size: 14px; padding: 5px;"><a href="export_inventar.php" class="text-danger">Inventarliste als CSV exportieren</a></li>
            <li class="list-group-item" style="font-size: 14px; padding: 5px;"><a href="javascript:void(0);" onclick="openPrintPreview();" class="text-danger">Inventarliste drucken</a></li>
            <li class="list-group-item" style="font-size: 14px; padding: 5px;"><a href="upload_admin_inventar.php" class="text-danger">CSV-Datei hochladen</a></li>
        </ul>
    </div>
</div>




    </div>
        </div>

    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
 <!-- Bootstrap JavaScript- und jQuery-Dateien einbinden -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>