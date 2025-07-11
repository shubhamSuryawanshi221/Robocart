<!-- filepath: /c:/xampp/htdocs/Robocart/shop_dashboard.php -->
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['shop_id'])) {
    header('Location: shop_login.php');
    exit();
}

$shop_id = $_SESSION['shop_id'];

// Fetch orders for the shop
$sql_orders = "SELECT co.id, co.project_name, co.description, co.requirements, co.budget, co.location, co.contact, u.username AS customer_name, co.status, co.completion_date
               FROM custom_orders co
               JOIN users u ON co.user_id = u.id
               WHERE co.shop_id = :shop_id";
$query_orders = $conn->prepare($sql_orders);
$query_orders->bindParam(':shop_id', $shop_id, PDO::PARAM_INT);
$query_orders->execute();
$orders = $query_orders->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $completion_date = $_POST['completion_date'];

    $sql_update = "UPDATE custom_orders SET status = :status, completion_date = :completion_date WHERE id = :order_id";
    $query_update = $conn->prepare($sql_update);
    $query_update->bindParam(':status', $status, PDO::PARAM_STR);
    $query_update->bindParam(':completion_date', $completion_date, PDO::PARAM_STR);
    $query_update->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $query_update->execute();

    header('Location: shop_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Dashboard - Robocart</title>
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
        .order-card {
            margin-bottom: 20px;
        }
        .order-card img {
            border-radius: 15px;
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Shop Dashboard</h3>
            </div>
            <div class="card-body">
                <?php if (empty($orders)): ?>
                    <p>No orders available.</p>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($orders as $order): ?>
                            <div class="col-md-4 order-card">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($order['project_name']) ?></h5>
                                        <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($order['description']) ?></p>
                                        <p class="card-text"><strong>Requirements:</strong> <?= htmlspecialchars($order['requirements']) ?></p>
                                        <p class="card-text"><strong>Budget:</strong> ₹<?= htmlspecialchars($order['budget']) ?></p>
                                        <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($order['location']) ?></p>
                                        <p class="card-text"><strong>Contact:</strong> <?= htmlspecialchars($order['contact']) ?></p>
                                        <p class="card-text"><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                                        <p class="card-text"><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
                                        <p class="card-text"><strong>Completion Date:</strong> <?= htmlspecialchars($order['completion_date']) ?></p>
                                        <form method="POST" action="">
                                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option value="Accepted" <?= $order['status'] == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                                                    <option value="Rejected" <?= $order['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                                    <option value="Completed" <?= $order['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="completion_date" class="form-label">Completion Date</label>
                                                <input type="date" class="form-control" id="completion_date" name="completion_date" value="<?= htmlspecialchars($order['completion_date']) ?>" required>
                                            </div>
                                            <button type="submit" name="update_order" class="btn btn-primary">Update Order</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>