<!-- filepath: /c:/xampp/htdocs/Robocart/edit_product.php -->
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $sql_update = "UPDATE products SET name = :name, description = :description, price = :price, image = :image WHERE id = :product_id";
    $query_update = $conn->prepare($sql_update);
    $query_update->bindParam(':name', $name, PDO::PARAM_STR);
    $query_update->bindParam(':description', $description, PDO::PARAM_STR);
    $query_update->bindParam(':price', $price, PDO::PARAM_STR);
    $query_update->bindParam(':image', $image, PDO::PARAM_STR);
    $query_update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $query_update->execute();

    header('Location: manage_products.php');
    exit();
}

$product_id = $_GET['id'];
$sql_product = "SELECT * FROM products WHERE id = :product_id";
$query_product = $conn->prepare($sql_product);
$query_product->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$query_product->execute();
$product = $query_product->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Robocart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3>Edit Product</h3>
        <form method="POST" action="">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image URL</label>
                <input type="text" class="form-control" id="image" name="image" value="<?= htmlspecialchars($product['image']) ?>" required>
            </div>
            <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>