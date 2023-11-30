<?php include_once "zugriffskontrolle.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Willkommen</title>
    <!-- Füge hier deine CSS-Dateien und JavaScript-Dateien hinzu, einschließlich des Menüs -->
    <link rel="stylesheet" type="text/css" href="style_index.css">
 
</head>
<body>
   
<?php include('menu.php'); ?>
    <div class="content">
    <div class="container">
        <!-- Hier können allgemeine Inhalte wie Header oder Bilder platziert werden -->
        <h1>Willkommen <?php echo $_SESSION["benutzername"]; ?></h1>
        <div class="mein-bild">
            <img src="welcome.png" alt="Logo" title="Bild von Asoy ID auf Pixaby" style="margin-top: 100px; width: 400px; height: auto;">
        </div>
    </div>

    <!-- Hier befindet sich der gesamte Inhalt Ihrer Seite -->
</div>

<div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
