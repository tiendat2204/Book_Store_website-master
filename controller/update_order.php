<?php include './model/config.php';


session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_order'])) {
    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];

    try {
        $update_order_query = $pdo->prepare("UPDATE `orders` SET payment_status = :update_payment WHERE id = :order_update_id");
        $update_order_query->bindParam(':update_payment', $update_payment, PDO::PARAM_STR);
        $update_order_query->bindParam(':order_update_id', $order_update_id, PDO::PARAM_INT);
        $update_order_query->execute();
        $message[] = 'trạng thái thanh toán đã được cập nhật!';
    } catch (PDOException $e) {
        die('Query failed: ' . $e->getMessage());
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    try {
        $delete_order_query = $pdo->prepare("DELETE FROM `orders` WHERE id = :delete_id");
        $delete_order_query->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $delete_order_query->execute();
        $message[] = 'Xóa đơn hàng  thành công!';
    } catch (PDOException $e) {
        die('Query failed: ' . $e->getMessage());
    }
}

?>