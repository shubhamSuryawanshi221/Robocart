<!-- filepath: /c:/xampp/htdocs/Robocart/like_product.php -->
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

// Check if the user has already liked this product
$sql_check = "SELECT * FROM product_feedback WHERE user_id = :user_id AND product_id = :product_id";
$query_check = $conn->prepare($sql_check);
$query_check->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$query_check->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$query_check->execute();
$existing_feedback = $query_check->fetch(PDO::FETCH_ASSOC);

if ($existing_feedback) {
    // Update the existing like
    $sql_update = "UPDATE product_feedback SET liked = 1 WHERE user_id = :user_id AND product_id = :product_id";
    $query_update = $conn->prepare($sql_update);
    $query_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query_update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $query_update->execute();
} else {
    // Insert a new like
    $sql_insert = "INSERT INTO product_feedback (user_id, product_id, liked) VALUES (:user_id, :product_id, 1)";
    $query_insert = $conn->prepare($sql_insert);
    $query_insert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query_insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $query_insert->execute();
}

echo json_encode(['success' => true]);
?>