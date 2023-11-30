<?php
$admin_passwort = $_POST["passwort"];

$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "inventardb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

$admin_sql = "SELECT passwort FROM mitarbeiterinnen WHERE benutzername = 'admin'";
$admin_result = $conn->query($admin_sql);

if ($admin_result->num_rows > 0) {
    $admin_row = $admin_result->fetch_assoc();
    $admin_hashed_passwort = $admin_row["passwort"];

    if (password_verify($admin_passwort, $admin_hashed_passwort)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}

$conn->close();
?>
