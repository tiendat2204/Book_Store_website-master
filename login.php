<?php
include './model/config.php';
session_start();

if(isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']); 

    // Sử dụng PDO để thực hiện truy vấn SQL
    $select_users = $pdo->prepare("SELECT * FROM `users` WHERE email = :email AND password = :password");
    $select_users->bindParam(':email', $email, PDO::PARAM_STR);
    $select_users->bindParam(':password', $password, PDO::PARAM_STR);
    $select_users->execute();

    if($select_users->rowCount() > 0) {

        $row = $select_users->fetch(PDO::FETCH_ASSOC);

        if($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
        } else if($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:index.php');
        }
    } else {
        $message[] = 'sai email hoặc mật khẩu!';
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

    <div class="form-container">

        <form action="" method="post">
            <h3>Đăng nhập ngay</h3>
            <input type="email" name="email" placeholder="Email" required class="box">
            <input type="password" name="password" placeholder="Mật khẩu" required class="box">
            <input type="submit" name="submit" value="Đăng nhập ngay" class="btn1">
            <p>bạn chưa có tài khoản? <a href="register.php">Đăng kí ngay</a></p>
        </form>

    </div>
</body>
</html>