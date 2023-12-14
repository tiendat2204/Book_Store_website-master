<?php
include '../model/config.php';
function getCommentCount($productId, $pdo)
{
    $sql = "SELECT COUNT(*) AS comment_count FROM comment WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['comment_count'];
}
$category_id = $_GET['category_id'] ?? null;

$select_products = $pdo->prepare("SELECT * FROM `products` WHERE `category_id` = :category_id");
$select_products->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$select_products->execute();

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
<?php
}
?>