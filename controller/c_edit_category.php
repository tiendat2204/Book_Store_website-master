<?php
session_start();
require_once '../model/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryID = $_POST['category_id'];
    $newCategoryName = $_POST['new_category_name'];

    $updateQuery = $pdo->prepare("UPDATE categories SET name = :new_name WHERE id = :category_id");
    $updateQuery->bindParam(':new_name', $newCategoryName);
    $updateQuery->bindParam(':category_id', $categoryID);

    if ($updateQuery->execute()) {
        $_SESSION['messages'][] = 'Chỉnh sửa thành công.';
    } else {
        $_SESSION['messages'][] = 'Chỉnh sửa thất bại.';
    }
    header('Location: ../admin_category.php');
    exit;
}
