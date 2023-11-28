<?php

include './model/config.php';
include './controller/c_register.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="207747938873-pm2gin00oc1tkurs9k67d5u31f49vnab.apps.googleusercontent.com">
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php
    if(isset($message)) {
        foreach($message as $message) {
            echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
    ?>
<div class="container-center">
<div class="form-container" id="register-form">

<form action="" method="post">
    <h3>Đăng ký ngay</h3>
    <input type="text" name="name" placeholder="Nhập tên của bạn" required class="box">
    <input type="email" name="email" placeholder="Nhập email của bạn" required class="box">
    <input type="password" name="password" placeholder="Nhập mật khẩu của bạn" required class="box">
    <input type="password" name="cpassword" placeholder="Xác nhận mật khẩu của bạn" required class="box">
    <select name="user_type" class="box" style="display: none;">
        <option value="user">Người dùng</option>
        <option value="admin">Quản trị viên</option>
    </select>
  
    <input type="submit" name="submit" value="Đăng ký ngay" class="btn1">
    <p>Bạn chưa có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
</form>

</div>
</div>
</body>

</html>