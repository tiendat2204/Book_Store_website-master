<?php
require_once './controller/add_to_cart.php';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shop</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Đảm bảo bạn đã bao gồm jQuery -->
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    

</head>
<body>
    <?php include  'header.php'; ?>

    <div class="heading">
        <h3>Của hàng chúng tôi</h3>
        <p><a href="index.php">Trang Chủ</a> / Của Hàng </p>
    </div>

    <section class="products">
        <h1 class="title">Tất cả </h1>
        <div class="category">
    <div class="title_category">
        <span class="text-title">Danh mục sản phẩm</span>
    </div>
    <div class="sp" id="categoryLinks">
        <a href="shop.php?category_id=2" class="product_col">
            <img src="images/thieunhis2 (1).jpg" alt="">
            <div class="title_product">Tâm Lý</div>
        </a>
        
        <a href="shop.php?category_id=3" class="product_col">
            <img src="images/Thao_t_ng.jpg" alt="">
            <div class="title_product">Kinh Dị</div>
        </a>
        <a href="shop.php?category_id=1" class="product_col">
            <img src="images/T_m_linh.jpg" alt="">
            <div class="title_product">Động Vật</div>
        </a>
        <a href="shop.php?category_id=4" class="product_col">
            <img src="images/tpkds1.jpg" alt="">
            <div class="title_product">Đời Sống</div>
        </a>
        <a href="shop.php" class="product_col">
            <img src="images/_am_m_.jpg" alt="">
            <div class="title_product">Tất Cả</div>
        </a>
    </div>
</div>


        <div class="box-container" id="product-container">
            <?php
            
              if ($category_id !== null) {
                  $select_products = $pdo->prepare("SELECT * FROM `products` WHERE `category_id` = :category_id");
                  $select_products->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                  $select_products->execute();
              } else {
                  $select_products = $pdo->query("SELECT * FROM `products`");
              }

            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
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
                echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

<script src="js/category.js"></script>
    <script src="js/script.js"></script>

</body>
</html>
