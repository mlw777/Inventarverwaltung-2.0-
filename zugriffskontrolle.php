<?php
session_start();

if (!isset($_SESSION["eingeloggt"]) || !$_SESSION["eingeloggt"]) {
    header("Location: home.php");
    exit();
}
?>
