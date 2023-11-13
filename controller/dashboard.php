<?php
include './model/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

$categories = ['tamly', 'kinhdi', 'doisong', 'dongvat'];
$productCounts = [];

// Duyệt qua từng danh mục và lấy số lượng sản phẩm
foreach ($categories as $category) {
    $select_products = $pdo->prepare("SELECT COUNT(*) as count FROM `products` WHERE category_id = (SELECT id FROM `categories` WHERE name = :category)");
    $select_products->bindParam(':category', $category);
    $select_products->execute();
    $result = $select_products->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];
    array_push($productCounts, $count);
}

$number_of_comments = 0;
$select_comments = $pdo->query("SELECT * FROM `comment`");
$number_of_comments = $select_comments->rowCount();

$number_of_products = 0;
$select_products = $pdo->query("SELECT * FROM `products`");
$number_of_products = $select_products->rowCount();

$number_of_users = 0;
$select_users = $pdo->prepare("SELECT * FROM `users` WHERE user_type = 'user'");
$select_users->execute();
$number_of_users = $select_users->rowCount();

$number_of_admins = 0;
$select_admins = $pdo->prepare("SELECT * FROM `users` WHERE user_type = 'admin'");
$select_admins->execute();
$number_of_admins = $select_admins->rowCount();

$number_of_account = 0;
$select_account = $pdo->query("SELECT * FROM `users`");
$number_of_account = $select_account->rowCount();

$number_of_messages = 0;
$select_messages = $pdo->query("SELECT * FROM `message`");
$number_of_messages = $select_messages->rowCount();
?>