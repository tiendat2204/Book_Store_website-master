<?php
session_start();
include '../model/config.php';
require_once '../vendor/autoload.php';

// Thông tin xác thực API Google
$clientID = '207747938873-pm2gin00oc1tkurs9k67d5u31f49vnab.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost:3000/controller/xulylogin.php';

// Tạo một đối tượng Google_Client
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Kiểm tra nếu có mã xác thực từ Google
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Lấy thông tin hồ sơ
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $google_email = $google_account_info->email;
    $google_name = $google_account_info->name;
    $google_avatar_url = $google_account_info->picture; // URL avatar từ Google

    // Lưu thông tin vào session
    $_SESSION['user_name'] = $google_name;
    $_SESSION['user_email'] = $google_email;
    $_SESSION['user_avatar_url'] = $google_avatar_url;
    $_SESSION['user_id'] = $row['id'];

    // Kiểm tra xem tài khoản Google đã tồn tại trong cơ sở dữ liệu chưa
    $select_google_user = $pdo->prepare("SELECT * FROM `users` WHERE email = :email");
    $select_google_user->bindParam(':email', $google_email, PDO::PARAM_STR);
    $select_google_user->execute();

    if ($select_google_user->rowCount() > 0) {
        // Người dùng Google đã tồn tại, đăng nhập
        $row = $select_google_user->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $row['id'];

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
        }

        // Thông báo thành công
        $_SESSION['messages'] = array('Đăng nhập thành công!');
    } else {
        // Người dùng Google chưa tồn tại, thêm vào cơ sở dữ liệu
        $insert_google_user = $pdo->prepare("INSERT INTO `users` (name, email, user_type, avatar) VALUES (:name, :email, 'user', :avatar)");
        $insert_google_user->bindParam(':name', $google_name, PDO::PARAM_STR);
        $insert_google_user->bindParam(':email', $google_email, PDO::PARAM_STR);
        $insert_google_user->bindParam(':avatar', $google_avatar_url, PDO::PARAM_STR);
        $insert_google_user->execute();

        // Lấy thông tin người dùng mới thêm vào
        $select_new_user = $pdo->prepare("SELECT * FROM `users` WHERE email = :email");
        $select_new_user->bindParam(':email', $google_email, PDO::PARAM_STR);
        $select_new_user->execute();

        $row = $select_new_user->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $row['id'];

        // Thông báo thành công
        $_SESSION['messages'] = array('Đăng nhập thành công!');
    }

    // Redirect đến trang chính sau khi xử lý xong
    header("Location: ../index.php");
    exit();
} else {
    // Nếu chưa có mã xác thực, hiển thị thông báo lỗi
    echo "Lỗi xác thực từ Google!";
}
?>
