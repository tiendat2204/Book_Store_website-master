<?php
    include './controller/UserCURD.php';

?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Users</title>

        <!-- Font Awesome CDN link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Custom admin CSS file link -->
        <link rel="stylesheet" href="css/admin_style.css">
    </head>

    <body>
        <?php include 'admin_header.php'; ?>

        <section class="users">
            <h1 class="title">Tài khoản người dùng</h1>
            <a href="add_user.php" class="add-btn">Thêm người dùng</a>

            <div class="box-container">
                <?php
                    try {
                        // Sử dụng biến kết nối từ tệp cấu hình
                        $stmt = $pdo->query("SELECT * FROM `users`");
                        while ($fetch_users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                            <div class="box">
                                <p>ID người dùng: <span><?php echo $fetch_users['id']; ?></span></p>
                                <p>Tên người dùng: <span><?php echo $fetch_users['name']; ?></span></p>
                                <p>Email: <span><?php echo $fetch_users['email']; ?></span></p>
                                <p>Loại người dùng: <span style="color:<?php if ($fetch_users['user_type'] == 'admin') { echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span></p>
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
        </section>

        <section class="container_user" style="display: none;">
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
                        <button class="btn-user" type="submit">Thêm người dùng</button>
                        <button type="button" class="btn-user" onclick="cancelAddUser()"> Hủy </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Custom admin JS file link -->
        <script src="js/admin_script1.js"></script>
    </body>
</html>

