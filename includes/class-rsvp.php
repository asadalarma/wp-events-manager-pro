<?php
defined('ABSPATH') || exit;

class WEMP_RSVP {

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        add_action('wp_ajax_wemp_rsvp', [$this, 'handle_rsvp']);
        add_action('wp_ajax_nopriv_wemp_rsvp', [$this, 'handle_rsvp']);

        add_shortcode('event_rsvp', [$this, 'render_rsvp_button']);
    }

    /**
     * Enqueue JS for AJAX RSVP
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'wemp-rsvp',
            WEMP_URL . 'assets/js/rsvp.js',
            ['jquery'],
            '1.0',
            true
        );

        wp_localize_script('wemp-rsvp', 'wempRSVP', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('wemp_rsvp_nonce')
        ]);
    }

    /**
     * Render RSVP button
     */
    public function render_rsvp_button() {
        if (!is_singular('event')) {
            return '';
        }

        global $post;

        return sprintf(
            '<button class="wemp-rsvp-btn" data-event="%d">%s</button>',
            esc_attr($post->ID),
            esc_html__('RSVP for this Event', 'wp-events-manager-pro')
        );
    }

    /**
     * Handle RSVP AJAX request
     */
    public function handle_rsvp() {

        // Security check
        if (
            !isset($_POST['nonce']) ||
            !wp_verify_nonce($_POST['nonce'], 'wemp_rsvp_nonce')
        ) {
            wp_send_json_error(__('Invalid security token.', 'wp-events-manager-pro'));
        }

        $event_id = absint($_POST['event_id'] ?? 0);

        if (!$event_id || get_post_type($event_id) !== 'event') {
            wp_send_json_error(__('Invalid event.', 'wp-events-manager-pro'));
        }

        $user_identifier = is_user_logged_in()
            ? get_current_user_id()
            : sanitize_text_field($_SERVER['REMOTE_ADDR']);

        $rsvps = get_post_meta($event_id, '_event_rsvps', true);
        $rsvps = is_array($rsvps) ? $rsvps : [];

        // Prevent duplicate RSVP
        if (in_array($user_identifier, $rsvps, true)) {
            wp_send_json_error(__('You have already RSVP’d.', 'wp-events-manager-pro'));
        }

        $rsvps[] = $user_identifier;
        update_post_meta($event_id, '_event_rsvps', $rsvps);

        wp_send_json_success(__('RSVP confirmed. Thank you!', 'wp-events-manager-pro'));
    }
}

new WEMP_RSVP();