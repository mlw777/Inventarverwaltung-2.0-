<?php
include_once "zugriffskontrolle.php";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style_teilnehmer.css">
    <title>Teilnehmer löschen</title>
</head>
<body>
<?php include('menu.php'); ?>
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
            // Admin-Passwort ist korrekt, hier kannst du den Teilnehmer löschen
            $rehanr = $_GET["id"];
            $loeschen_sql = "DELETE FROM rehabilitandinnen WHERE rehanr = '$rehanr'";
            if ($conn->query($loeschen_sql) === TRUE) {
               $successMessage = "Teilnehmer erfolgreich entfernt";
            } else {
                echo "Fehler beim Löschen des Teilnehmers: " . $conn->error;
            }
        } else {
            echo "Falsches Admin-Passwort.";
        }
    } else {
        echo "Admin nicht gefunden.";
    }
}

if (isset($_GET["id"])) {
    $rehanr = $_GET["id"]; // Hier sollte $rehanr gesetzt werden

    $select_sql = "SELECT rehanr, vorname, nachname, kurs FROM rehabilitandinnen WHERE rehanr='$rehanr'";
    $result = $conn->query($select_sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_delete"])) {
    $rehanr = $_POST["rehanr"];

    $delete_sql = "DELETE FROM rehabilitandinnen WHERE rehanr='$rehanr'";
    $conn->query($delete_sql);

    
}
?>


<div class="content">
    <div class="container">
    <h2>Teilnehmer löschen</h2>
    <?php
    // Erfolgsmeldung anzeigen, wenn sie gesetzt ist
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <?php if(isset($row)) { ?>
        <p>Sind Sie sicher, dass Sie den folgenden Teilnehmer löschen möchten?</p>
        <p>Rehanr: <?php echo $row["rehanr"]; ?></p>
        <p>Vorname: <?php echo $row["vorname"]; ?></p>
        <p>Nachname: <?php echo $row["nachname"]; ?></p>
        <p>Kurs: <?php echo $row["kurs"]; ?></p>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $_GET["id"]; ?>">
            <label for="admin_passwort">Admin-Passwort:</label>
            <input type="password" name="admin_passwort" required><br>
            <input type="submit" value="Löschen">
        </form>
        
        <br>
        <a href="teilnehmer.php">zurück</a>
        <?php
} else {
    echo "Teilnehmer nicht gefunden.";
}
?>

</div>
    </div>
     <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
