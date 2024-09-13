<?php 
// Load the Visa Module
require_once plugin_dir_path(__FILE__) . 'modules/visa/class-visa.php';
require_once plugin_dir_path(__FILE__) . 'modules/visa/class-visa-detail.php';
require_once plugin_dir_path(__FILE__) . 'modules/visa/functions-visa.php';
require_once plugin_dir_path(__FILE__) . 'modules/visa/class-visa-taxonomy-filter.php';
require_once plugin_dir_path(__FILE__) . 'modules/visa/class-visa-detail-filter.php';

// Load the Visa Module
// require_once plugin_dir_path(__FILE__) . 'modules/product/product.php';
// require_once plugin_dir_path(__FILE__) . 'modules/product/product-detail.php';
// require_once plugin_dir_path(__FILE__) . 'modules/product/functions.php';

// Initialize the Visa Module
if (class_exists('Visa')) {
    // Khởi tạo module
    $visa_module = new Visa();

    // Khởi tạo module
    $visa_detail_module = new Visa_Detail_Shortcode();
    $visa_taxonomy_filter_module = new  VisaTaxonomyFilter();
    $visa_detail_filter_module = new  Visa_Detail_Filter_Shortcode();
}
