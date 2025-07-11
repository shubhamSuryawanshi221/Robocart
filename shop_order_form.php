<!-- filepath: /c:/xampp/htdocs/Robocart/shop/shop_order_form.php -->
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $user_id = $_SESSION['user_id'];
    $shop_id = $_POST['shop_id'];
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $budget = $_POST['budget'];
    $location = $_POST['location'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO custom_orders (user_id, shop_id, project_name, description, requirements, budget, location, contact) VALUES (:user_id, :shop_id, :project_name, :description, :requirements, :budget, :location, :contact)";
    $query = $conn->prepare($sql);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindParam(':shop_id', $shop_id, PDO::PARAM_INT);
    $query->bindParam(':project_name', $project_name, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':requirements', $requirements, PDO::PARAM_STR);
    $query->bindParam(':budget', $budget, PDO::PARAM_STR);
    $query->bindParam(':location', $location, PDO::PARAM_STR);
    $query->bindParam(':contact', $contact, PDO::PARAM_STR);
    $query->execute();

    $success = "Your order has been placed successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order - Robocart</title>
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

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Place a Custom Order</h3>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $success ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <input type="hidden" name="shop_id" value="<?= htmlspecialchars($_GET['shop_id']) ?>">
                    <div class="mb-3">
                        <label for="project_name" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="project_name" name="project_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="requirements" class="form-label">Requirements</label>
                        <textarea class="form-control" id="requirements" name="requirements" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="form-label">Budget</label>
                        <input type="text" class="form-control" id="budget" name="budget" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact Information</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    <button type="submit" name="place_order" class="btn btn-primary">Place Order</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>