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
    $_SESSION['messages'] = $message;
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
    $_SESSION['messages'] = $message;
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
    $_SESSION['messages'] = $message;
}
?>