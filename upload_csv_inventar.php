<?php
include_once "zugriffskontrolle.php"; ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style_inventar2.css">
    <title>Inventar CSV Upload</title>
</head>
<body>
<?php include('menu.php'); ?>
<div class= "content">
    <div class="container">
    <h1>Inventar CSV Upload</h1>

    <?php
    // Fehlerprotokollierung aktivieren
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Funktion zum Prüfen, ob eine Datei hochgeladen wurde und die richtige Erweiterung hat
    function isCSVFile($file) {
        $allowedExtensions = array('csv');
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        return in_array($fileExtension, $allowedExtensions);
    }

    // Überprüfen, ob das Formular abgeschickt wurde
    if(isset($_POST['submit'])) {
        // Überprüfen, ob eine Datei ausgewählt wurde
        if(isset($_FILES['csv_file']) && isCSVFile($_FILES['csv_file'])) {
            $csvFile = $_FILES['csv_file']['tmp_name'];

            // Überprüfen, ob die Datei nicht leer ist
            if (filesize($csvFile) > 0) {
                // Öffnen und Einlesen der CSV-Datei
                $file = fopen($csvFile, 'r');
                if ($file) {
                    // Datenbankverbindung herstellen (ersetzen Sie die Platzhalter durch Ihre eigenen Daten)
                    $dbHost = "localhost";
                    $dbUser = "admin";
                    $dbPassword = "admin";
                    $dbName = "inventardb";
                    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

                    if ($conn->connect_error) {
                        die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
                    }

                    $success = true;
                    $lineNumber = 0; // Zeilennummer für Fehlermeldung
                    while (($row = fgetcsv($file, 1000, ',')) !== false) {
                        $lineNumber++;
                        $row = array_map('trim', $row);
                        // Überprüfen, ob jede Zeile genau 5 Parameter hat
                        if (count($row) == 5) {
                            $inventarid = $row[0];
                            $bezeichnung = $row[1];
                            $seriennr = $row[2];
                            $kategorie = $row[3];
                            $status = $row[4];

                            // SQL-Query zum Einfügen der Daten in die Datenbank (passen Sie die Tabelle und Spalten an)
                            $sql = "INSERT INTO inventar (inventarid, bezeichnung, seriennr, kategorie, status)
                                    VALUES ('$inventarid', '$bezeichnung', '$seriennr', '$kategorie', '$status')";

                            if ($conn->query($sql) !== true) {
                                $success = false;
                                echo "Fehler in Zeile $lineNumber: " . $conn->error;
                                break;
                            }
                        } else {
                            $success = false;
                            echo "Fehler in Zeile $lineNumber: Die CSV-Datei sollte genau 5 Parameter pro Zeile haben.<br>";
                        }
                    }

                    fclose($file);

                    if ($success) {
                        echo "Upload CSV erfolgreich.";
                    } else {
                        echo "Fehler beim Upload der CSV-Datei oder Datenbank. Stellen Sie sicher, dass alle Zeilen in der CSV-Datei korrekt sind.";
                    }

                    // Datenbankverbindung schließen
                    $conn->close();
                } else {
                    echo "Fehler beim Öffnen der CSV-Datei.";
                }
            } else {
                echo "Die CSV-Datei ist leer.";
            }
        } else {
            echo "CSV auswählen.";
        }
    }
    ?>

    <form action="upload_csv_inventar.php" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file">
        <input type="submit" name="submit" value="Hochladen">
    </form>

    <a href="inventar.php">Zurück</a>
</div>
</div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
