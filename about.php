<?php

require_once './model/config.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về Chúng Tôi</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Về Chúng tôi</h3>
        <p> <a href="index.php">Trang Chủ</a> / Về Chúng Tôi </p>
    </div>

    <section class="about">

        <div class="flex">

            <div class="image">
                <img src="images/about-img.jpg" alt="">
            </div>

            <div class="content">
                <h3>Tại sao chọn chúng tôi?</h3>
                <p>Bản thân công ty đã là một công ty rất thành công. Người được chọn trong cuộc sống, người mà khi bạn nhìn thấy rõ ràng, nơi mà cả lao động lẫn niềm vui đều không được đảm nhận, thì nên được thực hiện! Dễ thôi, những người khen ngợi!</p>
                <p>Bản thân nó đã là một nỗi đau và sẽ kéo theo đó là một người theo chủ nghĩa tinh hoa béo bở. Sự phân biệt sự thật cản trở ham muốn lạc thú, nơi mà lỗi lầm của tâm trí tìm kiếm, để chúng ta không bao giờ có lỗi với người hiền lành! Anh ta cũng không bị thúc đẩy bởi mong muốn theo đuổi những thú vui xa hơn.</p>
                <button class="btn-31">
  <span class="text-container">
    <a href="contact.php">Liên hệ ngay</a>
  </span>
</button>
            </div>

        </div>

    </section>

    <section class="reviews">

        <h1 class="title">Đánh giá của khách hàng</h1>

        <div class="box-container">

            <div class="box">
                <img src="images/bl1g5.png" alt="">
                <p>Sách hay mới xịn!!</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h3>Mr Tùng</h3>
            </div>

            <div class="box">
                <img src="images/bl1g5.png" alt="">
                <p>Sách bên này bán chất lượng tốt</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Mr Hào</h3>
            </div>

            <div class="box">
                <img src="images/user2.png" alt="">
                <p>Nhà tôi 3 đời đọc sách, đều mua sách trên web này</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Mrs Chi</h3>
            </div>

            <div class="box">
                <img src="images/bl1g5.png" alt="">
                <p>Ước tiệm sách này gần nhà để ngày nào cũng đọc</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h3>Mr Dũng</h3>
            </div>

            <div class="box">
                <img src="images/bl1g5.png" alt="">
                <p>Bán rất nhiều sách, rất ưng.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Mr Hòa</h3>
            </div>

            <div class="box">
                <img src="images/bl1g5.png" alt="">
                <p>Sách không dở, nhưng không cũ</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h3>Mrs Nhi</h3>
            </div>

        </div>

    </section>

    <section class="authors">

        <h1 class="title">Tác Giả</h1>

        <div class="box-container">

            <div class="box">
                <img src="images/thay.jpg" alt="">
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
                <h3>Mr Thích Nhất Hạnh</h3>
            </div>

            <div class="box">
                <img src="images/red_queen_au.jpg" alt="">
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
                <h3>Mrs Victoria Aveyard</h3>
            </div>

            <div class="box">
                <img src="images/dac_au.jpg" alt="">
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
                <h3>Mr Dale Carnegie</h3>
            </div>

            <div class="box">
                <img src="images/cam_au.jpg" alt="">
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
                <h3>José Mauro de Vasconcelos</h3>
            </div>

            <div class="box">
                <img src="images/tuoi_au.jpg" alt="">
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
                <h3>Mrs Rosie Nguyễn</h3>
            </div>

            <div class="box">
                <img src="images/thac.jpeg" alt="">
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
                <h3>Mr Nguyễn Ngọc Thạch</h3>
            </div>

        </div>

    </section>






    <?php include 'footer.php'; ?>

    <!-- custom js file link -->
    <script src="js/script.js"></script>

</body>

</html>