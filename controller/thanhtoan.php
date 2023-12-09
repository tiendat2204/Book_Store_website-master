<?php
include './model/config.php';

function generateOrderCode() {
    return 'ORDER' . time() . rand(1000, 9999);
}
function calculateCartTotal($cart_query, $user_id) {
    $cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $cart_query->execute();
    $cart_total = 0;
    while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
        $cart_total += ($cart_item['price'] * $cart_item['quantity']);
    }
    return $cart_total;
}

function insertOrder($insert_order_query, $user_id, $method, $address, $cart_total, $placed_on, $order_code , $pdo) {
    $insert_order_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $insert_order_query->bindParam(':method', $method, PDO::PARAM_STR);
    $insert_order_query->bindParam(':address', $address, PDO::PARAM_STR);
    $insert_order_query->bindParam(':cart_total', $cart_total, PDO::PARAM_STR);
    $insert_order_query->bindParam(':placed_on', $placed_on, PDO::PARAM_STR);
    $insert_order_query->bindParam(':order_code', $order_code, PDO::PARAM_STR);
    $insert_order_query->bindParam(':total_orders', $cart_total, PDO::PARAM_STR);
    $insert_order_query->execute();
    return $pdo->lastInsertId();
}

function insertOrderDetail($insert_detail_query, $order_id, $cart_item, $pdo) {
    $product_id = $cart_item['product_id'];
    $quantity = $cart_item['quantity'];
    $subtotal = $cart_item['price'] * $cart_item['quantity'];

    $insert_detail_query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $insert_detail_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $insert_detail_query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $insert_detail_query->bindParam(':subtotal', $subtotal, PDO::PARAM_STR);
    $insert_detail_query->execute();
}


function deleteCart($delete_cart_query, $user_id) {
    $delete_cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $delete_cart_query->execute();
}

$order_code = generateOrderCode();
$_SESSION['order_code'] = $order_code;

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location: login.php');
}
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_btn'])) {

        $method = htmlspecialchars($_POST['method']);
        $address = $_POST['street'] . ', ' . $_POST['state'] . ', ' . $_POST['country'];
        $placed_on = date('d/m/Y', strtotime(date('d-M-Y')));

        $cart_query = $pdo->prepare("SELECT cart.*, products.name, products.price FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = :user_id");
        $cart_total = calculateCartTotal($cart_query, $user_id, $pdo);

        $insert_order_query = $pdo->prepare("INSERT INTO `orders` (user_id, method, address, total_price, placed_on, order_code, total_orders) VALUES (:user_id, :method, :address, :cart_total, :placed_on, :order_code, :total_orders)");
        $order_id = insertOrder($insert_order_query, $user_id, $method, $address, $cart_total, $placed_on, $order_code, $pdo);

        $cart_query->execute();
        while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $insert_detail_query = $pdo->prepare("INSERT INTO `order_detail` (order_id, product_id, quantity, subtotal) VALUES (:order_id, :product_id, :quantity, :subtotal)");
            insertOrderDetail($insert_detail_query, $order_id, $cart_item, $pdo);
        }

        if ($cart_total == 0) {
            $message[] = 'giỏ hàng trống';
        } else {
            $delete_cart_query = $pdo->prepare("DELETE FROM `cart` WHERE user_id = :user_id");
            deleteCart($delete_cart_query, $user_id, $pdo);

            $message[] = 'Đơn hàng đã được đặt thành công!';
            if ($method == 'vnpay') {
                include './vnpay_php/vnpay_create_payment.php';
                exit();
            } elseif ($method == 'MoMo') {
                include './controller/c_momo.php';
                exit();
            }
        }

        $_SESSION['messages'] = $message;
    }
}
?>