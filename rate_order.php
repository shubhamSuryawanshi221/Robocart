<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'user')";
    $query = $conn->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();

    $_SESSION['success'] = "Registration successful. You can now log in.";
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Robocart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg,rgb(255, 255, 255),rgb(255, 255, 255));
            animation: backgroundAnimation 10s infinite alternate;
        }

        @keyframes backgroundAnimation {
            0% { background: linear-gradient(135deg,rgb(255, 255, 255),rgb(255, 255, 255)); }
            100% { background: linear-gradient(135deg,rgb(255, 255, 255),rgb(255, 255, 255)); }
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
            width: 400px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-control {
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }

        .btn-primary {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            border: none;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #9b59b6, #71b7e6);
        }

        .input-group-text {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            border: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
            <p class="mt-3 text-center">Already have an account? <a href="login.php" style="color: #007bff;">Login</a></p>
        </form>
    </div>
</body>
</html>