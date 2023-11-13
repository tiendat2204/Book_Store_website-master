<?php 
include './model/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    try {
        // Sử dụng biến kết nối từ file config
        $stmt = $pdo->prepare("DELETE FROM `users` WHERE id = :delete_id");
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();

        header('location:admin_users.php');
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}


?>