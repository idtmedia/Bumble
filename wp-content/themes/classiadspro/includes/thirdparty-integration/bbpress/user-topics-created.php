<?php

/**
 * User Topics Created
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<?php do_action( 'bbp_template_before_user_topics_created' ); ?>

	<?php bbp_set_query_name( 'bbp_user_profile_topics_created' ); ?>

	<div id="bbp-author-topics-started" class="bbp-author-topics-started">
		<h2 class="entry-title"><?php esc_html_e( 'Forum Topics Created', 'classiadspro' ); ?></h2>
		<div class="bbp-user-section">

			<?php if ( bbp_get_user_topics_started() ) : ?>

				<?php bbp_get_template_part( 'pagination', 'topics' ); ?>

				<?php bbp_get_template_part( 'loop',       'topics' ); ?>

				<?php bbp_get_template_part( 'pagination', 'topics' ); ?>

			<?php else : ?>

				<p><?php bbp_is_user_home() ? esc_html_e( 'You have not created any topics.', 'classiadspro' ) : esc_html_e( 'This user has not created any topics.', 'classiadspro' ); ?></p>

			<?php endif; ?>

		</div>
	</div><!-- #bbp-author-topics-started -->

	<?php bbp_reset_query_name(); ?>

	<?php do_action( 'bbp_template_after_user_topics_created' ); ?>
