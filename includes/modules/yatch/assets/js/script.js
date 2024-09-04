// Custom scripts for Yatch module
document.addEventListener('DOMContentLoaded', function() {
    console.log('Yatch module loaded');
    // Add your custom JavaScript here
});


jQuery(document).ready(function($) {
    $('.yatch-toggle').on('click', function() {
        var view = $(this).data('view');
        console.log(view);
        $('.yatch-posts').removeClass('yatch-list-view yatch-grid-view').addClass('yatch-' + view + '-view');
    });
});


jQuery(document).ready(function($) {
    // Hàm debounce
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Hàm xử lý tìm kiếm
    function handleSearch() {
        var $form = $('#yatch-search-form');
        var formData = $form.serialize();
        console.log(formData);
        $.ajax({
            url: yatchAjax.ajax_url,
            type: 'GET',
            data: formData + '&action=yatch_search',
            success: function(response) {
                $('.yatch-posts').html(response);
            },
            error: function(xhr, status, error) {
                console.error('AJAX error: ' + status + ' - ' + error);
            }
        });
    }

    // Sử dụng debounce cho ô tìm kiếm
    $('#yatch-search-form input').on('input', debounce(handleSearch, 300));

    // Xử lý sự kiện khi người dùng nhấn vào nút sắp xếp
    $('.sort-button').on('click', function(e) {
        e.preventDefault();

        var sortOrder = $(this).data('order');
        var sortBy = $(this).data('orderby');

        // Cập nhật giá trị sắp xếp vào các trường ẩn (nếu có)
        $('#sort-order').val(sortOrder);
        $('#sort-by').val(sortBy);

        // Gọi lại hàm tìm kiếm và sắp xếp
        handleSearch();
    });

    handleSearch();
});

