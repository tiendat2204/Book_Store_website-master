<?php
include '../model/config.php';
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
  $select_total_quantity = $pdo->prepare("SELECT SUM(quantity) AS total_quantity FROM `cart` WHERE user_id = :user_id");
  

  if ($update_cart_query->execute()) {
    // Lấy tổng giá tiền của tất cả sản phẩm trong giỏ hàng
    $select_grand_total = $pdo->prepare("SELECT SUM(quantity * price) AS grand_total FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = :user_id");
    $select_grand_total->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $select_grand_total->execute();
    $grand_total = $select_grand_total->fetch(PDO::FETCH_ASSOC)['grand_total'];
    
    // Lấy giá tiền của sản phẩm cụ thể được cập nhật
    $select_cart = $pdo->prepare("SELECT products.price FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.id = :cart_id");
    $select_cart->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
    $select_cart->execute();
    $row = $select_cart->fetch(PDO::FETCH_ASSOC);
    $total_price = $row['price'] * $quantity;
    $select_total_quantity->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $select_total_quantity->execute();
    $total_quantity  = $select_total_quantity->fetch(PDO::FETCH_ASSOC)['total_quantity'];
    // Trả về thông tin tổng giá tiền của tất cả sản phẩm và giá tiền của sản phẩm cụ thể
    echo json_encode(array('total_price' => $total_price, '#grand-total-all-prod' => $grand_total, 'total_quantity' => $total_quantity));
  } else {
    echo json_encode(array('error' => 'Không thể cập nhật số lượng!'));
  }
}
?>
