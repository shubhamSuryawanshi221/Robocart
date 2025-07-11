<?php

session_start(); // Also needed here!
include 'config.php'; // Include database connection

// Ensure database credentials are defined
$db_username = 'robocart'; // Replace with actual username
$db_password = ''; // Replace with actual password

if (!isset($_SESSION['login_user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$username = $_SESSION['login_user'];
$post = $_SESSION['login_post'];

// Update the database connection to use the correct credentials
// $conn is already defined in config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['buy_product'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $sql = "INSERT INTO purchases (username, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssi", $username, $product_id, $quantity);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Your order has been placed successfully!');
                        window.location.href='contact_us.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Error: Unable to place your order.');
                      </script>";
            }

            $stmt->close();
        } else {
            echo "<script>
                    alert('Error: Unable to process your request.');
                  </script>";
        }
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        try {
            // Prepare the SQL statement using PDO
            $stmt = $conn->prepare("INSERT INTO contact_us (name, email, message) VALUES (:name, :email, :message)");
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':message', $message);

            // Execute the statement
            $stmt->execute();

            echo "<script>alert('Message sent successfully!'); window.location.href='contact_us.php';</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Robocart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: #e6f7ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .navbar {
            width: 100%;
        }
        .contact-container {
            display: flex;
            flex-direction: column;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 900px;
            margin: 20px 0;
        }

        @media (min-width: 768px) {
            .contact-container {
                flex-direction: row;
            }
        }

        .form-section {
            flex: 1;
            padding: 30px;
        }

        .form-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background: #00bcd4;
            border: none;
            border-radius: 25px;
            padding: 12px 20px;
            width: 100%;
            font-size: 18px;
            box-shadow: 0 4px 10px rgba(0, 188, 212, 0.2);
        }

        .btn-primary:hover {
            background: #0097a7;
        }

        .illustration-section {
            flex: 1;
            background: #e6f7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .illustration-section img {
            max-width: 100%;
            height: auto;
        }

        .footer {
            background: #222;
            padding: 20px;
            color: #ccc;
            text-align: center;
            width: 100%;
            margin-top: 50px;
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


    <div class="contact-container">
        <div class="form-section">
            <h2>Contact Us</h2>
            <form method="post">
                <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                <textarea class="form-control" name="message" placeholder="Your Message" rows="4" required resize="none"></textarea>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
        <div class="illustration-section">
            <img src="assets\img\Robocart1 (2).png" alt="Contact Illustration">
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