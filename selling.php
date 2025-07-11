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
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .product-card img {
            width: 200px;
            height: 200px;
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
            <?php 
            $products = [
                ["name" => "Arduino Uno", "price" => 2,184.00, "discount" => 5, "image" => "assets/img/Arduno.png"],
                ["name" => "Jumper Wires", "price" => 10,299.00, "discount" => 2, "image" => "assets/img/jumperwires.jpeg"],
                ["name" => "Breadboard", "price" => 215.00, "discount" => 3, "image" => "assets/img/Breadboard.jpeg"],
                ["name" => "Motor Driver", "price" => 229.00, "discount" => 4, "image" => "assets/img/motor driver.png"],
                ["name" => "Ultrasonic Sensor", "price" => 150, "discount" => 3, "image" => "assets/img/ultrasonic sensor.png"],
                ["name" => "Servo Motor", "price" => 3500.00, "discount" => 2, "image" => "assets/img/servo motor.png"],
                ["name" => "LEDs", "price" =>2199.00, "discount" => 1, "image" => "assets/img/led.jpeg"],
                ["name" => "Resistors", "price" => 177.00, "discount" => 1, "image" => "assets/img/electricalresistor.jpeg"],
                ["name" => "Capacitors", "price" => 189.00, "discount" => 1, "image" => "assets/img/Capacitors.png"],
                ["name" => "Transistors", "price" => 50.00, "discount" => 1, "image" => "assets/img/Transistors.png"],
                ["name" => "Compass Module", "price" => 50.00, "discount" => 2, "image" => "assets/img/Compass Module.png"],
                ["name" => "GPS Module", "price" => 110.00, "discount" => 5, "image" => "assets/img/GPS Module.jpeg"],
                ["name" => "WiFi Module", "price" => 30.00, "discount" => 4, "image" => "assets/img/wifi module.png"],
                ["name" => "Flame Sensor", "price" => 70.00, "discount" => 1, "image" => "assets/img/Flame Sensor.png"],
                ["name" => "Gas Sensor", "price" => 120.00, "discount" => 2, "image" => "assets/img/Gas Sensor.png"],
                ["name" => "Sound Sensor", "price" => 110.00, "discount" => 1, "image" => "assets/img/sound senssor.png"],
                ["name" => "Joystick Module", "price" => 110.00, "discount" => 2, "image" => "assets/img/Joystick Module.png"],
                ["name" => "Keypad Module", "price" => 150.00, "discount" => 1, "image" => "assets/img/Keypad Module.png"],
                ["name" => "LCD Display", "price" => 100.00, "discount" => 3, "image" => "assets/img/LCD Display.png"],
                ["name" => "Camera Module", "price" => 70.00, "discount" => 5, "image" => "assets/img/Camera Module.png"],
                ["name" => "RFID Module", "price" => 110.00, "discount" => 2, "image" => "assets/img/RFID Module.png"],
                ["name" => "IR Sensor", "price" => 80.00, "discount" => 1, "image" => "assets/img/IR Sensor.png"],
                ["name" => "Accelerometer", "price" => 229.00, "discount" => 2, "image" => "assets/img/accelerometer.png"],
                ["name" => "Temperature Sensor", "price" => 200.00, "discount" => 1, "image" => "assets/img/Temperature Sensor.png"],
                ["name" => "LED Module", "price" => 489.00, "discount" => 1, "image" => "assets/img/LED Module.png"],
                ["name" => "Line Follower Sensor", "price" => 140.00, "discount" => 1, "image" => "assets/img/Line Follower Sensor.png"]
            ];

            foreach ($products as $product) : ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="product-card">
                        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                        <div class="product-details">
                            <h5><?= $product['name'] ?></h5>
                            <p>Price: ₹ <?= $product['price'] ?><br>Discount: <?= $product['discount'] ?>%</p>
                            <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <span class="star" data-value="<?= $i ?>">&#9733;</span>
                                <?php endfor; ?>
                            </div>
                            <script>
                                document.querySelectorAll('.product-card').forEach(card => {
                                    card.querySelectorAll('.star').forEach(star => {
                                        star.addEventListener('click', function() {
                                            let value = this.getAttribute('data-value');
                                            card.querySelectorAll('.star').forEach(s => {
                                                s.style.color = s.getAttribute('data-value') <= value ? '#ffcf33' : '#000';
                                            });
                                        });
                                    });
                                });
                            </script>
                            <button class="btn btn-order" onclick="window.location.href='order_form.php?product=<?= $product['name'] ?>'">
                                <i class="fas fa-shopping-cart"></i> Buy Now
                            </button>
                            <p class="like"><i class="fas fa-heart"></i> Like</p>
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
                    <p>Email: info@robocart.com</p>
                    <p>Phone: +123 456 7890</p>
                    <div>
                        <a href="#" style="color: #ccc; margin-right: 10px;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" style="color: #ccc; margin-right: 10px;"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="color: #ccc; margin-right: 10px;"><i class="fab fa-instagram"></i></a>
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