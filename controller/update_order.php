<?php
session_start();
include './model/config.php';

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    redirect('login.php');
}

if (isset($_POST['update_order'])) {
    updateOrderStatus($_POST['order_id'], $_POST['update_payment']);
}

function redirect($url, $delay = 1) {
    header("refresh:$delay;url=$url");
    exit();
}
function updateOrderStatus($order_id, $payment_status) {
    global $pdo;

    try {
        $query = $pdo->prepare("UPDATE `orders` SET payment_status = :payment_status WHERE id = :order_id");
        $query->bindParam(':payment_status', $payment_status, PDO::PARAM_STR);
        $query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['messages'] = array('Trạng thái đơn hàng đã được cập nhật');
        redirect('./admin_orders.php');
    } catch (PDOException $e) {
        die('Query failed: ' . $e->getMessage());
    }
}


?>
