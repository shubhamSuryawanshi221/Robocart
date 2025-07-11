<!-- filepath: /c:/xampp/htdocs/Robocart/profile.php -->
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT * FROM users WHERE id = :user_id";
$query_user = $conn->prepare($sql_user);
$query_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$query_user->execute();
$user = $query_user->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $pin = $_POST['pin'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $sql_update = "UPDATE users SET phone = :phone, address = :address, state = :state, pin = :pin, password = :password WHERE id = :user_id";
        $query_update = $conn->prepare($sql_update);
        $query_update->bindParam(':password', $password_hash, PDO::PARAM_STR);
    } else {
        $sql_update = "UPDATE users SET phone = :phone, address = :address, state = :state, pin = :pin WHERE id = :user_id";
        $query_update = $conn->prepare($sql_update);
    }

    $query_update->bindParam(':phone', $phone, PDO::PARAM_STR);
    $query_update->bindParam(':address', $address, PDO::PARAM_STR);
    $query_update->bindParam(':state', $state, PDO::PARAM_STR);
    $query_update->bindParam(':pin', $pin, PDO::PARAM_STR);
    $query_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query_update->execute();

    $success = "Your information has been updated successfully.";
}

// Handle search query
$search_query = isset($_GET['query']) ? $_GET['query'] : '';
$products = [];

if (!empty($search_query)) {
    $sql = "SELECT * FROM products WHERE name LIKE :searchTerm";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $search_query . '%';
    $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Robocart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-family: Arial, sans-serif;
        }
        .profile-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            background: white;
        }
        .profile-card-header {
            background-color: #6a5acd;
            color: #fff;
            border-radius: 15px 15px 0 0;
            padding: 20px;
            text-align: center;
        }
        .profile-card-body {
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
        .logo {
            width: 100px;
            margin-bottom: 20px;
        }
        .suggestions {
            border: 1px solid #ccc;
            border-top: none;
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            width: 100%;
            z-index: 1000;
            background-color: #fff;
        }
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }
        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card profile-card" id="profile-card">
                    <div class="card-header profile-card-header">
                        <img src="assets/img/Robocart1 (2).png" alt="Project Logo" class="logo">
                        <h3>Profile</h3>
                    </div>
                    <div class="card-body profile-card-body">
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $success ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" value="<?= htmlspecialchars($user['state']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="pin" class="form-label">PIN</label>
                                <input type="text" class="form-control" id="pin" name="pin" value="<?= htmlspecialchars($user['pin']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password (leave blank to keep current password)</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" name="update" class="btn btn-primary w-100">Update Information</button>
                        </form>
                        <button id="download-card" class="btn btn-primary w-100 mt-3" onclick="downloadProfileCard()">Download Profile Card</button>
                        <script>
                            function downloadProfileCard() {
                                const element = document.getElementById('profile-card');
                                html2canvas(element).then(canvas => {
                                    const link = document.createElement('a');
                                    link.href = canvas.toDataURL('image/png');
                                    link.download = 'profile-card.png';
                                    link.click();
                                });
                            }
                        </script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>

<?php
// Close connection
$conn = null;
?>