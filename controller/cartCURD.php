<?php
include './model/config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $delete_cart_query = $pdo->prepare("DELETE FROM `cart` WHERE id = :delete_id AND user_id = :user_id");
    $delete_cart_query->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    $delete_cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    try {
        $delete_cart_query->execute();
        $message[] = 'Đã xóa khỏi giỏ hàng!';
    } catch (PDOException $e) {
        $message[] = 'Không thể xóa khỏi giỏ hàng! Lỗi: ' . $e->getMessage();
    }
}

if (isset($_GET['delete_all'])) {
    $delete_all_cart_query = $pdo->prepare("DELETE FROM `cart` WHERE user_id = :user_id");
    $delete_all_cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    try {
        $delete_all_cart_query->execute();
        $message[] = 'Đã xóa hết khỏi giỏ hàng!';

        // Thêm mã JavaScript để xóa tất cả sản phẩm và thông tin từ local storage
        echo '<script>';
        echo 'localStorage.removeItem("totalQuantity");';
        echo 'localStorage.removeItem("grandTotal");';
        echo '</script>';
    } catch (PDOException $e) {
        $message[] = 'Không thể xóa tất cả! Lỗi: ' . $e->getMessage();
    }
}
?>
