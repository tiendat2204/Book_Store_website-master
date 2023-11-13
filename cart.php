<?php
include './controller/cartCURD.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>Giỏ Hàng</h3>
    <p> <a href="index.php">Trang Chủ</a> / Giỏ Hàng </p>
</div>

<section class="shopping-cart">

    <h1 class="title">Sản Phẩm Đã Thêm</h1>

    <div class="box-container">
        <?php
        $grand_total = 0;
        $select_cart = $pdo->prepare("SELECT cart.*, products.name, products.price, products.image FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = :user_id");
        $select_cart->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $select_cart->execute();
        
        if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                ?>
                 <div class="box">
                    <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?');"></a>
                    <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
                    <div class="name"><?php echo $fetch_cart['name']; ?></div>
                    <div class="price">$<?php echo $fetch_cart['price']; ?>/-</div>
                    <form action="" method="post">
                        <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                        <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                        <input type="submit" name="update_cart" value="Cập nhật" class="option-btn">
                    </form>
                    <div class="sub-total">Tổng cộng: <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>/-</span> </div>
                </div>
                <?php
                $grand_total += $sub_total;
            }
        } else {
            echo '<p class="empty">giỏ hàng trống</p>';
        }
        ?>
    </div>

    <div style="margin-top: 2rem; text-align:center;">
        <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('Xóa tất cả sản phẩm khỏi giỏ hàng?');">Xóa tất cả</a>
    </div>

    <div class="cart-total">
        <p>Tổng cộng: <span>$<?php echo $grand_total; ?>/-</span></p>
        <div class="flex">
            <a href="shop.php" class="option-btn">Tiếp tục mua sắm</a>
            <a href="checkout.php" class="btn1 <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Tiến hành thanh toán</a>
        </div>
    </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>

</html>
