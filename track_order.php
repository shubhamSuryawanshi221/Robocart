<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
$query = $conn->prepare($sql);
$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order - Robocart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .page-header {
            background: linear-gradient(135deg, #1a1a1a, #6a5acd);
            color: #fff;
            padding: 30px 0;
            text-align: center;
            margin-bottom: 30px;
        }
        .page-header h1 {
            margin: 0;
            font-size: 2.5rem;
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
        .progress {
            height: 20px;
            border-radius: 10px;
        }
        .progress-bar {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="page-header">
        <div class="container">
            <h1>Track Your Orders</h1>
        </div>
    </div>

    <div class="container">
        <h3 class="mb-4">Your Orders</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Tracking Status</th>
                    <th>Estimated Delivery Date</th>
                    <th>Payment Process</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                        <td>
                            <div class="progress">
                                <?php
                                $progress = 0;
                                switch ($order['tracking_status']) {
                                    case 'Pending':
                                        $progress = 25;
                                        break;
                                    case 'Confirmed':
                                        $progress = 50;
                                        break;
                                    case 'Shipped':
                                        $progress = 75;
                                        break;
                                    case 'Delivered':
                                        $progress = 100;
                                        break;
                                }
                                ?>
                                <div class="progress-bar" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"><?= htmlspecialchars($order['tracking_status']) ?></div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($order['estimated_delivery_date']) ?></td>
                        <td><?= htmlspecialchars($order['payment_method']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>