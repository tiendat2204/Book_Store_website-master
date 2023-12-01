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

    if ($cart_query->rowCount() > 0) {
        while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);

    // Insert into orders table
    $insert_order_query = $pdo->prepare("INSERT INTO `orders`(user_id, method, address, total_products, total_price, placed_on, order_code) VALUES(:user_id, :method, :address, :total_products, :cart_total, :placed_on, :order_code)");
    $insert_order_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $insert_order_query->bindParam(':method', $method, PDO::PARAM_STR);
    $insert_order_query->bindParam(':address', $address, PDO::PARAM_STR);
    $insert_order_query->bindParam(':total_products', $total_products, PDO::PARAM_STR);
    $insert_order_query->bindParam(':cart_total', $cart_total, PDO::PARAM_STR);
    $insert_order_query->bindParam(':placed_on', $placed_on, PDO::PARAM_STR);
    $insert_order_query->bindParam(':order_code', $order_code, PDO::PARAM_STR);
    $insert_order_query->execute();
    $order_id = $pdo->lastInsertId();

    if ($cart_total == 0) {
        $message[] = 'giỏ hàng trống';
    } else {
    
        // Insert into order_detail table
        $insert_order_detail_query = $pdo->prepare("INSERT INTO `order_detail`(order_id, product_id, quantity, subtotal) VALUES(:order_id, :product_id, :quantity, :subtotal)");

        foreach ($cart_products as $cart_item) {
            $product_info = explode('(', $cart_item);
            $product_name = trim($product_info[0]);
            $quantity = intval(trim($product_info[1], ')'));

            $product_query = $pdo->prepare("SELECT id, price FROM `products` WHERE name = :product_name");
            $product_query->bindParam(':product_name', $product_name, PDO::PARAM_STR);
            $product_query->execute();
            $product_result = $product_query->fetch(PDO::FETCH_ASSOC);
            $product_id = $product_result['id'];
            $product_price = $product_result['price'];
            $sub_total = $quantity * $product_price;

            // Insert into order_detail
            $insert_order_detail_query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $insert_order_detail_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $insert_order_detail_query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $insert_order_detail_query->bindParam(':subtotal', $sub_total, PDO::PARAM_STR);
            $insert_order_detail_query->execute();
        }
        
        // Clear the cart after successful order
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
