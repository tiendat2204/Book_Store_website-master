
<?php
session_start();
require_once '../model/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $category_name = trim($_POST['category_name']);
    if (empty($category_name)) {
        $_SESSION['messages'][] = 'Tên danh mục không được trống.';
    } else {
        $insert_query = $pdo->prepare("INSERT INTO categories (name) VALUES (:category_name)");
        $insert_query->bindParam(':category_name', $category_name, PDO::PARAM_STR);

        if ($insert_query->execute()) {
            $_SESSION['messages'][] = 'Danh mục mới đã được thêm thành công.';
        } else {
            $_SESSION['messages'][] = 'Đã xảy ra lỗi khi thêm danh mục.';
        }
    }

    header('Location: ../admin_category.php');
    exit;
}
?>
