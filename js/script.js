let navBar = document.querySelector(".header .header-2 .navbar");

document.querySelector("#menu-btn").onclick = () => {
  navBar.classList.toggle("active");
  userBox.classList.remove("active");
};

function toggleSubmenu(event) {
  event.preventDefault();
  var submenu = document.getElementById("submenu");
  submenu.classList.toggle("show");
}

document.addEventListener("DOMContentLoaded", function () {
  let userIcon = document.getElementById("user-icon");
  let userBox = document.querySelector(".user-box");

  if (userIcon) {
    let isUserBoxVisible = false;

    userIcon.addEventListener("click", function () {
      if (isUserBoxVisible) {
        userBox.style.display = "none"; // Ẩn user-box nếu đang hiển thị
        isUserBoxVisible = false;
      } else {
        userBox.style.display = "block"; // Hiển thị user-box nếu đang ẩn
        isUserBoxVisible = true;
      }
    });
  }
});
var swiper = new Swiper(".home-slider", {
  spaceBetween: 30,
  centeredSlides: true,
  speed: 2300,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

// Hàm thay đổi số lượng sản phẩm trong giỏ hàng
function changeQuantity(action, cartId) {
  // Lấy các phần tử DOM liên quan
  var inputElement = $('[data-cart-id="' + cartId + '"] input[name="quantity"]');
  var priceElement = $('[data-cart-id="' + cartId + '"] .price-cart');

  // Lấy giá trị hiện tại và giá trị gốc của sản phẩm
  var currentQuantity = parseInt(inputElement.val());
  var originalProductPrice = parseFloat(priceElement.data("product-price"));

  // Thay đổi số lượng theo hành động chỉ định
  if (action === "increase") {
    currentQuantity += 1;
  } else if (action === "decrease" && currentQuantity > 1) {
    currentQuantity -= 1;
  }

  // Cập nhật số lượng trong input
  inputElement.val(currentQuantity);

  // Gọi hàm cập nhật tổng giá tiền và gửi AJAX để cập nhật giỏ hàng
  updateTotalPrice(cartId, currentQuantity);
}

// Hàm cập nhật tổng giá tiền của một sản phẩm và gửi AJAX để cập nhật giỏ hàng
function updateTotalPrice(cartId, quantity) {
  // Tính toán tổng giá tiền của sản phẩm
  var total = quantity * parseFloat($('[data-cart-id="' + cartId + '"] .price-cart').text());

  // Cập nhật tổng giá tiền của sản phẩm có cartId trùng khớp
  $('[data-cart-id="' + cartId + '"] #grand-total').text(total);

  // Gửi AJAX để cập nhật giỏ hàng trên máy chủ
  $.ajax({
    url: "../controller/update_cart.php",
    type: "POST",
    data: { cart_id: cartId, quantity: quantity },
    success: function (response) {
      try {
        // Xử lý dữ liệu JSON trả về từ AJAX
        var data = JSON.parse(response);

        // Cập nhật giao diện dựa trên dữ liệu từ AJAX response
        if (data) {
          $('#grand-total-all-prod').text(data['#grand-total-all-prod']);
          $('#grand-total-all').text(data['#grand-total-all-prod']);
          $('#total-quantity').text(data.total_quantity);

          // Lưu trữ dữ liệu vào localStorage để giữ lại sau khi làm mới trang
          localStorage.setItem('grandTotal', data['#grand-total-all-prod']);
          localStorage.setItem('totalQuantity', data.total_quantity);
        } else {
          alert("Dữ liệu trả về không hợp lệ!");
        }
      } catch (error) {
        console.error("Lỗi khi xử lý dữ liệu JSON:", error);
        alert("Có lỗi xảy ra khi xử lý dữ liệu JSON!");
      }
    },
  });
}

// Hàm xử lý sự kiện khi tài liệu đã sẵn sàng
$(document).ready(function () {
  // Kiểm tra xem có dữ liệu trong localStorage không
  var storedGrandTotal = localStorage.getItem("grandTotal");
  var storedTotalQuantity = localStorage.getItem("totalQuantity");

  // Sử dụng dữ liệu từ localStorage để cập nhật giao diện
  if (storedGrandTotal && storedTotalQuantity) {
    $('#grand-total-all-prod').text(storedGrandTotal);
    $('#grand-total-all').text(storedGrandTotal);
    $("#total-quantity").text(storedTotalQuantity);
  }
});

