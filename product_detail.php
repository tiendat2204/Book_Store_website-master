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

if ($product_id) {
    $product_query = $pdo->prepare("SELECT * FROM `products` WHERE id = :product_id");
    $product_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $product_query->execute();

    if ($product_data = $product_query->fetch(PDO::FETCH_ASSOC)) {
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
    } else {
        echo 'Sản phẩm không tồn tại.';
        exit();
    }
} else {
    echo 'Thiếu thông tin sản phẩm.';
    exit();
}
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
            <div class="container px-4 px-lg-5 my-5 shadow-lg p-3 mb-5 bg-white rounded">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-4">
                        <img class="card-img-top mb-5 mb-md-0" src="images/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>" />
                    </div>

                    <div class="col-md-6">
                        <h1 class="display-5 fw-bold text-dark"><?php echo $product_name; ?></h1>
                        <div class="fs-5 mb-5 text-danger">
                            <span class="text-decoration-line-through text-muted">$45.00</span>
                            <h2 class="text-danger"><?php echo "$" . $product_price; ?></h2>
                            <div class="in4-sach text-dark">
                                <div class="medium mb-5">Tác giả:  <strong><?php echo $product_author; ?></strong></div>
                                <div class="medium mb-5">Nhà xuất bản: <strong><?php echo $product_publisher; ?></strong></div>
                                <div class="medium mb-5">Nhà cung cấp: <strong><?php echo $product_supplier; ?></strong></div>
                            </div>
                        </div>

                        <h3 class="text-dark">Giới thiệu:</h3>
                        <p class="lead text-dark"><?php echo $product_info; ?></p>

                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <div class="d-flex">
                                <input class="form-control text-center me-6" id="inputQuantity" name="product_quantity" type="number" value="1" style="max-width: 6rem" />
                                <button class="CartBtn" type="submit" name="add_to_cart">
                                    <span class="IconContainer"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="rgb(17, 17, 17)" class="cart"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path></svg>
                                    </span>
                                    <p class="text-btn">Thêm vào giỏ hàng</p>
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
                                        <div class="radio-input">
                                            <input value="value-1" name="value-radio" id="value-1" type="radio" class="star s1" />
                                            <input value="value-2" name="value-radio" id="value-2" type="radio" class="star s2" />
                                            <input value="value-3" name="value-radio" id="value-3" type="radio" class="star s3" />
                                            <input value="value-4" name="value-radio" id="value-4" type="radio" class="star s4" />
                                            <input value="value-5" name="value-radio" id="value-5" type="radio" class="star s5" />
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <form action="" method="post">
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <div class="d-flex justify-content-center ">
                                                <a class="btn btn-outline-dark mt-auto" href="product_detail.php?product_id=<?php echo $related_product['id']; ?>">
                                                    Chi tiết 
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
