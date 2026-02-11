<?php
defined('ABSPATH') || exit;

class WEMP_Taxonomy_Event_Type {

    public function __construct() {
        add_action('init', [$this, 'register']);
    }

    public function register() {
        register_taxonomy('event_type', 'event', [
            'label' => __('Event Type', 'wp-events-manager-pro'),
            'hierarchical' => true,
            'show_in_rest' => true,
        ]);
    }
}

new WEMP_Taxonomy_Event_Type();
