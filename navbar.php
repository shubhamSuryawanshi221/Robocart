<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for social media icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS for animations -->
    <style>
        .navbar {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand img {
            height: 40px;
        }
        .navbar-nav .nav-link {
            color: #000;
            transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
        .navbar-nav .nav-link:hover {
            color:rgb(38, 0, 255);
            transform: scale(1.1);
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #000;
            transition: color 0.3s ease-in-out;
        }
        .navbar-brand:hover {
            color:rgb(38, 0, 255);
        }
        .dropdown-menu {
            background-color: #fff;
            border: none;
        }
        .dropdown-item {
            color: #000;
        }
        .dropdown-item:hover {
            background-color:rgb(38, 0, 255);
            color: #000;
        }
    </style>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/Robocart1 (2).png" alt="Robocart Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php"><i class="fas fa-info-circle"></i> About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact_us.php"><i class="fas fa-envelope"></i> Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="team.php"><i class="fas fa-users"></i> Team</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="contact_shops.php"><i class="fas fa-store"></i> Contact Shops</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sell_project.php"><i class="fas fa-dollar-sign"></i> Sell Project</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="search.php"><i class="fas fa-search"></i> Search</a>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                </li>
            <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
