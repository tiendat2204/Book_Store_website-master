
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
                    console.log(data);
                    // Xóa danh sách sản phẩm hiện tại
                    var productContainer = document.getElementById("product-container");
                    productContainer.innerHTML = "";

                    // Hiển thị danh sách sản phẩm mới
                    if (data.length > 0) {
                        
                        data.forEach(function (product) {
                            var originalPrice = product.price;
                            var discount = product.discount;
                            var discountedPrice = originalPrice - (originalPrice * discount / 100);

                            var productHTML = `
                            <form action="" method="post" class="box">
                            <a href="product_detail.php?product_id=${product.id}">
                                <img class="image" src="uploaded_img/${product.image}" alt="">
                            </a>
                            <div class="name">${product.name}</div>
                            <div class="price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)} </div>
                            <input type="hidden" name="product_name" value="${product.name}">
                            <div class="radio-input">
                                <input value="value-1" name="value-radio" id="value-1" type="radio" class="star s1" />
                                <input value="value-2" name="value-radio" id="value-2" type="radio" class="star s2" />
                                <input value="value-3" name="value-radio" id="value-3" type="radio" class="star s3" />
                                <input value="value-4" name="value-radio" id="value-4" type="radio" class="star s4" />
                                <input value="value-5" name="value-radio" id="value-5" type="radio" class="star s5" />
                            </div>
                            <div class="price-discount">
                                        ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(discountedPrice)}
                                    </div>
                            <div class="comment-count">
                            <span class="star-icon"></i></span>
                            Bình luận: 0
                        </div>
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



