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
            <a href=""><img src="images/logo.avif" alt="" class="logo1"></a>
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
                <div class="container-tooltip">
                <span class="hover-me-tooltip"><a href="apibook.php" class="fa-brands fa-google"></a></span>
                <div class="tooltip">
                         <p>Tìm kiếm với google <i class="fa-brands fa-google"></i></p>
               </div>
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div id="user-icon" class="fas fa-user"></div>
                    <div class="user-box">
                        <p>Tên : <span><?= $_SESSION['user_name'] ?></span></p>
                        <p>email : <span><?= $_SESSION['user_email'] ?></span></p>
                        <a href="profile.php" class="delete-btn">Sửa</a>
                        <a href="logout.php" class="delete-btn">Đăng Xuất</a>
                    </div>
                <?php else: ?>
                    <div id="user-icon" class="fas fa-user"></div>
                    <div class="user-box">
                        <div class="res">
                    <a href="login.php" class="custom-link">Đăng nhập</a>
                <a href="register.php" class="custom-link">Đăng ký</a>
                </div>
                        </div>
                <?php endif; ?>
                
                <?php
                $select_cart_number = $pdo->prepare("SELECT COUNT(*) FROM `cart` WHERE user_id = :user_id");
                $select_cart_number->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $select_cart_number->execute();
                $cart_rows_number = $select_cart_number->fetchColumn();
                ?>
                <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?= $cart_rows_number ?>)</span> </a>
                
            </div>
            
        </div>
    </div>
</header>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var messages = document.querySelectorAll(".message");
    
    messages.forEach(function(message) {
        setTimeout(function() {
            message.style.display = "none";
        }, 4000); 
    });
});
</script>