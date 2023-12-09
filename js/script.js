// Toggle the submenu's show class when a submenu link is clicked
function toggleSubmenu(event) {
  event.preventDefault();
  document.getElementById("submenu");
  submenu.classList.toggle("show");
}

document.addEventListener("DOMContentLoaded", function () {
  const userIcon = document.getElementById("user-icon");
  const userBox = document.querySelector(".user-box");
  if (userIcon) {
    let isUserBoxVisible = false;
    userIcon.addEventListener("click", function () {
      userBox.style.display = isUserBoxVisible ? "none" : "block";
      isUserBoxVisible = !isUserBoxVisible;
    });
  }

  const menuBtn = document.querySelector("#menu-btn");
  const navBar = document.querySelector(".navbar");

  // Toggle the navigation bar's active class when the menu button is clicked
  menuBtn.addEventListener("click", () => {
    navBar.classList.toggle("active");
    userBox.style.display = "none"; // Hide user box when menu is clicked
  });
});

// Initialize the swiper slider
const swiper = new Swiper(".home-slider", {
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

// order

document.addEventListener('DOMContentLoaded', function () {
  var canceledOrdersList = document.getElementById('canceled-orders-list');
  var toggleCanceledOrdersButton = document.getElementById('toggle-canceled-orders');
  toggleCanceledOrdersButton.addEventListener('click', function () {
      canceledOrdersList.style.display = canceledOrdersList.style.display === 'none' ? 'flex' : 'none';
      toggleCanceledOrdersButton.innerText = canceledOrdersList.style.display === 'none' ? 'Đơn Hàng Đã Hủy' : 'Ẩn Đơn Hàng Đã Hủy';
  });
});
// cart
function changeQuantity(action, cartId) {
  const inputElement = $(`[data-cart-id="${cartId}"] input[name="quantity"]`);
  const priceElement = $(`[data-cart-id="${cartId}"] .price-cart`);
  let currentQuantity = parseInt(inputElement.val());
  const originalProductPrice = parseFloat(priceElement.data("product-price"));
  if (action === "increase") {
    currentQuantity += 1;
  } else if (action === "decrease" && currentQuantity > 1) {
    currentQuantity -= 1;
  }
  inputElement.val(currentQuantity);
  updateTotalPrice(cartId, currentQuantity);
}

function updateTotalPrice(cartId, quantity) {
  const total = quantity * parseFloat($(`[data-cart-id="${cartId}"] .price-cart`).text());

  $(`[data-cart-id="${cartId}"] #grand-total`).text(formatCurrency(total));

  $.ajax({
    url: "./controller/update_cart.php",
    type: "POST",
    data: { cart_id: cartId, quantity: quantity },
    success: function (response) {
      try {
        const data = JSON.parse(response);
        if (data) {
          $('#grand-total-all-prod').text(formatCurrency(data['#grand-total-all-prod']));
          $('#grand-total-all').text(formatCurrency(data['#grand-total-all-prod']));
          $('#total-quantity').text(data.total_quantity);

          localStorage.setItem('grandTotal', data['#grand-total-all-prod']);
          localStorage.setItem('totalQuantity', data.total_quantity);
        } else {
          alert("Invalid response data!");
        }
      } catch (error) {
        console.error("Error parsing JSON data:", error);
        alert("Error processing JSON data!");
      }
    },
  });
}

$(document).ready(function () {
  const storedGrandTotal = localStorage.getItem("grandTotal");
  const storedTotalQuantity = localStorage.getItem("totalQuantity");

  if (storedGrandTotal && storedTotalQuantity) {
    $('#grand-total-all-prod').text(formatCurrency(storedGrandTotal));
    $('#grand-total-all').text(formatCurrency(storedGrandTotal));
    $("#total-quantity").text(storedTotalQuantity);
  }
});

function formatCurrency(number) {
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
}

function addProductToCart(productId, price) {

  const totalQuantityElement = $('#total-quantity');
  const grandTotalElement = $('#grand-total-all-prod');

  // Increase the total quantity by 1
  let totalQuantity = parseInt(totalQuantityElement.text());
  totalQuantity += 1;

  // Calculate the new grand total
  let grandTotal = parseFloat(grandTotalElement.text().replace(/[^\d.-]/g, '')); 
  grandTotal += price;
  totalQuantityElement.text(totalQuantity);
  grandTotalElement.text(formatCurrency(grandTotal));
  localStorage.setItem('grandTotal', grandTotal);
  localStorage.setItem('totalQuantity', totalQuantity);
}

// cart_input
function validateQuantity(input) {
  var currentValue = parseInt(input.value);
  if (currentValue < 1 || isNaN(currentValue)) {
    input.value = 1;
  }
}
