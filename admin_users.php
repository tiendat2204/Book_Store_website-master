<?php
include './controller/UserCURD.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user data from the database based on the user_id
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
    <h1 class="title" style="margin: 30px 0px;">Tài khoản người dùng</h1>
    <?php if (isset($user)): ?>
        <section class="edit-user-container" id="editUserContainer">
            <h1 class="edit-user-title">Chỉnh sửa thông tin người dùng</h1>
            <form method="post" action="admin_users.php" class="edit-user-form">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <label for="name">Tên người dùng:</label>
                <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                <label for="user_type">Loại người dùng:</label>
                <select name="user_type" required>
                    <option value="user" <?php if ($user['user_type'] === 'user') echo 'selected'; ?>>Người dùng</option>
                    <option value="admin" <?php if ($user['user_type'] === 'admin') echo 'selected'; ?>>Admin</option>
                </select>
                <label for="status">Trạng thái tài khoản:</label>
<select name="status" required>
    <option value="active" <?php echo ($user['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
    <option value="blocked" <?php echo ($user['status'] == 'blocked') ? 'selected' : ''; ?>>Blocked</option>
</select>

                <button type="submit" name="edit_user">Lưu thay đổi</button>
                <a href="admin_users.php" class="cancel-btn">Hủy</a>
            </form>
        </section>
    <?php endif; ?>
    <section class="users">
    <a href="add_user.php" class="add-btn">Thêm người dùng</a>
    <table>
        <thead>
            <tr>
                <th>Trạng thái</th>
                <th>ID người dùng</th>
                <th>Tên người dùng</th>
                <th>Email</th>
                <th>Loại người dùng</th>
                <th>Chỉnh sửa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $stmt = $pdo->query("SELECT * FROM `users`");
                while ($fetch_users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td style="color:<?php echo ($fetch_users['status'] == 'blocked') ? 'var(--red)' : 'var(--green)'; ?>">
                            <?php echo ucfirst($fetch_users['status']); ?>
                        </td>
                        <td><?php echo $fetch_users['id']; ?></td>
                        <td><?php echo $fetch_users['name']; ?></td>
                        <td><?php echo $fetch_users['email']; ?></td>
                        <td style="color:<?php echo ($fetch_users['user_type'] == 'admin') ? 'var(--orange)' : 'inherit'; ?>">
                            <?php echo $fetch_users['user_type']; ?>
                        </td>
                        <td>
                            <a href="admin_users.php?edit=<?php echo $fetch_users['id']; ?>" data-user-id="<?php echo $fetch_users['id']; ?>" class="edit-btn">Chỉnh sửa người dùng</a>
                        </td>
                    </tr>
                    <?php
                }
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
            }
            ?>
        </tbody>
    </table>
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
                    <button class="btn-user" type="submit" name="add_user">Thêm người dùng</button>
                    <button type="button" class="btn-user" onclick="cancelAddUser()"> Hủy </button>
                </div>
            </form>
        </div>
    </section>
    <script src="js/admin_script1.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editButtons = document.querySelectorAll('.edit-btn');
            var editUserContainer = document.getElementById('editUserContainer');

            editButtons.forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault(); 

                    var userId = button.getAttribute('data-user-id');
                    window.location.href = 'admin_users.php?id=' + userId;
                });
            });
            <?php if (isset($user)): ?>
            editUserContainer.style.display = 'block';
            <?php endif; ?>
        });
    </script>
</body>
</html>
