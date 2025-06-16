<?php
session_start();

if (isset($_SESSION["Email_Admin"])) {
    session_unset();
    session_destroy();
}

// Arahkan langsung ke halaman login
header("Location: index.php");
exit();
?>