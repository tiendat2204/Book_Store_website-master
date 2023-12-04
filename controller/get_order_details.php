<?php


if (isset($_GET['orderId'])) {
    // Lấy orderId từ yêu cầu Ajax
    $orderId = $_GET['orderId'];
    include "../model/config.php"; 

    $orderDetailsQuery = $pdo->prepare("SELECT products.name AS name, products.image AS image, order_detail.quantity AS quantity FROM order_detail LEFT JOIN products ON order_detail.product_id = products.id WHERE order_detail.order_id = :orderId");
    $orderDetailsQuery->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $orderDetailsQuery->execute();

    if ($orderDetailsQuery->rowCount() > 0) {
        $products = $orderDetailsQuery->fetchAll(PDO::FETCH_ASSOC);

        // Trả về JSON chứa thông tin chi tiết đơn hàng
        echo json_encode(['success' => true, 'products' => $products]);
        exit();
    } else {
        // Không tìm thấy chi tiết đơn hàng
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy chi tiết đơn hàng']);
        exit();
    }
} else {
    // Nếu orderId không được cung cấp trong yêu cầu Ajax
    echo json_encode(['success' => false, 'message' => 'OrderId không hợp lệ']);
    exit();
}
?>
