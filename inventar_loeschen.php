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

$successMessage = "";
$row = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["admin_passwort"])) {
    $admin_passwort = $_POST["admin_passwort"];

    // Überprüfen, ob das eingegebene Admin-Passwort korrekt ist
    $admin_sql = "SELECT passwort FROM mitarbeiterinnen WHERE benutzername = 'admin'";
    $admin_result = $conn->query($admin_sql);

    if ($admin_result->num_rows > 0) {
        $admin_row = $admin_result->fetch_assoc();
        $admin_hashed_passwort = $admin_row["passwort"];

        if (password_verify($admin_passwort, $admin_hashed_passwort)) {
            // Admin-Passwort ist korrekt, hier kannst du das Inventarobjekt löschen
            if (isset($_GET["id"])) {
                $inventarid = $_GET["id"];
                $loeschen_sql = "DELETE FROM inventar WHERE inventarid = '$inventarid'";
                if ($conn->query($loeschen_sql) === TRUE) {
                    $successMessage = "Objekt erfolgreich entfernt";
                } else {
                    echo "Fehler beim Löschen des Inventarobjekts: " . $conn->error;
                }
            } else {
                echo "Inventar-ID nicht definiert.";
            }
        } else {
            echo "Falsches Admin-Passwort.";
        }
    } else {
        echo "Admin nicht gefunden.";
    }
}

if (isset($_GET["id"])) {
    $inventarid = $_GET["id"];

    $select_sql = "SELECT inventarid, bezeichnung, seriennr, kategorie, status FROM inventar WHERE inventarid='$inventarid'";
    $result = $conn->query($select_sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Inventarobjekt nicht gefunden.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style_inventar2.css">
    <title>Inventar löschen</title>
</head>
<body>
<?php include('menu.php'); ?>
<div class= "content">
    <div class="container">
    <h1>Inventar löschen</h1>
    <?php
    // Erfolgsmeldung anzeigen, wenn sie gesetzt ist
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <?php if (!empty($row)) { // Überprüfen, ob $row Daten enthält ?>
        <p>Sind Sie sicher, dass Sie das folgende Inventarobjekt löschen möchten?</p>
        <p>Inventar ID: <?php echo $row["inventarid"]; ?></p>
        <p>Bezeichnung: <?php echo $row["bezeichnung"]; ?></p>
        <p>Seriennummer: <?php echo $row["seriennr"]; ?></p>
        <p>Kategorie: <?php echo $row["kategorie"]; ?></p>
        <p>Status: <?php echo $row["status"]; ?></p>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $_GET["id"]; ?>">
            <label for="admin_passwort">Admin-Passwort:</label>
            <input type="password" name="admin_passwort" required><br>
            <input type="submit" value="Löschen">
        </form>
    <?php } ?>
    
    <br>
    
    <a href="inventar.php">Zurück</a>
    </div>
        </div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
