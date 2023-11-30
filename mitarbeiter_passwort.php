<?php
include_once "zugriffskontrolle.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Passwort ändern</title>
    <link rel="stylesheet" type="text/css" href="style_mitarbeiter.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#admin_passwort_form").on("submit", function(event) {
                event.preventDefault();

                var adminPasswort = $("#admin_passwort").val();

                // Überprüfen, ob das eingegebene Admin-Passwort korrekt ist
                $.post("check_admin_passwort.php", { passwort: adminPasswort }, function(response) {
                    if (response === "success") {
                        // Admin-Passwort ist korrekt, weiter zur Passwort-Änderungs-Form
                        var mitarbeiterid = "<?php echo $_GET['id']; ?>";
                        window.location.href = "mitarbeiter_passwort_aendern.php?id=" + mitarbeiterid;
                    } else {
                        $("#admin_passwort").val("");
                        alert("Falsches Admin-Passwort.");
                    }
                });
            });
        });
    </script>
</head>
<body>
<?php include('menu.php'); ?>
<div class= "content">
    <div class="container">
    <h1>Admin-Passwort eingeben</h1>
    <form id="admin_passwort_form">
        <label for="admin_passwort">Admin-Passwort:</label>
        <input type="password" id="admin_passwort" name="admin_passwort" required>
        <input type="submit" value="Weiter">
    </form>
    <br>
    <a href="mitarbeiter.php">Abbrechen</a>
    </div>
    </div>
    <div class="footer">
        <!-- Hier befindet sich Ihr Footer-Inhalt -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
