<?php
// Đảm bảo rằng người dùng đã đăng nhập trước khi truy cập trang profile
include "./model/config.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}




// Truy vấn thông tin người dùng dựa trên user_id
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
    <title>Thông tin cá nhân</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 <!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.8/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->


    <!-- custom css file link  -->
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
    <!-- Account page navigation-->
  
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Ảnh đại diện</div>
                <div class="card-body text-center">
    <!-- Hiển thị ảnh hồ sơ -->
    <img class="img-account-profile rounded-circle mb-2" src="<?php echo 'uploaded_img/' . $user['avatar']; ?>" alt="Profile Picture">
    <!-- Profile picture help block-->
    <div class="small font-italic text-muted mb-4">Ảnh không vượt quá 5MB</div>
</div>

            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Chi tiết tài khoản</div>
                <div class="card-body">
                <form action="./controller/update_profile.php" method="post" enctype="multipart/form-data">
    <!-- Form Group (username) -->
    <div class="mb-4">
        <label class="small mb-2" for="inputUsername">Tên </label>
        <input class="form-control" id="inputUsername" type="text" name="username" placeholder="Enter your username" value="<?php echo $user['name']; ?>">
    </div>

  
<!-- Form Group (mật khẩu) -->
<div class="mb-4">
    <label class="small mb-2" for="inputPassword">Mật khẩu</label>
    <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Nhập mật khẩu mới">
</div>

    <!-- Form Group (location) -->
    <div class="mb-4">
        <label class="small mb-2" for="inputLocation">Địa chỉ</label>
        <input class="form-control" id="inputLocation" type="text" name="location" placeholder="Enter your location" value="<?php echo $user['location']; ?>">
    </div>

    <!-- Form Group (email address) -->
    <div class="mb-4">
        <label class="small mb-2" for="inputEmailAddress">Email </label>
        <input class="form-control" id="inputEmailAddress" type="email" name="email" placeholder="Enter your email address" value="<?php echo $user['email']; ?>">
    </div>

    <!-- Form Group (phone number) -->
    <div class="mb-4">
        <label class="small mb-2" for "inputPhone">Số điện thoại</label>
        <input class="form-control" id="inputPhone" type="tel" name="phone" placeholder="Enter your phone number" value="<?php echo $user['phone']; ?>">
        <input type="file" name="avatar"style="margin-top: 8px;">
    </div>
    <!-- Save changes button -->
    <button class="btn btn-primary" type="submit" name="save_changes" >Lưu thay đổi</button>
</form>


                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>
