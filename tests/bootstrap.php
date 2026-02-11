<?php
// Load Composer autoloader (for PHPUnit Polyfills)
require dirname( __DIR__ ) . '/vendor/autoload.php';

// Path to WordPress test suite
$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
    $_tests_dir = '/tmp/wordpress-tests-lib';
}

// Load WordPress test functions
require_once $_tests_dir . '/includes/functions.php';

// Load your plugin
require dirname( dirname( __FILE__ ) ) . '/wp-events-manager-pro.php';
