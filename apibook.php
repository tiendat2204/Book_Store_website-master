<?php
include './model/config.php';
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Books API Integration</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

 
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="heading">
    <h3>Tìm kiếm với google</h3>
    <p> <a href="index.php">trang chủ</a> / tìm kiếm với google </p>
</div>
    <div class="container" style="margin: 110px;">
        <div class="searchBox">
            <h1>Tìm kiếm thứ gì đó</h1>
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Nhập từ khóa...">
                <button type="submit" class="search-btn-api">Tìm kiếm</button>
            </form>
        </div>

        <?php
        if (isset($_GET['search']) && !empty($_GET['search'])) {
    
            $apiKey = 'AIzaSyBXxNY1uiD1csX1GOP1DjLLAFRwpwx2R9U';

   
            $query = urlencode($_GET['search']);


            $apiUrl = "https://www.googleapis.com/books/v1/volumes?q=${query}&key=${apiKey}";


            $response = file_get_contents($apiUrl);

            if ($response !== false) {
                $data = json_decode($response, true);


                if (isset($data['items'])) {
                    echo '<ul class="book-results">';
                    foreach ($data['items'] as $item) {
                        echo '<li class="book-item">';
                        echo '<h2 class="book-title"><strong>Tên sách:</strong> ' . $item['volumeInfo']['title'] . '</h2>';

            
                        if (isset($item['volumeInfo']['imageLinks']['thumbnail'])) {
                            echo '<img src="' . $item['volumeInfo']['imageLinks']['thumbnail'] . '" alt="Hình ảnh sách" class="book-cover">';
                        }

                        echo '<p class="book-authors"><strong>Tác giả(s):</strong> ' . implode(', ', $item['volumeInfo']['authors']) . '</p>';
                        echo '<p class="book-description"><strong>Mô tả:</strong> ' . $item['volumeInfo']['description'] . '</p>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p class="no-results">Không tìm thấy kết quả.</p>';
                }
            } else {
                echo '<p class="no-results">Lỗi khi thực hiện yêu cầu API.</p>';
            }
        }
        ?>
    </div>
    <?php
    include 'footer.php';
    ?>
<script src="js/script.js"></script>

</body>

</html>
