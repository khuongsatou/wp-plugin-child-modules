<?php
class Yatch_Detail_Shortcode {

public function __construct() {
    add_shortcode('yatch_detail', array($this, 'display_yatch_detail'));
}

public function display_yatch_detail($atts) {
    global $post;

    // Lấy giá trị slug của yatch từ URL
    if (isset($_GET['yatch_slug'])) {
        $yatch_slug = sanitize_text_field($_GET['yatch_slug']);
    } else {
        return '<p>' . __('No yatch selected.', 'text-domain') . '</p>';
    }

    // Tìm bài viết theo slug
    $yatch_post = get_posts(array(
        'name'        => $yatch_slug,
        'post_type'   => 'yatch_post',
        'post_status' => 'publish',
        'numberposts' => 1
    ));

    if (!$yatch_post) {
        return '<p>' . __('Yatch not found.', 'text-domain') . '</p>';
    }

    // Thiết lập dữ liệu post cho WordPress
    $post = $yatch_post[0];
    setup_postdata($post);

    ob_start();
    
    // Hiển thị chi tiết bài viết
    echo '<h1>' . get_the_title() . '</h1>';
    echo '<div>' . get_the_content() . '</div>';
    echo '<p>Star Rating: ' . esc_html(get_post_meta(get_the_ID(), '_yatch_star_rating', true)) . '</p>';
    echo '<p>Review Count: ' . esc_html(get_post_meta(get_the_ID(), '_yatch_review_count', true)) . '</p>';
    echo '<p>Price: $' . esc_html(get_post_meta(get_the_ID(), '_yatch_price', true)) . '</p>';
    
    wp_reset_postdata();
    
    return ob_get_clean();
}
}

// Khởi tạo class
new Yatch_Detail_Shortcode();
