<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

try {
    // Check if the `orders` table exists
    $query = "SHOW TABLES LIKE 'orders'";
    $result = $conn->query($query);

    if ($result->rowCount() === 0) { // Use rowCount() for PDO
        throw new Exception("The 'orders' table does not exist in the database.");
    }

    // Fetch orders data
    $sql_orders = "SELECT o.*, p.name AS product_name, u.email AS user_email FROM orders o 
                   JOIN products p ON o.product_id = p.id
                   JOIN users u ON o.user_id = u.id";
    $query_orders = $conn->prepare($sql_orders);
    $query_orders->execute();
    $orders = $query_orders->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $delivery_date = $_POST['delivery_date'];

    $sql_update = "UPDATE orders SET status = :status, delivery_date = :delivery_date WHERE id = :order_id";
    $query_update = $conn->prepare($sql_update);
    $query_update->bindParam(':status', $status, PDO::PARAM_STR);
    $query_update->bindParam(':delivery_date', $delivery_date, PDO::PARAM_STR);
    $query_update->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $query_update->execute();

    // Fetch user email
    $sql_user = "SELECT u.email FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = :order_id";
    $query_user = $conn->prepare($sql_user);
    $query_user->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $query_user->execute();
    $user_email = $query_user->fetch(PDO::FETCH_ASSOC)['email'];

    // Send notification email to user
    $subject = "Order Status Update";
    $message = "Your order status has been updated to '$status'.";
    if ($status == 'Confirmed') {
        $message .= " Your order will be delivered on $delivery_date.";
    }
    mail($user_email, $subject, $message);

    header('Location: admin_dashboard.php');
    exit();
}

// Fetch data for dashboard
$sql_users = "SELECT COUNT(*) AS user_count FROM users WHERE role = 'user'";
$query_users = $conn->prepare($sql_users);
$query_users->execute();
$user_count = $query_users->fetch(PDO::FETCH_ASSOC)['user_count'];

$sql_orders = "SELECT COUNT(*) AS order_count FROM orders";
$query_orders = $conn->prepare($sql_orders);
$query_orders->execute();
$order_count = $query_orders->fetch(PDO::FETCH_ASSOC)['order_count'];

$sql_products = "SELECT COUNT(*) AS product_count FROM products";
$query_products = $conn->prepare($sql_products);
$query_products->execute();
$product_count = $query_products->fetch(PDO::FETCH_ASSOC)['product_count'];

// Fetch all users
$sql_all_users = "SELECT * FROM users";
$query_all_users = $conn->prepare($sql_all_users);
$query_all_users->execute();
$all_users = $query_all_users->fetchAll(PDO::FETCH_ASSOC);

// Fetch projects that users want to sell
$sql_projects = "SELECT * FROM projects";
$query_projects = $conn->prepare($sql_projects);
$query_projects->execute();
$projects = $query_projects->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Robocart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-family: Arial, sans-serif;
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
        <div class="header">
            <h1>Admin Dashboard</h1>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <div id="dashboard" class="dashboard-container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-users"></i> Total Users</h5>
                            <p class="card-text"><?= $user_count ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Total Orders</h5>
                            <p class="card-text"><?= $order_count ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-box"></i> Total Products</h5>
                            <p class="card-text"><?= $product_count ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <h2>All Users</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['role'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a href="index.php" class="btn btn-primary">Go to Home Page</a>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3 class="mt-5">User Projects</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Project Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Zip Folder</th>
                                <th>Image</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td><?= $project['id'] ?></td>
                                    <td><?= $project['project_name'] ?></td>
                                    <td><?= $project['description'] ?></td>
                                    <td>₹ <?= $project['price'] ?></td>
                                    <td><?= $project['status'] ?></td>
                                    <td><a href="<?= $project['zip_folder'] ?>" download>Download</a></td>
                                    <td><img src="<?= $project['image'] ?>" alt="<?= $project['project_name'] ?>" style="width: 100px; height: auto;"></td>
                                    <td>
                                        <!-- <form method="POST" action="update_project_status.php">
                                            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                            <button type="submit" name="action" value="accept" class="btn btn-success btn-sm">Accept</button>
                                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                        </form> -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>