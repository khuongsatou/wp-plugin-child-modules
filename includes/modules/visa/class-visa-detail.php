<?php
class Visa_Detail_Shortcode {

    public function __construct() {
        add_shortcode('visa_detail', array($this, 'display_visa_detail'));
        add_action('template_redirect', array($this, 'add_visa_to_cart'));
    }

    public function display_visa_detail($atts) {
        global $post;

        if (isset($_GET['visa_slug'])) {
            $visa_slug = sanitize_text_field($_GET['visa_slug']);
        } else {
            return '<p>' . __('No visa selected.', 'text-domain') . '</p>';
        }

        $visa_post = get_posts(array(
            'name'        => $visa_slug,
            'post_type'   => 'visa_post',
            'post_status' => 'publish',
            'numberposts' => 1
        ));

        if (!$visa_post) {
            return '<p>' . __('Visa not found.', 'text-domain') . '</p>';
        }

        $post = $visa_post[0];
        setup_postdata($post);

        $price = get_post_meta(get_the_ID(), '_visa_price', true);

        ob_start();
        
        echo '<h1>' . get_the_title() . '</h1>';
        echo '<div>' . get_the_content() . '</div>';
        echo '<p>Star Rating: ' . esc_html(get_post_meta(get_the_ID(), '_visa_star_rating', true)) . '</p>';
        echo '<p>Review Count: ' . esc_html(get_post_meta(get_the_ID(), '_visa_review_count', true)) . '</p>';
        echo '<p>Price: $' . esc_html($price) . '</p>';
        echo '<p>Thêm vào cart: ' . '<a href="' . esc_url(add_query_arg(array(
            // 'visa_sku' => get_post_field('_visa_sku', true),
            'visa_slug' => get_post_field('post_name', get_the_ID()),
            'action' => 'add_to_cart'
        ), get_permalink())) . '">' . __('Add to Cart', 'text-domain') . '</a>' . '</p>';


        wp_reset_postdata();
        
        return ob_get_clean();
    }

    public function add_visa_to_cart() {
        if (isset($_GET['action']) && $_GET['action'] == 'add_to_cart' && isset($_GET['visa_slug'])) {
            echo $_GET['action'];
            $visa_slug = sanitize_text_field($_GET['visa_slug']);
            
            $visa_post = get_posts(array(
                'name'        => $visa_slug,
                'post_type'   => 'visa_post',
                'post_status' => 'publish',
                'numberposts' => 1
            ));

            if ($visa_post) {
                $post = $visa_post[0];
                $price = get_post_meta($post->ID, '_visa_price', true);
                $visa_sku = get_post_meta($post->ID, '_visa_sku', true);

                // Thêm sản phẩm vào giỏ hàng WooCommerce
                $product_data = array(
                    'name' => get_the_title($post),
                    'price' => $price,
                    'visa_sku' => $visa_sku,
                    'quantity' => 1,
                );

                echo '<pre>';
                print_r($product_data);
                echo '</pre>';

                $cart_item_data = array(
                    'custom_price' => $price,
                );

                // Sử dụng hook để thêm sản phẩm vào giỏ hàng với giá tùy chỉnh
                $product_id = wc_get_product_id_by_sku($visa_sku); // Bạn có thể tạo một sản phẩm chung với SKU này để đại diện cho tất cả du thuyền inventory "visa_booking"
                # Sau đó sẽ lấy ID product_id ra
                echo $product_id;
                echo '<pre>';
                print_r($cart_item_data);
                echo '</pre>';
                WC()->cart->add_to_cart($product_id, 1, 0, array(), $cart_item_data);

                // Chuyển hướng tới trang thanh toán
                wp_redirect(wc_get_checkout_url());
                exit;
            }
        }
    }

}

// // Khởi tạo class
// new Visa_Detail_Shortcode();
