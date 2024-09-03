<?php

class Yatch_Product_Shortcode {

    public function __construct() {
        add_shortcode('custom_yatch', array($this, 'custom_yatch_shortcode'));
    }

    function custom_yatch_shortcode($atts) {
        $atts = shortcode_atts(
            array(
                'posts_per_page' => 10, // Số lượng sản phẩm cần hiển thị
            ), $atts, 'custom_yatch'
        );
        
        // Truy vấn các sản phẩm của WooCommerce
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $atts['posts_per_page'],
        );
        
        $products = new WP_Query($args);
        
        if (!$products->have_posts()) return 'No products found';
        
        ob_start();
        ?>
        <div class="custom-products">
            <?php while ($products->have_posts()) : $products->the_post(); global $product; ?>
                <div class="product-item">
                    <h2><?php the_title(); ?></h2>
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    <p><?php echo $product->get_price_html(); ?></p>
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>?add-to-cart=<?php echo esc_attr($product->get_id()); ?>" class="button add-to-cart">Add to Cart</a>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
        
        return ob_get_clean();
    }
}

// Khởi tạo class
new Yatch_Product_Shortcode();
