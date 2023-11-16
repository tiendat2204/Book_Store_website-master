<?php
include './model/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $password = $_POST['password'];
    $hashed_password = md5($password);

    try {
        $stmt = $pdo->prepare("INSERT INTO `users` (name, email, password, user_type) VALUES (:name, :email, :password, :user_type)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':user_type', $user_type, PDO::PARAM_STR);
        $stmt->execute();

        header('location:admin_users.php');
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
    <title>Thêm người dùng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>

    <?php include 'admin_header.php'; ?>
    <section class="container_user">
        <div class="user_add">
            <h1>Thêm tài khoản</h1>
            <form method="post" action="">
                <div class="inputGroup">
                    <input type="text" required="" autocomplete="off" id="name" name="name">
                    <label for="name">Tên</label>
                </div>

                <div class="inputGroup">
                    <input type="email" required="" autocomplete="off" id="email" name="email">
                    <label for="email">Email</label>
                </div>

                <div class="inputGroup">
                    <input type="text" required="" autocomplete="off" id="user_type" name="user_type">
                    <label for="user_type">Loại người dùng (User-Admin)</label>
                </div>

                <div class="inputGroup">
                    <input type="password" required="" autocomplete="off" id="password" name="password">
                    <label for="password">Mật khẩu</label>
                </div>

                <div class="inputGroup">
                <button class="btn-user" type="submit"> Thêm người dùng
</button>
                </div>
            </form>
        </div>
    </section>

    <script src="js/admin_script1.js"></script>
</body>

</html>
