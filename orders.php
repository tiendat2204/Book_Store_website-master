<?php
include './model/config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    // Người dùng chưa đăng nhập, hiển thị thông báo
    $message = 'Bạn cần đăng nhập để xem đơn hàng.';
} else {
    $user_id = $_SESSION['user_id'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn Hàng</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Đơn hàng của bạn</h3>
        <p> <a href="index.php">Trang Chủ</a> / Đơn Hàng </p>
    </div>

    <section class="placed-orders">
        <?php
        if (isset($message)) {
            // Hiển thị thông báo nếu người dùng chưa đăng nhập
            echo '<p>' . $message . '</p>';
        } else {
            // Người dùng đã đăng nhập, hiển thị đơn hàng
            ?>
            <h1 class="title">Đặt Hàng</h1>

            <div class="box-container">

                <?php
                // Sử dụng PDO thay vì MySQLi
                $order_query = $pdo->prepare("SELECT orders.*, users.name AS user_name, users.phone AS user_phone, users.email AS user_email FROM `orders` LEFT JOIN `users` ON orders.user_id = users.id WHERE orders.user_id = :user_id");
                $order_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $order_query->execute();

                if ($order_query->rowCount() > 0) {
                    while ($fetch_orders = $order_query->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="box">
                            <p>Đặt hàng vào ngày: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                            <p>Tên: <span><?php echo $fetch_orders['user_name']; ?></span> </p>
                            <p>Số điện thoại: <span><?php echo $fetch_orders['user_phone']; ?></span> </p>
                            <p>Email: <span><?php echo $fetch_orders['user_email']; ?></span> </p>
                            <p>Địa chỉ: <span><?php echo $fetch_orders['address']; ?></span> </p>
                            <p>Phương thức thanh toán: <span><?php echo $fetch_orders['method']; ?></span> </p>
                            <p>Đơn hàng của bạn: <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                            <p>Tổng giá: <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
                            <p>Tình trạng thanh toán: <span style="color:<?php if ($fetch_orders['payment_status'] == 'Chưa thanh toán') {
                                    echo 'red';
                                } else {
                                    echo 'green';
                                } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
                        </div>

                    <?php
                    }
                } else {
                    echo '<p class="empty">Không có đơn hàng nào!</p>';
                }
                ?>
            </div>
        <?php
        }
        ?>
    </section>

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>
