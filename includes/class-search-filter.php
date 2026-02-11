<?php
defined('ABSPATH') || exit;

class WEMP_Search_Filter {

    public function __construct() {
        add_shortcode('event_filter', [$this, 'render']);
    }

    public function render() {
        $terms = get_terms('event_type');
        ob_start(); ?>
        <form method="get">
            <select name="event_type">
                <option value=""><?php _e('All Types', 'wp-events-manager-pro'); ?></option>
                <?php foreach ($terms as $term): ?>
                    <option value="<?php echo esc_attr($term->slug); ?>">
                        <?php echo esc_html($term->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit"><?php _e('Filter', 'wp-events-manager-pro'); ?></button>
        </form>
        <?php
        return ob_get_clean();
    }
}
new WEMP_Search_Filter();