<?php
include './model/config.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM `users` WHERE id = :delete_id");
    $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $_SESSION['messages'] = array('Xóa người dùng thành công!');
    } else {
        $_SESSION['messages'] = array('Xóa người dùng thất bại!');
    }
    header('location:admin_users.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_user'])) {
        // Handle user editing
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];

        $stmt = $pdo->prepare("UPDATE `users` SET name = :name, email = :email, user_type = :user_type WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':user_type', $user_type, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['messages'] = array('Chỉnh sửa người dùng thành công!');
        } else {
            $_SESSION['messages'] = array('Chỉnh sửa người dùng thất bại!');
        }
        header('location:admin_users.php');
        exit();
    } elseif (isset($_POST['add_user'])) {
        // Handle user addition
        $name = $_POST['name'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];
        $password = $_POST['password'];
        $hashed_password = md5($password);
        $stmt = $pdo->prepare("INSERT INTO `users` (name, email, password, user_type) VALUES (:name, :email, :password, :user_type)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':user_type', $user_type, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['messages'] = array('Thêm người dùng thành công!');
        } else {
            $_SESSION['messages'] = array('Thêm người dùng thất bại!');
        }
        header('location:admin_users.php');
        exit();
    }
}
?>
