<!-- filepath: /c:/xampp/htdocs/Robocart/logout.php -->
<?php
session_start();
session_destroy();
header('Location: login.php');
exit();
?>