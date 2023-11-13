let navbar = document.querySelector(".header .navbar");
let accountBox = document.querySelector(".header .account-box");

document.querySelector("#menu-btn").onclick = () => {
  navbar.classList.toggle("active");
  accountBox.classList.remove("active");
};

document.querySelector("#user-btn").onclick = () => {
  accountBox.classList.toggle("active");
  navbar.classList.remove("active");
};

window.onscroll = () => {
  navbar.classList.remove("active");
  accountBox.classList.remove("active");
};

document.addEventListener("DOMContentLoaded", function () {
  const closeUpdateButton = document.getElementById('close-update');
  const editProductForm = document.querySelector('.edit-product-form');

  closeUpdateButton.addEventListener('click', function () {
    editProductForm.style.display = 'none';
});
});