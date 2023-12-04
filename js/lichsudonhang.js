function viewOrderDetails(orderId) {
    var orderDetailsContent = '<p>Đang tải...</p>';
    $('#orderDetailsModal').modal('show');
    $('#orderDetailsContent').html(orderDetailsContent);
    $.ajax({
        url: './controller/get_order_details.php',
        method: 'GET',
        data: { orderId: orderId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var orderDetailsContent = '<h5>Thông Tin Chi Tiết Đơn Hàng #' + orderId + '</h5>';
                $.each(response.products, function(index, product) {
                    orderDetailsContent += '<div class="product-details">';
                    orderDetailsContent += '<img src="uploaded_img/' + product.image + '" alt="' + product.name + '">';
                    orderDetailsContent += '<p><strong>' + product.name + '</strong></p>';
                    orderDetailsContent += '<p>Số Lượng: ' + product.quantity + '</p>';
                    orderDetailsContent += '</div>';
                });
                $('#orderDetailsContent').html(orderDetailsContent);
            } else {
                console.error('Lỗi khi lấy thông tin chi tiết đơn hàng');
                $('#orderDetailsContent').html('<p>Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại sau.</p>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi Ajax:', status, error);
            $('#orderDetailsContent').html('<p>Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại sau.</p>');
        }
    });
}