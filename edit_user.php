<?php
include './model/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    try {
        // Sử dụng biến kết nối từ file config
        $stmt = $pdo->prepare("SELECT * FROM `users` WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa người dùng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
        /* Thêm CSS tại đây để tùy chỉnh giao diện */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .edit-user {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .title {
            font-size: 24px;
            margin: 0 0 20px;
        }

        form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form input[type="email"],
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="edit-user">
        <h1 class="title">Chỉnh sửa thông tin người dùng</h1>
        <form method="post" action="update_user.php">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
            <label for="name">Tên người dùng:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            <label for="user_type">Loại người dùng:</label>
            <select name="user_type" required>
                <option value="user" <?php if ($user['user_type'] === 'user') echo 'selected'; ?>>Người dùng</option>
                <option value="admin" <?php if ($user['user_type'] === 'admin') echo 'selected'; ?>>Admin</option>
            </select>
            <button type="submit">Lưu thay đổi</button>
        </form>
    </section>
</body>
</html>
