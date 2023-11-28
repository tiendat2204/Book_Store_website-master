<?php 
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = md5(htmlspecialchars($_POST['password']));
    $cpassword = md5(htmlspecialchars($_POST['cpassword']));
    $user_type = htmlspecialchars($_POST['user_type']);

    $select_users = $pdo->prepare("SELECT * FROM `users` WHERE email = :email AND password = :password");
    $select_users->bindParam(':email', $email, PDO::PARAM_STR);
    $select_users->bindParam(':password', $password, PDO::PARAM_STR);
    $select_users->execute();

    if ($select_users->rowCount() > 0) {
        $message[] = 'Người dùng đã tồn tại!';
    } else {
        if ($password != $cpassword) {
            $message[] = 'Xác nhận mật khẩu không khớp';
        } else {
            $insert_user = $pdo->prepare("INSERT INTO `users` (name, email, password, user_type) VALUES(:name, :email, :password, :user_type)");
            $insert_user->bindParam(':name', $name, PDO::PARAM_STR);
            $insert_user->bindParam(':email', $email, PDO::PARAM_STR);
            $insert_user->bindParam(':password', $cpassword, PDO::PARAM_STR);
            $insert_user->bindParam(':user_type', $user_type, PDO::PARAM_STR);
            $insert_user->execute();

            $message[] = 'Đăng ký thành công!';
        }
    }
}
?>