<?php
include './model/config.php';
session_start();

$message = []; // Khởi tạo một mảng trống để lưu trữ thông báo

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Sử dụng PDO để thực hiện truy vấn SQL
    $select_users = $pdo->prepare("SELECT * FROM `users` WHERE email = :email AND password = :password");
    $select_users->bindParam(':email', $email, PDO::PARAM_STR);
    $select_users->bindParam(':password', $password, PDO::PARAM_STR);
    $select_users->execute();

    if ($select_users->rowCount() > 0) {
        $row = $select_users->fetch(PDO::FETCH_ASSOC);

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];

            // Thông báo thành công
            $message[] = 'Đăng nhập thành công!';
            // Không cần chuyển hướng ngay lập tức ở đây
        } else if ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];

            // Thông báo thành công
            $message[] = 'Đăng nhập thành công!';
            // Không cần chuyển hướng ngay lập tức ở đây
        }
    } else {
        $message[] = 'Sai email hoặc mật khẩu!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . $msg . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<div class="container-center">
<div class="form-container" id="login-form">
<form action="" method="post">
    <h3>Đăng nhập ngay</h3>
    <input type="email" name="email" placeholder="Email" required class="box">
    <input type="password" name="password" placeholder="Mật khẩu" required class="box">
    <input type="submit" name="submit" value="Đăng nhập ngay" class="btn1">
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

</div>

<?php
if (isset($_SESSION['admin_name']) || isset($_SESSION['user_name'])) {
    echo '
          <script>
            setTimeout(function(){
                window.location.href = "' . (isset($_SESSION['admin_name']) ? 'admin_page.php' : 'index.php') . '";
            }, 3000);
          </script>';
}
?>
</body>
</html>
