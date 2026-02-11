<?php
/**
 * Plugin Name: WP Events Manager Pro
 * Description: Custom Events Manager with WP-CLI, RSVP, REST API, filtering, and notifications.
 * Version: 1.0.0
 * Author: Muhammad Asad
 * Text Domain: wp-events-manager-pro
 * Domain Path: /languages
 */

defined('ABSPATH') || exit;

define('WEMP_PATH', plugin_dir_path(__FILE__));
define('WEMP_URL', plugin_dir_url(__FILE__));

require_once WEMP_PATH . 'includes/class-cpt-event.php';
require_once WEMP_PATH . 'includes/class-taxonomy-event-type.php';
require_once WEMP_PATH . 'includes/class-meta-boxes.php';
require_once WEMP_PATH . 'includes/class-admin-columns.php';
require_once WEMP_PATH . 'includes/class-shortcodes.php';
require_once WEMP_PATH . 'includes/class-search-filter.php';
require_once WEMP_PATH . 'includes/class-rest-api.php';
require_once WEMP_PATH . 'includes/class-notifications.php';
require_once WEMP_PATH . 'includes/class-rsvp.php';
require_once WEMP_PATH . 'includes/class-wp-cli.php';

add_action('plugins_loaded', function () {
    load_plugin_textdomain(
        'wp-events-manager-pro',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
});
