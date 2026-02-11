<?php
defined('ABSPATH') || exit;

class WEMP_CPT_Event {

    public function __construct() {
        add_action('init', [$this, 'register']);
    }

    public function register() {
        register_post_type('event', [
            'labels' => [
                'name' => __('Events', 'wp-events-manager-pro'),
                'singular_name' => __('Event', 'wp-events-manager-pro'),
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'events'],
            'supports' => ['title', 'editor', 'thumbnail'],
            'show_in_rest' => true,
        ]);
    }
}

new WEMP_CPT_Event();
