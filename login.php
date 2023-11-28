<?php
include './model/config.php';
session_start();
require_once './vendor/autoload.php';
include './controller/c_login.php';
$clientID = '207747938873-pm2gin00oc1tkurs9k67d5u31f49vnab.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost:3000/controller/xulylogin.php'; // URL to handle Google login response

// Create a Google_Client object
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");   
// Create a URL for Google login
$googleLoginUrl = $client->createAuthUrl();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="207747938873-pm2gin00oc1tkurs9k67d5u31f49vnab.apps.googleusercontent.com">
</head>
<body>
<?php
include './controller/message.php';

?>

<div class="container-center">
    <div class="form-container" id="login-form">
        <form action="" method="post">
            <h3>Đăng nhập ngay</h3>
            <input type="email" name="email" placeholder="Email" required class="box">
            <input type="password" name="password" placeholder="Mật khẩu" required class="box">
            <div class="btn-login">
                <input type="submit" name="submit" value="Đăng nhập ngay" class="btn1">

          
      <?php 
      if (isset($googleLoginUrl) && !isset($_SESSION['user_name']) && !isset($_SESSION['admin_name'])) {
        echo '<a href="' . $googleLoginUrl . '" class="google-btn"><i class="fab fa-google"></i> Đăng nhập bằng Google</a>';
    }
      ?>
            <p>bạn chưa có tài khoản? <a href="register.php">Đăng kí ngay</a></p>
            <p><a href="#" onclick="showForgotPasswordForm()">Quên mật khẩu?</a></p>
        </form>
    </div>
    <div class="form-container" id="forgot-password-form" style="display:none;">
        <form action="controller/forgot_password.php" method="post">
            <h3>Quên mật khẩu</h3>
            <p>Nhập địa chỉ email để khôi phục mật khẩu</p>
            <input type="email" name="forgot_email" placeholder="Email" required class="box">
            <input type="submit" name="submit" value="Gửi yêu cầu" class="btn1">
            <p><a href="#" onclick="showLoginForm()">Quay lại đăng nhập</a></p>
        </form>
    </div>
</div>

<script>
    function showForgotPasswordForm() {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('forgot-password-form').style.display = 'block';
    }

    function showLoginForm() {
        document.getElementById('login-form').style.display = 'block';
        document.getElementById('forgot-password-form').style.display = 'none';
    }


  
</script>
<?php
if (isset($_SESSION['admin_name']) || isset($_SESSION['user_name'])) {
    echo '
          <script>
            setTimeout(function(){
                window.location.href = "' . (isset($_SESSION['admin_name']) ? 'admin_page.php' : 'index.php') . '";
            }, 2000);
          </script>';
}
?>
</body>

</html>
