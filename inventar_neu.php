<?php
include_once "zugriffskontrolle.php"; ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style_inventar2.css">
    <title>Neues Inventar hinzufügen</title>
    <style>
    body {
        text-align: center; /* Überschrift zentrieren */
        font-family: Arial, sans-serif;
    }

    h1 {
        margin-bottom: 20px; /* Abstand unter der Überschrift */
    }

    .container {
    text-align: left; /* Text in der Container linksbündig ausrichten */
    max-width: 300px; /* Hier die gewünschte Breite in Pixeln setzen */
    margin: 0 auto; /* In der Mitte der Seite ausrichten */
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f8f8f8;
}

    label {
        display: block; /* Labels als Blockelemente anzeigen (untereinander) */
        margin-bottom: 5px; /* Abstand zwischen den Labels */
    }

    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="submit"] {
        background-color: red;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: darkred;
    }

    .alert {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 3px;
        margin-top: 10px;
    }

.red-button {
    background: red;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.red-button:hover {
    background-color: darkred;
}

.red-link {
    color: red;
    text-decoration: none;
    transition: color 0.3s;
}

.red-link:hover {
    color: darkred;
}


</style>

</head>
<body>
<?php include('menu.php'); ?>
 <div class= "content">
 <div class="container">
    <?php
// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "inventardb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $inventarid = $_POST["inventarid"];
    $bezeichnung = $_POST["bezeichnung"];
    $seriennr = $_POST["seriennr"];
    $kategorie = $_POST["kategorie"];

    // Setzen Sie den Status standardmäßig auf "verfügbar"
    $status = "verfügbar";

    $insert_sql = "INSERT INTO inventar (inventarid, bezeichnung, seriennr, kategorie, status) VALUES ('$inventarid', '$bezeichnung', '$seriennr', '$kategorie', '$status')";
    
    if ($conn->query($insert_sql) === TRUE) {
        $successMessage = "Neues Objekt erfolgreich hinzugefügt.";
    } else {
        echo "Fehler beim Hinzufügen des Inventarobjekts: " . $conn->error;
    }
}
?>


    <h1>Neues Inventar hinzufügen</h1>
    <?php
    // Erfolgsmeldung anzeigen, wenn sie gesetzt ist
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="inventarid">InventarID:</label>
        <input type="text" name="inventarid" required><br>
        <label for="bezeichnung">Bezeichnung:</label>
        <input type="text" name="bezeichnung" required><br>
        <label for="seriennr">Seriennummer:</label>
        <input type="text" name="seriennr" required><br>
        <label for="kategorie">Kategorie:</label>
        <input type="text" name="kategorie" required><br>
        <input type="submit" name="submit" value="Hinzufügen" class="red-button" >
    </form>
    
    <br>
    
    <a  href="inventar.php" class="red-link">Abbrechen</a>
    </div>
        </div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
