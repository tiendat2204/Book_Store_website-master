<?php 
include './model/config.php'; 
session_start(); 
$user_id = $_SESSION['user_id'] ?? null; 
$message = []; 
if (isset($_POST['send'], $user_id)) { 
    $number = $_POST['number']; 
    $msg = $_POST['message']; 
    $select_message = $pdo->prepare("SELECT * FROM `message` WHERE user_id = :user_id AND number = :number AND message = :msg"); 
    $select_message->execute([':user_id' => $user_id, ':number' => $number, ':msg' => $msg]); 
    if ($select_message->rowCount() > 0) { 
        $message[] = 'Tin nhắn chưa gửi!'; 
    } else { 
        $insert_message = $pdo->prepare("INSERT INTO `message` (user_id, number, message) VALUES (:user_id, :number, :msg)"); 
        $insert_message->execute([':user_id' => $user_id, ':number' => $number, ':msg' => $msg]); 
        $message[] = 'BookWorld sẽ trả lời qua Gmail !'; 
    } 
} elseif (!isset($user_id)) { 
    $message[] = 'Bạn cần đăng nhập để gửi tin nhắn'; 
} 
$_SESSION['messages'] = $message; 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>
    <link rel="icon" href="./images/logo.avif" type="image/png" >

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>liên hệ chúng tôi</h3>
    <p> <a href="index.php">trang chủ</a> / liên hệ </p>
</div>

<section class="contact">

    <form action="" method="post">
        <h3>Để lại Gmail</h3>
        <h3>BookWorld sẽ trả lời qua Gmail !</h3>

        <form action="" method="post">

    <input type="text" name="name" required placeholder="Tên" class="box" value="<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>">
    <input type="email" name="email" required placeholder="Email" class="box" value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>">
    <input type="number" name="number" required placeholder="Số điện thoại" class="box">
    <textarea name="message" class="box" placeholder="Tin nhắn" id="" cols="30" rows="10"></textarea>
    <input type="submit" value="gửi ngay" name="send" class="btn1">
</form>

</form>


</section>
<div id="map">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.4440936688493!2d106.62119134570102!3d10.853788130276968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752b6c59ba4c97%3A0x535e784068f1558b!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1701749082558!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

<?php include 'footer.php'; ?>

<!-- custom js file link -->
<script src="js/script.js"></script>

</body>

</html>
