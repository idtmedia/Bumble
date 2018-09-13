<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo difp_info_output();

if( ! $total_announcements ) {
	echo "<div class='difp-error'>".apply_filters('difp_filter_announcement_empty', __("No announcements found.", 'ALSP') )."</div>";
	return;
}

do_action('difp_display_before_announcementbox');
	  
	  	?><form class="difp-message-table form" method="post" action="">
		<div class="difp-table difp-action-table">
			<div>
				<div class="difp-bulk-action">
					<select name="difp-bulk-action">
						<option value=""><?php _e('Bulk action', 'ALSP'); ?></option>
						<?php foreach( Difp_Announcement::init()->get_table_bulk_actions() as $bulk_action => $bulk_action_display ) { ?>
						<option value="<?php echo $bulk_action; ?>"><?php echo $bulk_action_display; ?></option>
						<?php } ?>
					</select>
				</div>
				<div>
					<input type="hidden" name="token"  value="<?php echo difp_create_nonce('announcement_bulk_action'); ?>"/>
					<button type="submit" class="difp-button" name="difp_action" value="announcement_bulk_action"><?php _e('Apply', 'ALSP'); ?></button>
				</div>
				<div class="difp-loading-gif-div">
				</div>
				<div class="difp-filter">
					<select onchange="if (this.value) window.location.href=this.value">
						<?php foreach( Difp_Announcement::init()->get_table_filters() as $filter => $filter_display ) { ?>
						<option value="<?php echo esc_url( add_query_arg( array('difp-filter' => $filter, 'difppage' => false ) ) ); ?>" <?php selected($g_filter, $filter);?>><?php echo $filter_display; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<?php if( $announcements->have_posts() ) { ?>
		<div id="difp-table" class="difp-table difp-odd-even"><?php
			while ( $announcements->have_posts() ) { 
				$announcements->the_post(); ?>
					<div id="difp-message-<?php echo get_the_ID(); ?>" class="difp-table-row"><?php
						foreach ( Difp_Announcement::init()->get_table_columns() as $column => $display ) { ?>
							<div class="difp-column difp-column-<?php echo $column; ?>"><?php Difp_Announcement::init()->get_column_content($column); ?></div>
						<?php } ?>
					</div>
				<?php
			} //endwhile
			?></div><?php
			echo difp_pagination( Difp_Announcement::init()->get_user_announcement_count( empty($g_filter) ? 'total' : $g_filter ), difp_get_option('announcements_page', 15) );
		} else {
			?><div class="difp-error"><?php _e('No announcements found. Try different filter.', 'ALSP'); ?></div><?php 
		}
		?></form><?php 
		wp_reset_postdata();