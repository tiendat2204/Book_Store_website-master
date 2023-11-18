<?php
include './model/config.php';

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    // Kiểm tra xem mã xác nhận có hợp lệ hay không
    $select_users = $pdo->prepare("SELECT * FROM `users` WHERE email = :email AND token = :token");
    $select_users->bindParam(':email', $email, PDO::PARAM_STR);
    $select_users->bindParam(':token', $token, PDO::PARAM_STR);
    $select_users->execute();

    if ($select_users->rowCount() > 0) {
        if (isset($_POST['submit'])) {
            $password = md5($_POST['password']);

            // Lưu mật khẩu mới vào cơ sở dữ liệu
            $update_users = $pdo->prepare("UPDATE `users` SET password = :password, token = NULL WHERE email = :email");
            $update_users->bindParam(':password', $password, PDO::PARAM_STR);
            $update_users->bindParam(':email', $email, PDO::PARAM_STR);
            $update_users->execute();

            // Thông báo cho người dùng biết rằng mật khẩu của họ đã được thay đổi thành công
            $message[] = 'Mật khẩu của bạn đã được thay đổi thành công vui lòng đăng nhập .';

            // Chuyển hướng đến trang đăng nhập
           
            
        }
    } else {
        $message[] = 'Liên kết không hợp lệ.';
    }
} else {
    $message[] = 'Liên kết không hợp lệ.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

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
<?php 
include './header.php'

?>
<section class="container-rsp">

    <div class="form-container-rsp">
        <form action="" method="post">
            <h3 class="title-rsp">Đặt lại mật khẩu</h3>
            <input type="email" name="email" placeholder="Email" required class="box-rsp" value="<?php echo isset($email) ? $email : ''; ?>" readonly>
            
<input class="box-rsp" type="password" placeholder="Mật khẩu mới" require name="password">
            <input type="submit" name="submit" value="Đặt lại mật khẩu" class="btn1-rsp">
        </form>
    </div>
</section>
<?php 
include 'footer.php'

?>
</body>

</html>
