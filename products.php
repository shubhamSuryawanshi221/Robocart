<!-- filepath: /c:/xampp/htdocs/Robocart/products.php -->
<?php
session_start();
include 'config.php';

// Fetch products from the database
$sql_products = "SELECT * FROM products";
$query_products = $conn->prepare($sql_products);
$query_products->execute();
$products = $query_products->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Robocart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #6a5acd;
            color: #fff;
            border-radius: 15px 15px 0 0;
            padding: 20px;
            text-align: center;
        }
        .card-body {
            padding: 20px;
        }
        .btn-primary {
            background-color: #6a5acd;
            border-color: #6a5acd;
        }
        .btn-primary:hover {
            background-color: #5a4dbd;
            border-color: #5a4dbd;
        }
        .btn-secondary {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-secondary:hover {
            background-color: #218838;
            border-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2 class="text-center">Our Products</h2>
        <div class="row">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                <p class="card-text">Price: ₹ <?= htmlspecialchars($product['price']) ?></p>
                                <div class="mt-auto">
                                    <a href="order.php?product_id=<?= htmlspecialchars($product['id']) ?>" class="btn btn-primary">Order Now</a>
                                    <a href="selling.php?product_id=<?= htmlspecialchars($product['id']) ?>" class="btn btn-secondary mt-2">Sell This Product</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No products available.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>