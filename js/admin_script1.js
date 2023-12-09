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

document.addEventListener("DOMContentLoaded", function () {
  const closeUpdateButton = document.getElementById('close-update');
  const editProductForm = document.querySelector('.edit-product-form');

  closeUpdateButton.addEventListener('click', function () {
    editProductForm.style.display = 'none';
});
});
// user
document.addEventListener("DOMContentLoaded", function () {
  // Lấy liên kết thêm người dùng và phần container_user
  var addUserLink = document.querySelector(".add-btn");
  var userContainer = document.querySelector(".container_user");
  var btnClose = document.querySelector(".btn-user-close");
  // Thiết lập lắng nghe sự kiện click trên liên kết thêm người dùng
  addUserLink.addEventListener("click", function (event) {
      // Ngăn chặn hành vi mặc định của liên kết
      event.preventDefault();
      // Hiển thị container_user
      userContainer.style.display = "block";
  });
});
function cancelAddUser() {
  var addUserSection = document.querySelector('.container_user');
  addUserSection.style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
  var messages = document.querySelectorAll('.message');

  messages.forEach(function (message) {
      setTimeout(function () {
          message.style.display = 'none'; 
      }, 4500);
  });
});