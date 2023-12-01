<?php 
include './model/config.php';


$order_query = $pdo->prepare("SELECT * FROM `orders` WHERE id = :order_id");
$order_query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$order_query->execute();
$order_result = $order_query->fetch(PDO::FETCH_ASSOC);

// Truy vấn giỏ hàng và sản phẩm tương ứng
$cart_query = $pdo->prepare("SELECT cart.*, products.name, products.price FROM `cart` INNER JOIN `products` ON cart.product_id = products.id WHERE cart.user_id = :user_id");
$cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$cart_query->execute();

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = 'Thanh toán đơn hàng ' .$order_id;
$amount = $order_result['total_price'] ;
$redirectUrl = "http://localhost:3000/orders.php";
$ipnUrl = "http://localhost:3000/orders.php";
$extraData = "";
$order_code = $order_result['order_code'];


// Retrieve data from POST request
$partnerCode = $partnerCode;
$accessKey = $accessKey;
$secretKey = $secretKey;
$orderId = $order_code;
$orderInfo = $orderInfo ;
$amount = $amount;
$ipnUrl = $ipnUrl;
$redirectUrl = $redirectUrl;
$extraData = $extraData;   

$requestId = time() . "";
$requestType = "payWithATM";

// $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
// var_dump($extraData);

// Generate HMAC SHA256 signature
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);

// Set request data
$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    "storeId" => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature
);

// Send POST request and decode JSON response
$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);

// Redirect to payment URL
header('Location: ' . $jsonResult['payUrl']);
$delete_cart_query = $pdo->prepare("DELETE FROM `cart` WHERE user_id = :user_id");
$delete_cart_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$delete_cart_query->execute();
exit();
// Function to send POST request
function execPostRequest($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data))
    );
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
?>
