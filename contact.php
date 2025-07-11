<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Robocart</title>
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

        .contact-section {
            padding: 50px 20px;
        }

        .contact-card {
            background: rgba(27, 26, 26, 0.1);
            border: none;
            border-radius: 15px;
            text-align: center;
            color: #000000;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            width: 100%;
        }

        .contact-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .contact-card a {
            color: #ff6347;
            text-decoration: none;
            font-weight: bold;
        }

        .footer {
            background: #222;
            padding: 15px;
            color: #ccc;
            text-align: center;
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
        <h1>Contact Our Robotics Shopkeepers</h1>
    </header>

    <section class="contact-section container">
        <div class="row">
            <div class="col-12">
                <div class="contact-card">
                    <img src="assets/img/inset.jpeg" alt="Shopkeeper 1" height="150px" width="150px">
                    <h4>Inset Link</h4>
                    <p>Phone: 7942694492</p>
                    <p>
                        <a href="https://instagram.com/johndoe" target="_blank">Instagram</a> | 
                        <a href="https://t.me/johndoe" target="_blank">Telegram</a> | 
                        <a href="https://wa.me/7942694492" target="_blank">WhatsApp</a>
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="contact-card">
                    <img src="assets.img/Marutiurjaproject.jpeg" alt="Shopkeeper 2">
                    <h4>Maruti Urja</h4>
                    <p>Phone: +91 94235 44333</p>
                    <p>
                        <a href="https://instagram.com/janesmith" target="_blank">Instagram</a> | 
                        <a href="https://t.me/janesmith" target="_blank">Telegram</a> | 
                        <a href="https://wa.me/+91 9876543210" target="_blank">WhatsApp</a>
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="contact-card">
                    <img src="shopkeeper3.jpg" alt="Shopkeeper 3">
                    <h4>Sam Wilson</h4>
                    <p>Phone: +456 789 1230</p>
                    <p>
                        <a href="https://instagram.com/samwilson" target="_blank">Instagram</a> | 
                        <a href="https://t.me/samwilson" target="_blank">Telegram</a> | 
                        <a href="https://wa.me/4567891230" target="_blank">WhatsApp</a>
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="contact-card">
                    <img src="shopkeeper4.jpg" alt="Shopkeeper 4">
                    <h4>Emma Brown</h4>
                    <p>Phone: +321 654 9870</p>
                    <p>
                        <a href="https://instagram.com/emmabrown" target="_blank">Instagram</a> | 
                        <a href="https://t.me/emmabrown" target="_blank">Telegram</a> | 
                        <a href="https://wa.me/3216549870" target="_blank">WhatsApp</a>
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="contact-card">
                    <img src="shopkeeper5.jpg" alt="Shopkeeper 5">
                    <h4>Chris Evans</h4>
                    <p>Phone: +654 321 7890</p>
                    <p>
                        <a href="https://instagram.com/chrisevans" target="_blank">Instagram</a> | 
                        <a href="https://t.me/chrisevans" target="_blank">Telegram</a> | 
                        <a href="https://wa.me/6543217890" target="_blank">WhatsApp</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2025 All rights reserved to the Robocart.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
