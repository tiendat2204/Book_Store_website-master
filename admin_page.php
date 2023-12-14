<?php
include './model/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

$categories = [];
$select_categories = $pdo->query("SELECT name FROM `categories`");
while ($row = $select_categories->fetch(PDO::FETCH_ASSOC)) {
    $categories[] = $row['name'];
}

$productCounts = [];

foreach ($categories as $category) {
    $select_products = $pdo->prepare("SELECT COUNT(*) as count FROM `products` WHERE category_id = (SELECT id FROM `categories` WHERE name = :category)");
    $select_products->bindParam(':category', $category);
    $select_products->execute();
    $result = $select_products->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];
    array_push($productCounts, $count);
}

$number_of_comments = $pdo->query("SELECT COUNT(*) FROM `comment`")->fetchColumn();

$number_of_products = $pdo->query("SELECT COUNT(*) FROM `products`")->fetchColumn();

$number_of_users = $pdo->query("SELECT COUNT(*) FROM `users` WHERE user_type = 'user'")->fetchColumn();

$number_of_admins = $pdo->query("SELECT COUNT(*) FROM `users` WHERE user_type = 'admin'")->fetchColumn();

$number_of_account = $pdo->query("SELECT COUNT(*) FROM `users`")->fetchColumn();

$number_of_messages = $pdo->query("SELECT COUNT(*) FROM `message`")->fetchColumn();
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

    <h1 class="title">Bảng điều khiển</h1>



        <div class="box-container">
            

            <div class="box">
                <?php
                $total_pendings = 0;
                $select_pending = $pdo->prepare("SELECT SUM(total_price) as total_price FROM `orders` WHERE payment_status = 'Đợi xác nhận'");
                $select_pending->execute();
                $total_pendings = $select_pending->fetchColumn();
                ?>
             <h3><?php echo number_format($total_pendings, 0, ',', '.') . 'đ'; ?></h3>

                <p>Đang xử lí</p>
            </div>

            <div class="box">
                <?php
                $total_completed = 0;
                $select_completed = $pdo->prepare("SELECT SUM(total_price) as total_price FROM `orders` WHERE payment_status = 'Đã giao hàng'");
                $select_completed->execute();
                $total_completed = $select_completed->fetchColumn();
                ?>
              <h3><?php echo number_format($total_completed, 0, ',', '.') . 'đ'; ?></h3>
                <p>thanh toán hoàn tất</p>
            </div>

            <div class="box">
                <?php
                $number_of_orders = $pdo->query("SELECT COUNT(*) FROM `orders`")->fetchColumn();
                ?>
                <h3><?php echo $number_of_orders; ?></h3>
                <p>Đang đặt hàng</p>
            </div>

            <div class="box">
                <h3><?php echo $number_of_products; ?></h3>
                <p>Tổng sản phẩm</p>
            </div>

            <div class="box">
                <h3><?php echo $number_of_users; ?></h3>
                <p>Người dùng</p>
            </div>

            <div class="box">
                <h3><?php echo $number_of_comments; ?></h3>
                <p>Số bình luận</p>
            </div>

            <div class="box">
                <h3><?php echo $number_of_account; ?></h3>
                <p>Tổng số người dùng  </p>
            </div>

            <div class="box">
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
   
   var doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
var doughnutData = {
    labels: <?php echo json_encode($categories); ?>,
    datasets: [{
        data: <?php echo json_encode($productCounts); ?>,
        backgroundColor: [
      'rgba(155, 99, 132, 0.5)',
      'rgba(55, 192, 192, 0.5)',
      'rgba(255, 205, 86, 0.5)',
      'rgba(54, 162, 235, 0.5)',
      'rgba(255, 159, 64, 0.5)',
      'rgba(13, 102, 255, 0.5)',
      'rgba(255, 99, 132, 0.5)',
      'rgba(75, 192, 192, 0.5)',
      'rgba(355, 205, 86, 0.5)',
      'rgba(54, 162, 235, 0.5)'
    ],
    borderColor: [
      'rgba(155, 99, 132, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(255, 205, 86, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 159, 64, 1)',
      'rgba(153, 102, 255, 1)',
      'rgba(255, 99, 132, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(255, 205, 86, 1)',
      'rgba(54, 162, 235, 1)'
    ],
    borderWidth: 1
    }]
};
var doughnutChart = new Chart(doughnutCtx, {
    type: 'doughnut',
    data: doughnutData,
    options: {
        responsive: false,
    }
});


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


