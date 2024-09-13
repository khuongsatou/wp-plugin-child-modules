<?php
// functions.php hoặc plugin tùy chỉnh

class VisaTaxonomyFilter
{

    public function __construct()
    {
        add_shortcode('visa_tabs', [$this, 'render_shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        # MetaBox
        add_action('add_meta_boxes', array($this, 'add_meta_boxes_v2'));
        add_action('save_post', array($this, 'save_meta_box_visa_v2'));

        add_action('add_meta_boxes', array($this, 'add_custom_meta_box_v2'));
        add_action('save_post', array($this, 'save_custom_meta_box_data_v2'));

        # Ajax
        add_action('wp_ajax_filter_visa_posts', [$this, 'filter_visa_posts']);
        add_action('wp_ajax_nopriv_filter_visa_posts', [$this, 'filter_visa_posts']);
    }

    public function enqueue_scripts()
    {
        // Đăng ký và tải file JavaScript
        wp_enqueue_script('visa-filter-js',  plugin_dir_url(__FILE__) . 'assets/js/visa-filter.js', ['jquery'], null, true);

        // Truyền biến ajax_url cho file JavaScript
        wp_localize_script('visa-filter-js', 'visa_filter_vars', [
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
        wp_enqueue_style('visa-filter-css', plugin_dir_url(__FILE__) . 'assets/css/visa-filter.css');
    }

    public function render_shortcode()
    {
        ob_start();
?>
        <div class="tabs">
            <ul class="tab-nav">
                <li class="tab-item active" data-region="">
                    <i class="fas fa-globe-asia"></i> All
                </li>
                <li class="tab-item" data-region="chau-a">
                    <i class="fas fa-globe-asia"></i> Châu Á
                </li>
                <li class="tab-item" data-region="chau-au">
                    <i class="fas fa-globe-europe"></i> Châu Âu
                </li>
                <li class="tab-item" data-region="chau-my">
                    <i class="fas fa-globe-americas"></i> Châu Mỹ
                </li>
            </ul>
            <div id="visa-posts" class="tab-content">
                <!-- Nội dung bài viết sẽ được AJAX tải vào đây -->
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function filter_visa_posts()
    {
        $region = isset($_POST['region']) ? sanitize_text_field($_POST['region']) : '';
        // echo $region;
        // Tùy chỉnh lại truy vấn bài viết theo taxonomy tương ứng
        if (!empty($region)) {
            $args = array(
                'post_type' => 'visa_post',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'visa_category',
                        'field'    => 'slug',
                        'terms'    => sanitize_text_field($region),
                    ),
                ),
            );
        } else {
            $args = array(
                'post_type' => 'visa_post'
            );
        }


        // echo '<pre>';
        // print_r($args);
        // echo '</pre>';

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
        ?>
                <div class="card">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" onerror="this.src='https://www.cvent-assets.com/brand-page-guestside-site/assets/images/venue-card-placeholder.png';">
                    <div class="info">
                        <a class="link" href="<?php echo esc_url(add_query_arg('visa_slug', get_post_field('post_name', get_the_ID()), '/visa-detail-v2')); ?>">
                            <?php the_title(); ?>
                        </a>
                        <p class="excerpt">
                            <?php echo get_the_excerpt(); ?>
                        </p>
                        <div class="meta">
                            <span>
                                <i class="fas fa-star"></i> <?php echo get_post_meta(get_the_ID(), 'rating', true); ?> (<?php echo get_post_meta(get_the_ID(), 'booked_count', true); ?> booked)
                            </span>
                            <span class="visa-type"><i class="fas fa-suitcase"></i> <?php echo get_post_meta(get_the_ID(), 'visa_type', true); ?></span>
                        </div>
                        <div class="details">
                            <span class="duration"><i class="fas fa-clock"></i> <?php echo get_post_meta(get_the_ID(), 'duration', true); ?></span>
                            <span class="price">$<?php echo get_post_meta(get_the_ID(), 'price', true); ?></span>
                        </div>
                        <button onclick="window.location.href='<?php echo esc_url(add_query_arg('visa_slug', get_post_field('post_name', get_the_ID()), '/visa-detail-v2')); ?>'">Book Now</button>
                    </div>
                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>No posts found.</p>';
        endif;

        wp_die();
    }


    public function add_meta_boxes_v2()
    {
        add_meta_box(
            'visa_meta_box_v2',
            __('Visa Post Details v2'),
            array($this, 'render_meta_box_v2'),
            'visa_post',
            'side',
            'default'
        );
    }

    public function render_meta_box_v2($post)
    {
        // Lấy các giá trị hiện tại của các trường meta
        $rating = get_post_meta($post->ID, 'rating', true);
        $booked_count = get_post_meta($post->ID, 'booked_count', true);
        $visa_type = get_post_meta($post->ID, 'visa_type', true);
        $price = get_post_meta($post->ID, 'price', true);
        $duration = get_post_meta($post->ID, 'duration', true);
        $valid_until = get_post_meta($post->ID, 'valid_until', true);
        $country = get_post_meta($post->ID, 'country', true);
        $visa_processing_time = get_post_meta($post->ID, 'visa_processing_time', true);
        $visa_max_stay = get_post_meta($post->ID, 'visa_max_stay', true);
        $st_form_visa = get_post_meta($post->ID, 'st_form_visa', true);
        ?>
        <div class="meta-box">
            <p>
                <label for="rating"><?php _e('Rating:', 'textdomain'); ?></label>
                <input type="number" step="0.1" id="rating" name="rating" value="<?php echo esc_attr($rating); ?>" />
            </p>
            <p>
                <label for="booked_count"><?php _e('Booked Count:', 'textdomain'); ?></label>
                <input type="number" id="booked_count" name="booked_count" value="<?php echo esc_attr($booked_count); ?>" />
            </p>
            <p>
                <label for="visa_type"><?php _e('Visa Type:', 'textdomain'); ?></label>
                <input type="text" id="visa_type" name="visa_type" value="<?php echo esc_attr($visa_type); ?>" />
            </p>
            <p>
                <label for="price"><?php _e('Price:', 'textdomain'); ?></label>
                <input type="number" step="0.01" id="price" name="price" value="<?php echo esc_attr($price); ?>" />
            </p>
            <p>
                <label for="duration"><?php _e('Duration:', 'textdomain'); ?></label>
                <input type="text" id="duration" name="duration" value="<?php echo esc_attr($duration); ?>" />
            </p>

            <p>
                <label for="visa_processing_time"><?php _e('Visa processing time:', 'textdomain'); ?></label>
                <input type="number" id="visa_processing_time" name="visa_processing_time" value="<?php echo esc_attr($visa_processing_time); ?>" />
            </p>
            <p>
                <label for="visa_max_stay"><?php _e('Visa max stay:', 'textdomain'); ?></label>
                <input type="number" id="visa_max_stay" name="visa_max_stay" value="<?php echo esc_attr($visa_max_stay); ?>" />
            </p>
            <p>
                <label for="st_form_visa"><?php _e('Shortcode Form Visa:', 'textdomain'); ?></label>
                <input type="text" id="st_form_visa" name="st_form_visa" value="<?php echo esc_attr($st_form_visa); ?>" />
            </p>
        </div>
    <?php
    }

    public function save_meta_box_visa_v2($post_id)
    {
        // Kiểm tra quyền người dùng
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Lưu các trường meta
        $fields = ['rating', 'booked_count', 'visa_type', 'price', 'duration', 'valid_until', 'country', 'visa_processing_time', 'visa_max_stay', 'st_form_visa'];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }

    // Thêm meta box vào custom post type
    public function add_custom_meta_box_v2() {

    add_meta_box(
        'visa_meta_box_post_question_v2',
        __('Visa Post Question Details v2'),
        array($this, 'render_custom_meta_box_v2'),
        'visa_post',
        'normal',
        'high'
    );
}

    // Hàm render form trong meta box
    public function render_custom_meta_box_v2($post)
{
    // Lấy dữ liệu đã lưu từ post meta (nếu có)
    $saved_data = get_post_meta($post->ID, '_custom_list_data', true);
    ?>
    <div id="custom-meta-box-container">
        <button style="padding:10px;margin-bottom:10px;" type="button" id="add-item-button">Thêm trường nhập</button>
        <div id="input-container">
            <?php
            if (!empty($saved_data)) {
                foreach ($saved_data as $key => $value) {
                    // Hiển thị cả phần description (nếu có)
                    echo '<div class="input-group" style="margin-top:10px;">
                        <input type="text" name="custom_list_data[]" value="' . esc_attr($value['data']) . '" placeholder="Nhập dữ liệu" />
                        <input type="text" name="custom_description_data[]" value="' . esc_attr($value['description']) . '" placeholder="Nhập mô tả" style="margin-left: 10px;" />
                        <button type="button" class="remove-input" style="margin-left: 10px;">Xóa</button>
                    </div>';
                }
            }
            ?>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#add-item-button').click(function() {
                var inputGroup = '<div class="input-group" style="margin-top:10px;">' +
                                 '<input type="text" name="custom_list_data[]" placeholder="Nhập dữ liệu"/>' +
                                 '<input type="text" name="custom_description_data[]" placeholder="Nhập mô tả" style="margin-left: 10px;" />' +
                                 '<button style="margin-left:5px;" type="button" class="remove-input">Xóa</button>' +
                                 '</div>';
                $('#input-container').append(inputGroup);
            });

            $(document).on('click', '.remove-input', function() {
                $(this).parent().remove();
            });
        });
    </script>
    <?php
}

    


// Hàm lưu dữ liệu meta box
function save_custom_meta_box_data_v2($post_id) {
    // Kiểm tra quyền của người dùng
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Kiểm tra nếu có dữ liệu gửi đi
    if (isset($_POST['custom_list_data']) && is_array($_POST['custom_list_data']) && isset($_POST['custom_description_data']) && is_array($_POST['custom_description_data'])) {
        $data_to_save = [];
        foreach ($_POST['custom_list_data'] as $key => $data) {
            // Lưu cả phần description tương ứng
            $description = sanitize_text_field($_POST['custom_description_data'][$key]);
            $data_to_save[] = [
                'data' => sanitize_text_field($data),
                'description' => $description
            ];
        }

        // Cập nhật post meta với cả dữ liệu và description
        update_post_meta($post_id, '_custom_list_data', $data_to_save);
    } else {
        // Nếu không có dữ liệu thì xóa meta
        delete_post_meta($post_id, '_custom_list_data');
    }
}


}
