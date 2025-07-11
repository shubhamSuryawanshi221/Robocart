<?php
session_start();
include('config.php');
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = "SELECT * FROM users WHERE reset_token = :token AND reset_expiry > NOW()";
    $query = $conn->prepare($sql);
    $query->bindParam(':token', $token, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if($result) {
        if(isset($_POST['submit'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = :password, reset_token = NULL, reset_expiry = NULL WHERE reset_token = :token";
            $query = $conn->prepare($sql);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':token', $token, PDO::PARAM_STR);
            $query->execute();

            $msg = "Password has been reset successfully.";
        }
    } else {
        $error = "Invalid or expired token.";
    }
} else {
    $error = "No token provided.";
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Robocart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!-- FontAwesome Font Style -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>
<body>

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header -->

<section class="contact_us section-padding">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <h3>Reset Password</h3>
        <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        <div class="contact_form gray-bg">
          <form method="post">
            <div class="form-group">
              <label class="control-label">New Password <span>*</span></label>
              <input type="password" name="password" class="form-control white_bg" id="password" required>
            </div>
            <div class="form-group">
              <button class="btn" type="submit" name="submit">Reset Password <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer -->

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top-->

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
</body>
</html>