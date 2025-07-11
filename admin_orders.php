<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch orders
include 'config.php';

// Add estimated_delivery_date column if it doesn't exist
$sql_add_column = "ALTER TABLE orders ADD COLUMN IF NOT EXISTS estimated_delivery_date DATE";
$conn->exec($sql_add_column);

$sql_orders = "SELECT * FROM orders ORDER BY created_at DESC";
$query_orders = $conn->prepare($sql_orders);
$query_orders->execute();
$orders = $query_orders->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $tracking_status = $_POST['tracking_status'];
    $estimated_delivery_date = $_POST['estimated_delivery_date'];

    $sql_update = "UPDATE orders SET tracking_status = :tracking_status, estimated_delivery_date = :estimated_delivery_date WHERE id = :order_id";
    $query_update = $conn->prepare($sql_update);
    $query_update->bindParam(':tracking_status', $tracking_status, PDO::PARAM_STR);
    $query_update->bindParam(':estimated_delivery_date', $estimated_delivery_date, PDO::PARAM_STR);
    $query_update->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $query_update->execute();

    header('Location: <admin>admin_orders.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders - Robocart</title>
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
        .table {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table th {
            background: #6a5acd;
            color: #fff;
            border: none;
        }
        .table td {
            border: none;
        }
        .table tbody tr:nth-child(even) {
            background: #f2f2f2;
        }
        .btn-primary {
            background-color: #6a5acd;
            border-color: #6a5acd;
        }
        .btn-primary:hover {
            background-color: #5a4dbd;
            border-color: #5a4dbd;
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
        <h3 class="mb-4">Manage Orders</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Tracking Status</th>
                    <th>Estimated Delivery Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['user_id']) ?></td>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                        <td><?= htmlspecialchars($order['tracking_status']) ?></td>
                        <td><?= htmlspecialchars($order['estimated_delivery_date'] ?? 'N/A') ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateOrderModal<?= $order['id'] ?>">Update</button>
                        </td>
                    </tr>

                    <!-- Update Order Modal -->
                    <div class="modal fade" id="updateOrderModal<?= $order['id'] ?>" tabindex="-1" aria-labelledby="updateOrderModalLabel<?= $order['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateOrderModalLabel<?= $order['id'] ?>">Update Order</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <div class="mb-3">
                                            <label for="tracking_status" class="form-label">Tracking Status</label>
                                            <select class="form-select" name="tracking_status" id="tracking_status" required>
                                                <option value="Pending" <?= $order['tracking_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="Confirmed" <?= $order['tracking_status'] == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                <option value="Shipped" <?= $order['tracking_status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                                <option value="Delivered" <?= $order['tracking_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="estimated_delivery_date" class="form-label">Estimated Delivery Date</label>
                                            <input type="date" class="form-control" name="estimated_delivery_date" id="estimated_delivery_date" value="<?= $order['estimated_delivery_date'] ?? '' ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="update_order" class="btn btn-primary">Update Order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>