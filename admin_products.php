<?php include './model/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

$message = [];

if (isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;
    $author = $_POST['author']; // Thêm thông tin tác giả
    $publisher = $_POST['publisher']; // Thêm thông tin nhà sản xuất
    $supplier = $_POST['supplier']; // Thêm thông tin nhà cung cấp
    $in4 = $_POST['in4']; // Thêm thông tin sách (in4 sách)
    $category_id = $_POST['category_id'];

    $select_product_name = $pdo->prepare("SELECT name FROM `products` WHERE name = :name");
    $select_product_name->bindParam(':name', $name, PDO::PARAM_STR);
    $select_product_name->execute();

    if ($select_product_name->rowCount() > 0) {
        $message[] = 'sản phẩm chưa được thêm!';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'kích thước ảnh quá lớn';
        } else {
            $add_product_query = $pdo->prepare("INSERT INTO `products`(name, price, image, tacgia, nhacungcap, nhaxuatban, in4, category_id) VALUES(:name, :price, :image, :author, :publisher, :supplier, :in4, :category_id)");
            $add_product_query->bindParam(':name', $name, PDO::PARAM_STR);
            $add_product_query->bindParam(':price', $price, PDO::PARAM_INT);
            $add_product_query->bindParam(':image', $image, PDO::PARAM_STR);
            $add_product_query->bindParam(':author', $author, PDO::PARAM_STR);
            $add_product_query->bindParam(':publisher', $publisher, PDO::PARAM_STR);
            $add_product_query->bindParam(':supplier', $supplier, PDO::PARAM_STR);
            $add_product_query->bindParam(':in4', $in4, PDO::PARAM_STR);
            $add_product_query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            if ($add_product_query->execute()) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Thêm sản phẩm thành công!';
            } else {
                $message[] = 'Không thể thêm sản phẩm';
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = $pdo->prepare("SELECT image FROM `products` WHERE id = :delete_id");
    $delete_image_query->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    $delete_image_query->execute();
    $fetch_delete_image = $delete_image_query->fetch(PDO::FETCH_ASSOC);
    unlink('uploaded_img/' . $fetch_delete_image['image']);

    $delete_product_query = $pdo->prepare("DELETE FROM `products` WHERE id = :delete_id");
    $delete_product_query->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    $delete_product_query->execute();
    $message[] = 'Xóa sản phẩm thành công!';
}

if (isset($_POST['update_product'])) {

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    $update_author = $_POST['update_author'];
    $update_publisher = $_POST['update_publisher'];
    $update_supplier = $_POST['update_supplier'];
    $update_in4 = $_POST['update_in4'];
    $update_category_id = $_POST['update_category_id'];
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/' . $update_image;
    $update_old_image = $_POST['update_old_image'];


      
    $update_product_query = $pdo->prepare("UPDATE `products` SET name = :update_name, price = :update_price, tacgia = :update_author, nhaxuatban = :update_publisher, nhacungcap = :update_supplier, in4 = :update_in4, category_id = :update_category_id WHERE id = :update_p_id");
    $update_product_query->bindParam(':update_name', $update_name, PDO::PARAM_STR);
    $update_product_query->bindParam(':update_price', $update_price, PDO::PARAM_INT);
    $update_product_query->bindParam(':update_author', $update_author, PDO::PARAM_STR);
    $update_product_query->bindParam(':update_publisher', $update_publisher, PDO::PARAM_STR);
    $update_product_query->bindParam(':update_supplier', $update_supplier, PDO::PARAM_STR);
    $update_product_query->bindParam(':update_in4', $update_in4, PDO::PARAM_STR);
    $update_product_query->bindParam(':update_category_id', $update_category_id, PDO::PARAM_INT);
    $update_product_query->bindParam(':update_p_id', $update_p_id, PDO::PARAM_INT);

    if ($update_product_query->execute()) {
        if (!empty($update_image)) {
            if ($update_image_size > 2000000) {
                $message[] = 'kích thước ảnh quá lớn';
            } else {
                $update_image_query = $pdo->prepare("UPDATE `products` SET image = :update_image WHERE id = :update_p_id");
                $update_image_query->bindParam(':update_image', $update_image, PDO::PARAM_STR);
                $update_image_query->bindParam(':update_p_id', $update_p_id, PDO::PARAM_INT);
                $update_image_query->execute();

                move_uploaded_file($update_image_tmp_name, $update_folder);
                unlink('uploaded_img/' . $update_old_image);
            }
        }
        $message[] = 'Cập nhật sản phẩm thành công!';
      
    } else {
        $message[] = 'Không thể cập nhật sản phẩm';
    }
}
    



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
        <option value="1">Tâm lý-1</option>
        <option value="2">Động vật-2</option>
        <option value="3">Đời sống-3</option>
        <option value="4">Kinh dị-4</option>
    </select>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
            <input type="submit" value="Thêm sản phẩm" name="add_product" class="btn">
        </form>

    </section>

    <!-- Hiển thị sản phẩm -->

    <section class="show-products">

        <div class="box-container">

            <?php
            $select_products = $pdo->query("SELECT * FROM `products`");
            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
<div class="information-book">

    <div class="author">Tác giả: <?php echo $fetch_products['tacgia']; ?></div>
    <div class="publisher">Nhà xuất bản: <?php echo $fetch_products['nhaxuatban']; ?></div>
    <div class="supplier">Nhà cung cấp: <?php echo $fetch_products['nhacungcap']; ?></div>
    <div class="category">Danh mục: <?php echo $fetch_products['category_id']; ?></div>
</div>

                        <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Cập nhật</a>
                        <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Xóa sản phẩm này?');">Xóa</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">Chưa có sản phẩm nào được thêm!</p>';
            }
            ?>
        </div>

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
                <option value="1" <?php echo ($fetch_update['category_id'] == 1) ? 'selected' : ''; ?>>Tâm lý</option>
                <option value="2" <?php echo ($fetch_update['category_id'] == 2) ? 'selected' : ''; ?>>Động vật</option>
                <option value="3" <?php echo ($fetch_update['category_id'] == 3) ? 'selected' : ''; ?>>Đời sống</option>
                <option value="4" <?php echo ($fetch_update['category_id'] == 4) ? 'selected' : ''; ?>>Kinh dị</option>
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
