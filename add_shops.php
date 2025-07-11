<!-- filepath: /c:/xampp/htdocs/Robocart/add_shop.php -->
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $contact_name = $_POST['contact_name'];
    $address = $_POST['address'];
    $location = $_POST['location'];
    $social_media = $_POST['social_media'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    $sql = "INSERT INTO shops (name, contact_name, address, location, social_media, image) VALUES (:name, :contact_name, :address, :location, :social_media, :image)";
    $query = $conn->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':contact_name', $contact_name, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':location', $location, PDO::PARAM_STR);
    $query->bindParam(':social_media', $social_media, PDO::PARAM_STR);
    $query->bindParam(':image', $target_file, PDO::PARAM_STR);
    $query->execute();

    $success = "Shop added successfully.";
}

// Fetch all shops
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
    <title>Add Shop - Robocart</title>
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
                <h3>Add Shop</h3>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $success ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Shop Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_name" class="form-label">Contact Name</label>
                        <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Google Maps Link</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="social_media" class="form-label">Social Media Links</label>
                        <textarea class="form-control" id="social_media" name="social_media" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Shop Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" name="add_shop" class="btn btn-primary">Add Shop</button>
                </form>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
            <h3>All Shops</h3>
            </div>
            <div class="card-body">
            <?php if (empty($shops)): ?>
                <p class="text-center">No shops available.</p>
            <?php else: ?>
                <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered text-center align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact Name</th>
                        <th>Address</th>
                        <th>Location</th>
                        <th>Social Media</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($shops as $shop): ?>
                        <tr>
                        <td><?= htmlspecialchars($shop['id']) ?></td>
                        <td><?= htmlspecialchars($shop['name']) ?></td>
                        <td><?= htmlspecialchars($shop['contact_name']) ?></td>
                        <td><?= htmlspecialchars($shop['address']) ?></td>
                        <td><a href="<?= htmlspecialchars($shop['location']) ?>" target="_blank" class="btn btn-link">View</a></td>
                        <td><?= htmlspecialchars($shop['social_media']) ?></td>
                        <td><img src="<?= htmlspecialchars($shop['image']) ?>" alt="<?= htmlspecialchars($shop['name']) ?>" width="50" class="rounded"></td>
                        <td>
                            <a href="edit_shop.php?id=<?= htmlspecialchars($shop['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_shop.php?id=<?= htmlspecialchars($shop['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this shop?');">Delete</a>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>
            </div>
        </div>
        </div>




    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>