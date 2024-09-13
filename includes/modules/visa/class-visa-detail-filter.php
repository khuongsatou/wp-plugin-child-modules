<?php
class Visa_Detail_Filter_Shortcode
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_shortcode('visa_detail_filter', array($this, 'display_visa_detail'));
        // add_shortcode('visa_detail_top_info', array($this, 'display_visa_detail_top_info'));
        // add_action('template_redirect', array($this, 'add_visa_to_cart'));
    }


    public function enqueue_scripts()
    {
        // Đăng ký và tải file JavaScript
        wp_enqueue_script('visa-detail-filter-js',  plugin_dir_url(__FILE__) . 'assets/js/visa-detail-filter.js', ['jquery'], null, true);

        // Truyền biến ajax_url cho file JavaScript
        wp_localize_script('visa-detail-filter-js', 'visa_filter_vars', [
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
        wp_enqueue_style('visa-detail-filter-css', plugin_dir_url(__FILE__) . 'assets/css/visa-detail-filter.css');
    }

    public function display_visa_detail($atts)
    {
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
        $st_form_visa = get_post_meta(get_the_ID(), 'st_form_visa', true);

        ob_start();

        echo '<h1>' . get_the_title() . '</h1>';

        $this->display_visa_detail_top_info($atts);

        echo '<hr/>';


        echo '<div>' . get_the_content() . '</div>';

?>

        <!-- Hiển thị form liên hệ Contact Form 7 -->
        <div class="contact-form">
            <?php echo do_shortcode($st_form_visa); ?>
        </div>


    <?php

        $this->display_custom_list_v2(get_the_ID());

        wp_reset_postdata();

        return ob_get_clean();
    }

    public function display_visa_detail_top_info($atts)
    {
        // ob_start(); // Bắt đầu bộ đệm đầu ra để lưu trữ HTML

        // Lấy dữ liệu từ post meta
        $visa_processing_time = get_post_meta(get_the_ID(), 'visa_processing_time', true);
        $visa_max_stay = get_post_meta(get_the_ID(), 'visa_max_stay', true);
        $visa_validity = get_post_meta(get_the_ID(), 'duration', true);


        // echo '<h1>' . get_the_title() . '</h1>';
        // HTML hiển thị thông tin visa
    ?>
        <div class="visa-info-box">
            <div class="visa-info-item">
                <i class="fas fa-stopwatch"></i>
                <span>Thời gian xử lý: <?php echo esc_html($visa_processing_time); ?> ngày</span>
            </div>
            <div class="visa-info-item">
                <i class="fas fa-history"></i>
                <span>Thời gian lưu trú tối đa: <?php echo esc_html($visa_max_stay); ?> ngày</span>
            </div>
            <div class="visa-info-item">
                <i class="fas fa-undo-alt"></i>
                <span>Hiệu lực visa: <?php echo esc_html($visa_validity); ?> tháng</span>
            </div>
        </div>


        <?php

        // return ob_get_clean(); // Kết thúc bộ đệm đầu ra và trả về nội dung
    }


    // Hiển thị danh sách ra ngoài frontend
    // Hiển thị danh sách và mô tả ra ngoài frontend
    function display_custom_list_v2($post_id)
    {
        $custom_list_data = get_post_meta($post_id, '_custom_list_data', true);
        if (!empty($custom_list_data) && is_array($custom_list_data)) {
            echo '<h3>Câu hỏi thường gặp khi đặt dịch vụ làm VISA?</h3>';
            echo '<div class="container-question">';
            foreach ($custom_list_data as $item) {
        ?>



                <div class="faq-item">
                    <div class="question">
                        <span><?php echo esc_html($item['data']); ?></span>
                        <i class="fas fa-chevron-up"></i>
                    </div>
                    <div class="answer hidden">
                        <?php echo esc_html($item['description']); ?>
                    </div>
                </div>

<?php
          
            }
            echo '</div>';
        }
    }
}
