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
        // Use PDO to perform the delete query
        $delete_statement = $pdo->prepare("DELETE FROM `message` WHERE id = :delete_id");
        $delete_statement->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $delete_statement->execute();
        $_SESSION['messages'] = array('Xóa tin nhắn thành công!');

        header('location:admin_contacts.php');
exit();
    } catch (PDOException $e) {
        die('Query failed: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin nhắn</title>

    <!-- Liên kết đến font awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Liên kết đến tệp CSS tùy chỉnh cho giao diện quản trị -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="messages">

        <h1 class="title">Tin nhắn</h1>

        <div class="box-container">
            <?php
            try {
                // Sử dụng INNER JOIN để kết hợp thông tin từ bảng message và users
                $select_message = $pdo->query("SELECT message.*, users.name AS user_name, users.email AS user_email, users.phone AS user_phone FROM `message` INNER JOIN `users` ON message.user_id = users.id");

                if ($select_message->rowCount() > 0) {
                    while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="box">
                            <p> ID người dùng : <span><?php echo $fetch_message['user_id']; ?></span> </p>
                            <p> Tên người dùng : <span><?php echo $fetch_message['user_name']; ?></span> </p>
                            <p> Email người dùng : <span><?php echo $fetch_message['user_email']; ?></span> </p>
                            <p> Số điện thoại người dùng : <span><?php echo $fetch_message['user_phone']; ?></span> </p>
                            <p> Nội dung tin nhắn : <span><?php echo $fetch_message['message']; ?></span> </p>
                            <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>"
                               onclick="return confirm('Xóa tin nhắn này?');" class="delete-btn">Xóa tin nhắn</a>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="empty">Bạn không có tin nhắn nào!</p>';
                }
            } catch (PDOException $e) {
                die('Truy vấn thất bại: ' . $e->getMessage());
            }
            ?>
        </div>

    </section>

    <!-- Liên kết đến tệp script JavaScript tùy chỉnh cho giao diện quản trị -->
    <script src="js/admin_script1.js"></script>

</body>

</html>
