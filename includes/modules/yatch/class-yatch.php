<?php

if (!defined('ABSPATH')) {
    die;
}

class Yatch
{

    public function __construct()
    {
        $this->register_hooks();
        $this->register_ajax_hooks();
    }

    private function register_hooks()
    {
        add_action('init', array($this, 'custom_post_type'));
        add_action('init', array($this, 'create_yatch_taxonomy'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));

        // Đăng ký shortcode
        add_shortcode('yatch_list', array($this, 'display_yatch_list'));

        // Thêm meta box
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));

        // Thêm cột tùy chỉnh vào danh sách quản lý
        add_filter('manage_yatch_post_posts_columns', array($this, 'set_custom_columns'));
        add_action('manage_yatch_post_posts_custom_column', array($this, 'custom_column'), 10, 2);

        // Sắp xếp theo cột tùy chỉnh
        add_filter('manage_edit-yatch_post_sortable_columns', array($this, 'sortable_columns'));
        add_action('pre_get_posts', array($this, 'sort_custom_columns'));
    }

    private function register_ajax_hooks()
    {
        add_action('wp_ajax_yatch_search', array($this, 'handle_ajax_search'));
        add_action('wp_ajax_nopriv_yatch_search', array($this, 'handle_ajax_search'));
    }

    public function sortable_columns($columns)
    {
        $columns['star_rating'] = 'star_rating';
        $columns['review_count'] = 'review_count';
        $columns['price'] = 'price';
        $columns['cabin_count'] = 'cabin_count';
        $columns['adult_count'] = 'adult_count';
        $columns['children_count'] = 'children_count';
        return $columns;
    }



    public function custom_post_type()
    {
        $labels = array(
            'name'               => _x('Yatches', 'post type general name', 'textdomain'),
            'singular_name'      => _x('Yatch', 'post type singular name', 'textdomain'),
            'menu_name'          => _x('Yatches', 'admin menu', 'textdomain'),
            'name_admin_bar'     => _x('Yatch', 'add new on admin bar', 'textdomain'),
            'add_new'            => _x('Add New', 'yatch', 'textdomain'),
            'add_new_item'       => __('Add New Yatch', 'textdomain'),
            'new_item'           => __('New Yatch', 'textdomain'),
            'edit_item'          => __('Edit Yatch', 'textdomain'),
            'view_item'          => __('View Yatch', 'textdomain'),
            'all_items'          => __('All Yatches', 'textdomain'),
            'search_items'       => __('Search Yatches', 'textdomain'),
            'parent_item_colon'  => __('Parent Yatches:', 'textdomain'),
            'not_found'          => __('No yatches found.', 'textdomain'),
            'not_found_in_trash' => __('No yatches found in Trash.', 'textdomain'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'yatch'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
            'taxonomies'  => array('yatch_category')
        );

        register_post_type('yatch_post', $args);
    }

    public function create_yatch_taxonomy()
    {
        $labels = array(
            'name'              => _x('Yatch Categories', 'taxonomy general name', 'textdomain'),
            'singular_name'     => _x('Yatch Category', 'taxonomy singular name', 'textdomain'),
            'search_items'      => __('Search Yatch Categories', 'textdomain'),
            'all_items'         => __('All Yatch Categories', 'textdomain'),
            'parent_item'       => __('Parent Yatch Category', 'textdomain'),
            'parent_item_colon' => __('Parent Yatch Category:', 'textdomain'),
            'edit_item'         => __('Edit Yatch Category', 'textdomain'),
            'update_item'       => __('Update Yatch Category', 'textdomain'),
            'add_new_item'      => __('Add New Yatch Category', 'textdomain'),
            'new_item_name'     => __('New Yatch Category Name', 'textdomain'),
            'menu_name'         => __('Yatch Categories', 'textdomain'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'yatch-category'),
        );

        register_taxonomy('yatch_category', array('yatch_post'), $args);
    }

    public function enqueue_assets()
    {
        wp_enqueue_style('yatch-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
        wp_enqueue_script('yatch-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);

        wp_localize_script('yatch-script', 'yatchAjax', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }

    // Thêm meta box cho hạng sao, đánh giá, và giá
    public function add_meta_boxes()
    {
        add_meta_box(
            'yatch_meta_box',
            __('Yatch Post Details'),
            array($this, 'render_meta_box'),
            'yatch_post',
            'side',
            'default'
        );
    }

    public function render_meta_box($post)
    {
        // Lấy giá trị hiện tại của các trường
        $star_rating = get_post_meta($post->ID, '_yatch_star_rating', true);
        $review_count = get_post_meta($post->ID, '_yatch_review_count', true);
        $price = get_post_meta($post->ID, '_yatch_price', true);
        $cabin_count = get_post_meta($post->ID, '_yatch_cabin_count', true);
        $adult_count = get_post_meta($post->ID, '_yatch_adult_count', true);
        $children_count = get_post_meta($post->ID, '_yatch_children_count', true);

        // Render các trường trong meta box
?>
        <label for="yatch_star_rating"><?php _e('Star Rating'); ?></label>
        <input style="width:150px !important;" type="number" id="yatch_star_rating" name="yatch_star_rating" value="<?php echo esc_attr($star_rating); ?>" min="1" max="5" step="0.5">
        <br />
        <label for="yatch_review_count"><?php _e('Review Count'); ?></label>
        <input style="width:150px !important;" type="number" id="yatch_review_count" name="yatch_review_count" value="<?php echo esc_attr($review_count); ?>">
        <br />
        <label for="yatch_price"><?php _e('Price'); ?></label>
        <input style="width:150px !important;" type="number" id="yatch_price" name="yatch_price" value="<?php echo esc_attr($price); ?>" step="0.01">
        <br />
        <label for="yatch_cabin_count"><?php _e('Cabin Count'); ?></label>
        <input style="width:150px !important;" type="number" id="yatch_cabin_count" name="yatch_cabin_count" value="<?php echo esc_attr($cabin_count); ?>">
        <br />
        <label for="yatch_adult_count"><?php _e('Adult Count'); ?></label>
        <input style="width:150px !important;" type="number" id="yatch_adult_count" name="yatch_adult_count" value="<?php echo esc_attr($adult_count); ?>">
        <br />
        <label for="yatch_children_count"><?php _e('Children Count'); ?></label>
        <input style="width:150px !important;" type="number" id="yatch_children_count" name="yatch_children_count" value="<?php echo esc_attr($children_count); ?>">
    <?php
    }


    public function save_meta_boxes($post_id)
    {
        if (array_key_exists('yatch_star_rating', $_POST)) {
            update_post_meta($post_id, '_yatch_star_rating', sanitize_text_field($_POST['yatch_star_rating']));
        }
        if (array_key_exists('yatch_review_count', $_POST)) {
            update_post_meta($post_id, '_yatch_review_count', sanitize_text_field($_POST['yatch_review_count']));
        }
        if (array_key_exists('yatch_price', $_POST)) {
            update_post_meta($post_id, '_yatch_price', sanitize_text_field($_POST['yatch_price']));
        }
        if (array_key_exists('yatch_cabin_count', $_POST)) {
            update_post_meta($post_id, '_yatch_cabin_count', sanitize_text_field($_POST['yatch_cabin_count']));
        }
        if (array_key_exists('yatch_adult_count', $_POST)) {
            update_post_meta($post_id, '_yatch_adult_count', sanitize_text_field($_POST['yatch_adult_count']));
        }
        if (array_key_exists('yatch_children_count', $_POST)) {
            update_post_meta($post_id, '_yatch_children_count', sanitize_text_field($_POST['yatch_children_count']));
        }
    }


    // Thêm cột tùy chỉnh vào danh sách quản lý
    public function set_custom_columns($columns)
    {
        $columns['star_rating'] = __('Star Rating');
        $columns['review_count'] = __('Review Count');
        $columns['price'] = __('Price');
        $columns['cabin_count'] = __('Cabin Count');
        $columns['adult_count'] = __('Adult Count');
        $columns['children_count'] = __('Children Count');
        return $columns;
    }


    public function custom_column($column, $post_id)
    {
        switch ($column) {
            case 'star_rating':
                $star_rating = get_post_meta($post_id, '_yatch_star_rating', true);
                echo esc_html($star_rating);
                break;
            case 'review_count':
                $review_count = get_post_meta($post_id, '_yatch_review_count', true);
                echo esc_html($review_count);
                break;
            case 'price':
                $price = get_post_meta($post_id, '_yatch_price', true);
                echo esc_html($price);
                break;
            case 'cabin_count':
                $cabin_count = get_post_meta($post_id, '_yatch_cabin_count', true);
                echo esc_html($cabin_count);
                break;
            case 'adult_count':
                $adult_count = get_post_meta($post_id, '_yatch_adult_count', true);
                echo esc_html($adult_count);
                break;
            case 'children_count':
                $children_count = get_post_meta($post_id, '_yatch_children_count', true);
                echo esc_html($children_count);
                break;
        }
    }



    // Đặt cột tùy chỉnh là sortable
    public function sort_custom_columns($query)
    {
        if (!is_admin() || !$query->is_main_query()) {
            return;
        }

        $orderby = $query->get('orderby');

        if ('star_rating' === $orderby) {
            $query->set('meta_key', '_yatch_star_rating');
            $query->set('orderby', 'meta_value_num');
        } elseif ('review_count' === $orderby) {
            $query->set('meta_key', '_yatch_review_count');
            $query->set('orderby', 'meta_value_num');
        } elseif ('price' === $orderby) {
            $query->set('meta_key', '_yatch_price');
            $query->set('orderby', 'meta_value_num');
        } elseif ('cabin_count' === $orderby) {
            $query->set('meta_key', '_yatch_cabin_count');
            $query->set('orderby', 'meta_value_num');
        } elseif ('adult_count' === $orderby) {
            $query->set('meta_key', '_yatch_adult_count');
            $query->set('orderby', 'meta_value_num');
        } elseif ('children_count' === $orderby) {
            $query->set('meta_key', '_yatch_children_count');
            $query->set('orderby', 'meta_value_num');
        }
    }



    // Hàm hiển thị danh sách post dưới dạng shortcode với chế độ list/grid và sắp xếp
    public function display_yatch_list($atts)
    {
        // Xử lý các tham số shortcode
        $atts = shortcode_atts(
            array(
                'posts_per_page' => 5,
                'view'           => 'list', // Chế độ mặc định là list
                'orderby'        => 'date', // Sắp xếp theo ngày đăng
                'order'          => 'DESC', // Thứ tự giảm dần
            ),
            $atts,
            'yatch_list'
        );

        // Lấy các tham số từ URL nếu có
        $orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : $atts['orderby'];
        $order = isset($_GET['order']) ? strtoupper(sanitize_text_field($_GET['order'])) : $atts['order'];
        $search_query = isset($_GET['search_query']) ? sanitize_text_field($_GET['search_query']) : '';

        // Xác định meta_key dựa trên giá trị của orderby
        $meta_key = $this->get_meta_key($orderby);

        // Cấu hình các tham số cho WP_Query
        $query_args = array(
            'post_type'      => 'yatch_post',
            'posts_per_page' => $atts['posts_per_page'],
            'meta_key'       => $meta_key,
            'orderby'        => $meta_key ? 'meta_value_num' : $orderby,
            'order'          => $order,
            's'              => $search_query, // Thêm từ khóa tìm kiếm vào truy vấn
        );

        // Thêm điều kiện sắp xếp cho các cột cabin_count, adult_count, children_count
        if (in_array($orderby, array('cabin_count', 'adult_count', 'children_count'))) {
            $query_args['meta_key'] = '_yatch_' . $orderby;
            $query_args['orderby'] = 'meta_value_num';
        }

        $query = new WP_Query($query_args);

        ob_start();

        // Thêm form tìm kiếm
        $this->render_search_form($search_query);

        // Thêm nút chuyển đổi chế độ hiển thị
        $this->render_view_toggle($atts['view']);

        // Thêm các nút sắp xếp
        $this->render_sort_buttons($order, $search_query);

        // Hiển thị danh sách các bài viết
        $this->render_posts($query, $atts['view']);

        return ob_get_clean();
    }


    private function get_meta_key($orderby)
    {
        switch ($orderby) {
            case 'star_rating':
                return '_yatch_star_rating';
            case 'review_count':
                return '_yatch_review_count';
            case 'price':
                return '_yatch_price';
            case 'cabin_count':
                return '_yatch_cabin_count';
            case 'adult_count':
                return '_yatch_adult_count';
            case 'children_count':
                return '_yatch_children_count';
            default:
                return '';
        }
    }


    private function render_search_form($search_query)
    {
        echo '<div class="yatch-search-form">';
        echo '<form id="yatch-search-form" method="get">';
        echo '<input type="text" name="search_query" placeholder="' . esc_attr__('Search...', 'text-domain') . '" value="' . esc_attr($search_query) . '" />';
        echo '</form>';
        echo '</div>';
    }

    private function render_view_toggle($current_view)
    {
        echo '<div class="yatch-view-toggle">';
        echo '<button class="yatch-toggle" data-view="list"' . ($current_view === 'list' ? ' disabled' : '') . '>' . __('List View') . '</button>';
        echo '<button class="yatch-toggle" data-view="grid"' . ($current_view === 'grid' ? ' disabled' : '') . '>' . __('Grid View') . '</button>';
        echo '</div>';
    }

    private function render_sort_buttons($current_order, $search_query)
    {
        $sort_fields = array(
            'date'           => __('Date'),
            'star_rating'    => __('Star Rating'),
            'review_count'   => __('Review Count'),
            'price'          => __('Price'),
            'cabin_count'    => __('Cabin Count'),
            'adult_count'    => __('Adult Count'),
            'children_count' => __('Children Count'),
        );

        foreach ($sort_fields as $field => $label) {
            $order = ($current_order === 'ASC') ? 'DESC' : 'ASC';
            $link = add_query_arg(array(
                'orderby' => $field,
                'order'   => $order,
                'search_query' => $search_query,
            ));

            echo '<a href="' . esc_url($link) . '" class="sort-button">' . esc_html($label) . '</a><br/>';
        }
    }


    private function render_posts($query, $view)
    {
        if ($query->have_posts()) {
            echo '<div class="yatch-posts yatch-' . esc_attr($view) . '-view">';
            while ($query->have_posts()) {
                $query->the_post();
                $this->render_post_item();
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>' . __('No posts found.') . '</p>';
        }
    }



    private function render_post_item()
    {
        $star_rating = get_post_meta(get_the_ID(), '_yatch_star_rating', true);
        $review_count = get_post_meta(get_the_ID(), '_yatch_review_count', true);
        $price = get_post_meta(get_the_ID(), '_yatch_price', true);
        $cabin_count = get_post_meta(get_the_ID(), '_yatch_cabin_count', true);
        $adult_count = get_post_meta(get_the_ID(), '_yatch_adult_count', true);
        $children_count = get_post_meta(get_the_ID(), '_yatch_children_count', true);
    ?>



        <?php
        echo '<div class="yatch-post-item">';
        ?>
        <h2>
            <a href="<?php echo esc_url(add_query_arg('yatch_slug', get_post_field('post_name', get_the_ID()), '/yatch-detail')); ?>">
                <?php the_title(); ?>
            </a>
        </h2>

        <?php
        if (has_post_thumbnail()) {
            echo get_the_post_thumbnail(get_the_ID(), 'medium');
        }
        // echo '<h2>' . get_the_title() . '</h2>';
        echo '</a>';
        echo '<p>' . __('Star Rating: ') . esc_html($star_rating) . '</p>';
        echo '<p>' . __('Review Count: ') . esc_html($review_count) . '</p>';
        echo '<p>' . __('Price: $') . esc_html($price) . '</p>';
        echo '<p>' . __('Cabins: ') . esc_html($cabin_count) . '</p>';
        echo '<p>' . __('Adults: ') . esc_html($adult_count) . '</p>';
        echo '<p>' . __('Children: ') . esc_html($children_count) . '</p>';
        echo '<p>' . get_the_excerpt() . '</p>'; // Hiển thị nội dung tóm tắt
        echo '</div>';
    }




    public function handle_ajax_search()
    {
        $atts = array(
            'posts_per_page' => 5,
            'view'           => 'list',
            'orderby'        => isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date',
            'order'          => isset($_GET['order']) ? strtoupper(sanitize_text_field($_GET['order'])) : 'DESC',
        );

        $search_query = isset($_GET['search_query']) ? sanitize_text_field($_GET['search_query']) : '';
        $meta_query = array('relation' => 'OR');
        if (!empty($search_query)) {
            $meta_query[] = array(
                'key'     => '_yatch_star_rating',
                'value'   => $search_query,
                'compare' => 'LIKE',
                'type'    => 'NUMERIC'
            );
        }

        echo '<pre>';
        print_r($meta_query);
        echo '</pre>';


        if (!empty($search_query)) {
            $meta_query[] = array(
                'key'     => '_yatch_review_count',
                'value'   => $search_query,
                'compare' => 'LIKE',
                'type'    => 'NUMERIC'
            );
        }

        if (!empty($search_query)) {
            $meta_query[] = array(
                'key'     => '_yatch_price',
                'value'   => $search_query,
                'compare' => 'LIKE',
                'type'    => 'NUMERIC'
            );
        }

        $meta_key = '';
        if ($atts['orderby'] === 'star_rating') {
            $meta_key = '_yatch_star_rating';
        } elseif ($atts['orderby'] === 'review_count') {
            $meta_key = '_yatch_review_count';
        } elseif ($atts['orderby'] === 'price') {
            $meta_key = '_yatch_price';
        }

        // Tạo một hàm tùy chỉnh để thay đổi điều kiện WHERE của truy vấn
        add_filter('posts_where', function ($where) use ($search_query) {
            if (!empty($search_query)) {
                global $wpdb;
                $where .= $wpdb->prepare(" OR {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like($search_query) . '%');
            }
            // Thêm điều kiện post_type vào WHERE
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_type = %s", 'yatch_post');
            return $where;
        });

        $query_args = array(
            'post_type'      => 'yatch_post',
            'posts_per_page' => $atts['posts_per_page'],
            'meta_key'       => $meta_key,
            'orderby'        => $meta_key ? 'meta_value_num' : $atts['orderby'],
            'order'          => $atts['order'],
            // 's'              => $search_query,
            'meta_query'     => $meta_query
        );

        $query = new WP_Query($query_args);
        // echo '<pre>'; print_r($query ); echo '</pre>';

        // Loại bỏ filter sau khi sử dụng để không ảnh hưởng đến các truy vấn khác
        remove_filter('posts_where', function ($where) use ($search_query) {
            if (!empty($search_query)) {
                global $wpdb;
                $where .= $wpdb->prepare(" OR {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like($search_query) . '%');
            }
            // Thêm điều kiện post_type vào WHERE
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_type = %s", 'yatch_post');
            return $where;
        });


        ob_start();

        if ($query->have_posts()) {
            echo '<div class="yatch-posts yatch-' . esc_attr($atts['view']) . '-view">';
            while ($query->have_posts()) {
                $query->the_post();

                $star_rating = get_post_meta(get_the_ID(), '_yatch_star_rating', true);
                $review_count = get_post_meta(get_the_ID(), '_yatch_review_count', true);
                $price = get_post_meta(get_the_ID(), '_yatch_price', true);

        ?>



<?php


                echo '<div class="yatch-post-item">';
                echo '<a href="' . get_permalink() . '">';
                if (has_post_thumbnail()) {
                    echo get_the_post_thumbnail(get_the_ID(), 'medium');
                }
                echo '<h2>' . get_the_title() . '</h2>';
                echo '</a>';
                echo '<p>' . __('Star Rating: ') . esc_html($star_rating) . '</p>';
                echo '<p>' . __('Review Count: ') . esc_html($review_count) . '</p>';
                echo '<p>' . __('Price: $') . esc_html($price) . '</p>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>' . __('No posts found.') . '</p>';
        }

        wp_reset_postdata();
        echo ob_get_clean();
        wp_die();
    }


    public function run()
    {
        // Các thao tác cần thiết khi plugin khởi chạy
    }

    public static function activate()
    {
        // Logic kích hoạt như tạo bảng database, thêm tùy chọn
    }

    public static function deactivate()
    {
        // Logic vô hiệu hóa như xóa bảng database, xóa tùy chọn
    }
}

// Kích hoạt plugin
register_activation_hook(__FILE__, array('Yatch', 'activate'));

// Vô hiệu hóa plugin
register_deactivation_hook(__FILE__, array('Yatch', 'deactivate'));
