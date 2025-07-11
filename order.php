<?php
session_start();
include 'config.php';

if (!isset($_SESSION['login_user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$username = $_SESSION['login_user'];
$post = $_SESSION['login_post'];



// Fetch products from the database
$sql_products = "SELECT * FROM products";
$query_products = $conn->prepare($sql_products);
$query_products->execute();
$products = $query_products->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selling - Robotics Project</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg,rgb(255, 255, 255),rgb(254, 254, 254));
            color: #fff;
        }

        .header {
            text-align: center;
            padding: 5px;
            background: rgb(255, 71, 4);
            color: #fff;
        }

        .selling-section {
            padding: 50px 20px;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 15px;
            color: #fff;
            padding: 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            animation: fadeInUp 0.5s ease-in-out;
            height: 300px; /* Set a fixed height for all product cards */
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .product-card img {
            width: 150px; /* Reduce the width of the image */
            height: 150px; /* Reduce the height of the image */
            border-radius: 10px;
            object-fit: cover;
            margin-right: 20px;
        }

        .product-details {
            flex: 1;
            color: black; /* Set text color to black */
        }

        .product-details h5 {
            color: red; /* Set product name color to red */
            margin-bottom: 10px;
        }

        .product-details p,
        .product-details .rating {
            color: black; /* Set text color to black */
        }

        .rating {
            color: #ffcf33;
            font-size: 20px;
        }

        .btn-order {
            background-color: #28a745; /* Green color */
            color: #fff;
            margin: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease-in-out;
            border: 2px solid #218838; /* Darker green border color */
            padding: 10px 20px; /* Add padding */
            border-radius: 5px; /* Add border radius */
        }

        .btn-order:hover {
            background-color: #218838; /* Darker green color on hover */
        }

        .btn-order i {
            margin-right: 5px;
        }

        .like {
            color: #ff6347;
            cursor: pointer;
            transition: color 0.3s ease-in-out;
        }

        .like:hover {
            color: #ff4500;
        }

        .footer {
            background: #222;
            padding: 15px;
            color: #ccc;
            text-align: center;
            bottom: 0;
            width: 100%;
        }

        @keyframes fadeInUp {
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

    <header class="header">
        <h1>Buy Sensors & Motors</h1>
    </header>

    <section class="selling-section container">
        <div class="row gy-4">
            <!-- Example Product Card -->
            <?php foreach ($products as $product) : ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="product-details">
                            <h5><?= htmlspecialchars($product['name']) ?></h5>
                            <p>Price: ₹ <?= htmlspecialchars($product['price']) ?><br>Discount: <?= htmlspecialchars($product['discount']) ?>%</p>
                            <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <span class="star" data-value="<?= $i ?>" data-product-id="<?= $product['id'] ?>">&#9733;</span>
                                <?php endfor; ?>
                            </div>
                            <button class="btn btn-order" onclick="window.location.href='product_details.php?product_id=<?= htmlspecialchars($product['id']) ?>'">
                                <i class="fas fa-shopping-cart"></i> Buy Now
                            </button>
                            <p class="like" data-product-id="<?= $product['id'] ?>"><i class="fas fa-heart"></i> Like</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
    </footer>    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.star').on('click', function() {
                var value = $(this).data('value');
                var productId = $(this).data('product-id');
                var stars = $(this).parent().find('.star');

                $.ajax({
                    url: 'rate_product.php',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        rating: value
                    },
                    success: function(response) {
                        stars.each(function() {
                            if ($(this).data('value') <= value) {
                                $(this).css('color', '#ffcf33');
                            } else {
                                $(this).css('color', '#000');
                            }
                        });
                    }
                });
            });

            $('.like').on('click', function() {
                var productId = $(this).data('product-id');
                var likeIcon = $(this).find('i');

                $.ajax({
                    url: 'like_product.php',
                    method: 'POST',
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        likeIcon.css('color', '#ff4500');
                    }
                });
            });
        });
    </script>
</body>
</html>