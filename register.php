<?php

include './model/config.php';

if(isset($_POST['submit'])) {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $pass = md5(htmlspecialchars($_POST['password']));
    $cpass = md5(htmlspecialchars($_POST['cpassword']));
    $user_type = htmlspecialchars($_POST['user_type']);

    $select_users = $pdo->prepare("SELECT * FROM `users` WHERE email = :email AND password = :password");
    $select_users->bindParam(':email', $email, PDO::PARAM_STR);
    $select_users->bindParam(':password', $pass, PDO::PARAM_STR);
    $select_users->execute();

    if($select_users->rowCount() > 0) {
        $message[] = 'Người dùng đã tồn tại!';
    } else {
        if($pass != $cpass) {
            $message[] = 'Xác nhận mật khẩu không khớp';
        } else {
            $insert_user = $pdo->prepare("INSERT INTO `users` (name, email, password, user_type) VALUES(:name, :email, :password, :user_type)");
            $insert_user->bindParam(':name', $name, PDO::PARAM_STR);
            $insert_user->bindParam(':email', $email, PDO::PARAM_STR);
            $insert_user->bindParam(':password', $cpass, PDO::PARAM_STR);
            $insert_user->bindParam(':user_type', $user_type, PDO::PARAM_STR);
            $insert_user->execute();

            $message[] = 'Đăng kí thành công!';
            
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

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