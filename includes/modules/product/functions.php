<?php

function create_custom_product_post_type() {
    register_post_type('custom_product',
        array(
            'labels' => array(
                'name' => __('Custom Products'),
                'singular_name' => __('Custom Product')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'menu_icon' => 'dashicons-cart',
        )
    );
}
add_action('init', 'create_custom_product_post_type');
