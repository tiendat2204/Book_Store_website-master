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
        $delete_statement = $pdo->prepare("DELETE FROM `message` WHERE id = :delete_id");
        $delete_statement->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $delete_statement->execute();
        $_SESSION['messages'] = array('Xóa tin nhắn thành công!');

        header('location:admin_contacts.php');
exit();
    } catch (PDOException $e) {
        die('Query failed: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin nhắn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">

</head>
<style>
    textarea {
    height: 100px;
    margin-bottom: 16px;
    border-radius: 10px;
    width: 250px;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

</style>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="messages">

        <h1 class="title">Tin nhắn</h1>
        <div id="replyModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="./controller/send_reply_mail.php" method="post">
            <label for="reply_message">Nội dung trả lời:</label>
            <textarea name="reply_message" id="reply_message" rows="4" required></textarea>
            <input type="hidden" name="message_id" id="message_id">
            <input type="submit" name="submit_reply" value="Gửi trả lời">
        </form>
    </div>
</div>
        <table>
    <thead>
        <tr>
            <th>ID người dùng</th>
            <th>Tên người dùng</th>
            <th>Email người dùng</th>
            <th>Số điện thoại người dùng</th>
            <th>Nội dung tin nhắn</th>
            <th>Xóa tin nhắn</th>
            <th>Phản hồi</th>

        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $select_message = $pdo->query("SELECT message.*, users.name AS user_name, users.email AS user_email, users.phone AS user_phone FROM `message` INNER JOIN `users` ON message.user_id = users.id");

            if ($select_message->rowCount() > 0) {
                while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?php echo $fetch_message['user_id']; ?></td>
                        <td><?php echo $fetch_message['user_name']; ?></td>
                        <td><?php echo $fetch_message['user_email']; ?></td>
                        <td><?php echo $fetch_message['user_phone']; ?></td>
                        <td><?php echo $fetch_message['message']; ?></td>
                        <td>
                            <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>"
                               onclick="return confirm('Xóa tin nhắn này?');" class="delete-btn">Xóa tin nhắn</a>
                        </td>
                        <td>
                                   
                                    <a href="#" class="reply-btn" data-message-id="<?php echo $fetch_message['id'];
                                     ?>">Trả lời</a>
                                </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="6" class="empty">Bạn không có tin nhắn nào!</td></tr>';
            }
        } catch (PDOException $e) {
            die('Truy vấn thất bại: ' . $e->getMessage());
        }
        ?>
    </tbody>
</table>


    </section>
    <script src="js/admin_script1.js"></script>
    <script>
    const replyButtons = document.querySelectorAll('.reply-btn');
    const replyModal = document.getElementById('replyModal');
    const closeModal = document.querySelector('.close');
    const messageIDInput = document.getElementById('message_id');

    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const messageID = this.getAttribute('data-message-id');
            messageIDInput.value = messageID;
            replyModal.style.display = 'block';
        });
    });

    closeModal.addEventListener('click', function() {
        replyModal.style.display = 'none';
    });

    window.onclick = function(event) {
        if (event.target == replyModal) {
            replyModal.style.display = 'none';
        }
    };
</script>
</body>

</html>
