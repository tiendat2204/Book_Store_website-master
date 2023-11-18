<?php
include "./controller/add_to_cart.php";
// Hàm để lấy số lượng bình luận cho một sản phẩm cụ thể
function getCommentCount($productId, $pdo)
{
    try {
        // Chuẩn bị truy vấn SQL để đếm số lượng bình luận cho sản phẩm có ID tương ứng
        $sql = "SELECT COUNT(*) AS comment_count FROM comment WHERE product_id = :product_id";

        // Chuẩn bị và thực thi truy vấn
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Trả về số lượng bình luận
        return $result['comment_count'];
    } catch (PDOException $e) {
        // Xử lý lỗi nếu có
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/loader.css">

    <!-- swiper css file cnd link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<link rel="stylesheet" href="css/style1.css">
<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>
<style>
    a{
        text-decoration: none;
    }
    
</style>
<body>



    <?php include 'header.php'; ?>
  
   <section class="home" id="home">
    <div class="swiper home-slider">
        <div class="swiper-wrapper">
            <div class="item swiper-slide">
                <img src="images/home4.jpeg" alt="" />
                <div class="content">
                    <h3>Đọc sách để thành công.</h3>
                    <p style="color: #000;">
                        Một quyển sách hay là đời sống xương máu quý giá của một tinh thần ướp hương và cất kín cho mai sau. (J.Milton)
                    </p>
                    <a href="about.php"><button class="white-btn">discover</button></a>
                </div>
            </div>

            <div class="item swiper-slide">
                <img src="images/home1.jpeg" alt="" />
                <div class="content">
                    <h3>Sách là cửa sổ tâm hồn</h3>
                    <p style="color: #000;">
                        Gặp được một quyển sách hay nên mua liền dù đọc được hay không đọc được, vì sớm muộn gì cũng cần đến nó. (W.Churchill)
                    </p>
                    <a href="shop.php"><button class="white-btn">discover</button></a>
                </div>
            </div>

            <div class="item swiper-slide">
                <img src="images/home2.webp" alt="" />
                <div class="content">
                    <h3>Một quyển sách hay</h3>
                    <p style="color: #000;">
                        Một cuốn sách hay cho ta một điều tốt, một người bạn tốt cho ta một điều hay (Gustavơ Lebon)
                    </p>
                    <a href="contact.php"><button class="white-btn">discover</button></a>
                </div>
            </div>

            <div class="item swiper-slide">
                <img src="images/home3.jpeg" alt="" />
                <div class="content">
                    <h3>Con đường thành công</h3>
                    <p style="color: #000;">
                        "Chính từ sách mà những người khôn ngoan tìm được sự an ủi khỏi những rắc rối của cuộc đời.” - Victor Hugo
                    </p>
                    <a href="#"><button class="white-btn">discover</button></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="products">
    <h1 class="title">Đề xuất</h1>
    <div class="box-container">
        <?php
        $select_products = $pdo->query("SELECT * FROM `products` LIMIT 8");

        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                // Get the number of comments for the current product.
                $productId = $fetch_products['id'];
                $commentCount = getCommentCount($productId, $pdo);

                ?>
                <form action="" method="post" class="box">
                    <a href="product_detail.php?product_id=<?php echo $fetch_products['id']; ?>">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                    </a>
                    <div class="name"><?php echo $fetch_products['name']; ?></div>
                    <div class="price"><?php echo number_format($fetch_products['price'], 0, ',', '.') . 'đ'; ?></div>
                    <div class="radio-input">
                        <input value="value-1" name="value-radio" id="value-1" type="radio" class="star s1" />
                        <input value="value-2" name="value-radio" id="value-2" type="radio" class="star s2" />
                        <input value="value-3" name="value-radio" id="value-3" type="radio" class="star s3" />
                        <input value="value-4" name="value-radio" id="value-4" type="radio" class="star s4" />
                        <input value="value-5" name="value-radio" id="value-5" type="radio" class="star s5" />
                    </div>

                    <div class="comment-count">
                        <span class="star-icon"></i></span>
                        Bình luận: <?php echo $commentCount; ?>
                    </div>
                    <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                    <input type="hidden" name="product_id" value="<?php echo isset($fetch_products['id']) ? $fetch_products['id'] : ''; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

                    <input type="submit" value="Thêm giỏ hàng" name="add_to_cart" class="btn1">
                </form>
            <?php
            }
        } else {
            echo '<p class="empty">no products added yet!</p>';
        }
        ?>
    </div>

    <div class="load-more" style="margin-top: 2rem; text-align:center">
        <button class="read-more">
            <a href="shop.php">Đọc thêm</a>
        </button>
    </div>
</section>

<section class="about">
    <div class="flex">
        <div class="image">
            <img src="images/about-img.jpg" alt="">
        </div>

        <div class="content">
            <h3>Về chúng tôi</h3>
            <p>"Vào khoảnh khắc mà chúng ta quyết thuyết phục đứa trẻ, bất cứ đứa trẻ nào, bước qua bậc thềm ấy, bậc thềm màu nhiệm dẫn vào thư viện, ta thay đổi cuộc sống của nó mãi mãi, theo cách tốt đẹp hơn.” - Barack Obama</p>
            <button class="btn-31">
                <span class="text-container">
                    <a href="about.php">Về chúng tôi</a>
                </span>
            </button>
        </div>
    </div>
</section>

<section class="content-section" id="portfolio">
    <div class="container px-4 px-lg-5">
        <div class="content-section-heading text-center">
            <h3 class="text-secondary mb-3">Tác giả đề xuất</h3>
            <h2 class="mb-5">Đề xuất tháng 11</h2>
        </div>
        <div class="row gx-0">
            <div class="col-lg-6">
                <a class="portfolio-item" href="#!">
                    <div class="caption">
                        <div class="caption-content">
                            <div class="h2">Thích Nhất Hạnh</div>
                            <p class="mb-0"> Hãy bước đi như thể bạn đang hôn Trái đất bằng bàn chân của mình.</p>
                        </div>
                    </div>
                    <img class="img-fluid" src="images/thay.jpg" alt="..." />
                </a>
            </div>
            <div class="col-lg-6">
                <a class="portfolio-item" href="#!">
                    <div class="caption">
                        <div class="caption-content">
                            <div class="h2">Dale Carnegie</div>
                            <p class="mb-0">Chỉ có bạn mới có thể đem lại sự bình yên cho chính bạn.</p>
                        </div>
                    </div>
                    <img class="img-fluid" src="images/dale-carnegie-gettyimages-515180032.jpg" alt="..." />
                </a>
            </div>
            <div class="col-lg-6">
                <a class="portfolio-item" href="#!">
                    <div class="caption">
                        <div class="caption-content">
                            <div class="h2">Rosie Nguyễn</div>
                            <p class="mb-0">Ta chỉ có một cuộc đời để sống, sao không làm những điều thực sự có ý nghĩa với bản thân ?</p>
                        </div>
                    </div>
                    <img class="img-fluid" src="images/travel-blogger-rosie-nguyen-1-1688954337.jpeg" alt="..." />
                </a>
            </div>
            <div class="col-lg-6">
                <a class="portfolio-item" href="#!">
                    <div class="caption">
                        <div class="caption-content">
                            <div class="h2"> Paulo Coelho</div>
                            <p class="mb-0">One day you will wake up and there won't be any more time to do the things you've always wanted. Do it now.</p>
                        </div>
                    </div>
                    <img class="img-fluid" src="images/Paulo-Coelho-nha-gia-kim.jpg" alt="..." />
                </a>
            </div>
        </div>
    </div>
</section>

<section class="home-contact">
    <div class="content">
        <h3>bạn có thắc mắc?</h3>
        <p>"Chúng ta sẽ trở thành gì phụ thuộc vào điều chúng ta đọc sau khi các thầy cô giáo đã xong việc với chúng ta. Trường học vĩ đại nhất chính là sách vở.” - Thomas Carlyle</p>
        <button class="contact-us">
            <span>
                <a href="contact.php" class="">Liên hệ chúng tôi</a>
            </span>
        </button>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Swiper JS file CDN link -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="js/add_to_cart.js"></script>

<!-- Custom JS file link -->
<script src="js/script.js"></script>
