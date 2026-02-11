<?php get_header(); ?>
<h1><?php the_title(); ?></h1>
<p><?php the_content(); ?></p>
<p><strong>Date:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_event_date', true)); ?></p>
<p><strong>Location:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_event_location', true)); ?></p>
<?php echo do_shortcode('[event_rsvp]'); ?>
<?php get_footer(); ?>
