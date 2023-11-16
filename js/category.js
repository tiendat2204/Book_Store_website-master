
document.addEventListener("DOMContentLoaded", function () {
    // Lắng nghe sự kiện khi người dùng bấm vào danh mục sản phẩm
    var categoryLinks = document.querySelectorAll("#categoryLinks a");
    categoryLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            var category_id = this.getAttribute("href").split("=")[1];

            // Gửi yêu cầu Ajax để lấy sản phẩm dựa trên category_id
            fetch("category_ajax.php?category_id=" + category_id)
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    // Xóa danh sách sản phẩm hiện tại
                    var productContainer = document.getElementById("product-container");
                    productContainer.innerHTML = "";

                    // Hiển thị danh sách sản phẩm mới
                    if (data.length > 0) {
                        data.forEach(function (product) {
                            var productHTML = `
                                <form action="" method="post" class="box">
                                    <a href="product_detail.php?product_id=${product.id}">
                                        <img class="image" src="uploaded_img/${product.image}" alt="">
                                    </a>
                                    <div class="name">${product.name}</div>
                                    <div class="price">$${product.price}/-</div>
                                    <input type="number" min="1" name="product_quantity" value="1" class="qty">
                                    <input type="hidden" name="product_name" value="${product.name}">
                                    <input type="hidden" name="product_price" value="${product.price}">
                                    <input type="hidden" name="product_image" value="${product.image}">
                                    <input type="submit" value="Thêm giỏ hàng" name="add_to_cart" class="btn1">
                                </form>`;
                            productContainer.innerHTML += productHTML;
                        });
                    } else {
                        productContainer.innerHTML = '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
                    }
                })
                .catch(function (error) {
                    console.error("Có lỗi xảy ra. Vui lòng thử lại sau.");
                });
        });
    });
});



