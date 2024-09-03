<?php
class Yatch_Detail_Shortcode {

public function __construct() {
    add_shortcode('yatch_detail', array($this, 'display_yatch_detail'));
    add_action('template_redirect', array($this, 'add_yatch_to_cart'));
}

public function display_yatch_detail($atts) {
    global $post;

    if (isset($_GET['yatch_slug'])) {
        $yatch_slug = sanitize_text_field($_GET['yatch_slug']);
    } else {
        return '<p>' . __('No yatch selected.', 'text-domain') . '</p>';
    }

    $yatch_post = get_posts(array(
        'name'        => $yatch_slug,
        'post_type'   => 'yatch_post',
        'post_status' => 'publish',
        'numberposts' => 1
    ));

    if (!$yatch_post) {
        return '<p>' . __('Yatch not found.', 'text-domain') . '</p>';
    }

    $post = $yatch_post[0];
    setup_postdata($post);

    $price = get_post_meta(get_the_ID(), '_yatch_price', true);

    ob_start();
    
    echo '<h1>' . get_the_title() . '</h1>';
    echo '<div>' . get_the_content() . '</div>';
    echo '<p>Star Rating: ' . esc_html(get_post_meta(get_the_ID(), '_yatch_star_rating', true)) . '</p>';
    echo '<p>Review Count: ' . esc_html(get_post_meta(get_the_ID(), '_yatch_review_count', true)) . '</p>';
    echo '<p>Price: $' . esc_html($price) . '</p>';

    // Nút thêm vào giỏ hàng
    echo '<a href="' . esc_url(add_query_arg(array(
        'yatch_slug' => get_post_field('post_name', get_the_ID()),
        'action' => 'add_to_cart'
    ), get_permalink())) . '">' . __('Add to Cart', 'text-domain') . '</a>';

    wp_reset_postdata();
    
    return ob_get_clean();
}

public function add_yatch_to_cart() {
    if (isset($_GET['action']) && $_GET['action'] == 'add_to_cart' && isset($_GET['yatch_slug'])) {
        echo $_GET['action'];
        $yatch_slug = sanitize_text_field($_GET['yatch_slug']);
        
        $yatch_post = get_posts(array(
            'name'        => $yatch_slug,
            'post_type'   => 'yatch_post',
            'post_status' => 'publish',
            'numberposts' => 1
        ));

        if ($yatch_post) {
            $post = $yatch_post[0];
            $price = get_post_meta($post->ID, '_yatch_price', true);

            // Thêm sản phẩm vào giỏ hàng WooCommerce
            $product_data = array(
                'name' => get_the_title($post),
                'price' => $price,
                'quantity' => 1,
            );

            echo '<pre>';
            print_r($product_data);
            echo '</pre>';

            $cart_item_data = array(
                'custom_price' => $price,
            );

            // Sử dụng hook để thêm sản phẩm vào giỏ hàng với giá tùy chỉnh
            $product_id = wc_get_product_id_by_sku('your-custom-sku'); // Bạn có thể tạo một sản phẩm chung với SKU này để đại diện cho tất cả du thuyền
            WC()->cart->add_to_cart($product_id, 1, 0, array(), $cart_item_data);

            // Chuyển hướng tới trang thanh toán
            // wp_redirect(wc_get_checkout_url());
            exit;
        }
    }
}

}

// Khởi tạo class
new Yatch_Detail_Shortcode();
