<?php
include_once "zugriffskontrolle.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Administrator-Authentifizierung</title>
    <link rel="stylesheet" type="text/css" href="style_inventar2.css">
    <!-- Fügen Sie das Bootstrap CSS-Link-Tag hier ein -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    
   /* Ihre benutzerdefinierten Stile */
.custom-input-small {
    width: 100%;
    max-width: 150px; /* Maximalbreite des Eingabefelds */
    border: 1px solid;
    border-radius: 5px;
    padding: 5px;
    font-size: 14px; /* Kleinere Schriftgröße */
}

/* Stil für den Button */
.custom-button {
    background-color: #e60000;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px; /* Kleinere Abstände */
    font-size: 14px; /* Kleinere Schriftgröße */
    cursor: pointer;
}

.custom-button:hover {
    background-color: darkred;
}

    </style>
</head>

<body>
    <?php include('menu.php'); ?>
    <div class="content">
        <div class="container">
            <h1 class="mt-5" style="display: block; margin: 0 auto; margin-bottom: 30px;">Authentifizierung</h1>
            <img src="password.png" alt="Passwortbild" title="Privat 2 icon by Icons8" style="display: block; margin: 0 auto; margin-bottom: 60px;">

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
                    // Wenn das Passwort korrekt ist, leiten Sie den Administrator zur CSV-Upload-Seite weiter
                    echo '<script>window.location.href = "upload_csv_inventar.php";</script>';
                    exit();
                } elseif (isset($_POST['admin_password'])) {
                    // Wenn das Passwort falsch ist, zeigen Sie eine Fehlermeldung an
                    echo '<div class="alert alert-danger mt-3">Falsches Administratorpasswort. Bitte versuchen Sie es erneut.</div>';
                }
            } else {
                echo '<div class="alert alert-danger mt-3">Administrator nicht gefunden.</div>';
            }

            // Schließen Sie die Datenbankverbindung
            $conn->close();
            ?>

<form method="POST" action="upload_admin_inventar.php">
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-6 mt-3">
            <div class="form-group">
                <label for="admin_password">Administratorpasswort:</label>
                <input type="password" class="custom-input" name="admin_password" required>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-6 mt-3 text-center"> <!-- Hinzufügen der text-center-Klasse -->
            <button type="submit" name="submit" class="custom-button">Weiter</button>
        </div>
    </div>
</form>




        </div>
    </div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>

    <!-- Fügen Sie das Bootstrap JavaScript- und jQuery-Dateien-Links hier ein -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
