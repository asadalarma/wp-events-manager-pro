<?php
defined('ABSPATH') || exit;

class WEMP_Meta_Boxes {

    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add']);
        add_action('save_post', [$this, 'save']);
    }

    public function add() {
        add_meta_box(
            'event_details',
            __('Event Details', 'wp-events-manager-pro'),
            [$this, 'render'],
            'event'
        );
    }

    public function render($post) {
        wp_nonce_field('wemp_save_event', 'wemp_nonce');
        ?>
        <p>
            <label><?php _e('Event Date', 'wp-events-manager-pro'); ?></label><br>
            <input type="date" name="event_date" value="<?php echo esc_attr(get_post_meta($post->ID, '_event_date', true)); ?>">
        </p>
        <p>
            <label><?php _e('Location', 'wp-events-manager-pro'); ?></label><br>
            <input type="text" name="event_location" value="<?php echo esc_attr(get_post_meta($post->ID, '_event_location', true)); ?>">
        </p>
        <?php
    }

    public function save($post_id) {
        if (!isset($_POST['wemp_nonce']) || !wp_verify_nonce($_POST['wemp_nonce'], 'wemp_save_event')) {
            return;
        }

        update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date'] ?? ''));
        update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location'] ?? ''));
    }
}

new WEMP_Meta_Boxes();