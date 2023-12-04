<?php
include './model/config.php';

function generateOrderCode() {
    $prefix = 'ORDER';
    $timestamp = time();
    $randomNumber = rand(1000, 9999);

    $orderCode = $prefix . $timestamp . $randomNumber;

    return $orderCode;
}

$order_code = generateOrderCode();
$_SESSION['order_code'] = $order_code;

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location: login.php');
}

if (isset($_POST['order_btn'])) {
    $method = htmlspecialchars($_POST['method']);
    $address = $_POST['street'] . ', ' . $_POST['state'] . ', ' . $_POST['country'];
    $placed_on = date('d/m/Y', strtotime(date('d-M-Y')));

    $cart_total = 0;
    $cart_products = array();

    $cart_query = $pdo->prepare("SELECT cart.*, products.name, products.price FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = :user_id");
    $cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $cart_query->execute();

    // Tính tổng giá
    $cart_total = 0;
    while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
        $sub_total = ($cart_item['price'] * $cart_item['quantity']);
        $cart_total += $sub_total;
    }

    // Insert into orders table
    $insert_order_query = $pdo->prepare("INSERT INTO `orders` (user_id, method, address, total_price, placed_on, order_code, total_orders) VALUES (:user_id, :method, :address, :cart_total, :placed_on, :order_code, :total_orders)");
    $insert_order_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $insert_order_query->bindParam(':method', $method, PDO::PARAM_STR);
    $insert_order_query->bindParam(':address', $address, PDO::PARAM_STR);
    $insert_order_query->bindParam(':cart_total', $cart_total, PDO::PARAM_STR);
    $insert_order_query->bindParam(':placed_on', $placed_on, PDO::PARAM_STR);
    $insert_order_query->bindParam(':order_code', $order_code, PDO::PARAM_STR);
    $insert_order_query->bindParam(':total_orders', $cart_total, PDO::PARAM_STR);
    $insert_order_query->execute();
    $order_id = $pdo->lastInsertId(); // Lấy order_id sau khi chèn vào bảng orders

    // Chèn dữ liệu vào bảng `order_detail`
    $cart_query->execute(); // Execute lại câu truy vấn để lấy dữ liệu
    while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
        $sub_total = ($cart_item['price'] * $cart_item['quantity']);

        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];
        $subtotal = $sub_total;

        $insert_detail_query = $pdo->prepare("INSERT INTO `order_detail` (order_id, product_id, quantity, subtotal) VALUES (:order_id, :product_id, :quantity, :subtotal)");
        $insert_detail_query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $insert_detail_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $insert_detail_query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $insert_detail_query->bindParam(':subtotal', $subtotal, PDO::PARAM_STR);
        $insert_detail_query->execute();
    }

    if ($cart_total == 0) {
        $message[] = 'giỏ hàng trống';
    } else {
        // Xóa giỏ hàng sau khi đặt hàng thành công
        $delete_cart_query = $pdo->prepare("DELETE FROM `cart` WHERE user_id = :user_id");
        $delete_cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $delete_cart_query->execute();

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
?>
