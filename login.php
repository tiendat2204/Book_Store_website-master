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
            $message[] = [
                'type' => 'success',
                'text' => 'Đăng nhập thành công!'
            ];
            // Không cần chuyển hướng ngay lập tức ở đây
        } else if ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];

            // Thông báo thành công
            $message[] = [
                'type' => 'success',
                'text' => 'Đăng nhập thành công!'
            ];
            // Không cần chuyển hướng ngay lập tức ở đây
        }
    } else {
        $message[] = [
            'type' => 'error',
            'text' => 'Sai email hoặc mật khẩu!'
        ];
    }
    $_SESSION['login_message'] = $message;
  
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
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<style>
    /* Điều chỉnh kích thước và vị trí của nút đăng nhập Google */
    .g-signin2 {
            margin-top: 20px;
            width: 20%;
            align-self: center;
        }

        .g-signin2 > div {
            width: 215%;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .g-signin2 > div:hover {
            background-color: #f1f1f1;
        }

        .g-signin2 > div > span {
            margin-left: 10px;
            font-size: 14px;
            color: #333;
        }
</style>

<body>

<?php
if (isset($_SESSION['login_message'])) {
    $loginMessage = $_SESSION['login_message'];


    foreach ($loginMessage as $msg) {
        echo '
        <div class="message ' . $msg['type'] . '">
            <span>' . $msg['text'] . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }


    unset($_SESSION['login_message']);
  
}


if (isset($_SESSION['forgot_password_message'])) {
    $forgotPasswordMessage = $_SESSION['forgot_password_message'];

    foreach ($forgotPasswordMessage as $msg) {
        echo '
        <div class="message ' . $msg['type'] . '">
            <span>' . $msg['text'] . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }

    // Xóa thông báo sau khi đã hiển thị
    unset($_SESSION['forgot_password_message']);
}
?>


<div class="container-center">
<div class="form-container" id="login-form">
<form action="" method="post">
    <h3>Đăng nhập ngay</h3>
    <input type="email" name="email" placeholder="Email" required class="box">
    <input type="password" name="password" placeholder="Mật khẩu" required class="box">
    <div class="g-signin2" data-onsuccess="onGoogleSignIn">
                <div>
                    <i class="fab fa-google"></i>
                    <span>Đăng nhập bằng Google</span>
                </div>
            </div>
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
            }, 2000);
          </script>';
}
?>
</body>

</html>
