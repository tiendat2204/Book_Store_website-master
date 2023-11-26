<?php
include './controller/add_to_cart.php';

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

if (isset($_POST['search'])) {
    $search_item = $_POST['search'];
    $category = $_POST['category'];
    $sort_by = $_POST['sort_by'];

    // Tạo câu truy vấn dựa trên thông tin tìm kiếm và sắp xếp
    $query = "SELECT * FROM `products` WHERE name LIKE :search_item";

    if (!empty($category) && $category !== "Tất cả danh mục") {
        $query .= " AND category_id = :category";
    }

    if ($sort_by === "asc") {
        $query .= " ORDER BY price ASC";
    } elseif ($sort_by === "desc") {
        $query .= " ORDER BY price DESC";
    }

    $select_products = $pdo->prepare($query);
    $select_products->bindValue(':search_item', '%' . $search_item . '%', PDO::PARAM_STR);

    if (!empty($category) && $category !== "Tất cả danh mục") {
        $select_products->bindValue(':category', $category, PDO::PARAM_STR);
    }

    $select_products->execute();

    if ($select_products->rowCount() > 0) {
        while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            // Hiển thị kết quả tìm kiếm ở đây
            ?>
            <form action="" method="post" class="box">
                <a href="product_detail.php?product_id=<?php echo $fetch_product['id']; ?>">
                    <img class="image" src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
                </a>
                <div class="name"><?php echo $fetch_product['name']; ?></div>
                <div class="price"><?php echo number_format($fetch_product['price'], 0, ',', '.') ; ?>đ</div>
                <div class="radio-input">
                    <input value="value-1" name="value-radio" id="value-1" type="radio" class="star s1" />
                    <input value="value-2" name="value-radio" id="value-2" type="radio" class="star s2" />
                    <input value="value-3" name="value-radio" id="value-3" type="radio" class="star s3" />
                    <input value="value-4" name="value-radio" id="value-4" type="radio" class="star s4" />
                    <input value="value-5" name="value-radio" id="value-5" type="radio" class="star s5" />
                </div>
                <div class="price-discount">
                    <?php
                    $originalPrice = $fetch_product['price'];
                    $discount = $fetch_product['discount'];
                    $discountedPrice = $originalPrice - ($originalPrice * $discount / 100);
                    echo number_format($discountedPrice, 0, ',', '.') . 'đ';
                    ?>
                </div>
                <div class="comment-count">
                    <span class="star-icon"></i></span>
                    Bình luận: <?php echo getCommentCount($fetch_product['id'], $pdo); ?>
                </div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                <input type="submit" value="Thêm giỏ hàng" name="add_to_cart" class="btn1">
            </form>
            <?php
        }
    } else {
        echo '<p class="empty">Không có kết quả!</p>';
    }
} else {
    echo '<p class="empty">Tìm Kiếm Thứ Gì Đó!</p>';
}
?>
