<?php
include_once "zugriffskontrolle.php";
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style_mitarbeiter.css">
    <title>Administrator-Authentifizierung</title>
</head>
<body>
<?php include('menu.php'); ?>
<div class= "content">
    <div class="container">
<h1>Administrator-Authentifizierung</h1>

<?php
// Schritt 1: Datenbankverbindung herstellen (ersetzen Sie die Platzhalter durch Ihre eigenen Daten)
$dbHost = "localhost";
$dbUser = "admin";
$dbPassword = "admin";
$dbName = "inventardb";

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// Schritt 2: Administratorpasswort aus der Datenbank abrufen
$adminUsername = "admin"; // Benutzername des Administrators
$sql = "SELECT passwort FROM mitarbeiterinnen WHERE benutzername = '$adminUsername'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $adminPasswordHash = $row["passwort"];

    // Schritt 3: Überprüfen Sie das eingegebene Passwort
    if (isset($_POST['admin_password']) && password_verify($_POST['admin_password'], $adminPasswordHash)) {
        // Wenn das Passwort korrekt ist, führen Sie JavaScript-Weiterleitung durch
        echo '<script>window.location.href = "upload_csv_mitarbeiter.php";</script>';
        exit();
    } elseif (isset($_POST['admin_password'])) {
        // Wenn das Passwort falsch ist, zeigen Sie eine Fehlermeldung an
        echo "Falsches Administratorpasswort. Bitte versuchen Sie es erneut.";
    }
} else {
    echo "Administrator nicht gefunden.";
}

// Schließen Sie die Datenbankverbindung
$conn->close();
?>

<form method="POST" action="upload_admin_mitarbeiter.php">
    <label for="admin_password">Administratorpasswort:</label>
    <input type="password" name="admin_password" required>
    <input type="submit" name="submit" value="Weiter">
</form>
</div>
</div>
<div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
