<!-- filepath: /c:/xampp/htdocs/Robocart/manage_users.php -->
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch all users data
include 'config.php';

$sql_all_users = "SELECT * FROM users WHERE role = 'user'";
$query_all_users = $conn->prepare($sql_all_users);
$query_all_users->execute();
$all_users = $query_all_users->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Robocart</title>
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
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .card:nth-child(odd) .card-header {
            background-color: #6a5acd;
        }
        .card:nth-child(even) .card-header {
            background-color: #ff6347;
        }
        .btn-delete {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #c82333;
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
        <div id="users" class="dashboard-container">
            <h4>Manage Users</h4>
            <div class="grid-container">
                <?php foreach ($all_users as $user): ?>
                    <div class="card">
                        <div class="card-header">
                            User ID: <?= htmlspecialchars($user['id']) ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($user['username']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($user['email']) ?></p>
                            <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
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