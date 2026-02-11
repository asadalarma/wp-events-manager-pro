<?php
defined('ABSPATH') || exit;

class WEMP_Admin_Columns {

    public function __construct() {
        add_filter('manage_event_posts_columns', [$this, 'columns']);
        add_action('manage_event_posts_custom_column', [$this, 'render'], 10, 2);
    }

    public function columns($cols) {
        $cols['event_date'] = __('Date', 'wp-events-manager-pro');
        $cols['event_location'] = __('Location', 'wp-events-manager-pro');
        return $cols;
    }

    public function render($column, $post_id) {
        if ($column === 'event_date') {
            echo esc_html(get_post_meta($post_id, '_event_date', true));
        }
        if ($column === 'event_location') {
            echo esc_html(get_post_meta($post_id, '_event_location', true));
        }
    }
}

new WEMP_Admin_Columns();
