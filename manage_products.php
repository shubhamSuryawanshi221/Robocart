<!-- filepath: /c:/xampp/htdocs/Robocart/manage_products.php -->
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Handle form submission for adding a new product
if (isset($_POST['submit']) && $_POST['submit'] == "Add Product") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    $sql = "INSERT INTO products (name, description, price, discount, image) VALUES (:name, :description, :price, :discount, :image)";
    $query = $conn->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':price', $price, PDO::PARAM_STR);
    $query->bindParam(':discount', $discount, PDO::PARAM_STR);
    $query->bindParam(':image', $target_file, PDO::PARAM_STR);
    $query->execute();
    $msg = "Product added successfully";
}

// Handle form submission for editing a product
if (isset($_POST['submit']) && $_POST['submit'] == "Edit Product") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $image = $_FILES['image']['name'];
    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $sql = "UPDATE products SET name = :name, description = :description, price = :price, discount = :discount, image = :image WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':image', $target_file, PDO::PARAM_STR);
    } else {
        $sql = "UPDATE products SET name = :name, description = :description, price = :price, discount = :discount WHERE id = :id";
        $query = $conn->prepare($sql);
    }
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':price', $price, PDO::PARAM_STR);
    $query->bindParam(':discount', $discount, PDO::PARAM_STR);
    $query->execute();
    $msg = "Product updated successfully";
}

// Handle product deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $msg = "Product deleted successfully";
}

// Fetch all products
$sql_all_products = "SELECT * FROM products";
$query_all_products = $conn->prepare($sql_all_products);
$query_all_products->execute();
$all_products = $query_all_products->fetchAll(PDO::FETCH_ASSOC);

// Fetch all orders
$sql_all_orders = "SELECT * FROM orders";
$query_all_orders = $conn->prepare($sql_all_orders);
$query_all_orders->execute();
$all_orders = $query_all_orders->fetchAll(PDO::FETCH_ASSOC);

// Fetch all sales
$sql_all_sales = "SELECT * FROM sales";
$query_all_sales = $conn->prepare($sql_all_sales);
$query_all_sales->execute();
$all_sales = $query_all_sales->fetchAll(PDO::FETCH_ASSOC);

// Fetch product and order data
$sql = "SELECT o.id AS order_id, u.username AS customer_name, p.name AS product, o.quantity, o.total_price
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN products p ON o.product_id = p.id";
$query = $conn->prepare($sql);
$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Robocart</title>
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
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .table-custom {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .table-custom thead {
            background-color: #6a5acd;
            color: #fff;
        }
        .table-custom tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<div class="sidebar">
<a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
        <a href="add_shops.php"><i class="fas fa-plus-circle"></i> Add Shop</a>
        <a href="insert_product.php"><i class="fas fa-plus-circle"></i> Insert Product</a>
        <a href="manage_products.php"><i class="fas fa-boxes"></i> Manage Products</a>
        <a href="contact_shops.php"><i class="fas fa-address-book"></i> Contact Shops</a>  
        <a href="contact_us_dashboard.php"><i class="fas fa-envelope"></i> ContactUS</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <div class="container dashboard-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4>Manage Products</h4>
                        </div>
                        <div class="card-body">
                            <?php if (isset($msg)): ?>
                                <div class="alert alert-success">
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Product Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Discount</label>
                                    <input type="number" class="form-control" id="discount" name="discount">
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Product Image</label>
                                    <input type="file" class="form-control" id="image" name="image" required>
                                </div>
                                <button type="submit" name="submit" value="Add Product" class="btn btn-primary">Add Product</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header bg-primary">
                            <h4>Existing Products</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($all_products as $product): ?>
                                        <tr>
                                            <td><?= $product['id'] ?></td>
                                            <td><?= $product['name'] ?></td>
                                            <td><?= $product['description'] ?></td>
                                            <td>₹<?= number_format($product['price'], 2) ?></td>
                                            <td><?= $product['discount'] ?>%</td>
                                            <td><img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="50"></td>
                                            <td>
                                                <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="manage_products.php?delete=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                          
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>