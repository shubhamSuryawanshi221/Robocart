<!-- filepath: /c:/xampp/htdocs/Robocart/contact_shops.php -->
<?php
session_start();
include 'config.php';


if (!isset($_SESSION['login_user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$username = $_SESSION['login_user'];
$post = $_SESSION['login_post'];


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch shop details
$sql_shops = "SELECT * FROM shops";
$query_shops = $conn->prepare($sql_shops);
$query_shops->execute();
$shops = $query_shops->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Shops - Robocart</title>
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
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-10px);
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
        .shop-card {
            margin-bottom: 20px;
        }
        .shop-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .shop-card img {
            border-radius: 15px;
            width: 100%;
            height: auto;
        }
        .shop-card .btn-order {
            background-color: #28a745;
            border-color: #28a745;
        }
        .shop-card .btn-order:hover {
            background-color: #218838;
            border-color: #218838;
        }
        .sumit{
            font-size: 80px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h3 class="text-center mb-4" style="color:rgb(239, 84, 0); font-weight: bold;">Our Shop Name</h3>
        <h1 class="sumit text-center mb-4" style="color:rgb(239, 84, 0); font-weight: bold;"> ROBOCART </h1>
        <div class="row">
            <?php foreach ($shops as $shop): ?>
                <div class="col-md-4 shop-card">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($shop['image']) ?>" alt="<?= htmlspecialchars($shop['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($shop['name']) ?></h5>
                            <p class="card-text"><strong>Location:</strong> <a href="<?= htmlspecialchars($shop['location']) ?>" target="_blank">View Location</a></p>
                            <p class="card-text"><strong>Contact:</strong> <?= htmlspecialchars($shop['contact_name']) ?></p>
                            <a href="mailto:<?= htmlspecialchars($shop['contact_name']) ?>" class="btn btn-primary mt-auto">Contact Shop</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>