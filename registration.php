<!-- filepath: /c:/xampp/htdocs/Robocart/includes/registration.php -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php'); // Include the config file with database connection details

$error = '';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $query = $conn->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();

        header('Location: login.php');
        exit();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robocart - Registration</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!-- FontAwesome Font Style -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

<!--Header-->
<?php include('header.php');?>
<!-- /Header -->

<!--Page Header-->
<section class="page-header registration_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Registration</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li>Registration</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header-->

<!--Registration-->
<section class="registration section-padding">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <h3>Register</h3>
        <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        <div class="registration_form gray-bg">
          <form method="post">
            <div class="form-group">
              <label class="control-label">Username <span>*</span></label>
              <input type="text" name="username" class="form-control white_bg" id="username" required>
            </div>
            <div class="form-group">
              <label class="control-label">Email Address <span>*</span></label>
              <input type="email" name="email" class="form-control white_bg" id="emailaddress" required>
            </div>
            <div class="form-group">
              <label class="control-label">Password <span>*</span></label>
              <input type="password" name="password" class="form-control white_bg" id="password" required>
            </div>
            <div class="form-group">
              <button class="btn" type="submit" name="register">Register <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /Registration-->

<!--Footer -->
<?php include('footer.php');?>
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
</body>
</html>