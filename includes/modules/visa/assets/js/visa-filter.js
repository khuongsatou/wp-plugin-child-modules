jQuery(document).ready(function($) {
    function load_visa_posts(region) {
        $.ajax({
            url: visa_filter_vars.ajax_url,  // Sử dụng biến ajax_url đã truyền từ PHP
            type: 'POST',
            data: {
                action: 'filter_visa_posts',
                region: region
            },
            success: function(response) {
                $('#visa-posts').html(response);
            }
        });
    }

    // Mặc định load bài viết cho Châu Á
    load_visa_posts('');

    // Sự kiện click trên tab
    $('.visa-tab-nav a').click(function(e) {
        e.preventDefault();
        var region = $(this).data('region');

        $('.visa-tab-nav a').removeClass('active');
        $(this).addClass('active');

        load_visa_posts(region);
    });
});


jQuery(document).ready(function($) {
    $('.tab-item').on('click', function(e) {
        e.preventDefault();

        var region = $(this).data('region');

        // Đặt lại trạng thái active cho tab
        $('.tab-item').removeClass('active');
        $(this).addClass('active');

        // Gửi yêu cầu AJAX
        $.ajax({
            url: visa_filter_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_visa_posts',
                region: region
            },
            success: function(response) {
                $('#visa-posts').html(response);
            }
        });
    });
});
