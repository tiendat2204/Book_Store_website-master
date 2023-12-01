<?php
include './model/config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    $message = 'Bạn cần đăng nhập để xem đơn hàng.';
} else {
    $user_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {

    // Check if it is a VNPAY payment
    if (isset($_GET['vnp_ResponseCode'])) {
        $vnp_Amount = $_GET['vnp_Amount'];
        $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
        $vnp_TxnRef = $_GET['vnp_TxnRef'];

        // Check order status for VNPAY
        if ($vnp_ResponseCode == '00') {
            // Order successful
            $_SESSION['messages'] = array("Đơn hàng có mã $vnp_TxnRef đã thanh toán thành công !");
        } else {
            // Order unsuccessful
            $_SESSION['messages'] = array("Đơn hàng có mã $vnp_TxnRef đã thanh toán không thành công !");
            
            // Set payment status to 'Chưa thanh toán'
            $updateStatusQuery = $pdo->prepare("UPDATE orders SET payment_status = 'Chưa thanh toán' WHERE order_code = :order_code");
            $updateStatusQuery->bindParam(':order_code', $vnp_TxnRef, PDO::PARAM_STR);
            $updateStatusQuery->execute();
            
        }

        unset($_SESSION['order_status']);
    }

    // Check if it is a MoMo payment
    elseif (isset($_GET['transId'])) {
        $partnerCode = $_GET['partnerCode'];
        $orderId = $_GET['orderId'];
        $requestId = $_GET['requestId'];
        $amount = $_GET['amount'];
        $orderInfo = $_GET['orderInfo'];
        $resultCode = $_GET['resultCode'];
        $message = $_GET['message'];

        // Check order status for MoMo
        if ($resultCode == '0') {
            // Order successful
            $_SESSION['messages'] = array("Đơn hàng có mã $orderId đã thanh toán thành công !");
        } else {
            // Order unsuccessful
            $_SESSION['messages'] = array("Đơn hàng có mã $orderId đã thanh toán không thành công !");
            
            // Set payment status to 'Chưa thanh toán'
            $updateStatusQuery = $pdo->prepare("UPDATE orders SET payment_status = 'Chưa thanh toán' WHERE order_code = :order_code");
            $updateStatusQuery->bindParam(':order_code', $orderId, PDO::PARAM_STR);
            $updateStatusQuery->execute();
        }

        unset($_SESSION['order_status']);
    }
    
} else {
    // Handle other cases or actions as needed
}

// Đoạn mã HTML và JavaScript ở đây...
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn Hàng</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Đơn hàng của bạn</h3>
        <p><a href="index.php">Trang Chủ</a> / Đơn Hàng</p>
    </div>

    <section class="placed-orders">
        <?php
        if (isset($message)) {
            echo '<p>' . $message . '</p>';
        } else {
            ?>
            <section class="canceled-orders">
                <button id="toggle-canceled-orders">Hiển Thị Đơn Hàng Đã Hủy</button>
                <div class="box-container-cancel" >
                    <ul class="canceled-orders-list" id="canceled-orders-list">
                        <?php
                        $canceled_order_query = $pdo->prepare("SELECT orders.*, users.name AS user_name, users.phone AS user_phone, users.email AS user_email
                            FROM `orders`
                            LEFT JOIN `users` ON orders.user_id = users.id
                            WHERE orders.user_id = :user_id AND orders.payment_status = 'Đã hủy'");
                        $canceled_order_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                        $canceled_order_query->execute();

                        if ($canceled_order_query->rowCount() > 0) {
                            while ($fetch_canceled_orders = $canceled_order_query->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <li class="canceled-order-item">
                                    <div class="canceled-order-info">
                                        <span class="canceled-order-date"><?php echo $fetch_canceled_orders['placed_on']; ?></span>
                                        <span class="canceled-order-total"><?php echo number_format($fetch_canceled_orders['total_price'], 0, ',', '.') . ' VND'; ?></span>
                                    </div>
                                    <div class="canceled-order-details">
                                        <p><strong>Ngày đặt hàng:</strong> <?php echo $fetch_canceled_orders['placed_on']; ?></p>
                                        <p><strong>Tên:</strong> <?php echo $fetch_canceled_orders['user_name']; ?></p>
                                        <p><strong>Số điện thoại:</strong> <?php echo $fetch_canceled_orders['user_phone']; ?></p>
                                        <p><strong>Email:</strong> <?php echo $fetch_canceled_orders['user_email']; ?></p>
                                        <p><strong>Sản phẩm đã hủy:</strong></p>
                                        <ul>
                                            <?php
                                            $canceled_product_query = $pdo->prepare("SELECT order_detail.*, products.name AS product_name, products.image AS product_image
                                                FROM order_detail
                                                LEFT JOIN products ON order_detail.product_id = products.id
                                                WHERE order_detail.order_id = :order_id");
                                            $canceled_product_query->bindParam(':order_id', $fetch_canceled_orders['id'], PDO::PARAM_INT);
                                            $canceled_product_query->execute();

                                            while ($canceled_product = $canceled_product_query->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<li class='canceled-order-product'>";
                                                echo "<a href='product_detail.php?product_id={$canceled_product['product_id']}'>";
                                                echo "<img src='images/{$canceled_product['product_image']}' alt='{$canceled_product['product_name']}' class='product-thumbnail'>";
                                                echo "{$canceled_product['product_name']} - Số lượng: {$canceled_product['quantity']}";
                                                echo "</a>";
                                                echo "</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </li>
                                <?php
                            }
                        } else {
                            echo '<p class="empty">Không có đơn hàng nào đã hủy!</p>';
                        }
                        ?>
                    </ul>
                </div>
            </section>
            <h1 class="title">Đặt Hàng</h1>
            <div class="box-container">
                <?php
                $order_query = $pdo->prepare("SELECT orders.*, users.name AS user_name, users.phone AS user_phone, users.email AS user_email FROM `orders` LEFT JOIN `users` ON orders.user_id = users.id WHERE orders.user_id = :user_id");
                $order_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $order_query->execute();

                if ($order_query->rowCount() > 0) {
                    while ($fetch_orders = $order_query->fetch(PDO::FETCH_ASSOC)) {
                        if ($fetch_orders['payment_status'] == 'Đã hủy') {
                            continue;
                        }
                        ?>
                        <div class="order-form">
                            <section class="in4_user">
                                <div class="order-row-day">
                                    <div class="order-day">Ngày đặt hàng:</div>
                                    <div class="order-value-day"><?php echo $fetch_orders['placed_on']; ?></div>
                                </div>
                                <div class="order-row-name">
                                    <div class="order-name">Tên:</div>
                                    <div class="order-value-name"><?php echo $fetch_orders['user_name']; ?></div>
                                </div>
                                <div class="order-row-phone">
                                    <div class="order-phone">Số điện thoại:</div>
                                    <div class="order-value-phone"><?php echo $fetch_orders['user_phone']; ?></div>
                                </div>
                                <div class="order-row-email">
                                    <div class="order-email">Email:</div>
                                    <div class="order-value-email"><?php echo $fetch_orders['user_email']; ?></div>
                                </div>
                                <div class="order-row-address">
                                    <div class="order-address">Địa chỉ:</div>
                                    <div class="order-value-address"><?php echo $fetch_orders['address']; ?></div>
                                </div>
                                <div class="order-row-payment">
                                    <div class="order-payment">Phương thức thanh toán:</div>
                                    <div class="order-value-payment"><?php echo $fetch_orders['method']; ?></div>
                                </div>
                            </section>
                            <div class="order-details-title">
                                <div class="order-row-product">
                                    SẢN PHẨM
                                </div>
                                <div class="order-row-quantity">
                                    SỐ LƯỢNG
                                </div>
                                <div class="order-row-price">
                                    GIÁ SẢN PHẨM
                                </div>
                            </div>
                            <?php
                            $order_detail_query = $pdo->prepare("SELECT order_detail.*, products.name AS product_name, products.image AS product_image FROM order_detail LEFT JOIN products ON order_detail.product_id = products.id WHERE order_detail.order_id = :order_id");
                            $order_detail_query->bindParam(':order_id', $fetch_orders['id'], PDO::PARAM_INT);
                            $order_detail_query->execute();

                            while ($fetch_order_detail = $order_detail_query->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <section class="in4_product">
                                    <div class="order-details">
                                        <div class="order-value-image">
                                            <a href="product_detail.php?product_id=<?php echo $fetch_order_detail['product_id']; ?>">
                                                <img src="images/<?php echo $fetch_order_detail['product_image']; ?>" alt="Product Image">
                                            </a>
                                            <div class="order-value-product"><?php echo $fetch_order_detail['product_name']; ?></div>
                                        </div>
                                        <div class="order-value-quantity"><?php echo $fetch_order_detail['quantity']; ?>  quyển</div>
                                        <div class="order-value-price"><?php echo number_format($fetch_order_detail['subtotal'], 0, ',', '.') . ' VND'; ?></div>
                                    </div>
                                </section>
                                <?php
                            }
                            ?>
                            <div class="order-row-total">
                                <div class="order-total">Tổng giá:</div>
                                <div class="order-value-total"><?php echo number_format($fetch_orders['total_price'], 0, ',', '.') . ' VND'; ?></div>
                            </div>
                            <div class="order-row-status">
                                <div class="order-status">Tình trạng dơn hàng:</div>
                                <div class="order-value-status" style="color:<?php echo ($fetch_orders['payment_status'] == 'Đợi xác nhận') ? 'red' : 'green'; ?>"><?php echo $fetch_orders['payment_status']; ?></div>
                                <?php if ($fetch_orders['payment_status'] == 'Đợi xác nhận'): ?>
                                    <a href="./controller/cancel_order.php?order_id=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng không?');" class="cancel-link">Hủy đơn hàng</a>
                                <?php endif; ?>
                            </div>
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

    <script src="js/script.js"></script>

</body>
</html>
