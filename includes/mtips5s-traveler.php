<?php 
// Load the Yatch Module
require_once plugin_dir_path(__FILE__) . 'modules/yatch/class-yatch.php';
require_once plugin_dir_path(__FILE__) . 'modules/yatch/class-yatch-detail.php';
require_once plugin_dir_path(__FILE__) . 'modules/yatch/functions-yatch.php';

// Load the Yatch Module
// require_once plugin_dir_path(__FILE__) . 'modules/product/product.php';
// require_once plugin_dir_path(__FILE__) . 'modules/product/product-detail.php';
// require_once plugin_dir_path(__FILE__) . 'modules/product/functions.php';

// Initialize the Yatch Module
if (class_exists('Yatch')) {
    $yatch_module = new Yatch();

    // Khởi tạo class
    $yatch_detail_module = new Yatch_Detail_Shortcode();
}
