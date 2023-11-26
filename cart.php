<?php
include './controller/cartCURD.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    a{
        text-decoration: none;
    }
</style>
<body>
    <?php include 'header.php'; ?>
    <div class="heading">
        <h3>Giỏ Hàng</h3>
        <p> <a href="index.php">Trang Chủ</a> / Giỏ Hàng </p>
    </div>
    <section class="shopping-cart">
        <h1 class="title">Sản Phẩm Đã Thêm</h1>
        <section class="h-100 gradient-custom">
            <div class="container py-5">
                <div class="row d-flex justify-content-center my-4">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex justify-content-between">
                                <h5 class="mb-0 fs-3">Giỏ hàng</h5>
                                <a href="cart.php?delete_all=true" class="btn btn-danger btn-lg" onclick="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi giỏ hàng không?')">
                                    Xóa Tất Cả
                                </a>
                            </div>
                            <div class="card-body">
                                <?php
                                $total_all_products = 0;
                                $grand_total = 0;
                                $select_cart = $pdo->prepare("SELECT cart.*, products.name, products.price, products.image, products.tacgia, products.nhacungcap, products.nhaxuatban FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = :user_id");
                                $select_cart->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                                $select_cart->execute();
                                while ($row = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                    $product_name = $row['name'];
                                    $product_price = $row['price'];
                                    $product_image = $row['image'];
                                    $author = $row['tacgia'];
                                    $supplier = $row['nhacungcap'];
                                    $publisher = $row['nhaxuatban'];
                                    $total_products = $product_price * $row['quantity'];
                                 
                                ?>
                                    <div class="row border-bottom py-3" data-cart-id="<?= $row['id'] ?>">
                                        <div class="col-lg-2 col-md-12 mb-4 mb-lg-0">
                                            <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                                <img src="images/<?= $product_image ?>" class="img-fluid" />
                                                <a href="#!">
                                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                            <p class="product-name"><?= $product_name ?></p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="detail-label fs-4">Tác giả:</p>
                                                    <p class="detail-value"><?= $author ?></p>
                                                    <p class="detail-label fs-4">Nhà cung cấp:</p>
                                                    <p class="detail-value"><?= $supplier ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="detail-label fs-4">Nhà xuất bản:</p>
                                                    <p class="detail-value"><?= $publisher ?></p>
                                                    
                                                    <div class="price-flex">
                                                    <p class="detail-label fs-4">Giá:</p>
<h4 class="price-cart" data-product-price="<?= $product_price ?>" data-cart-id="<?= $row['id'] ?>">
    <?= $product_price ?>₫
</h4>

                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center mb-4" style="width: 150px">
                                                    <button class="btn btn-primary btn-lg px-4 me-2" onclick="changeQuantity('decrease', <?= $row['id'] ?>)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <div class="form-outline flex-grow-1">
                                                    <input id="form1" min="1" name="quantity" value="<?= abs($row['quantity']) ?>" type="number" class="form-control form-control-lg" data-cart-id="<?= $row['id'] ?>" oninput="validateQuantity(this)">
                                                    </div>
                                                    <button class="btn btn-primary btn-lg px-4 ms-2" onclick="changeQuantity('increase', <?= $row['id'] ?>)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                            <a href="cart.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm me-2" id="detele-btn" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng không?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <div id="total-price" class="text-start text-md-end custom-total-price">
    <h4 class="fs-3">Tổng tiền: <strong id="grand-total" style="margin-left: 20px; color: #ff0000;">
        <?= $total_products ?>
    </strong></h4>
</div>

                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                            <p class="fs-4"><strong>Dự kiến giao hàng</strong></p>
        <p class="mb-0 fs-6">12.10.2020 - 14.10.2020</p>
                            </div>
                        </div>
                        <div class="card mb-4 mb-lg-0">
                            <div class="card-body">
                                <p><strong class="fs-4">Chấp nhận thanh toán</strong></p>
                                <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg" alt="Visa" />
                                <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg" alt="American Express" />
                                <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg" alt="Mastercard" />

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0 fs-3">Hóa đơn</h5>
                            </div>
                            <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0 fs-3">
                Tổng tiền
                <span id="grand-total-display" class="fs-5"><span id="grand-total-all-prod"></span> </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 fs-3">
                Số sản phẩm: 
                <h6 class="fs-5"><span id="total-quantity"></span> quyển</h6>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3 fs-3">
                <div>
                    <strong>Tổng hóa đơn</strong>
                    <strong>
                        <p class="mb-0 fs-6">(Bao gồm thuế VAT)</p>
                    </strong>
                </div>
                <span id="grand-total-strong" class="fs-5"><strong><span id="grand-total-all"></span> </strong></span>
            </li>
        </ul>
        <a href="checkout.php" class="btn btn-primary btn-lg fs-5">
            Tiến hành thanh toán
        </a>
    </div>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
 
</body>
</html>
