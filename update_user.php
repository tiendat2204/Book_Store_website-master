<?php
include './model/config.php';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];

    try {
        // Sử dụng biến kết nối từ file config
        $stmt = $pdo->prepare("UPDATE `users` SET name = :name, email = :email, user_type = :user_type WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':user_type', $user_type, PDO::PARAM_STR);
        $stmt->execute();

        header('location:admin_users.php');
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>
