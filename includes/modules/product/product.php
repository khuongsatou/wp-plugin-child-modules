<?php
class Custom_Product_Shortcode {

    public function __construct() {
        add_shortcode('custom_product', array($this, 'custom_product_shortcode'));
        add_action('template_redirect', array($this, 'handle_add_to_cart'));
    }

    public function custom_product_shortcode($atts) {
        $atts = shortcode_atts(
            array(
                'posts_per_page' => 10,
            ), $atts, 'custom_product'
        );
        
        // Truy vấn custom post type 'custom_product'
        $args = array(
            'post_type' => 'custom_product',
            'posts_per_page' => $atts['posts_per_page'],
        );
        
        $products = new WP_Query($args);
        
        if (!$products->have_posts()) return 'No products found';
        
        ob_start();
        ?>
        <div class="custom-products">
            <?php while ($products->have_posts()) : $products->the_post(); ?>
                <div class="product-item">
                    <h2><?php the_title(); ?></h2>
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    <p><?php the_content(); ?></p>
                    <a href="<?php echo esc_url(add_query_arg('add_custom_to_cart', get_the_ID(), get_permalink())); ?>" class="button add-to-cart">Add to Cart</a>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
        
        return ob_get_clean();
    }

    public function handle_add_to_cart() {
        if (isset($_GET['add_custom_to_cart'])) {
            $product_id = intval($_GET['add_custom_to_cart']);
            $custom_product = get_post($product_id);

            // Kiểm tra nếu custom product tồn tại
            if ($custom_product && $custom_product->post_type === 'custom_product') {
                // Tạo một sản phẩm đơn giản tạm thời trong WooCommerce
                $woocommerce_product = new WC_Product_Simple();
                $woocommerce_product->set_name($custom_product->post_title);
                $woocommerce_product->set_regular_price(get_post_meta($product_id, '_price', true));
                $woocommerce_product->save();

                // Thêm sản phẩm vào giỏ hàng
                WC()->cart->add_to_cart($woocommerce_product->get_id());

                // Chuyển hướng tới trang checkout
                wp_redirect(wc_get_checkout_url());
                exit;
            }
        }
    }
}


new Custom_Product_Shortcode();