<?php
include 'config.php'; // Include database connection

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$product = isset($_GET['product']) ? $_GET['product'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order'])) {
    $user_id = $_SESSION['user_id'];
    $product_name = $_POST['product_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $quantity = $_POST['quantity'];
    $payment_method = $_POST['payment_method'];

    // Check if user_id exists in the users table
    $sql_check_user = "SELECT COUNT(*) FROM users WHERE id = :user_id";
    $query_check_user = $conn->prepare($sql_check_user);
    $query_check_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query_check_user->execute();
    $user_exists = $query_check_user->fetchColumn();

    if ($user_exists) {
        // Process payment using Stripe
        if ($payment_method == 'Credit Card' || $payment_method == 'Debit Card') {
            require_once 'vendor/autoload.php';
            \Stripe\Stripe::setApiKey('your_stripe_secret_key');

            try {
                $charge = \Stripe\Charge::create([
                    'amount' => 1000, // Amount in cents
                    'currency' => 'usd',
                    'source' => $_POST['stripeToken'],
                    'description' => 'Order payment',
                ]);

                // Store order details in the database
                $sql = "INSERT INTO orders (user_id, product_name, address, phone, quantity, payment_method, tracking_status) VALUES (:user_id, :product_name, :address, :phone, :quantity, :payment_method, 'Pending')";
                $query = $conn->prepare($sql);
                $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $query->bindParam(':product_name', $product_name, PDO::PARAM_STR);
                $query->bindParam(':address', $address, PDO::PARAM_STR);
                $query->bindParam(':phone', $phone, PDO::PARAM_STR);
                $query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $query->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
                $query->execute();

                $success = "Your order has been placed successfully.";
                header('Location: track_order.php');
                exit();
            } catch (\Stripe\Exception\CardException $e) {
                $error = "Payment failed: " . $e->getMessage();
            }
        } else {
            // Store order details in the database for other payment methods
            $sql = "INSERT INTO orders (user_id, product_name, address, phone, quantity, payment_method, tracking_status) VALUES (:user_id, :product_name, :address, :phone, :quantity, :payment_method, 'Pending')";
            $query = $conn->prepare($sql);
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $query->bindParam(':product_name', $product_name, PDO::PARAM_STR);
            $query->bindParam(':address', $address, PDO::PARAM_STR);
            $query->bindParam(':phone', $phone, PDO::PARAM_STR);
            $query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $query->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
            $query->execute();

            $success = "Your order has been placed successfully.";
            header('Location: track_order.php');
            exit();
        }
    } else {
        $error = "Invalid user ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form - Robocart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-family: Arial, sans-serif;
        }
        .order-container {
            margin-top: 100px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .input-group-text {
            background-color: #f8f9fa;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container order-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h3>Order Form</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $success ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                                <input type="text" class="form-control" id="product_name" name="product_name" value="<?= htmlspecialchars($product) ?>" readonly>
                            </div>
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Delivery Address" required>
                            </div>
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
                            </div>
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" min="1" required>
                            </div>
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                <select class="form-control" id="payment_method" name="payment_method" required>
                                    <option value="" disabled selected>Select Payment Method</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
                                    <option value="PayPal">PayPal</option>
                                    <option value="Cash on Delivery">Cash on Delivery</option>
                                    <option value="PhonePe">PhonePe</option>
                                </select>
                                <div id="phonepe-scanner" class="mt-3" style="display: none;">
                                    <div class="d-flex justify-content-center">
                                        <img src="assets/img/phonepay.jpg" alt="PhonePe QR Code" class="img-fluid" style="width: 150px; height: 150px;">
                                    </div>
                                    <p class="text-center">Scan the QR code with your PhonePe app to make the payment.</p>
                                </div>
                                <script>
                                    document.getElementById('payment_method').addEventListener('change', function() {
                                        var phonepeScanner = document.getElementById('phonepe-scanner');
                                        if (this.value === 'PhonePe') {
                                            phonepeScanner.style.display = 'block';
                                        } else {
                                            phonepeScanner.style.display = 'none';
                                        }
                                    });
                                </script>
                            </div>
                            <div id="card-element" class="mb-3"></div>
                            <button type="submit" name="order" class="btn btn-primary w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stripe JS -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('your_stripe_public_key');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.querySelector('.alert-danger');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);

                    // Submit the form
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>