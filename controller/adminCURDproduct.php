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

    $select_product_name = $pdo->prepare("SELECT name FROM `products` WHERE name = :name");
    $select_product_name->bindParam(':name', $name, PDO::PARAM_STR);
    $select_product_name->execute();

    if ($select_product_name->rowCount() > 0) {
        $message[] = 'sản phẩm chưa được thêm!';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'kích thước ảnh quá lớn';
        } else {
            $add_product_query = $pdo->prepare("INSERT INTO `products`(name, price, image) VALUES(:name, :price, :image)");
            $add_product_query->bindParam(':name', $name, PDO::PARAM_STR);
            $add_product_query->bindParam(':price', $price, PDO::PARAM_INT);
            $add_product_query->bindParam(':image', $image, PDO::PARAM_STR);

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
    header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];

    $update_product_query = $pdo->prepare("UPDATE `products` SET name = :update_name, price = :update_price WHERE id = :update_p_id");
    $update_product_query->bindParam(':update_name', $update_name, PDO::PARAM_STR);
    $update_product_query->bindParam(':update_price', $update_price, PDO::PARAM_INT);
    $update_product_query->bindParam(':update_p_id', $update_p_id, PDO::PARAM_INT);
    $update_product_query->execute();

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/' . $update_image;
    $update_old_image = $_POST['update_old_image'];

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

    header('location:admin_products.php');
}


?>