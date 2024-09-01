// Custom scripts for Yatch module
document.addEventListener('DOMContentLoaded', function() {
    console.log('Yatch module loaded');
    // Add your custom JavaScript here
});


jQuery(document).ready(function($) {
    $('.yatch-toggle').on('click', function() {
        var view = $(this).data('view');
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
});

