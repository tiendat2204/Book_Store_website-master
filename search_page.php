<?php
include './controller/add_to_cart.php';

// Retrieve all categories from the database
$categories_query = $pdo->query("SELECT * FROM categories");
$categories = $categories_query->fetchAll(PDO::FETCH_ASSOC);

// Retrieve comment count for a given product ID
function getCommentCount($productId, $pdo)
{
    try {
        $sql = "SELECT COUNT(*) AS comment_count FROM comment WHERE product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['comment_count'];
    } catch (PDOException $e) {
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
    <title>Trang Tìm Kiếm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Trang Tìm Kiếm</h3>
        <p><a href="index.php">Trang Chủ</a> / Tìm Kiếm</p>
    </div>

    <section class="search-form">
        <form action="" method="post" id="searchForm">
            <input type="text" name="search" placeholder="Tìm Kiếm Sản Phẩm..." class="box">
            <select name="category">
                <option value="">Tất cả danh mục</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <select name="sort_by">
                <option value="asc">Giá thấp đến cao</option>
                <option value="desc">Giá cao đến thấp</option>
            </select>
            <input type="submit" name="submit" value="Tìm" class="btn1">
        </form>
    </section>

    <section class="products">
        <div class="box-container" id="searchResults">
            <?php
            if (isset($_POST['submit'])) {
                $search_item = $_POST['search'];
                $category = $_POST['category'];
                $sort_by = $_POST['sort_by'];

                $query = "SELECT * FROM `products` WHERE name LIKE :search_item";
                $query = "SELECT p.*, COUNT(c.id) AS comment_count
                FROM `products` p
                LEFT JOIN comment c ON p.id = c.product_id
                WHERE p.name LIKE :search_item";
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
                        $productStatus = $fetch_product['status_products'];
                        $originalPrice = $fetch_product['price'];
                        $discount = $fetch_product['discount'];
                        $discountedPrice = $originalPrice - ($originalPrice * $discount / 100);
                        $commentCount = getCommentCount($fetch_product['id'], $pdo);
                        ?>
                        <form action="" method="post" class="box" id="addToCartForm">
                            <a href="product_detail.php?product_id=<?php echo $fetch_product['id']; ?>">
                                <img class="image" src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
                            </a>
                            <div class="name"><?php echo $fetch_product['name']; ?></div>
                            <div class="price"><?php echo number_format($originalPrice, 0, ',', '.') . 'đ'; ?></div>
                            <div class="radio-input">
                                <input value="value-1" name="value-radio" id="value-1" type="radio" class="star s1" />
                                <input value="value-2" name="value-radio" id="value-2" type="radio" class="star s2" />
                                <input value="value-3" name="value-radio" id="value-3" type="radio" class="star s3" />
                                <input value="value-4" name="value-radio" id="value-4" type="radio" class="star s4" />
                                <input value="value-5" name="value-radio" id="value-5" type="radio" class="star s5" />
                            </div>
                            <div class="price-discount"><?php echo number_format($discountedPrice, 0, ',', '.') . 'đ'; ?></div>
                            <div class="comment-count">
                                <span class="star-icon"></span>
                                Bình luận: <?php echo $commentCount; ?>
                            </div>
                            <?php if ($productStatus === 'có sẵn'): ?>
                                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                                <input type="hidden" name="product_id" value="<?php echo isset($fetch_product['id']) ? $fetch_product['id'] : ''; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                                <input type="submit" value="Thêm giỏ hàng" name="add_to_cart" class="btn1">
                            <?php elseif ($productStatus === 'ngưng kinh doanh'): ?>
                                <button type="button" class="out-of-business-btn">Ngừng kinh doanh</button>
                            <?php elseif ($productStatus === 'hết hàng'): ?>
                                <button type="button" class="out-of-stock-btn">Hết hàng</button>
                            <?php endif; ?>
                        </form>
                        <?php
                    }
                } else {
                    echo '<p class="empty">Không có kết quả tìm kiếm!</p>';
                }
            } else {
                echo '<p class="empty">Tìm Kiếm Thứ Gì Đó!</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#searchForm").submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "controller/c_search.php",
                    data: formData,
                    dataType: "json",
                    success: function (data) {
                        displaySearchResults(data);
                    },
                    error: function (error) {
                        console.log("Lỗi trong quá trình gửi yêu cầu Ajax: " + JSON.stringify(error));
                    }
                });
            });

            function displaySearchResults(data) {
                var searchResults = $("#searchResults");
                searchResults.empty();

                if (data.length > 0) {
                    data.forEach(function (product) {
                        var productHtml = `
                            <form action="" method="post" class="box">
                                <a href="product_detail.php?product_id=${product.id}">
                                    <img class="image" src="uploaded_img/${product.image}" alt="">
                                </a>
                                <div class="name">${product.name}</div>
                                <div class="price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}</div>
                                <div class="radio-input">
                                    <input value="value-1" name="value-radio" id="value-1" type="radio" class="star s1" />
                                    <input value="value-2" name="value-radio" id="value-2" type="radio" class="star s2" />
                                    <input value="value-3" name="value-radio" id="value-3" type="radio" class="star s3" />
                                    <input value="value-4" name="value-radio" id="value-4" type="radio" class="star s4" />
                                    <input value="value-5" name="value-radio" id="value-5" type="radio" class="star s5" />
                                </div>
                                <div class="price-discount">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}</div>
                                <div class="comment-count">
                                    <span class="star-icon"></span>
                                    Bình luận: 0
                                </div>
                                <input type="hidden" name="product_id" value="${product.id}">
                                <input type="hidden" name="product_price" value="${product.price}">
                                <input type="hidden" name="product_image" value="${product.image}">
                                <input type="submit" value="Thêm giỏ hàng" name="add_to_cart" class="btn1">
                            </form>
                        `;
                        searchResults.append(productHtml);
                    });
                } else {
                    searchResults.append("<p>Không tìm thấy sản phẩm nào.</p>");
                }
            }
        });
    </script>
</body>
</html>
