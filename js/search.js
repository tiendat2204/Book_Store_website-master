document.addEventListener("DOMContentLoaded", function() {
    const searchForm = document.querySelector(".search-form form");
    const productsContainer = document.querySelector(".products .box-container");

    searchForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const searchItem = searchForm.querySelector('input[name="search"]').value;
        const category = searchForm.querySelector('select[name="category"]').value;
        const sortBy = searchForm.querySelector('select[name="sort_by"]').value;

        // Sử dụng AJAX để gửi yêu cầu tìm kiếm
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "search_products.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                productsContainer.innerHTML = xhr.responseText;
            }
        };
        xhr.send("search=" + searchItem + "&category=" + category + "&sort_by=" + sortBy);
    });
});
