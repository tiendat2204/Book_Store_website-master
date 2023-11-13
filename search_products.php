<?php
include './controller/add_to_cart.php';

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
                        <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="qty">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
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

