<?php
include "../model/config.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$avatar = ""; // Mặc định: không có hình đại diện

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $location = $_POST['location'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Kiểm tra xem có mật khẩu mới được nhập không
    if (!empty($_POST['password'])) {
        $new_password = $_POST['password'];
        // Băm mật khẩu mới bằng MD5 trước khi lưu vào cơ sở dữ liệu
        $new_password_md5 = md5($new_password);
    }

    // Kiểm tra xem người dùng có chọn ảnh đại diện mới hay không
    if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
        // Kiểm tra lỗi khi tải lên
        if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = '../uploaded_img/';
            $upload_file = $upload_dir . basename($_FILES['avatar']['name']);

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_file)) {
                $avatar = basename($_FILES['avatar']['name']);
            } else {
                echo "Có lỗi xảy ra khi tải lên ảnh.";
            }
        } else {
            echo "Lỗi khi tải lên ảnh. Mã lỗi: " . $_FILES['avatar']['error'];
        }
    }

    $user_id = $_SESSION['user_id'];

    // Tạo câu truy vấn cập nhật dữ liệu người dùng
    $query = "UPDATE users SET name = :username, location = :location, email = :email, phone = :phone";

    // Thêm mật khẩu mới vào câu truy vấn nếu có
    if (isset($new_password_md5)) {
        $query .= ", password = :new_password";
    }

    // Thêm cập nhật ảnh đại diện vào câu truy vấn nếu có
    if (!empty($avatar)) {
        $query .= ", avatar = :avatar";
    }

    $query .= " WHERE id = :user_id";

    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':location', $location, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':phone', $phone, PDO::PARAM_STR);

    // Thêm mật khẩu mới đã băm MD5 vào câu truy vấn nếu có
    if (isset($new_password_md5)) {
        $statement->bindParam(':new_password', $new_password_md5, PDO::PARAM_STR);
    }

    // Thêm ảnh đại diện vào câu truy vấn nếu có
    if (!empty($avatar)) {
        $statement->bindParam(':avatar', $avatar, PDO::PARAM_STR);
    }

    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($statement->execute()) {
        $message[] = 'Chỉnh sửa thành công!';
        $_SESSION['messages'] = $message; 
        echo "<script> window.location.href = '../profile.php';</script>";
        exit();
    } else {
        $message[] = 'Có lỗi xảy ra khi cập nhật thông tin hồ sơ.';
    $_SESSION['messages'] = $message; 
    }


    
}

include 'header.php';
?>
