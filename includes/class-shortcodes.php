<?php
defined('ABSPATH') || exit;

class WEMP_Shortcodes {

    public function __construct() {
        add_shortcode('event_list', [$this, 'list_events']);
        add_shortcode('event_rsvp', [$this, 'rsvp']);
    }

    public function list_events() {
        $events = get_posts(['post_type' => 'event']);
        ob_start();
        foreach ($events as $event) {
            echo '<p><a href="' . get_permalink($event->ID) . '">' . esc_html($event->post_title) . '</a></p>';
        }
        return ob_get_clean();
    }

    public function rsvp() {
        return do_shortcode('[event_rsvp]');
    }
}

new WEMP_Shortcodes();