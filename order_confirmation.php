<!-- filepath: /c:/xampp/htdocs/Robocart/order_confirmation.php -->
<?php
session_start();
include 'config.php';

if (!isset($_GET['product_id'])) {
    header('Location: order.php');
    exit();
}

$product_id = $_GET['product_id'];

// Fetch product details from the database
$sql_product = "SELECT * FROM products WHERE id = :product_id";
$query_product = $conn->prepare($sql_product);
$query_product->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$query_product->execute();
$product = $query_product->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: order.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    $sql_order = "INSERT INTO orders (user_id, product_id, address, payment_method, status) VALUES (:user_id, :product_id, :address, :payment_method, 'Pending')";
    $query_order = $conn->prepare($sql_order);
    $query_order->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query_order->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $query_order->bindParam(':address', $address, PDO::PARAM_STR);
    $query_order->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
    $query_order->execute();

    $order_id = $conn->lastInsertId();
    header("Location: payment.php?order_id=$order_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Robocart</title>
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
                <h3>Order Confirmation</h3>
            </div>
            <div class="card-body">
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: auto; border-radius: 15px;">
                <p class="mt-3"><?= htmlspecialchars($product['description']) ?></p>
                <p>Price: ₹ <?= htmlspecialchars($product['price']) ?></p>
                <p>Discount: <?= htmlspecialchars($product['discount']) ?>%</p>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="address" class="form-label">Shipping Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
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
                    <button type="submit" class="btn btn-primary">Confirm Order</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>