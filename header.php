<?php


if (isset($_SESSION['messages']) && is_array($_SESSION['messages'])) {
    foreach ($_SESSION['messages'] as $msg) {
        echo '
            <div class="message">
                <span>' . $msg . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        ';
    }

    // Xóa các thông báo sau khi đã hiển thị
    unset($_SESSION['messages']);
}
?>
 
<header class="header">

    <div class="header-1">
        <div class="flex">
            <div class="share">
                <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
        </div>
    </div>

    <div class="header-2">
        <div class="flex">

          <a href=""><img src="images/logo.avif" alt="" class="logo1
                "></a>
 
            <nav class="navbar">
                <a href="index.php">Trang Chủ</a>
                <a href="about.php">Chúng Tôi</a>
                <a href="shop.php" onclick="toggleSubmenu(event)">Cửa Hàng <span>&#9662;</span></a>
    <div id="submenu" class="submenu">
        <a href="shop.php?category_id=4">Đời Sống</a>
        <a href="shop.php?category_id=2">Tâm Lý</a>
        <a href="shop.php?category_id=3">Kinh Dị</a>
        <a href="shop.php?category_id=1">Động Vật</a>
        <a href="shop.php">Tất Cả</a>
    </div>
                <a href="contact.php">Liên Hệ</a>
                <a href="orders.php">Đơn Hàng</a>
            </nav>

            <div class="icons">
    <div id="menu-btn" class="fas fa-bars"></div>
    <a href="search_page.php" class="fas fa-search"></a>
    <?php
    if (isset($_SESSION['user_id'])) {
        // Hiển thị thông tin người dùng và nút logout nếu đã đăng nhập
        
          echo '<div id="user-icon" class="fas fa-user"></div>';
          
    } else {
        // Hiển thị nút đăng nhập và đăng ký nếu chưa đăng nhập
        echo '
        <a href="login.php">Đăng nhập</a>
        <a href="register.php">Đăng ký</a>';
    }

    $select_cart_number = $pdo->prepare("SELECT COUNT(*) FROM `cart` WHERE user_id = :user_id");
    $select_cart_number->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $select_cart_number->execute();
    $cart_rows_number = $select_cart_number->fetchColumn();
    ?>
    <div class="user-box">
    <p>Tên : <span><?php echo $_SESSION['user_name']; ?></span></p>
    <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
    <a href="profile.php" class="delete-btn">Sửa</a>
    <a href="logout.php" class="delete-btn">Đăng Xuất</a>
</div>

    <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
</div>



           
           
        </div>
    </div>
<script src="css/style.css"></script>
</header>
