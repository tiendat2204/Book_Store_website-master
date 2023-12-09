<?php 
include './controller/adminCURDproduct.php';
$categories_query = $pdo->query("SELECT id, name FROM categories");
$categories = $categories_query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>

    <!-- Liên kết đến font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Liên kết đến tệp CSS tùy chỉnh -->
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <!-- Phần CRUD sản phẩm -->

    <section class="add-products">

        <h1 class="title">Cửa hàng sản phẩm</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <h3>Thêm sản phẩm</h3>
            <input type="text" name="name" class="box" placeholder="Nhập tên sản phẩm" required>
            <input type="number" min="0" name="price" class="box" placeholder="Nhập giá sản phẩm" required>
            <input type="text" name="author" class="box" placeholder="Nhập tác giả" required>
            <input type="text" name="publisher" class="box" placeholder="Nhập nhà xuất bản" required>
            <input type="text" name="supplier" class="box" placeholder="Nhập nhà cung cấp" required>
            <textarea name="in4" class="box" placeholder="Nhập thông tin sách"></textarea>
            <select name="category_id" class="box" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
    </select>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
            <input type="submit" value="Thêm sản phẩm" name="add_product" class="btn">
        </form>

    </section>

    <!-- Hiển thị sản phẩm -->

    <section class="show-prd">
    <?php
    $select_products = $pdo->query("SELECT products.*, categories.name AS category_name FROM `products` LEFT JOIN `categories` ON products.category_id = categories.id");
    if ($select_products->rowCount() > 0) {
    ?>
        <table>
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Tác giả</th>
                    <th>Nhà xuất bản</th>
                    <th>Nhà cung cấp</th>
                    <th>Thông tin sách</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt=""></td>
                        <td><?php echo $fetch_products['name']; ?></td>
                        <td><?php echo number_format($fetch_products['price'], 0, ',', '.') . 'đ'; ?></td>
                        <td><?php echo $fetch_products['tacgia']; ?></td>
                        <td><?php echo $fetch_products['nhaxuatban']; ?></td>
                        <td><?php echo $fetch_products['nhacungcap']; ?></td>
                        <td><?php echo $fetch_products['in4']; ?></td>
                        <td><?php echo $fetch_products['category_name']; ?></td>
                        <td><?php echo $fetch_products['status_products']; ?></td>
                        <td class="product-actions">
                            <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="update-button">Chỉnh sửa</a>
                            <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-button" onclick="return confirm('Xóa sản phẩm này?');">Xóa</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        echo '<p>Chưa có sản phẩm nào được thêm!</p>';
    }
    ?>
</section>


    <section class="edit-product-form">

    <?php
if (isset($_GET['update'])) {
    $update_id = $_GET['update'];
    $update_query = $pdo->prepare("SELECT * FROM `products` WHERE id = :update_id");
    $update_query->bindParam(':update_id', $update_id, PDO::PARAM_INT);
    $update_query->execute();
    if ($update_query->rowCount() > 0) {
        $fetch_update = $update_query->fetch(PDO::FETCH_ASSOC);
?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
            <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
            <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
            <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Nhập tên sản phẩm">
            <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Nhập giá sản phẩm">
            <input type="text" name="update_author" value="<?php echo $fetch_update['tacgia']; ?>" class="box" required placeholder="Nhập tác giả">
            <input type="text" name="update_publisher" value="<?php echo $fetch_update['nhaxuatban']; ?>" class="box" required placeholder="Nhập nhà xuất bản">
            <input type="text" name="update_supplier" value="<?php echo $fetch_update['nhacungcap']; ?>" class="box" required placeholder="Nhập nhà cung cấp">
            <textarea name="update_in4" class="box" placeholder="Nhập thông tin sách"><?php echo $fetch_update['in4']; ?></textarea>
            <label for="update_category">Chọn danh mục:</label>
            <select name="update_category_id" class="box" required>
            <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo ($fetch_update['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                        <?php echo $category['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="update_status">Chọn trạng thái:</label>
<select name="update_status" class="box" required>
    <option value="có sẵn" <?php echo ($fetch_update['status_products'] == 'có sẵn') ? 'selected' : ''; ?>>có sẵn</option>
    <option value="ngưng kinh doanh" <?php echo ($fetch_update['status_products'] == 'ngưng kinh doanh') ? 'selected' : ''; ?>>ngưng kinh doanh</option>
    <option value="hết hàng" <?php echo ($fetch_update['status_products'] == 'hết hàng') ? 'selected' : ''; ?>>hết hàng</option>
</select>

            <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
            <input type="submit" value="Cập nhật" name="update_product" class="btn">
            <input type="reset" value="Hủy" id="close-update" class="option-btn">
        </form>
<?php
    }
} else {
    echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
}
?>


    </section>

    <!-- Liên kết đến tệp JS tùy chỉnh của quản trị viên -->
    <script src="js/admin_script1.js"></script>

</body>

</html>
