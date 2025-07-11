<?php
session_start(); // Also needed here!

include 'config.php'; // Include database connection
if (!isset($_SESSION['login_user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$username = $_SESSION['login_user'];
$post = $_SESSION['login_post'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Robocart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, rgb(255, 255, 255), rgb(255, 255, 255));
            color: #fff;
        }

        .header {
            text-align: center;
            padding: 5px;
            background: rgb(255, 71, 4);
            color: #fff;
        }

        .content-section {
            margin: 50px auto;
            text-align: center;
        }

        .content-section h2 {
            color:rgb(9, 13, 235);
        }

        .card {
            background-color: rgb(227, 227, 229);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-title {
            color: #ff6347;
        }

        .card:nth-child(1) {
            border: 2px solid #ff6347;
        }

        .card:nth-child(2) {
            border: 2px solid #4caf50;
        }

        .card:nth-child(3) {
            border: 2px solid #2196f3;
        }

        .footer {
            background: #222;
            padding: 15px;
            color: #ccc;
            text-align: center;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <header class="header">
        <h1>About Us</h1>
    </header>

    <section class="content-section">
        <h2>Robocart - Revolutionizing Robotics</h2>
        <p>Robocart is dedicated to making robotics accessible and affordable for everyone. We offer a wide range of robotics products designed to meet your needs. Our expert customer support and detailed product guides help you make informed decisions to get the products that are right for you. Join our community of robotics enthusiasts and gain access to exclusive content, tutorials, and events. Connect with us on Instagram, Telegram, and WhatsApp to stay updated on the latest robotics products and offers.</p>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="assets/img/Discovericon.png" class="card-img-top" alt="Image 1">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Discover Robotics</h5>
                            <p class="card-text">Discover a wide range of robotics products designed to meet your needs. Enjoy exclusive discounts and offers available only on our website.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="assets/img/Benefits.png" class="card-img-top" alt="Image 2">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Customer Support</h5>
                            <p class="card-text">Benefit from our expert customer support and detailed product guides to help you make informed decisions to get the products.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="assets/img/Community.png" class="card-img-top" alt="Image 3">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Join Our Community</h5>
                            <p class="card-text">Join our community of robotics enthusiasts and gain access to exclusive content, tutorials, and events (Instagram, Whatsapp, Telegram)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>CONNECT WITH US...!!!</h4>
    </section>

    <div class="d-flex justify-content-center my-4">
        <div class="social-media-icons">
            <a href="https://www.instagram.com/robocart_01?igsh=MW80emR2NW9wOHNnOA==" target="_blank" class="text-decoration-none">
                <i class="fab fa-instagram" style="font-size: 40px; color: #E1306C; margin: 0 10px;"></i>
            </a>
            <a href="https://t.me/Robocart_12" target="_blank" class="text-decoration-none">
                <i class="fab fa-telegram-plane" style="font-size: 40px; color: #0088cc; margin: 0 10px;"></i>
            </a>
            <a href="https://wa.me/+917666082234" target="_blank" class="text-decoration-none">
                <i class="fab fa-whatsapp" style="font-size: 40px; color: #25D366; margin: 0 10px;"></i>
            </a>
            <a href="https://www.youtube.com/channel/UCXXXXXX" target="_blank" class="text-decoration-none">
                <i class="fab fa-youtube" style="font-size: 40px; color: #FF0000; margin: 0 10px;"></i>
            </a>
            <a href="mailto:info@robocart.com" target="_blank" class="text-decoration-none">
                <i class="fas fa-envelope" style="font-size: 40px; color: #D44638; margin: 0 10px;"></i>
            </a>
        </div>
    </div>
        </div>
        <div class="google-map mt-4 d-flex justify-content-center">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019284634634!2d144.9630579153168!3d-37.81410797975171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d1f0f9b1f1b1!2sFederation%20Square!5e0!3m2!1sen!2sau!4v1614311234567!5m2!1sen!2sau" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        </div>
    </div>
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
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" style="color: #ccc;">Home</a></li>
                        <li><a href="#" style="color: #ccc;">About</a></li>
                        <li><a href="#" style="color: #ccc;">Contact Us</a></li>
                        <li><a href="#" style="color: #ccc;">Login</a></li>
                        <li><a href="#" style="color: #ccc;">Team</a></li>
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
            <a href="https://www.youtube.com/channel/UCXXXXXX" target="_blank" class="text-decoration-none">
                <i class="fab fa-youtube" style="font-size: 40px; color: #FF0000; margin: 0 10px;"></i>
            </a>
            <a href="mailto:info@robocart.com" target="_blank" class="text-decoration-none">
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