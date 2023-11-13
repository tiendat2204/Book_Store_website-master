<?php
include './model/config.php';
session_start();
$user_id = $_SESSION['user_id'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'] ?? null;
    $product_quantity = $_POST['product_quantity'] ?? null;
    if ($product_id && $product_quantity) {
        include './controller/add_to_cart.php';
    }
}
$product_id = $_GET['product_id'] ?? null;
if (!$product_id) {
    echo 'Thiếu thông tin sản phẩm.';
    exit();
}

$product_query = $pdo->prepare("SELECT * FROM `products` WHERE id = :product_id");
$product_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$product_query->execute();

if ($product_query->rowCount() === 0) {
    echo 'Sản phẩm không tồn tại.';
    exit();
}

$product_data = $product_query->fetch(PDO::FETCH_ASSOC);
$product_author = $product_data['tacgia'];
$product_publisher = $product_data['nhacungcap'];
$product_supplier = $product_data['nhaxuatban'];
$product_info = $product_data['in4'];
$product_name = $product_data['name'];
$product_price = $product_data['price'];
$product_image = $product_data['image'];

$related_products_query = $pdo->prepare("SELECT * FROM products WHERE category_id = :category_id AND id != :product_id LIMIT 4");
$related_products_query->bindParam(':category_id', $product_data['category_id'], PDO::PARAM_INT);
$related_products_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$related_products_query->execute();
$related_products = $related_products_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-4">
                        <img class="card-img-top mb-5 mb-md-0" src="images/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>" />
                    </div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bolder"><?php echo $product_name; ?></h1>
                        <div class="fs-5 mb-5">
                            <span class="text-decoration-line-through ">$45.00</span>
                            <h2 style="color: #c0392b;"><?php echo "$" . $product_price; ?></h2>
                            <div class="in4-sach">
                                <div class="medium mb-5">Tác giả: <?php echo $product_author; ?></div>
                                <div class="medium mb-5">Nhà xuất bản: <?php echo $product_publisher; ?></div>
                                <div class="medium mb-5">Nhà cung cấp: <?php echo $product_supplier; ?></div>
                            </div>
                        </div>
                        <h3>Giới thiệu:</h3>
                        <p class="lead"><?php echo $product_info; ?></p>
                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <div class="d-flex">
                                <input class="form-control text-center me-6" id="inputQuantity" name="product_quantity" type="number" value="1" style="max-width: 6rem" />
                                <button class="btn btn-outline-dark flex-shrink-0" type="submit" style="margin-left: 5px;" name="add_to_cart">
                                    <i class="bi-cart-fill me-1"></i>
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Các sản phẩm cùng mục</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php foreach ($related_products as $related_product) : ?>
                        <div class="col mb-5">
                            <div class="card h-100">
                                <a href="product_detail.php?product_id=<?php echo $related_product['id']; ?>">
                                    <img class="card-img-top" src="images/<?php echo $related_product['image']; ?>" alt="<?php echo $related_product['name']; ?>" />
                                </a>
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder"><?php echo $related_product['name']; ?></h5>
                                        <?php echo "$" . $related_product['price']; ?>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <form action="" method="post">
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                <a class="btn btn-outline-dark mt-auto" href="product_detail.php?product_id=<?php echo $related_product['id']; ?>">
                                                    View Details
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <form action="post_comment.php" method="post" class="comment-form">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="text" name="comment" placeholder="Nhập bình luận của bạn" required>
            <button type="submit" class="btn_comment">Gửi bình luận</button>
        </form>
        <div class="comments">
            <h3>Bình luận:</h3>
            <?php
            $get_comments_query = $pdo->prepare("SELECT * FROM comment WHERE product_id = :product_id ORDER BY created_at DESC");
            $get_comments_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $get_comments_query->execute();

            if ($get_comments_query->rowCount() > 0) {
                while ($comment_row = $get_comments_query->fetch(PDO::FETCH_ASSOC)) {
                    $user_id = $comment_row['user_id'];
                    $comment_text = $comment_row['message'];
                    $created_at = $comment_row['created_at'];

                    $get_user_query = $pdo->prepare("SELECT name FROM users WHERE id = :user_id");
                    $get_user_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $get_user_query->execute();
                    $user_row = $get_user_query->fetch(PDO::FETCH_ASSOC);
                    $username = $user_row['name'];
                    $comment_time = date('Y-m-d H:i:s', strtotime($created_at));

                    echo "<div class='comment-container'>
                            <p class='comment'><strong>$username:</strong> $comment_text</p>
                            <p class='comment-time'>$comment_time</p>
                        </div>";
                }
            } else {
                echo "<p>Chưa có bình luận nào.</p>";
            }
            ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>