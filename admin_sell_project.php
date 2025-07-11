<!-- filepath: /c:/xampp/htdocs/Robocart/admin_sell_project.php -->
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch products that users want to sell
$sql_sell_projects = "SELECT sp.id, sp.product_name, sp.description, sp.price, sp.status, u.username AS seller_name
                      FROM sell_projects sp
                      JOIN users u ON sp.user_id = u.id
                      WHERE sp.status = 'Pending'";
$query_sell_projects = $conn->prepare($sql_sell_projects);
$query_sell_projects->execute();
$sell_projects = $query_sell_projects->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $project_id = $_POST['project_id'];
    $status = $_POST['status'];

    $sql_update = "UPDATE sell_projects SET status = :status WHERE id = :project_id";
    $query_update = $conn->prepare($sql_update);
    $query_update->bindParam(':status', $status, PDO::PARAM_STR);
    $query_update->bindParam(':project_id', $project_id, PDO::PARAM_INT);
    $query_update->execute();

    // Fetch user email
    $sql_user = "SELECT u.email FROM sell_projects sp JOIN users u ON sp.user_id = u.id WHERE sp.id = :project_id";
    $query_user = $conn->prepare($sql_user);
    $query_user->bindParam(':project_id', $project_id, PDO::PARAM_INT);
    $query_user->execute();
    $user_email = $query_user->fetch(PDO::FETCH_ASSOC)['email'];

    // Send notification email to user
    $subject = "Product Sale Status Update";
    $message = "Your product sale status has been updated to '$status'.";
    mail($user_email, $subject, $message);

    header('Location: admin_sell_project.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sell Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
        .btn-danger {
            background-color: #ff6347;
            border-color: #ff6347;
        }
        .btn-danger:hover {
            background-color: #e55347;
            border-color: #e55347;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Sell Projects</h3>
            </div>
            <div class="card-body">
                <?php if (empty($sell_projects)): ?>
                    <p>No projects available.</p>
                <?php else: ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Seller</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sell_projects as $project): ?>
                                <tr>
                                    <td><?= htmlspecialchars($project['id']) ?></td>
                                    <td><?= htmlspecialchars($project['product_name']) ?></td>
                                    <td><?= htmlspecialchars($project['description']) ?></td>
                                    <td>₹<?= htmlspecialchars($project['price']) ?></td>
                                    <td><?= htmlspecialchars($project['seller_name']) ?></td>
                                    <td><?= htmlspecialchars($project['status']) ?></td>
                                    <td>
                                        <form method="POST" action="" class="d-inline">
                                            <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id']) ?>">
                                            <input type="hidden" name="status" value="Accepted">
                                            <button type="submit" name="update_status" class="btn btn-primary">Accept</button>
                                        </form>
                                        <form method="POST" action="" class="d-inline">
                                            <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id']) ?>">
                                            <input type="hidden" name="status" value="Rejected">
                                            <button type="submit" name="update_status" class="btn btn-danger">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>