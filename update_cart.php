<?php
include './model/config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}
if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    $update_cart_query = $pdo->prepare("UPDATE `cart` SET quantity = :quantity WHERE id = :cart_id");
    $update_cart_query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $update_cart_query->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);

    if ($update_cart_query->execute()) {
        $select_grand_total = $pdo->prepare("SELECT SUM(quantity * price) AS grand_total FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = :user_id");
        $select_grand_total->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $select_grand_total->execute();
        $grand_total = $select_grand_total->fetch(PDO::FETCH_ASSOC)['grand_total'];

        echo json_encode(array('total_price' => $quantity * $product_price, 'grand_total' => $grand_total));
    } else {
        echo json_encode(array('error' => 'Không thể cập nhật số lượng!'));
    }
}
?>