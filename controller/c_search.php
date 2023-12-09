<?php
include '../model/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $result = $select_products->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}
?>
