<?php
include '../model/config.php';

if (isset($_POST['submit_reply'])) {
    $comment_id = $_POST['comment_id'];
    $reply_message = $_POST['reply_message'];

    $update_comment_query = $pdo->prepare("UPDATE `comment` SET reply_message = :reply_message WHERE id = :comment_id");
    $update_comment_query->bindParam(':reply_message', $reply_message, PDO::PARAM_STR);
    $update_comment_query->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
    if ($update_comment_query->execute()) {
        $_SESSION['messages'] = array('Phản hồi đã được gửi!');
        header('location: ../admin_comment.php');
        exit();
    } else {
        die('Truy vấn thất bại');
    }
}


?>