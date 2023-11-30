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
$row = []; // Initialisieren Sie $row als leeres Array

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["admin_passwort"])) {
    $admin_passwort = $_POST["admin_passwort"];

    // Überprüfen, ob das eingegebene Admin-Passwort korrekt ist
    $admin_sql = "SELECT passwort FROM mitarbeiterinnen WHERE benutzername = 'admin'";
    $admin_result = $conn->query($admin_sql);

    if ($admin_result->num_rows > 0) {
        $admin_row = $admin_result->fetch_assoc();
        $admin_hashed_passwort = $admin_row["passwort"];

        if (password_verify($admin_passwort, $admin_hashed_passwort)) {
            // Admin-Passwort ist korrekt, hier kannst du den Mitarbeiter löschen
            if (isset($_GET["id"])) {
                $mitarbeiterid = $_GET["id"];
                $loeschen_sql = "DELETE FROM mitarbeiterinnen WHERE mitarbeiterid = '$mitarbeiterid'";
                if ($conn->query($loeschen_sql) === TRUE) {
                    $successMessage = "Mitarbeiter erfolgreich entfernt";
                } else {
                    echo "Fehler beim Löschen des Mitarbeiters: " . $conn->error;
                }
            } else {
                echo "Mitarbeiter-ID nicht definiert.";
            }
        } else {
            echo "Falsches Admin-Passwort.";
        }
    } else {
        echo "Admin nicht gefunden.";
    }
}

if (isset($_GET["id"])) {
    $mitarbeiterid = $_GET["id"];

    $select_sql = "SELECT mitarbeiterid, vorname, nachname, abteilung FROM mitarbeiterinnen WHERE mitarbeiterid='$mitarbeiterid'";
    $result = $conn->query($select_sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // Hier können Sie eine Benachrichtigung ausgeben, dass keine Übereinstimmung in der Datenbank gefunden wurde
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_delete"])) {
    if (isset($_POST["mitarbeiterid"])) {
        $mitarbeiterid = $_POST["mitarbeiterid"];

        $delete_sql = "DELETE FROM mitarbeiterinnen WHERE mitarbeiterid='$mitarbeiterid'";
        $conn->query($delete_sql);

        header("Location: mitarbeiter.php");
    } else {
        echo "Mitarbeiter-ID nicht definiert.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style_mitarbeiter.css">
    <title>Mitarbeiter löschen</title>
</head>
<body>
<?php include('menu.php'); ?>
<div class= "content">
    <div class="container">
    <h1>Mitarbeiter löschen</h1>
    <?php
    // Erfolgsmeldung anzeigen, wenn sie gesetzt ist
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
    }
    ?>
    <p>Sind Sie sicher, dass Sie den folgenden Mitarbeiter löschen möchten?</p>
    <p>Mitarbeiter ID: <?php echo isset($row["mitarbeiterid"]) ? $row["mitarbeiterid"] : ''; ?></p>
    <p>Vorname: <?php echo isset($row["vorname"]) ? $row["vorname"] : ''; ?></p>
    <p>Nachname: <?php echo isset($row["nachname"]) ? $row["nachname"] : ''; ?></p>
    <p>Abteilung: <?php echo isset($row["abteilung"]) ? $row["abteilung"] : ''; ?></p>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $_GET["id"]; ?>">
        <label for="admin_passwort">Admin-Passwort:</label>
        <input type="password" name="admin_passwort" required><br>
        <input type="submit" value="Löschen">
        <input type="hidden" name="mitarbeiterid" value="<?php echo isset($_GET["id"]) ? $_GET["id"] : ''; ?>">
    </form>
    
    <br>
    
    <a href="mitarbeiter.php">zurück</a>
</div>
</div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
