<?php
require_once './controller/add_to_cart.php';
$category_id = $_GET['category_id'] ?? null;

function getCommentCount($productId, $pdo)
{
    $sql = "SELECT COUNT(*) AS comment_count FROM comment WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['comment_count'];
}
function getCategories($pdo)
{
    $categories_query = $pdo->query("SELECT * FROM categories");
    return $categories_query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>shop</title>
    <link rel="icon" href="./images/logo.avif" type="image/png" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include  'header.php'; ?>

    <div class="heading">
        <h3>Cửa hàng chúng tôi</h3>
        <p><a href="index.php">Trang Chủ</a> / Cửa Hàng </p>
    </div>

    <section class="products cate">
    <!-- Sidebar-->
<aside class="category1">
    <div class="title-category">
        <span class="text-title">Danh mục sản phẩm</span>
    </div>
    <div class="category-list" id="categoryLinks">
                <?php
                $categories = getCategories($pdo);
                foreach ($categories as $category) {
                    ?>
                    <a href="" class="category-item"  data-category-id="<?php echo $category['id']; ?>">
                        <div class="category-title"><?php echo $category['name']; ?></div>
                    </a>
                    <?php
                }
                ?>
            </div>
</aside>


</div>

<div class="box-container" id="product-container">
    <?php
      $select_products = $pdo->query($category_id !== null ? "SELECT * FROM `products` WHERE `category_id` = $category_id" : "SELECT * FROM `products`");
      while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
          $productId = $fetch_products['id'];
          $commentCount = getCommentCount($productId, $pdo);
          $productStatus = $fetch_products['status_products'];

    ?>
            <form action="" method="post" class="box">
                <a href="product_detail.php?product_id=<?php echo $fetch_products['id']; ?>">
                    <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                </a>
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <div class="price"><?php echo number_format($fetch_products['price'], 0, ',', '.') . 'đ'; ?></div>
                <div class="price-discount">
                    <?php
                    $originalPrice = $fetch_products['price'];
                    $discount = $fetch_products['discount'];
                    $discountedPrice = $originalPrice - ($originalPrice * $discount / 100);
                    echo number_format($discountedPrice, 0, ',', '.') . 'đ';
                    ?>
                </div>
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
                <?php
                if ($productStatus === 'có sẵn') {
                    ?>
                    <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                    <input type="hidden" name="product_id" value="<?php echo isset($fetch_products['id']) ? $fetch_products['id'] : ''; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                    <input type="submit" value="Thêm giỏ hàng" name="add_to_cart" class="btn1">
                <?php
                } elseif ($productStatus === 'ngưng kinh doanh') {
                    ?>
                    <button type="button" class="out-of-business-btn">Ngừng kinh doanh</button>
                <?php
                } elseif ($productStatus === 'hết hàng') {
                    ?>
                    <button type="button" class="out-of-stock-btn">Hết hàng</button>
                <?php
                }
                ?>
            </form>
    <?php } ?>
</div>
</section>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
    $('.category-item').click(function(e) {
        e.preventDefault();
        var categoryId = $(this).data('category-id');
        $.ajax({
            url: './controller/c_category.php',
            type: 'GET',
            data: { category_id: categoryId },
            success: function(response) {
                $('#product-container').html(response);
            }
        });
    });
});
</script>
<script src="js/script.js"></script>

</body>
</html>