<?php
include './model/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];
$message = [];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    try {
        // Sử dụng PDO để thực hiện truy vấn xóa
        $delete_statement = $pdo->prepare("DELETE FROM `comment` WHERE id = :delete_id");
        $delete_statement->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $delete_statement->execute();
        $message = 'Xóa comment thành công!';

        $_SESSION['messages'] = $message;

        header('location:admin_comment.php');
    } catch (PDOException $e) {
        die('Query failed: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="vi">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn đặt hàng</title>

    <!-- Liên kết đến font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Liên kết đến tệp CSS tùy chỉnh của quản trị viên -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="comments">

<h1 class="title">Quản lý Comment</h1>


<div class="box-container">
    
    <?php
    try {
        $select_comments = $pdo->query("SELECT comment.*, users.name AS user_name FROM `comment`
            LEFT JOIN `users` ON comment.user_id = users.id");
        if ($select_comments->rowCount() > 0) {
            while ($comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box">
                    <p class="id_user">ID Người dùng: <span><?php echo $comment['user_id']; ?></span></p>
                    <p class="name_user">Tên Người dùng: <span><?php echo $comment['user_name']; ?></span></p>
                    <p class="nd_comment">Nội dung Comment: <span><?php echo $comment['message']; ?></span></p>
                    <a href="admin_comment.php?delete=<?php echo $comment['id']; ?>"
                       onclick="return confirm('Xóa Comment này?');" class="delete-btn">Xóa Comment</a>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">Không có Comment nào!</p>';
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
