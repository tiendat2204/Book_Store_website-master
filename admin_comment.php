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
        $delete_statement = $pdo->prepare("DELETE FROM `comment` WHERE id = :delete_id");
        $delete_statement->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $delete_statement->execute();
        $_SESSION['messages'] = array('Xóa comment thành công!');
        header('location:admin_comment.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn đặt hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">

</head>
 
<body>

    <?php include 'admin_header.php'; ?>
    <section class="comments">
    <h1 class="title">Quản lý Comment</h1>

    <table class="comment-table">
        <thead>
            <tr>
                <th>ID Người dùng</th>
                <th>Tên Người dùng</th>
                <th>Nội dung Comment</th>
                <th>Sản phẩm</th>
                <th>Hình ảnh sản phẩm</th>
                <th>Phản hồi</th>
                <th>Thao tác</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $select_comments = $pdo->query("SELECT comment.*, users.name AS user_name, products.name AS product_name, products.image AS product_image
                FROM `comment`
                LEFT JOIN `users` ON comment.user_id = users.id
                LEFT JOIN `products` ON comment.product_id = products.id");
                if ($select_comments->rowCount() > 0) {
                    while ($comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?php echo $comment['user_id']; ?></td>
                            <td><?php echo $comment['user_name']; ?></td>
                            <td><?php echo $comment['message']; ?></td>
                            <td><?php echo $comment['product_name']; ?></td>
                            <td><img src="uploaded_img/<?php echo $comment['product_image']; ?>" alt="Product Image"></td>
                            <td><?php echo $comment['reply_message']; ?></td>
                            <td class="comment-actions">
    <a href="admin_comment.php?delete=<?php echo $comment['id']; ?>"
       onclick="return confirm('Xóa Comment này?');" class="delete-button">Xóa Comment</a>
    <form action="./controller/c_rep_comment.php" method="post" class="reply-form">
        <textarea name="reply_message" placeholder="Phản hồi của bạn"></textarea>
        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
        <input type="submit" name="submit_reply" value="Gửi">
    </form>
</td>


                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="6" class="empty">Không có Comment nào!</td></tr>';
                }
            } catch (PDOException $e) {
                die('Truy vấn thất bại: ' . $e->getMessage());
            }
            ?>
        </tbody>
    </table>
</section>


    <script src="js/admin_script1.js"></script>

</body>

</html>
