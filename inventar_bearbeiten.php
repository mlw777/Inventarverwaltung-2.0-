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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $inventarid = $_GET["id"];
    $bezeichnung = $_POST["bezeichnung"];
    $seriennr = $_POST["seriennr"];
    $kategorie = $_POST["kategorie"];
    $status = $_POST["status"];

    $update_sql = "UPDATE inventar SET bezeichnung='$bezeichnung', seriennr='$seriennr', kategorie='$kategorie', status='$status' WHERE inventarid='$inventarid'";
    
    if ($conn->query($update_sql) === TRUE) {
        $sucessMessage = "Daten erfolgreich gespeichert.";
    } else {
        echo "Fehler beim Bearbeiten des Inventarobjekts: " . $conn->error;
    }
}

if (isset($_GET["id"])) {
    $inventarid = $_GET["id"];

    $select_sql = "SELECT inventarid, bezeichnung, seriennr, kategorie, status FROM inventar WHERE inventarid='$inventarid'";
    $result = $conn->query($select_sql);
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style_inventar2.css">
    <title>Inventar bearbeiten</title>
</head>
<body>

<?php include('menu.php'); ?>
<div class= "content">
    <div class="container">
    <h1>Inventar bearbeiten</h1>
   <?php if (!empty($sucessMessage)) {
    echo '<div class="alert alert-success">' . $sucessMessage . '</div>';
   } ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $_GET["id"]; ?>">
        <label for="bezeichnung">Bezeichnung:</label>
        <input type="text" name="bezeichnung" value="<?php echo $row["bezeichnung"]; ?>" required><br>
        <label for="seriennr">Seriennummer:</label>
        <input type="text" name="seriennr" value="<?php echo $row["seriennr"]; ?>" required><br>
        <label for="kategorie">Kategorie:</label>
        <input type="text" name="kategorie" value="<?php echo $row["kategorie"]; ?>" required><br>
        <label for="status">Status:</label>
        <input type="text" name="status" value="<?php echo $row["status"]; ?>" required><br>
        <input type="submit" name="submit" value="Speichern">
    </form>
    
    <br>
    
    <a href="inventar.php">Abbrechen</a>
    </div>
        </div>
        <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>

</html>
