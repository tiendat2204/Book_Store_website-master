    <?php
    include './model/config.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
   

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (isset($_POST['add_to_cart'])) {
        if ($user_id === null) {
            // Người dùng chưa đăng nhập, hiển thị thông báo
            $message[] = 'Bạn cần đăng nhập trước khi thêm sản phẩm vào giỏ hàng.';
        } else {
            $product_id = $_POST['product_id']; // Thêm dòng này để lấy product_id từ form
            $product_quantity = $_POST['product_quantity'];

            $check_cart_numbers = $pdo->prepare("SELECT * FROM `cart` WHERE product_id = :product_id AND user_id = :user_id");
            $check_cart_numbers->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $check_cart_numbers->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $check_cart_numbers->execute();

            if ($check_cart_numbers->rowCount() > 0) {
                $message[] = 'Sản phẩm đã được thêm vào giỏ hàng!';
            } else {
                $product_info_query = $pdo->prepare("SELECT * FROM `products` WHERE id = :product_id");
                $product_info_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $product_info_query->execute();
            
                if ($product_info_query->rowCount() > 0) {
                    $product_info = $product_info_query->fetch(PDO::FETCH_ASSOC);
            
                    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
                    $check_existing_product = $pdo->prepare("SELECT * FROM `cart` WHERE product_id = :product_id AND user_id = :user_id");
                    $check_existing_product->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                    $check_existing_product->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $check_existing_product->execute();
            
                    if ($check_existing_product->rowCount() > 0) {
                        $message[] = 'Sản phẩm đã tồn tại trong giỏ hàng!';
                    } else {
                        $insert_query = $pdo->prepare("INSERT INTO `cart` (user_id, product_id, quantity) VALUES (:user_id, :product_id, :product_quantity)");
                        $insert_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                        $insert_query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                        $insert_query->bindParam(':product_quantity', $product_quantity, PDO::PARAM_INT);
            
                        if ($insert_query->execute()) {
                            $message[] = 'Sản phẩm đã được thêm vào giỏ hàng!';
                        } else {
                            $message[] = 'Không thể thêm sản phẩm vào giỏ hàng!';
                        }
                    }
                } else {
                    $message[] = 'Không tìm thấy thông tin sản phẩm!';
                }
            }
        }}
    ?>
