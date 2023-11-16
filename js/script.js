// let userBox = document.querySelector(".header .header-2 .user-box");
let navBar = document.querySelector(".header .header-2 .navbar");

// document.querySelector("#user-btn").onclick = () => {
//   userBox.classList.toggle("active");
//   navBar.classList.remove('active');
// };

document.querySelector("#menu-btn").onclick = () => {
  navBar.classList.toggle("active");
  userBox.classList.remove('active');
};
// document.addEventListener('DOMContentLoaded', function() {
//   const viewDetailButtons = document.querySelectorAll('.view-detail');
  
//   viewDetailButtons.forEach(button => {
//       button.addEventListener('click', function() {
//           const productId = this.getAttribute('data-product-id');
//           window.location.href = `product_detail.php?product_id=${productId}`;
//       });
//   });
// });
function toggleSubmenu(event) {
  event.preventDefault();
  var submenu = document.getElementById("submenu");
  submenu.classList.toggle("show");
}


document.addEventListener("DOMContentLoaded", function() {
  let userIcon = document.getElementById("user-icon");
  let userBox = document.querySelector(".user-box");

  if (userIcon) {
      let isUserBoxVisible = false;

      userIcon.addEventListener("click", function() {
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


window.onscroll = () => {
    userBox.classList.remove('active');
    navBar.classList.remove('active');

    if(window.scrollY > 60) {
        document.querySelector('.header .header-2').classList.add('active');
    } else {
        document.querySelector('.header .header-2').classList.remove('active');
    }
}


