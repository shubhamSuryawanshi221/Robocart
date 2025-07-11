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
    <title>Project Team</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, rgb(255, 255, 255), rgb(255, 255, 255));
            color: #000;
        }

        .header {
            text-align: center;
            padding: 5px;
            background: rgb(255, 71, 4);
            color: #fff;
        }

        .motive-section {
            padding: 50px 20px;
            background: rgba(95, 95, 235, 0.6);
            border-radius: 15px;
            margin: 30px 0;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .motive-section h2 {
            margin-bottom: 20px;
        }

        .team-section {
            padding: 50px 20px;
        }

        .team-member {
            background: rgba(33, 33, 34, 0.1);
            border-radius: 20px;
            color: #000;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            animation: slideInUp 0.5s ease-in-out;
            height: 100%;
        }

        .team-member:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .team-details {
            text-align: center;
        }

        .team-details h5 {
            margin-bottom: 10px;
        }

        .team-details p {
            margin: 10px 0;
        }

        .team-details .socials a {
            color: rgb(0, 29, 253);
            margin-right: 10px;
            text-decoration: none;
        }

        .team-details .socials a:hover {
            color: #ff4500;
        }

        .robotics-info {
            padding: 50px 20px;
            background: rgba(95, 95, 235, 0.6);
            border-radius: 15px;
            margin-top: 30px;
            animation: fadeIn 1s ease-in-out;
        }

        .robotics-info h3 {
            margin-bottom: 20px;
        }
        .footer {
            background: #222;
            padding: 15px;
            color: #ccc;
            text-align: center;
            bottom: 0;
            width: 100%;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Motive of the Project -->
    <section class="motive-section">
        <h2>Welcome to Our Robotics Project</h2>
        <p>This project aims to introduce students to the world of robotics and help them develop practical knowledge through hands-on experience. Our goal is to make robotics accessible to students passionate about this field. Whether you're a beginner or have some experience, we invite you to explore the world of sensors, motors, and automation with us!</p>
    </section>

    <!-- Team Section -->
    <section class="team-section container">
        <h2 class="text-center mb-5">Meet Our Team</h2>
        <div class="row gy-4">
            <!-- Team Member 1 -->
            <div class="col-md-4 d-flex">
                <div class="team-member">
                    <img src="assets/img/find_user.png" alt="Team Member 1">
                    <div class="team-details">
                        <h5>Shubham Suryawanshi</h5>
                        <p>Class: BCS-TY</p>
                        <p>College: Dayanand Science College, Latur</p>
                        <p>Phone: <a href="tel:+917666082234">+91 76660 82234</a></p>
                        <div class="socials">
                            <a href="mailto:shubhamanils2003gmail.com" class="text-danger me-3"><i class="fas fa-envelope"></i></a>
                            <a href="https://github.com/shubhamSuryawanshi221" class="text-danger me-3"><i class="fab fa-github"></i></a>
                            <a href="https://www.instagram.com/shubham_221_/?utm_source=qr&igsh=MXdjcm1hZ3V4ZHA5ZA%3D%3D#" class="text-danger me-3"><i class="fab fa-instagram"></i></a>
                            <a href="https://linkedin.com" class="text-danger me-3"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Member 2 -->
            <div class="col-md-4 d-flex">
                <div class="team-member">
                    <img src="assets/img/find_user.png" alt="Team Member 2">
                    <div class="team-details">
                        <h5>Sneha Waghmare</h5>
                        <p>Class: BCS-TY</p>
                        <p>College: Dayanand Science College, Latur</p>
                        <p>Phone: <a href="tel:+919404721301">+91 94047 21301</a></p>
                        <div class="socials">
                            <a href="mailto:waghmaresnehuu@gmail.com" class="text-danger me-3"><i class="fas fa-envelope"></i></a>
                            <a href="https://github.com/sneha-waghmare" class="text-danger me-3"><i class="fab fa-github"></i></a>
                            <a href="https://www.instagram.com/waghmaresneha358?igsh=cnRkZml2cXBmN3R1" class="text-danger me-3"><i class="fab fa-instagram"></i></a>
                            <a href="https://linkedin.com" class="text-danger me-3"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="col-md-4 d-flex">
                <div class="team-member">
                    <img src="assets/img/find_user.png" alt="Team Member 3">
                    <div class="team-details">
                        <h5>Sumeet Thakur</h5>
                        <p>Class: BCS-TY</p>
                        <p>College: Dayanand Science College, Latur</p>
                        <p>Phone: <a href="tel:+919322898661">+91 93228 98661</a></p>
                        <div class="socials">
                            <a href="mailto:sumitthakur1719@gmail.com" class="text-danger me-3"><i class="fas fa-envelope"></i></a>
                            <a href="https://github.com/sumitthakur1719" class="text-danger me-3"><i class="fab fa-github"></i></a>
                            <a href="https://www.instagram.com/sumitthakur_364?igsh=ZHUxZ3NrbG93NXM2" class="text-danger me-3"><i class="fab fa-instagram"></i></a>
                            <a href="https://linkedin.com" class="text-danger me-3"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Information -->
    <section class="robotics-info container mb-5">
        <h3>About Our Team</h3>
        <p>Our team is composed of dedicated and passionate students from Dayanand Science College, Latur. We are united by our love for robotics and our desire to innovate and create. Each member brings unique skills and perspectives, making our team diverse and dynamic. We work collaboratively to design, build, and program robots, and we are committed to sharing our knowledge and experiences with others. Join us on our journey as we explore the fascinating world of robotics!</p>
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
