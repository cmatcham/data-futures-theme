<?php get_header(); ?>

<h1 class="heading"><?php the_title() ?></h1>
	<?php 
	global $post;
    $post = get_post(get_the_ID());
	setup_postdata( $post );
    the_content();
    wp_reset_postdata( $post );
?>

<?php get_footer(); ?>
