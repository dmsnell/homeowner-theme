<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Homeowner
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div id="column-1" class="homepage-column">
				<h3>
					Recent Maintenance
					<a href="<?php echo admin_url('post-new.php?post_type=maintenance'); ?>"><span class="dashicons dashicons-plus-alt"></span></a>
			 	</h3>
				<?php $posts = get_posts( array('posts_per_page' => 10, 'post_type'  => 'maintenance' ) ); ?>
				<?php foreach ($posts as $post): ?>
					<?php get_template_part( 'template-parts/homepage-column' ); ?>
				<?php endforeach ?>
			</div>
			<div id="column-2" class="homepage-column">
				<h3>
					Recent Upgrades
					<a href="<?php echo admin_url('post-new.php?post_type=upgrade'); ?>"><span class="dashicons dashicons-plus-alt"></span></a>
				</h3>
				<?php $posts = get_posts( array('posts_per_page' => 10, 'post_type'  => 'upgrade' ) ); ?>
				<?php foreach ($posts as $post): ?>
					<?php get_template_part( 'template-parts/homepage-column' ); ?>
				<?php endforeach ?>
			</div>
			

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
