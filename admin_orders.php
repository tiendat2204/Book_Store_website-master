<?php
    include './controller/update_order.php';
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
    <style>
    
 

    </style>
    <body>
        <?php include 'admin_header.php'; ?>

        <section class="orders">
            <h1 class="title">Đơn hàng đã đặt</h1>
            <div class="box-container">
                <?php
try {
    $select_orders = $pdo->query("SELECT orders.*, users.name AS user_name, users.phone AS user_phone, users.email AS user_email, GROUP_CONCAT(products.image) AS product_images FROM orders LEFT JOIN users ON orders.user_id = users.id LEFT JOIN order_detail ON orders.id = order_detail.order_id LEFT JOIN products ON order_detail.product_id = products.id GROUP BY orders.id");
    if ($select_orders->rowCount() > 0) {
        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
?>
            <div class="box">
                <p> Mã người dùng : <span><?= $fetch_orders['user_id'] ?></span> </p>
                <p> Đặt hàng vào : <span><?= $fetch_orders['placed_on'] ?></span> </p>
                <p> Tên : <span><?= $fetch_orders['user_name'] ?></span> </p>
                <p> Số điện thoại : <span><?= $fetch_orders['user_phone'] ?></span> </p>
                <p> Email : <span><?= $fetch_orders['user_email'] ?></span> </p>
                <p> Địa chỉ : <span><?= $fetch_orders['address'] ?></span> </p>
                <p> Tổng số sản phẩm : <span><?= $fetch_orders['total_products'] ?></span> </p>
                <p> Tổng giá : <span><?= number_format($fetch_orders['total_price'], 0, ',', '.') ?>đ</span> </p>
                <p> Phương thức thanh toán : <span><?= $fetch_orders['method'] ?></span> </p>
                <div class="image-prd-order">
                <?php
                    $product_images = explode(',', $fetch_orders['product_images']);
                    foreach ($product_images as $image) {
                ?>

                    <img src="images/<?= $image ?>" alt="Product Image" class="image-order">
                    <?php
                    }
                    ?>
                    </div>
                <form action="" method="post">
                    <input type="hidden" name="order_id" value="<?= $fetch_orders['id'] ?>">
                    <select name="update_payment">
                        <option value="" selected disabled><?= $fetch_orders['payment_status'] ?></option>
                        <option value="Đợi xác nhận">Đợi xác nhận</option>
                        <option value="Chờ lấy hàng">Chờ lấy hàng</option>
                        <option value="Chờ giao hàng">Chờ giao hàng</option>
                        <option value="Đã giao hàng">Đã giao hàng</option>
                    </select>
                    <input type="submit" value="Cập nhật" name="update_order" class="option-btn">
                    <a href="admin_orders.php?delete=<?= $fetch_orders['id'] ?>" onclick="return confirm('Xóa đơn hàng này?');" class="delete-btn">Xóa</a>
                </form>
            </div>
<?php
        }
    } else {
        echo 'Chưa có đơn hàng nào được đặt!';
    }
} catch (PDOException $e) {
    die('Truy vấn thất bại: ' . $e->getMessage());
}

                ?>
            </div>
        </section>

        <!-- Liên kết đến tệp JS tùy chỉnh của quản trị viên -->
        <script src="js/admin_script1.js"></script>
    </body>
</html>
