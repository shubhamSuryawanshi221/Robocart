<!-- filepath: /c:/xampp/htdocs/Robocart/privacy_policy.php -->
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robocart - Privacy Policy</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!-- FontAwesome Font Style -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <style>
        .privacy-policy {
            background: #f9f9f9;
            padding: 50px 0;
        }
        .privacy-policy h2 {
            color: #ff6347;
            margin-bottom: 30px;
        }
        .privacy-policy p {
            color: #333;
            line-height: 1.6;
        }
        .privacy-policy ul {
            list-style: disc;
            padding-left: 20px;
        }
        .privacy-policy ul li {
            margin-bottom: 10px;
        }
        .footer {
            background: #222;
            padding: 20px;
            color: #ccc;
            text-align: center;
        }
    </style>
</head>
<body>


  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header--> 

<!--Privacy Policy-->
<section class="privacy-policy section-padding">
  <div class="container">
    <div class="row">
    <div class="col-md-12">
      <h2>Privacy Policy</h2>
      <p>At Robocart, we are committed to protecting your privacy. This Privacy Policy outlines how we collect, use, and safeguard your personal information.</p>
      
      <h3>Information We Collect</h3>
      <p>We may collect the following types of information:</p>
      <ul>
        <li>Personal identification information (Name, email address, phone number, etc.)</li>
        <li>Payment information (credit card details, billing address, etc.)</li>
        <li>Technical data (IP address, browser type, operating system, etc.)</li>
      </ul>
      
      <h3>How We Use Your Information</h3>
      <p>We use the information we collect for the following purposes:</p>
      <ul>
        <li>To process and manage your orders</li>
        <li>To improve our website and services</li>
        <li>To communicate with you about your orders, inquiries, and promotions</li>
        <li>To comply with legal obligations</li>
      </ul>
      
      <h3>How We Protect Your Information</h3>
      <p>We implement a variety of security measures to maintain the safety of your personal information. These measures include:</p>
      <ul>
        <li>Encryption of sensitive data</li>
        <li>Secure servers and networks</li>
        <li>Access controls to limit access to your information</li>
      </ul>
      
      <h3>Sharing Your Information</h3>
      <p>We do not sell, trade, or otherwise transfer your personal information to outside parties, except as necessary to provide our services or comply with the law.</p>
      
      <h3>Your Rights</h3>
      <p>You have the right to:</p>
      <ul>
        <li>Access and update your personal information</li>
        <li>Request the deletion of your personal information</li>
        <li>Opt-out of receiving marketing communications</li>
      </ul>
      
      <h3>Changes to This Privacy Policy</h3>
      <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on our website.</p>
      
      <h3>Contact Us</h3>
      <p>If you have any questions about this Privacy Policy, please contact us at:</p>
      <p>Email: <a href="mailto:robcart@gmail.com"><i class="fa fa-envelope"></i> info@robocart.com</a></p>
      <p>Phone: <i class="fa fa-phone"></i> +91 7666082234</p>
      <p>Follow us on social media:</p>
      <p>
        <a href="https://t.me/robocart" target="_blank"><i class="fa fa-telegram"></i> Telegram</a> |
        <a href="https://www.instagram.com/robocart" target="_blank"><i class="fa fa-instagram"></i> Instagram</a> |
        <a href="https://www.youtube.com/robocart" target="_blank"><i class="fa fa-youtube"></i> YouTube</a>
      </p>
    </div>
    </div>
  </div>
</section>
<!-- /Privacy Policy--> 

<!--Footer-->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <p>&copy; 2025 Robocart. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<!--Switcher-->
<script src="assets/switcher/js/switcher.js"></script>
<!--bootstrap-slider-JS--> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<!--Slider-JS--> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
<script>
    function initMap() {
        var location = {lat: -25.344, lng: 131.036};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: location
        });
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
    }
    google.maps.event.addDomListener(window, 'load', initMap);
</script>
</body>
</html>