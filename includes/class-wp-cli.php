<?php
defined('ABSPATH') || exit;

class WEMP_WP_CLI {

    public function __construct() {
        if (defined('WP_CLI')) {
            WP_CLI::add_command('event create', [$this, 'create']);
        }
    }

    public function create($args) {
        wp_insert_post([
            'post_type' => 'event',
            'post_title' => $args[0] ?? 'CLI Event',
            'post_status' => 'publish',
        ]);

        WP_CLI::success('Event created successfully.');
    }
}

new WEMP_WP_CLI();