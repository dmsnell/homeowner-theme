<div class="homepage-item">
	<?php if( has_post_thumbnail( $post->ID ) ) {
		echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
	} else {
		echo '<img src="' . get_bloginfo('template_directory') . '/images/property_placeholder-150.jpg"  />';
	}?>
	<div class='item-meta' id='meta-rating'>
		<?php $rating = get_post_meta( $post->ID, 'rating', true ); ?>
		<?php for ($i=0; $i < 5; $i++) { 
			if( $i < $rating ) {
				echo '<span class="dashicons dashicons-star-filled"></span>';
			} else {
				echo '<span class="dashicons dashicons-star-empty"></span>';
			}
		} ?>
	</div>
	<h4>
		<a href="<?php echo get_the_permalink( $post->ID ); ?>">
			<?php echo get_the_title( $post->ID ); ?>
		</a>
		<a href="<?php echo admin_url('post.php?post=' . $post->ID . '&action=edit'); ?>"><span class="dashicons dashicons-edit"></span></a>
	</h4>
	<?php $description = $post->post_content; ?>
	<div id="item-description">
		<?php echo neat_trim($description, 100); ?>
	</div>
	<div class='item-meta' id='meta-date'>
		<label>Date</label>
		<?php echo get_post_meta( $post->ID, 'date_performed', true ); ?>
	</div>
	<div class='item-meta' id='meta-cost'>
		<label>Cost</label>
		$<?php echo get_post_meta( $post->ID, 'cost', true ); ?>
	</div>
	<div class='item-meta' id='meta-company'>
		<label>Company</label>
		<?php echo get_the_term_list( $post->ID, 'company', '', ', ' ); ?>
	</div>
	<div class='item-meta' id='meta-area'>
		<label>Area</label>
		<?php echo get_the_term_list( $post->ID, 'area', '', ', ' ); ?>
	</div>

</div>