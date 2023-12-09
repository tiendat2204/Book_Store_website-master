<?php
session_start();
include '../model/config.php';
require_once '../vendor/autoload.php';

$clientID = '207747938873-pm2gin00oc1tkurs9k67d5u31f49vnab.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost:3000/controller/xulylogin.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);

        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $google_email = $google_account_info->email;
        $google_name = $google_account_info->name;
        $google_avatar_url = $google_account_info->picture;

        $select_google_user = $pdo->prepare("SELECT * FROM `users` WHERE email = :email");
        $select_google_user->bindParam(':email', $google_email, PDO::PARAM_STR);
        $select_google_user->execute();

        if ($select_google_user->rowCount() > 0) {
            $row = $select_google_user->fetch(PDO::FETCH_ASSOC);

            if ($row['status'] == 'blocked') {
                $_SESSION['messages'] = array('Tài khoản của bạn đã bị chặn!');
                header("Location: ../login.php");
                exit();
            }

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_avatar_url'] = $row['avatar'];

            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
            }

            $_SESSION['messages'] = array('Đăng nhập thành công!');
        } else {
            $insert_google_user = $pdo->prepare("INSERT INTO `users` (name, email, user_type, avatar) VALUES (:name, :email, 'user', :avatar)");
            $insert_google_user->bindParam(':name', $google_name, PDO::PARAM_STR);
            $insert_google_user->bindParam(':email', $google_email, PDO::PARAM_STR);
            $insert_google_user->bindParam(':avatar', $google_avatar_url, PDO::PARAM_STR);
            $insert_google_user->execute();

            $select_new_user = $pdo->prepare("SELECT * FROM `users` WHERE email = :email");
            $select_new_user->bindParam(':email', $google_email, PDO::PARAM_STR);
            $select_new_user->execute();

            $row = $select_new_user->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_avatar_url'] = $row['avatar'];

            $_SESSION['messages'] = array('Đăng nhập thành công!');
        }

        header("Location: ../index.php");
        exit();
    } catch (Exception $e) {
        echo "Lỗi xác thực từ Google: " . $e->getMessage();
    }
} else {
    echo "Lỗi xác thực từ Google!";
}
?>
