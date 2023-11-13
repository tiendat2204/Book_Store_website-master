<?php
include './model/config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit(); // Dừng việc thực hiện script
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $message = $_POST['comment']; // Đổi tên biến này từ 'comment' thành 'message'
    $user_id = $_SESSION['user_id'];

    // Thực hiện truy vấn để lưu tin nhắn vào cơ sở dữ liệu
    $insert_message_query = $pdo->prepare("INSERT INTO comment (product_id, user_id, message) VALUES (:product_id, :user_id, :message)");
    $insert_message_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $insert_message_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $insert_message_query->bindParam(':message', $message, PDO::PARAM_STR);

    if ($insert_message_query->execute()) {
        // Tin nhắn đã được lưu thành công, bạn có thể thực hiện các xử lý bổ sung ở đây nếu cần.
        header("Location: product_detail.php?product_id=$product_id&success=1");
        exit();
    } else {
        // Xử lý lỗi nếu có lỗi khi lưu tin nhắn
        echo "Có lỗi xảy ra khi lưu tin nhắn.";
    }
} else {
    header('location: index.php');
    exit();
}
?>
