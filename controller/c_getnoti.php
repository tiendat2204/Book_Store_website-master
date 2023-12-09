<?php 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {
    if (isset($_GET['vnp_ResponseCode'])) {
        $vnp_Amount = $_GET['vnp_Amount'];
        $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
        $vnp_TxnRef = $_GET['vnp_TxnRef'];
        if ($vnp_ResponseCode == '00') {
            $_SESSION['messages'] = array("Đơn hàng có mã $vnp_TxnRef đã thanh toán thành công !");
        } else {
            $_SESSION['messages'] = array("Đơn hàng có mã $vnp_TxnRef đã thanh toán không thành công !");
            $updateStatusQuery = $pdo->prepare("UPDATE orders SET payment_status = 'Chưa thanh toán' WHERE order_code = :order_code");
            $updateStatusQuery->bindParam(':order_code', $vnp_TxnRef, PDO::PARAM_STR);
            $updateStatusQuery->execute();
        }

        unset($_SESSION['order_status']);
    }
    elseif (isset($_GET['transId'])) {
        $partnerCode = $_GET['partnerCode'];
        $orderId = $_GET['orderId'];
        $requestId = $_GET['requestId'];
        $amount = $_GET['amount'];
        $orderInfo = $_GET['orderInfo'];
        $resultCode = $_GET['resultCode'];
        $message = $_GET['message'];
        if ($resultCode == '0') {
            $_SESSION['messages'] = array("Đơn hàng có mã $orderId đã thanh toán thành công !");
        } else {
            $_SESSION['messages'] = array("Đơn hàng có mã $orderId đã thanh toán không thành công !");
            $updateStatusQuery = $pdo->prepare("UPDATE orders SET payment_status = 'Chưa thanh toán' WHERE order_code = :order_code");
            $updateStatusQuery->bindParam(':order_code', $orderId, PDO::PARAM_STR);
            $updateStatusQuery->execute();
        }

        unset($_SESSION['order_status']);
    }
    
} else {

}
?>