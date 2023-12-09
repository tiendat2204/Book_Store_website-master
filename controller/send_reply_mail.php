<?php
session_start();
include '../model/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if (isset($_POST['submit_reply'])) {
    $message_id = $_POST['message_id'];
    $reply_message = $_POST['reply_message'];

    try {
        $message_query = $pdo->prepare("SELECT message.*, users.email AS user_email FROM `message` INNER JOIN `users` ON message.user_id = users.id WHERE message.id = :message_id");
        $message_query->bindParam(':message_id', $message_id, PDO::PARAM_INT);
        $message_query->execute();

        if ($message_query->rowCount() > 0) {
            $message_data = $message_query->fetch(PDO::FETCH_ASSOC);
            $user_email = $message_data['user_email'];

            $mail = new PHPMailer(true);

            // Cài đặt máy chủ
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'Datboyngeo@gmail.com';                 // SMTP username
            $mail->Password   = 'zmcglyrjbfxgoxfe';                   // SMTP password
            $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            // Người nhận
            $mail->setFrom('Datboyngeo@gmail.com', 'Bookworld');
            $mail->addAddress($user_email);

  
$mail->isHTML(true);
$mail->Subject = 'Phản hồi từ Book World';


$customer_message = $message_data['message'];


$mail->Body = "
    <html>
    <head>
        <title>Phản hồi từ Book World</title>
    </head>
    <body>
        <p>Chào bạn,</p>
        <p>Dưới đây là nội dung tin nhắn mà bạn đã gửi cho chúng tôi:</p>
        <blockquote>
            $customer_message
        </blockquote>
        <p>Dưới đây là phản hồi của chúng tôi về tin nhắn của bạn:</p>
        <blockquote>
            $reply_message
        </blockquote>
        <p>Xin cảm ơn bạn đã liên hệ với chúng tôi.</p>
        <p>Trân trọng,</p>
        <p>Book World Team</p>
    </body>
    </html>
";


            $mail->send();
            $_SESSION['messages'] = array('Đã gửi phản hồi thành công!');
        } else {
            $_SESSION['messages'] = array('Gửi phản hồi thất bại!!');
        }

        header('location: ../admin_contacts.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['messages'] = array('Không thể gửi tin nhắn. Lỗi Mailer: ' . $mail->ErrorInfo);
        header('location:../admin_contacts.php');
        exit();
    }
} else {
    header('location: ../admin_contacts.php');
    exit();
}
?>
