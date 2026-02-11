<?php
defined('ABSPATH') || exit;

class WEMP_REST_API {

    public function __construct() {
        add_action('rest_api_init', [$this, 'routes']);
    }

    public function routes() {
        register_rest_route('events/v1', '/list', [
            'methods' => 'GET',
            'callback' => [$this, 'get_events'],
        ]);
    }

    public function get_events() {
        return get_posts(['post_type' => 'event']);
    }
}

new WEMP_REST_API();