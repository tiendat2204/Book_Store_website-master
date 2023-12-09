<?php
session_start();
require_once './model/config.php'; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản lý danh mục</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include 'admin_header.php'; ?>

<div class="content" style="margin-bottom: 50px;">


    <h2 class="category-heading">Quản lý danh mục</h2>

    <form action="./controller/c_add_category.php" method="post" class="category-form">
        <h3>Thêm danh mục mới</h3>
        <label for="category_name">Tên danh mục:</label>
        <input type="text" name="category_name" required class="category-input">
        <button type="submit" class="category-button">Thêm danh mục</button>
    </form>

    <?php
    $categories_query = $pdo->query("SELECT categories.id, categories.name, COUNT(products.id) as product_count FROM categories LEFT JOIN products ON categories.id = products.category_id GROUP BY categories.id");
    $categories = $categories_query->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Số lượng sản phẩm</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
    <tr>
        <td><?php echo $category['id']; ?></td>
        <td class="category-name">
            <span id="category-name-<?php echo $category['id']; ?>" class="category-name-text"><?php echo $category['name']; ?></span>
            <form id="edit-form-<?php echo $category['id']; ?>" class="edit-category-form" action="./controller/c_edit_category.php" method="post" style="display: none;">
                <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                <input type="text" name="new_category_name" value="<?php echo $category['name']; ?>" required>
                <button type="submit">Lưu</button>
            </form>
        </td>
        <td class="product-count"><?php echo $category['product_count']; ?></td>
        <td>
            <a href="#" class="edit-link" data-category-id="<?php echo $category['id']; ?>">Sửa</a>
        </td>
    </tr>
<?php endforeach; ?>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $(".edit-link").click(function () {
            var categoryId = $(this).data("category-id");
            $(".edit-category-form").hide();
            $(".category-name-text").show();
            $("#edit-form-" + categoryId).toggle();
            $("#category-name-" + categoryId).toggle();
        });
    });
</script>


</body>
</html>
