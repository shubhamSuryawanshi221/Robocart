<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch all products data
include 'config.php';

$sql_all_products = "SELECT p.*, 
    (SELECT AVG(rating) FROM product_feedback WHERE product_id = p.id) AS avg_rating, 
    (SELECT COUNT(*) FROM product_feedback WHERE product_id = p.id AND liked = 1) AS total_likes 
    FROM products p";
$query_all_products = $conn->prepare($sql_all_products);
$query_all_products->execute();
$all_products = $query_all_products->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Robocart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-family: Arial, sans-serif;
        }
        .dashboard-container {
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            border-radius: 15px 15px 0 0;
            color: #fff;
        }
        .card-body {
            padding: 20px;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: #ccc;
            display: block;
        }
        .sidebar a:hover {
            background-color: #575d63;
            color: white;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .card:nth-child(odd) .card-header {
            background-color: #6a5acd;
        }
        .card:nth-child(even) .card-header {
            background-color: #ff6347;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="admin_products.php"><i class="fas fa-box"></i> Products</a>
        <a href="admin_users.php"><i class="fas fa-users"></i> Registered Users</a>
        <a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
        <a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <div id="products" class="dashboard-container">
            <h4>Products</h4>
            <a href="add_product.php" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Add Product</a>
            <div class="row">
                <?php foreach ($all_products as $product): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Product ID: <?= htmlspecialchars($product['id']) ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                <p class="card-text">Price: ₹ <?= htmlspecialchars($product['price']) ?></p>
                                <p class="card-text">Average Rating: <?= htmlspecialchars($product['avg_rating']) ?></p>
                                <p class="card-text">Total Likes: <?= htmlspecialchars($product['total_likes']) ?></p>
                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" width="100%">
                                <div class="mt-3">
                                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
