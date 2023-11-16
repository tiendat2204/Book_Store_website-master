<?php

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    
    $update_cart_query = $pdo->prepare("UPDATE `cart` SET quantity = :cart_quantity WHERE id = :cart_id");
    $update_cart_query->bindParam(':cart_quantity', $cart_quantity, PDO::PARAM_INT);
    $update_cart_query->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
    
    if ($update_cart_query->execute()) {
        $message[] = 'Số lượng sản phẩm đã được cập nhật!';
    } else {
        $message[] = 'Không thể cập nhật số lượng!';
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $delete_cart_query = $pdo->prepare("DELETE FROM `cart` WHERE id = :delete_id");
    $delete_cart_query->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);

    if ($delete_cart_query->execute()) {
        header('location:cart.php');
    } else {
        $message[] = 'Không thể xóa khỏi giỏ hàng!';
    }
}

if (isset($_GET['delete_all'])) {
    $delete_all_cart_query = $pdo->prepare("DELETE FROM `cart` WHERE user_id = :user_id");
    $delete_all_cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($delete_all_cart_query->execute()) {
        header('location:cart.php');
    } else {
        $message[] = 'Không thể xóa tất cả!';
    }
}
?>