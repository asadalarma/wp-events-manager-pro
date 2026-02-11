<?php
defined('ABSPATH') || exit;

class WEMP_Notifications {

    public function __construct() {
        add_action(
            'transition_post_status',
            [$this, 'handle_event_status_change'],
            10,
            3
        );
    }

    /**
     * Send notifications on event publish or update
     *
     * @param string  $new_status
     * @param string  $old_status
     * @param WP_Post $post
     */
    public function handle_event_status_change($new_status, $old_status, $post) {

        // Only for Event post type
        if ($post->post_type !== 'event') {
            return;
        }

        // Ignore autosave & revisions
        if (wp_is_post_autosave($post->ID) || wp_is_post_revision($post->ID)) {
            return;
        }

        // Publish event
        if ($old_status !== 'publish' && $new_status === 'publish') {
            $this->send_publish_notification($post);
        }

        // Update published event
        if ($old_status === 'publish' && $new_status === 'publish') {
            $this->send_update_notification($post);
        }
    }

    /**
     * Email when event is published
     */
    private function send_publish_notification(WP_Post $post) {

        $subject = sprintf(
            __('New Event Published: %s', 'wp-events-manager-pro'),
            $post->post_title
        );

        $message = sprintf(
            __("A new event has been published.\n\nTitle: %s\nView Event: %s", 'wp-events-manager-pro'),
            $post->post_title,
            get_permalink($post->ID)
        );

        $this->send_email($subject, $message);
    }

    /**
     * Email when event is updated
     */
    private function send_update_notification(WP_Post $post) {

        $subject = sprintf(
            __('Event Updated: %s', 'wp-events-manager-pro'),
            $post->post_title
        );

        $message = sprintf(
            __("An event has been updated.\n\nTitle: %s\nView Event: %s", 'wp-events-manager-pro'),
            $post->post_title,
            get_permalink($post->ID)
        );

        $this->send_email($subject, $message);
    }

    /**
     * Centralized email sender
     */
    private function send_email($subject, $message) {

        $recipients = apply_filters(
            'wemp_notification_recipients',
            [get_option('admin_email')]
        );

        wp_mail(
            $recipients,
            wp_strip_all_tags($subject),
            wp_kses_post($message)
        );
    }
}

new WEMP_Notifications();