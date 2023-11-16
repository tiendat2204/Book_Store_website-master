<?php
include '../model/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if (isset($_POST['submit'])) {
    $email = $_POST['forgot_email'];

    // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu hay không
    $select_users = $pdo->prepare("SELECT * FROM `users` WHERE email = :email");
    $select_users->bindParam(':email', $email, PDO::PARAM_STR);
    $select_users->execute();

    if ($select_users->rowCount() > 0) {
        // Tạo mã xác nhận ngẫu nhiên
        $token = bin2hex(random_bytes(32));

        // Lưu mã xác nhận vào cơ sở dữ liệu
        $update_users = $pdo->prepare("UPDATE `users` SET token = :token WHERE email = :email");
        $update_users->bindParam(':token', $token, PDO::PARAM_STR);
        $update_users->bindParam(':email', $email, PDO::PARAM_STR);
        $update_users->execute();

        // Gửi email chứa mã xác nhận đến địa chỉ email của người dùng
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'Datboyngeo@gmail.com';                 // SMTP username
            $mail->Password   = 'zmcglyrjbfxgoxfe';                   // SMTP password
            $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('Datboyngeo@gmail.com', 'Shopcucoi');
            $mail->addAddress($email);                                  // Add a recipient

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'Restart password!';
            $mail->Body    = 'Hãy bấm vào liên kết bên để khôi phục mật khẩu: <a href="http://localhost:3000/xampp/htdocs/Book_Store_website-master/reset_password.php?email=' . $email . '&token=' . $token . '">Reset Password</a>';
            $mail->send();
           
            echo "Thư đặt đã được gửi đến địa chỉ email của bạn.";
        } catch (Exception $e) {
            echo 'Lỗi: ' . $mail->ErrorInfo;
        }
    } else {
        echo "Email không tồn tại.";
    }
}
?>
