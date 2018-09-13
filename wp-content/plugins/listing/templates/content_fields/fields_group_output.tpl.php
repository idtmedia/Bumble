<div class="alsp-fields-group group-style-<?php echo $content_fields_group->group_style; ?>">
	<?php if (!$content_fields_group->on_tab): ?>
	<div class="alsp-fields-group-caption"><?php echo $content_fields_group->name; ?></div>
	<?php endif; ?>
	<?php if (!$content_fields_group->hide_anonymous || is_user_logged_in()): ?>
		<?php foreach ($content_fields_group->content_fields_array AS $content_field): ?>
			<?php $content_field->renderOutput($listing); ?>
		<?php endforeach; ?>
	<?php elseif ($content_fields_group->hide_anonymous && !is_user_logged_in()): ?>
		<?php printf(__('You must be <a href="%s">logged in</a> to see this info', 'ALSP'), wp_login_url(get_permalink($listing->post->ID))); ?>
	<?php endif; ?>
</div>