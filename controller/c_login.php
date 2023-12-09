<?php 
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $select_users = $pdo->prepare("SELECT * FROM `users` WHERE email = :email AND password = :password");
    $select_users->bindParam(':email', $email, PDO::PARAM_STR);
    $select_users->bindParam(':password', $password, PDO::PARAM_STR);
    $select_users->execute();

    if ($select_users->rowCount() > 0) {
        $row = $select_users->fetch(PDO::FETCH_ASSOC);

        if ($row['status'] == 'blocked') {
            $_SESSION['messages'] = array('Tài khoản của bạn đã bị chặn!');
        } else {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['messages'] = array('Đăng nhập thành công!');
            } else if ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['messages'] = array('Đăng nhập thành công!');
            }
        }
    } else {
        $_SESSION['messages'] = array('Sai email hoặc mật khẩu!');
    }
}

?>