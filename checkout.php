<?php
include './controller/thanhtoan.php';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>

    <!-- Liên kết đến font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Liên kết đến tệp CSS tùy chỉnh -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>Thanh toán</h3>
    <p> <a href="index.php">Trang chủ</a> / Thanh toán </p>
</div>

<section class="display-order">

    <?php
    $grand_total = 0;
    $select_cart = $pdo->prepare("SELECT cart.*, products.name, products.price FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = :user_id");
    $select_cart->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $select_cart->execute();

    if ($select_cart->rowCount() > 0) {
        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
            $grand_total += $total_price;
            ?>
            <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$' . $fetch_cart['price'] . '/-' . ' x ' . $fetch_cart['quantity']; ?>)</span> </p>
            <?php
        }
    } else {
        echo '<p class="empty">Giỏ hàng của bạn đang trống</p>';
    }
    ?>
    <div class="grand-total"> Tổng cộng : <span>$<?php echo $grand_total; ?>/-</span> </div>

</section>

<section class="checkout">

    <form action="" method="post">
        <h3>Đặt hàng của bạn</h3>
        <div class="flex">
            <div class="inputBox">
                <span>Tên của bạn :</span>
                <input type="text" name="name" required placeholder="Nhập tên của bạn" value="<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>">
            </div>
            <div class="inputBox">
                <span>Số điện thoại của bạn :</span>
                <input type="text" name="number" required placeholder="Nhập số điện thoại của bạn" value="<?php echo isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : ''; ?>">
            </div>
            <div class="inputBox">
                <span>Email của bạn :</span>
                <input type="email" name="email" required placeholder="Nhập email của bạn" value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>">
            </div>
            <div class="inputBox">
                <span>Phương thức thanh toán :</span>
                <select name="method">
                    <option value="thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                    <option value="thẻ tín dụng">Thẻ tín dụng</option>
                    <option value="paypal">Zalopay</option>
                    <option value="paytm">MoMo</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Số nhà:</span>
                <input type="number" min="0" name="flat" required placeholder="Ví dụ: căn hộ số">
            </div>
            <div class="inputBox">
                <span>Tên đường:</span>
                <input type="text" name="street" required placeholder="Ví dụ: tên đường">
            </div>
            <div class="inputBox">
                <span>Thành phố :</span>
                <input type="text" name="city" required placeholder="Ví dụ: thành phố">
            </div>
            <div class="inputBox">
                <span>Tỉnh / Thành :</span>
                <input type="text" name="state" required placeholder="Ví dụ: tỉnh / thành phố">
            </div>
            <div class="inputBox">
                <span>Quốc gia :</span>
                <input type="text" name="country" required placeholder="Ví dụ: quốc gia">
            </div>
            <div class="inputBox">
                <span>Mã PIN :</span>
                <input type="number" min="0" name="pin_code" required placeholder="Ví dụ: mã PIN">
            </div>
        </div>
        <input type="submit" value="Đặt hàng ngay" class="btn1" name="order_btn">
    </form>

</section>

<?php include 'footer.php'; ?>

<!-- Liên kết đến tệp JavaScript tùy chỉnh -->
<script src="js/script.js"></script>

</body>

</html>
