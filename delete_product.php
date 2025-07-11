<!-- filepath: /c:/xampp/htdocs/Robocart/delete_product.php -->
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

include 'config.php';

$product_id = $_GET['id'];

$sql_delete = "DELETE FROM products WHERE id = :product_id";
$query_delete = $conn->prepare($sql_delete);
$query_delete->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$query_delete->execute();

header('Location: admin_products.php');
exit();
?>