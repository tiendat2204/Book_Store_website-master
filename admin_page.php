<?php
include './controller/dashboard.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Thư viện Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Tệp CSS tùy chỉnh của bạn -->
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <!-- admin dashboard section starts -->

    <section class="dashboard">

        <h1 class="title">dashboard</h1>

        <div class="box-container">

            <div class="box">
                <?php
                $total_pendings = 0;
                $select_pending = $pdo->prepare("SELECT total_price FROM
                `orders` WHERE payment_status = 'pending'");
                $select_pending->execute();
                $fetch_pendings = $select_pending->fetchAll(PDO::FETCH_ASSOC);
                foreach ($fetch_pendings as $pending) {
                    $total_price = $pending['total_price'];
                    $total_pendings += $total_price;
                }
                ?>
                <h3>$<?php echo $total_pendings; ?>/-</h3>
                <p>Đang xử lí</p>
            </div>

            <div class="box">
                <?php
                $total_completed = 0;
                $select_completed = $pdo->prepare("SELECT total_price FROM
                `orders` WHERE payment_status = 'completed'");
                $select_completed->execute();
                $fetch_completed = $select_completed->fetchAll(PDO::FETCH_ASSOC);
                foreach ($fetch_completed as $completed) {
                    $total_price = $completed['total_price'];
                    $total_completed += $total_price;
                }
                ?>
                <h3>$<?php echo $total_completed; ?>/-</h3>
                <p>thanh toán hoàn tất</p>
            </div>

            <div class="box">
                <?php
                $select_orders = $pdo->query("SELECT * FROM `orders`");
                $number_of_orders = $select_orders->rowCount();
                ?>
                <h3><?php echo $number_of_orders; ?></h3>
                <p>Đang đặt hàng</p>
            </div>

            <div class="box">
                <?php
                $select_products = $pdo->query("SELECT * FROM `products`");
                $number_of_products = $select_products->rowCount();
                ?>
                <h3><?php echo $number_of_products; ?></h3>
                <p>Tổng sản phẩm</p>
            </div>

            <div class="box">
                <?php
                $select_users = $pdo->prepare("SELECT * FROM `users` WHERE user_type = 'user'");
                $select_users->execute();
                $number_of_users = $select_users->rowCount();
                ?>
                <h3><?php echo $number_of_users; ?></h3>
                <p>Người dùng</p>
            </div>

            <div class="box">
                <?php
                $select_admins = $pdo->prepare("SELECT * FROM `users` WHERE user_type = 'admin'");
                $select_admins->execute();
                $number_of_admins = $select_admins->rowCount();
                ?>
                <h3><?php echo $number_of_admins; ?></h3>
                <p>Quản trị viên</p>
            </div>
            <div class="box">
    <h3><?php echo $number_of_comments; ?></h3>
    <p>Số bình luận</p>
</div>

            <div class="box">
                <?php
                $select_account = $pdo->query("SELECT * FROM `users`");
                $number_of_account = $select_account->rowCount();
                ?>
                <h3><?php echo $number_of_account; ?></h3>
                <p>Tổng số người dùng  </p>
            </div>

            <div class="box">
                <?php
                $select_messages = $pdo->query("SELECT * FROM `message`");
                $number_of_messages = $select_messages->rowCount();
                ?>
                <h3><?php echo $number_of_messages; ?></h3>
                <p>các tin nhắn mới</p>
            </div>
          
              
            </div>
                <div class="chart">

                    <canvas id="doughnutChart" width="500" height="500"></canvas>
                    <canvas id="lineChart" width="500" height="250"></canvas>
                </div>
        </div>
    </section>

    <script>
    // Lấy thẻ <canvas> cho biểu đồ Doughnut
    var doughnutCtx = document.getElementById('doughnutChart').getContext('2d');

var doughnutData = {
   
    labels: ['TÂM LÝ', 'KINH DỊ', 'ĐỜI SỐNG', 'ĐỘNG VẬT'], // Đặt nhãn tùy chọn cho các danh mục
    datasets: [{
        data: [
            <?php echo $productCounts[0]; ?>,
            <?php echo $productCounts[1]; ?>,
            <?php echo $productCounts[2]; ?>,
            <?php echo $productCounts[3]; ?>
        ],
        backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(255, 205, 86, 0.5)', 'rgba(54, 162, 235, 0.5'],
        borderColor: ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255, 205, 86, 1)', 'rgba(54, 162, 235, 1)'],
        borderWidth: 1
    }]
};

var doughnutChart = new Chart(doughnutCtx, {
    type: 'doughnut',
    data: doughnutData,
    options: {
        responsive: false, // Để kích thước cố định
    }
});
    // Lấy thẻ <canvas> cho biểu đồ sóng
    var lineCtx = document.getElementById('lineChart').getContext('2d');

var lineData = {
    labels: ['Sản phẩm', 'Người dùng', 'Tổng số người dùng'],
    datasets: [{
        label: 'Biểu đồ sóng',
        data: [
            <?php echo $number_of_products; ?>,
            <?php echo $number_of_users; ?>,
            <?php echo $number_of_account; ?>
        ],
        fill: false,
        borderColor: 'RED',
        borderWidth: 2
    }]
};

var lineChart = new Chart(lineCtx, {
    type: 'line',
    data: lineData,
    options: {
        responsive: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>


</body>

</html>