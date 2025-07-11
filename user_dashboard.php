<!-- filepath: /c:/xampp/htdocs/Robocart/user_dashboard.php -->
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT o.order_id, o.product_id, p.product_name, o.quantity, o.order_date, o.total_price FROM orders o JOIN products p ON o.product_id = p.product_id WHERE o.username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $orders = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch user orders
$sql_orders = "SELECT o.*, p.name AS product_name FROM orders o 
               JOIN products p ON o.product_id = p.id
               WHERE o.user_id = :user_id";
$query_orders = $conn->prepare($sql_orders);
$query_orders->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$query_orders->execute();
$orders = $query_orders->fetchAll(PDO::FETCH_ASSOC);

// Fetch user purchases
$sql_purchases = "SELECT p.*, o.quantity, o.total_price, o.status, o.delivery_date FROM orders o 
                  JOIN products p ON o.product_id = p.id
                  WHERE o.user_id = :user_id";
$query_purchases = $conn->prepare($sql_purchases);
$query_purchases->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$query_purchases->execute();
$purchases = $query_purchases->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];

    $sql_cancel = "UPDATE orders SET status = 'Canceled' WHERE id = :order_id";
    $query_cancel = $conn->prepare($sql_cancel);
    $query_cancel->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $query_cancel->execute();

    header('Location: user_dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buy_product'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    $sql_buy = "INSERT INTO orders (user_id, product_id, quantity, total_price, status, delivery_date) 
                VALUES (:user_id, :product_id, :quantity, :total_price, 'Pending', DATE_ADD(NOW(), INTERVAL 7 DAY))";
    $query_buy = $conn->prepare($sql_buy);
    $query_buy->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query_buy->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $query_buy->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $query_buy->bindParam(':total_price', $total_price, PDO::PARAM_STR);
    $query_buy->execute();

    $success_message = "Purchase successful!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Robocart</title>
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
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success_message) ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h3>Your Orders</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Delivery Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['id']) ?></td>
                                <td><?= htmlspecialchars($order['product_name']) ?></td>
                                <td><?= htmlspecialchars($order['quantity']) ?></td>
                                <td>₹ <?= htmlspecialchars($order['total_price']) ?></td>
                                <td><?= htmlspecialchars($order['status']) ?></td>
                                <td><?= htmlspecialchars($order['delivery_date']) ?></td>
                                <td>
                                    <?php if ($order['status'] == 'Pending'): ?>
                                        <form method="POST" action="" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                            <button type="submit" name="cancel_order" class="btn btn-danger btn-sm">Cancel</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header">
                <h3>Your Purchases</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Delivery Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchases as $purchase): ?>
                            <tr>
                                <td><?= htmlspecialchars($purchase['id']) ?></td>
                                <td><?= htmlspecialchars($purchase['name']) ?></td>
                                <td><?= htmlspecialchars($purchase['quantity']) ?></td>
                                <td>₹ <?= htmlspecialchars($purchase['total_price']) ?></td>
                                <td><?= htmlspecialchars($purchase['status']) ?></td>
                                <td><?= htmlspecialchars($purchase['delivery_date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>