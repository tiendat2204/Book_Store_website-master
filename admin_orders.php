<?php
    include './controller/update_order.php';
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

        <section>
    <h1>Đơn hàng đã đặt</h1>
    <?php
    try {
        $select_orders = $pdo->query("SELECT orders.*, users.name AS user_name, users.phone AS user_phone, users.email AS user_email, GROUP_CONCAT(products.name) AS product_names, GROUP_CONCAT(products.image) AS product_images, GROUP_CONCAT(order_detail.quantity) AS product_quantities, COUNT(order_detail.id) AS total_products FROM orders LEFT JOIN users ON orders.user_id = users.id LEFT JOIN order_detail ON orders.id = order_detail.order_id LEFT JOIN products ON order_detail.product_id = products.id GROUP BY orders.id");

        if ($select_orders->rowCount() > 0) {
    ?>
            <table>
                <thead>
                    <tr>
                        <th>Mã người dùng</th>
                        <th>Đặt hàng vào</th>
                        <th>Tên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Thông tin sản phẩm</th>
                        <th>Tổng số lượng sản phẩm</th>
                        <th>Tổng giá</th>
                        <th>Phương thức thanh toán</th>
                        <th>Hình ảnh sản phẩm</th>
                        <th>Cập nhật thanh toán</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $fetch_orders['user_id'] ?></td>
                            <td><?= $fetch_orders['placed_on'] ?></td>
                            <td><?= $fetch_orders['user_name'] ?></td>
                            <td><?= $fetch_orders['user_phone'] ?></td>
                            <td><?= $fetch_orders['user_email'] ?></td>
                            <td><?= $fetch_orders['address'] ?></td>
                           
                            <td>
                                <?php
                                $product_names = explode(',', $fetch_orders['product_names']);
                                $product_quantities = explode(',', $fetch_orders['product_quantities']);

                                for ($i = 0; $i < count($product_names); $i++) {
                                    echo $product_names[$i] . ' (Số lượng: ' . $product_quantities[$i] . ')';
                                    if ($i < count($product_names) - 1) {
                                        echo ', ';
                                    }
                                }
                                ?>
                            </td>
                            <td><?= array_sum($product_quantities) ?></td>
                            <td><?= number_format($fetch_orders['total_price'], 0, ',', '.') ?>đ</td>
                            <td><?= $fetch_orders['method'] ?></td>
                            <td>
                                <?php
                                $product_images = explode(',', $fetch_orders['product_images']);
                                foreach ($product_images as $image) {
                                ?>
                                    <img src="uploaded_img/<?= $image ?>" alt="Product Image" class="image-order">
                                <?php
                                }
                                ?>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="order_id" value="<?= $fetch_orders['id'] ?>">
                                    <select name="update_payment">
                                        <option value="" selected disabled><?= $fetch_orders['payment_status'] ?></option>
                                        <option value="Đợi xác nhận">Đợi xác nhận</option>
                                        <option value="Chờ lấy hàng">Chờ lấy hàng</option>
                                        <option value="Chờ giao hàng">Chờ giao hàng</option>
                                        <option value="Chưa thanh toán">Chưa thanh toán</option>
                                        <option value="Đã giao hàng">Đã giao hàng</option>
                                    </select>
                                    <input type="submit" value="Cập nhật" name="update_order" class="option-btn">
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
    <?php
        } else {
            echo 'Chưa có đơn hàng nào được đặt!';
        }
    } catch (PDOException $e) {
        die('Truy vấn thất bại: ' . $e->getMessage());
    }
    ?>
</section>

        <script src="js/admin_script1.js"></script>
    </body>
</html>
