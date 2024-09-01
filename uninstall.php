<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit; // Bảo vệ trực tiếp truy cập file.
}

// Xóa các cài đặt hoặc dữ liệu liên quan đến plugin tại đây.
// Xóa các tùy chọn hoặc dữ liệu đã lưu
delete_option('mtips5s-traveler_option');
