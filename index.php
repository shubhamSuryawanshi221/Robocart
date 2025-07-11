<?php
include 'config.php'; // Include database connection

session_start(); // Also needed here!
if (!isset($_SESSION['login_user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$username = $_SESSION['login_user'];
$post = $_SESSION['login_post'];



// Fetch products from the database
$sql = "SELECT * FROM products";
$query = $conn->prepare($sql);
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robocart - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg,rgb(255, 255, 255),rgb(255, 255, 255));
            color: #fff;
        }

        .header {
            text-align: center;
            padding: 5px;
            background: rgb(255, 71, 4);
            color: #fff;
        }
        .motive-section {
            padding: 30px 15px;
            background: rgba(235, 235, 246, 0.6);
            border-radius: 20px;
            margin: 30px 0;
            text-align: center;
        }

        .motive-section h2 {
            margin-bottom: 20px;
        }

        .carousel-item img {
            height: 80vh;
            object-fit: cover;
        }

        .content-section {
            margin: 50px auto;
            text-align: center;
        }

        .content-section h2 {
            color: #ff6347;
        }

        .product-grid-section {
            margin-bottom: 50px; /* Add margin to separate from footer */
        }

        .footer {
            background: #222;
            padding: 20px;
            color: #ccc;
            text-align: center;
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        @keyframes rise {
            from {
                transform: translateY(100vh);
                opacity: 1;
            }
            to {
                transform: translateY(-10vh);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <header class="header">
        <h1>Robocart</h1>
        <p>Your one-stop shop for all things robotics.</p>
    </header>

    <!-- Highlight Section -->
    <section class="highlight-section text-center py-5">
        <div class="container">
            <h2 class="mb-4">Why Choose Robocart?</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-light text-dark animate__animated animate__bounceInLeft" style="border: 2px solid #ff6347;">
                        <div class="card-body">
                            <h5 class="card-title">Wide Range of Products</h5>
                            <p class="card-text">We offer a diverse selection of robotics products to meet all your needs.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light text-dark animate__animated animate__bounceInUp animate__delay-1s" style="border: 2px solid #32cd32;">
                        <div class="card-body">
                            <h5 class="card-title">Quality Assurance</h5>
                            <p class="card-text">Our products are tested for quality and reliability to ensure customer satisfaction.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light text-dark animate__animated animate__bounceInRight animate__delay-2s" style="border: 2px solid #1e90ff;">
                        <div class="card-body">
                            <h5 class="card-title">Expert Support</h5>
                            <p class="card-text">Our team of experts is here to provide you with the support you need.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carousel Section -->
    <div id="roboticsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/img/1.jpg" class="d-block w-100" alt="1.jpg" style="filter: brightness(50%);">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100">
                    <div class="d-flex gap-2">
                        <a href="login.php" class="btn btn-lg btn-outline-light mb-2 animate__animated animate__bounceIn" style="border: 2px solid white; width: 150px; animation: colorChange 2s infinite;">Login</a>
                        <a href="register.php" class="btn btn-lg btn-outline-light animate__animated animate__bounceIn" style="border: 2px solid white; width: 150px; animation: colorChange 2s infinite;">Register</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/2.jpg" class="d-block w-100" alt="2.jpg" style="filter: brightness(50%);">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100">
                    <div class="d-flex gap-2">
                        <a href="login.php" class="btn btn-lg btn-outline-light mb-2 animate__animated animate__bounceIn" style="border: 2px solid white; width: 150px; animation: colorChange 2s infinite;">Login</a>
                        <a href="register.php" class="btn btn-lg btn-outline-light animate__animated animate__bounceIn" style="border: 2px solid white; width: 150px; animation: colorChange 2s infinite;">Register</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/4.jpg" class="d-block w-100" alt="3.jpg" style="filter: brightness(50%);">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100">
                    <div class="d-flex gap-2">
                        <a href="login.php" class="btn btn-lg btn-outline-light mb-2 animate__animated animate__bounceIn" style="border: 2px solid white; width: 150px; animation: colorChange 2s infinite;">Login</a>
                        <a href="register.php" class="btn btn-lg btn-outline-light animate__animated animate__bounceIn" style="border: 2px solid white; width: 150px; animation: colorChange 2s infinite;">Register</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#roboticsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#roboticsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <style>
        @keyframes colorChange {
            0% { border-color: white; }
            25% { border-color: yellow; }
            50% { border-color: green; }
            75% { border-color: pink; }
            100% { border-color: white; }
        }
    </style>

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Motive of the Project -->
    <section class="motive-section animate__animated animate__fadeInUp">
        <h2>Our Mission</h2>
        <p>Our mission is to advance the field of robotics through innovative research and development. We aim to create cutting-edge robotic solutions that improve efficiency, safety, and quality of life. Join us in our quest to push the boundaries of technology and make a positive impact on the world.</p>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-dark animate__animated animate__flipInY" style="border: 2px solid #007bff;">
                    <div class="card-body">
                        <h5 class="card-title">Innovation</h5>
                        <p class="card-text">We strive to be at the forefront of technological advancements in robotics.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-dark animate__animated animate__flipInY animate__delay-1s" style="border: 2px solid #28a745;">
                    <div class="card-body">
                        <h5 class="card-title">Efficiency</h5>
                        <p class="card-text">Our solutions are designed to enhance productivity and efficiency in various industries.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-dark animate__animated animate__flipInY animate__delay-2s" style="border: 2px solid #dc3545;">
                    <div class="card-body">
                        <h5 class="card-title">Quality of Life</h5>
                        <p class="card-text">We aim to improve the quality of life through our advanced robotic technologies.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="content-section">
        <h2>Introduction to Robotics</h2>
        <p>
            Robotics is an interdisciplinary field that integrates computer science, mechanical engineering,
            and electrical engineering to design, build, and operate robots. Robots are used in industries,
            healthcare, space exploration, and many other applications to perform tasks with precision and efficiency.
            The field of robotics encompasses various subfields, including artificial intelligence (AI), machine learning,
            control systems, and human-robot interaction. Advances in robotics technology have led to the development
            of autonomous robots capable of performing complex tasks without human intervention. Additionally, robotics
            research focuses on improving robot perception, manipulation, and mobility to enhance their capabilities
            and expand their range of applications.
        </p>
    </section>
    
    <!-- Product Grid Section -->
    <section class="product-grid-section">
        <div class="container">
            <h2 class="text-center mb-5">Our Collection</h2>
            <div class="row justify-content-center">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card shadow-sm mb-4 position-relative w-100">
                            <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= $product['name'] ?></h5>
                                <p class="card-text">Price: ₹<?= number_format($product['price'], 2) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

   
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Us</h5>
                    <p>Robocart is dedicated to making robotics accessible and affordable for everyone. Join us in revolutionizing the world of robotics.</p>
                    <form action="subscribe.php" method="post" class="mt-3">
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                            <button class="btn btn-primary" type="submit" style="background-color: #ff6347; border-color: #ff6347; font-size: 18px; padding: 10px 20px;">Subscribe</button>
                        </div>
                    </form>
                    <div>
                        <img src="assets/img/Robocart1 (2).png" alt="Robocart Logo" style="width: 200px;">
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="Index.php" style="color: #ccc;">Home</a></li>
                        <li><a href="about.php" style="color: #ccc;">About</a></li>
                        <li><a href="contact_us.php" style="color: #ccc;">Contact Us</a></li>
                        <li><a href="login.php" style="color: #ccc;">Login</a></li>
                        <li><a href="team.php" style="color: #ccc;">Team</a></li>
                        <li><a href="privacy_policy.php" style="color: #ccc;">Privacy Policy</a></li>
                        <li><a href="admin_login.php" style="color: #ccc;">Admin Login</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>Email: robocart1@gmail.com</p>
                    <p>Phone: +91 766082234</p>
                    <div>
                        <h5>Follow Us</h5>
                        <a href="https://www.instagram.com/robocart_01?igsh=MW80emR2NW9wOHNnOA==" target="_blank" class="text-decoration-none">
                <i class="fab fa-instagram" style="font-size: 40px; color: #E1306C; margin: 0 10px;"></i>
            </a>
            <a href="https://t.me/Robocart_12" target="_blank" class="text-decoration-none">
                <i class="fab fa-telegram-plane" style="font-size: 40px; color: #0088cc; margin: 0 10px;"></i>
            </a>
            <a href="https://wa.me/+917666082234" target="_blank" class="text-decoration-none">
                <i class="fab fa-whatsapp" style="font-size: 40px; color: #25D366; margin: 0 10px;"></i>
            </a>
            <a href="https://www.youtube.com/@shubham_221_" target="_blank" class="text-decoration-none">
                <i class="fab fa-youtube" style="font-size: 40px; color: #FF0000; margin: 0 10px;"></i>
            </a>
            <a href="mailto:robocart1@gmail..com" target="_blank" class="text-decoration-none">
                <i class="fas fa-envelope" style="font-size: 40px; color: #D44638; margin: 0 10px;"></i>
            </a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <p>&copy; 2025 All rights reserved to Robocart.</p>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
