<?php
session_start();
include '../model/config.php';
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

/**
 * Description of vnpay_ajax
 *
 * @author xonv
 */
require_once("config.php");
$order_query = $pdo->prepare("SELECT * FROM `orders` WHERE id = :order_id");
$order_query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$order_query->execute();
$order_result = $order_query->fetch(PDO::FETCH_ASSOC);
$cart_query = $pdo->prepare("SELECT cart.*, products.name, products.price FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = :user_id");
$cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$cart_query->execute();
if ($cart_query->rowCount() > 0) {
    while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
        $vnp_OrderInfo .= $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
    }
}
$order_code = $order_result['order_code'];
$vnp_TxnRef = $order_code;  //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
$vnp_OrderInfo = 'thanh toan don hang '. $vnp_TxnRef;
$vnp_OrderType = 'billpayment';
$vnp_Amount = $order_result['total_price'] * 100;
$vnp_Locale = 'vn';
$vnp_BankCode = 'NCB';
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef 

);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}


ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;

if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}

$returnData = array('code' => '00'
    , 'message' => 'success'
    , 'data' => $vnp_Url);
    if (!headers_sent()) {
        header('Location: ' . $vnp_Url);
        $delete_cart_query = $pdo->prepare("DELETE FROM `cart` WHERE user_id = :user_id");
        $delete_cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $delete_cart_query->execute();
        die();
    } else {
        echo "Headers already sent";
    }
    