<?php
require_once './controller/add_to_cart.php';

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $select_products = $pdo->prepare("SELECT * FROM `products` WHERE `category_id` = :category_id");
    $select_products->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $select_products->execute();

    $products = array();
    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        $products[] = $fetch_products;
    }
    echo json_encode($products);
}
?>
