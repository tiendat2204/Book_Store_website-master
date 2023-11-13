<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
            <div class="message">
                <span>' . $msg . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
    }
}
?>

<header class="header">

    <div class="flex">

        <a href="admin_page.php" class="logo">admin<span>Panel</span></a>

        <nav class="navbar">
            <a href="admin_page.php">Trang chủ</a>
            <a href="admin_products.php">Sản phẩm</a>
            <a href="admin_orders.php">Đơn hàng</a>
            <a href="admin_users.php">Người dùng</a>
            <a href="admin_comment.php">Bình luận</a>
            <a href="admin_contacts.php">Tin nhắn</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="account-box">
            <?php
            // Lấy thông tin người dùng từ biến $pdo
            $admin_id = $_SESSION['admin_id'];
            $select_admin = $pdo->prepare("SELECT name, email FROM `users` WHERE id = :admin_id");
            $select_admin->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
            $select_admin->execute();
            $admin_data = $select_admin->fetch(PDO::FETCH_ASSOC);

            if ($admin_data) {
                echo '<p>Tên người dùng : <span>' . $admin_data['name'] . '</span></p>';
                echo '<p>Email : <span>' . $admin_data['email'] . '</span></p>';
            }
            ?>
            <a href="logout.php" class="delete-btn">Đăng xuất</a>
        </div>

    </div>
<script src="js/admin_script1.js"></script>
</header>
