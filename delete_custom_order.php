<!-- filepath: /c:/xampp/htdocs/Robocart/delete_custom_order.php -->
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

include 'config.php';

$order_id = $_GET['id'];

$sql_delete = "DELETE FROM custom_orders WHERE id = :order_id";
$query_delete = $conn->prepare($sql_delete);
$query_delete->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$query_delete->execute();

header('Location: admin_dashboard.php');
exit();
?>