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

// Change the quantity of a product in the cart
function changeQuantity(action, cartId) {
  // Get the relevant DOM elements
  const inputElement = $(`[data-cart-id="${cartId}"] input[name="quantity"]`);
  const priceElement = $(`[data-cart-id="${cartId}"] .price-cart`);

  // Get the current and original product prices
  let currentQuantity = parseInt(inputElement.val());
  const originalProductPrice = parseFloat(priceElement.data("product-price"));

  // Change the quantity based on the specified action
  if (action === "increase") {
    currentQuantity += 1;
  } else if (action === "decrease" && currentQuantity > 1) {
    currentQuantity -= 1;
  }

  // Update the quantity input
  inputElement.val(currentQuantity);

  // Update the total price and send an AJAX request to update the cart
  updateTotalPrice(cartId, currentQuantity);
}

function updateTotalPrice(cartId, quantity) {
  // Calculate the total price of the product
  const total = quantity * parseFloat($(`[data-cart-id="${cartId}"] .price-cart`).text());

  $(`[data-cart-id="${cartId}"] #grand-total`).text(formatCurrency(total));

  $.ajax({
    url: "../controller/update_cart.php",
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
  // Get the relevant DOM elements
  const totalQuantityElement = $('#total-quantity');
  const grandTotalElement = $('#grand-total-all-prod');

  // Increase the total quantity by 1
  let totalQuantity = parseInt(totalQuantityElement.text());
  totalQuantity += 1;

  // Calculate the new grand total
  let grandTotal = parseFloat(grandTotalElement.text().replace(/[^\d.-]/g, '')); // Remove non-numeric characters from the string
  grandTotal += price;

  // Update the DOM elements with the new values
  totalQuantityElement.text(totalQuantity);
  grandTotalElement.text(formatCurrency(grandTotal));

  // Store the new values in localStorage
  localStorage.setItem('grandTotal', grandTotal);
  localStorage.setItem('totalQuantity', totalQuantity);
}

// cart_input
function validateQuantity(input) {
  // Get the current value of the input
  var currentValue = parseInt(input.value);

  // If the value is less than 1, set the value to 1
  if (currentValue < 1 || isNaN(currentValue)) {
    input.value = 1;
  }
}
