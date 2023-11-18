<?php
include './model/config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_POST['add_to_cart'])) {
    if ($user_id === null) {
        // Người dùng chưa đăng nhập, hiển thị thông báo
        $message[] = 'Bạn cần đăng nhập trước khi thêm sản phẩm vào giỏ hàng.';
    } else {
        $product_id = $_POST['product_id'];

        $check_existing_product = $pdo->prepare("SELECT * FROM `cart` WHERE product_id = :product_id AND user_id = :user_id");
        $check_existing_product->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $check_existing_product->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $check_existing_product->execute();

        if ($check_existing_product->rowCount() > 0) {
            // Sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
            $update_quantity_query = $pdo->prepare("UPDATE `cart` SET quantity = quantity + 1 WHERE product_id = :product_id AND user_id = :user_id");
            $update_quantity_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $update_quantity_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($update_quantity_query->execute()) {
                $message[] = 'Sản phẩm đã được thêm vào giỏ hàng!';
            } else {
                $message[] = 'Không thể cập nhật số lượng sản phẩm trong giỏ hàng!';
            }
        } else {
            // Sản phẩm chưa tồn tại trong giỏ hàng, chèn một hàng mới
            $insert_query = $pdo->prepare("INSERT INTO `cart` (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)");
            $insert_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $insert_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);

            if ($insert_query->execute()) {
                $message[] = 'Sản phẩm đã được thêm vào giỏ hàng!';
            } else {
                $message[] = 'Không thể thêm sản phẩm vào giỏ hàng!';
            }
        }
    }
}
?>
