<?php
include '../model/config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    
    // Kiểm tra xem đơn hàng có thể bị hủy không (tình trạng là "Đợi xác nhận")
    $order_status_query = $pdo->prepare("SELECT payment_status FROM orders WHERE id = :order_id AND payment_status = 'Đợi xác nhận'");
    $order_status_query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $order_status_query->execute();

    if ($order_status_query->rowCount() > 0) {
        // Cập nhật tình trạng đơn hàng thành "Đã hủy"
        $cancel_order_query = $pdo->prepare("UPDATE orders SET payment_status = 'Đã hủy' WHERE id = :order_id");
        $cancel_order_query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $cancel_order_query->execute();
        $_SESSION['messages'] = array('Đơn hàng đã được hủy thành công!');
        header('Location: ../orders.php');
        exit();
    } else {
        $_SESSION['messages'] = array('Không thể hủy đơn hàng này!');
        header('Location: ../orders.php');
        exit();
    }
} else {
    // Chuyển hướng trở lại trang đơn hàng nếu không có order_id được cung cấp
    header('Location: ../orders.php');
    exit();
}
?>
