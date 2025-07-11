<!-- filepath: /c:/xampp/htdocs/Robocart/sell_project.php -->
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



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $seller_id = $_SESSION['user_id']; // Assuming the seller is the logged-in user

    // Handle file upload
    $zip_folder = $_FILES['zip_folder']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($zip_folder);
    move_uploaded_file($_FILES['zip_folder']['tmp_name'], $target_file);

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target_image_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_image_file);

    $sql = "INSERT INTO projects (project_name, description, price, seller_id, zip_folder, image) VALUES (:project_name, :description, :price, :seller_id, :zip_folder, :image)";
    $query = $conn->prepare($sql);
    $query->bindParam(':project_name', $project_name, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':price', $price, PDO::PARAM_STR);
    $query->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
    $query->bindParam(':zip_folder', $target_file, PDO::PARAM_STR);
    $query->bindParam(':image', $target_image_file, PDO::PARAM_STR);
    $query->execute();

    $success = "Project listed for sale successfully.";
}

$sql = "SELECT * FROM projects";
$query = $conn->prepare($sql);
$query->execute();
$projects = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Project - Robocart</title>
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
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Sell Project</h3>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $success ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="project_name" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="project_name" name="project_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="zip_folder" class="form-label">Upload Project Zip Folder</label>
                        <input type="file" class="form-control" id="zip_folder" name="zip_folder" accept=".zip" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">List Project for Sale</button>
                </form>
                <h3 class="mt-5">All Projects</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Project Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Seller ID</th>
                            <th>Zip Folder</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?= $project['id'] ?></td>
                                <td><?= $project['project_name'] ?></td>
                                <td><?= $project['description'] ?></td>
                                <td>₹ <?= $project['price'] ?></td>
                                <td><?= $project['seller_id'] ?></td>
                                <td><a href="<?= $project['zip_folder'] ?>" download>Download</a></td>
                                <td><img src="<?= $project['image'] ?>" alt="<?= $project['project_name'] ?>" style="width: 100px; height: auto;"></td>
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