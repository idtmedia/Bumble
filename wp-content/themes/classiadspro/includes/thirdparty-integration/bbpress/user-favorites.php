<?php

/**
 * User Favorites
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<?php do_action( 'bbp_template_before_user_favorites' ); ?>

	<?php bbp_set_query_name( 'bbp_user_profile_favorites' ); ?>

	<div id="bbp-author-favorites" class="bbp-author-favorites">
		<h2 class="entry-title"><?php esc_html_e( 'Favorite Forum Topics', 'classiadspro' ); ?></h2>
		<div class="bbp-user-section">

			<?php if ( bbp_get_user_favorites() ) : ?>

				<?php bbp_get_template_part( 'pagination', 'topics' ); ?>

				<?php bbp_get_template_part( 'loop',       'topics' ); ?>

				<?php bbp_get_template_part( 'pagination', 'topics' ); ?>

			<?php else : ?>

				<p><?php bbp_is_user_home() ? esc_html_e( 'You currently have no favorite topics.', 'classiadspro' ) : esc_html_e( 'This user has no favorite topics.', 'classiadspro' ); ?></p>

			<?php endif; ?>

		</div>
	</div><!-- #bbp-author-favorites -->

	<?php bbp_reset_query_name(); ?>

	<?php do_action( 'bbp_template_after_user_favorites' ); ?>
