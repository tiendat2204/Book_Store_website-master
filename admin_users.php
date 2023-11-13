<?php
include './model/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    try {
        // Sử dụng biến kết nối từ file config
        $stmt = $pdo->prepare("DELETE FROM `users` WHERE id = :delete_id");
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();

        $message[] = 'Xóa người dùng thành công!';
        
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="users">

<h1 class="title"> Tài khoản người dùng </h1>

<div class="box-container">

    <?php
    try {
        // Sử dụng biến kết nối từ tệp cấu hình
        $stmt = $pdo->query("SELECT * FROM `users`");
        while ($fetch_users = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <div class="box">
            <p> ID người dùng : <span><?php echo $fetch_users['id']; ?></span> </p>
            <p> Tên người dùng : <span><?php echo $fetch_users['name']; ?></span> </p>
            <p> Email : <span><?php echo $fetch_users['email']; ?></span> </p>
            <p> Loại người dùng : <span style="color:<?php if ($fetch_users['user_type'] == 'admin') {
                                                    echo 'var(--orange)';
                                                } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
                                                
            <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Xóa người dùng này?');" class="delete-btn">Xóa người dùng</a>
            <a href="edit_user.php?id=<?php echo $fetch_users['id']; ?>" class="edit-btn">Chỉnh sửa người dùng</a>

        </div>
    <?php
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
    ?>
</div>
<a href="add_user.php" class="add-btn">Thêm người dùng</a>

</section>


    <!-- custom admin js file link  -->
    <script src="js/admin_script1.js"></script>
</body>

</html>