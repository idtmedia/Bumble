<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( $announcement->have_posts() ) {
	while ( $announcement->have_posts() ) { 
		$announcement->the_post();
	
	if( difp_make_read() ) {
		delete_user_meta( get_current_user_id(), '_difp_user_announcement_count' );
	}
	?>
	 <div class="difp-per-message">
		<div class="difp-message-title"><?php the_title(); ?>
			<span class="date"><?php the_time(); ?></span>
		</div>
		<div class="difp-message-content">
			<?php the_content(); ?>
			<?php do_action ( 'difp_display_after_announcement' ); ?>
		</div>
	</div>
	<?php }
	wp_reset_postdata();
} else {
	echo "<div class='difp-error'>".__("You do not have permission to view this announcement!", 'ALSP')."</div>";
}