<?php

include './controller/add_to_cart.php';
$categories_query = $pdo->query("SELECT * FROM categories");
$categories = $categories_query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Tìm Kiếm</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Trang Tìm </h3>
        <p> <a href="index.php">Trang Chủ</a> / Tìm Kiếm </p>
    </div>

    <section class="search-form">
    <form action="" method="post">
        <input type="text" name="search" placeholder="Tìm Kiếm Sản Phẩm..." class="box">
        <select name="category">
    <option value="">Tất cả danh mục</option>
    <?php
    foreach ($categories as $category) {
        echo "<option value=\"{$category['id']}\">{$category['name']}</option>";
    }
    ?>
</select>
<select name="sort_by">
        <option value="asc">Giá thấp đến cao</option>
        <option value="desc">Giá cao đến thấp</option>
    </select>
    <input type="submit" name="submit" value="Tìm" class="btn1">
    </form>

</section>

    <section class="products" style="padding-top: 0;">

        <div class="box-container">

            <?php
      if (isset($_POST['submit'])) {
        $search_item = $_POST['search'];
        $category = $_POST['category'];
        $sort_by = $_POST['sort_by'];
    
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
                ?>
                    <form action="" method="post" class="box">
                        <a href="product_detail.php?product_id=<?php echo $fetch_product['id']; ?>">
                            <img class="image" src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
                        </a>
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price"><?php echo number_format($fetch_products['price'], 0, ',', '.') . 'đ'; ?></div>
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
        </div>


    </section>

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    <script src="js/search.js"></script>

</body>

</html>
