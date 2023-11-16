<?php
include './model/config.php';
include './controller/cartCURD.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                                <h5 class="mb-0">Cart - 2 items</h5>
                                <a href="cart.php?delete_all=true" class="btn btn-danger btn-lg" onclick="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi giỏ hàng không?')">
                                    Xóa Tất Cả
                                </a>
                            </div>
                            <div class="card-body">
                                <?php
                                $grand_total = 0;
                                $select_cart = $pdo->prepare("SELECT cart.*, products.name, products.price, products.image, products.tacgia, products.nhacungcap, products.nhaxuatban, products.in4 FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = :user_id");
                                $select_cart->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                                $select_cart->execute();
                                while ($row = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                    $product_name = $row['name'];
                                    $product_price = $row['price'];
                                    $product_image = $row['image'];
                                    $author = $row['tacgia'];
                                    $supplier = $row['nhacungcap'];
                                    $publisher = $row['nhaxuatban'];
                                    $info = $row['in4'];
                                    $grand_total += $product_price;
                                ?>
                                    <div class="row border-bottom py-3" data-cart-id="<?= $row['id'] ?>">
                                        <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                            <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                                <img src="images/<?= $product_image ?>" class="w-100" />
                                                <a href="#!">
                                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                            <p class="product-name"><?= $product_name ?></p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="detail-label">Tác giả:</p>
                                                    <p class="detail-value"><?= $author ?></p>
                                                    <p class="detail-label">Nhà cung cấp:</p>
                                                    <p class="detail-value"><?= $supplier ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="detail-label">Nhà xuất bản:</p>
                                                    <p class="detail-value"><?= $publisher ?></p>
                                                    <div class="price-flex">
                                                        <p class="detail-label">Giá:<h4 class="price-cart">$<?= $product_price ?></h4></p>
                                                    </div>
                                                </div>
                                                <p class="detail-label">Thông tin:</p>
                                                <p class="detail-value"><?= $info ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                            <div class="d-flex justify-content-center align-items-center mb-4" style="width: 140px">
                                                <button class="btn btn-primary btn-lg px-4 me-2" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <div class="form-outline flex-grow-1">
                                                <input id="form1" min="0" name="quantity" value="<?= $row['quantity'] ?>" type="number" class="form-control form-control-lg" data-cart-id="<?= $row['id'] ?>" />
                                                </div>
                                                <button class="btn btn-primary btn-lg px-4 ms-2" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <a href="cart.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm me-2" id="detele-btn" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng không?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <div id="total-price" class="text-start text-md-end custom-total-price">
    <h4>Tổng tiền: <strong style="margin-left: 20px; color: #ff0000;"><?= $grand_total ?>$</strong></h4>
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
                                <p><strong>Expected shipping delivery</strong></p>
                                <p class="mb-0">12.10.2020 - 14.10.2020</p>
                            </div>
                        </div>
                        <div class="card mb-4 mb-lg-0">
                            <div class="card-body">
                                <p><strong>We accept</strong></p>
                                <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg" alt="Visa" />
                                <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg" alt="American Express" />
                                <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg" alt="Mastercard" />
                                <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce/includes/gateways/paypal/assets/images/paypal.webp" alt="PayPal acceptance mark" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0">Hóa đơn</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                        Tổng tiền
                                        <span>$<?= $grand_total ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        Số sản phẩm:
                                        <span><?= $select_cart->rowCount() ?> quyển</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                        <div>
                                            <strong>Tổng hóa đơn</strong>
                                            <strong>
                                                <p class="mb-0">(Bao gồm thuế VAT)</p>
                                            </strong>
                                        </div>
                                        <span><strong>$<?= $grand_total ?></strong></span>
                                    </li>
                                </ul>
                                <button type="button" class="btn btn-primary btn-lg btn-block">
                                    Tiến hành thanh toán
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <?php include 'footer.php'; ?>
    <script>
$('.quantity').on('click', function() {
    var $button = $(this);
    var oldValue = $button.parent().find('input').val();
    var cart_id = $button.data('cart_id');
    var product_price = $button.data('product_price');
    var grand_total = $('#grand_total').text();

    if ($button.hasClass('plus')) {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        if (oldValue > 1) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 1;
        }
    }
    $button.parent().find('input').val(newVal);

    // Gửi yêu cầu AJAX để cập nhật số lượng sản phẩm và tính lại tổng tiền của giỏ hàng
    $.ajax({
        url: 'update_cart.php',
        type: 'POST',
        dataType: 'json',
        data: {
            cart_id: cart_id,
            quantity: newVal
        },
        success: function(data) {
            if (data.error) {
                alert(data.error);
            } else {
                $('#total_price_' + cart_id).text(data.total_price);
                $('#grand_total').text(data.grand_total);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError);
        }
    });
});
</script>

    <script src="js/script.js"></script>
</body>
</html>
