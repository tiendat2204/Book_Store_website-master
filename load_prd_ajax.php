<?php
include './model/config.php';

$product_id = $_GET['product_id'] ?? null;

if ($product_id) {
  $product_query = $pdo->prepare("SELECT * FROM `products` WHERE id = :product_id");
  $product_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
  $product_query->execute();

  if ($product_data = $product_query->fetch(PDO::FETCH_ASSOC)) {
    header('Content-Type: application/json');
    echo json_encode($product_data);
  } else {
    echo 'Sản phẩm không tồn tại.';
    exit();
  }
} else {
  echo 'Thiếu thông tin sản phẩm.';
  exit();
}
?>
