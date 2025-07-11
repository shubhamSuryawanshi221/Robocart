<!-- filepath: /c:/xampp/htdocs/Robocart/payment.php -->
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['order_id'])) {
    header('Location: order.php');
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details from the database
$sql_order = "SELECT * FROM orders WHERE id = :order_id";
$query_order = $conn->prepare($sql_order);
$query_order->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$query_order->execute();
$order = $query_order->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: order.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['make_payment'])) {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    $sql_payment = "INSERT INTO payments (user_id, amount, payment_method, status) VALUES (:user_id, :amount, :payment_method, 'Completed')";
    $query_payment = $conn->prepare($sql_payment);
    $query_payment->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query_payment->bindParam(':amount', $amount, PDO::PARAM_STR);
    $query_payment->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
    $query_payment->execute();

    header('Location: user_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Robocart</title>
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
            border-radius: 15px 15px 0 0;
            color: #fff;
            background-color: #6a5acd;
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
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 10px;
        }
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Make Payment</h3>
            </div>
            <div class="card-body">
                <p>Order ID: <?= htmlspecialchars($order['id']) ?></p>
                <p>Product ID: <?= htmlspecialchars($order['product_id']) ?></p>
                <p>Shipping Address: <?= htmlspecialchars($order['address']) ?></p>
                <p>Payment Method: <?= htmlspecialchars($order['payment_method']) ?></p>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                            <option value="PayPal">PayPal</option>
                            <option value="Cash on Delivery">Cash on Delivery</option>
                        </select>
                    </div>
                    <button type="submit" name="make_payment" class="btn btn-primary">Make Payment</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>