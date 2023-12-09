<?php
include "./model/config.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = :user_id";
$statement = $pdo->prepare($query);
$statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/logo.avif" type="image/png" >

    <title>Thông tin cá nhân</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.8/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        a{
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="center-block">
        <div class="container-xl px-4 mt-4">
            <hr class="mt-0 mb-4">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Ảnh đại diện</div>
                        <div class="card-body text-center">
                            <img class="img-account-profile rounded-circle mb-2" src="<?php echo 'uploaded_img/' . $user['avatar']; ?>" alt="Profile Picture">
                            <div class="small font-italic text-muted mb-4">Ảnh không vượt quá 5MB</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card mb-4">
                        <div class="card-header">Chi tiết tài khoản</div>
                        <div class="card-body">
                            <form action="./controller/update_profile.php" method="post" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label class="small mb-2" for="inputUsername">Tên </label>
                                    <input class="form-control" id="inputUsername" type="text" name="username" placeholder="Enter your username" value="<?= $user['name']; ?>">
                                </div>
                                <div class="mb-4">
                                    <label class="small mb-2" for="inputPassword">Mật khẩu</label>
                                    <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Nhập mật khẩu mới">
                                </div>
                                <div class="mb-4">
                                    <label class="small mb-2" for="inputLocation">Địa chỉ</label>
                                    <input class="form-control" id="inputLocation" type="text" name="location" placeholder="Enter your location" value="<?= $user['location']; ?>">
                                </div>
                                <div class="mb-4">
                                    <label class="small mb-2" for="inputEmailAddress">Email </label>
                                    <input class="form-control" id="inputEmailAddress" type="email" name="email" placeholder="Enter your email address" value="<?= $user['email']; ?>">
                                </div>
                                <div class="mb-4">
                                    <label class="small mb-2" for "inputPhone">Số điện thoại</label>
                                    <input class="form-control" id="inputPhone" type="tel" name="phone" placeholder="Enter your phone number" value="<?= $user['phone']; ?>">
                                    <input type="file" name="avatar" style="margin-top: 8px;">
                                </div>

                                <button class="btn btn-primary" type="submit" name="save_changes">Lưu thay đổi</button>
                            </form>
                        </div> 
                    </div>
                </div>
                <h3>Lịch sử mua hàng:</h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php
        $order_query = $pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $order_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $order_query->execute();

        if ($order_query->rowCount() > 0) {
            while ($order = $order_query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="order-history-item">
                    <div class="order-details">
                        <p class="order-info">Mã đơn hàng: <strong><?= $order['id']; ?></strong></p>
                        <p class="order-info">Ngày đặt hàng: <strong><?= $order['placed_on']; ?></strong></p>
                        <p class="order-info">Tổng giá: <strong><?= number_format($order['total_price'], 0, ',', '.') . ' VND'; ?></strong></p>
                        <p class="order-info">Trạng thái thanh toán: <strong><?= $order['payment_status']; ?></strong></p>
                        <button type="button" class="btn btn-primary view-details-btn" onclick="viewOrderDetails(<?= $order['id']; ?>)">Xem Chi Tiết</button>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p>Chưa có lịch sử mua hàng!</p>';
        }
        ?>
    </div>
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content " style="top: 175px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">Chi Tiết Đơn Hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="orderDetailsContent">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include 'footer.php'; ?>
<script src="js/lichsudonhang.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-c1lBu3F3k5IgWbZgoBgFqTKw9wvmhLvF9R+taAM8l8iRAV9H8V0wZI+CcBEQ8Rc" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>
