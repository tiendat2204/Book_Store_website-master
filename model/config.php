<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=shop_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "";
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
    include '../controller/update_cart.php';
}
?>
