<?php get_header(); ?>
<h1><?php _e('Events', 'wp-events-manager-pro'); ?></h1>
<?php while (have_posts()): the_post(); ?>
    <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
<?php endwhile; ?>
<?php get_footer(); ?>
