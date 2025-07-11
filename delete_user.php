<!-- filepath: /c:/xampp/htdocs/Robocart/delete_user.php -->
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    $_SESSION['success'] = "User deleted successfully.";
    header('Location: admin_users.php');
    exit();
} else {
    header('Location: admin_users.php');
    exit();
}
?>