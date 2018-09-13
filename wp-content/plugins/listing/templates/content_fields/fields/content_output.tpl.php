<?php if (!empty($listing->post->post_content)): ?>
<div class="alsp-field alsp-field-output-block alsp-field-output-block-<?php echo $content_field->type; ?> alsp-field-output-block-<?php echo $content_field->id; ?>">
	<?php if ($content_field->icon_image || !$content_field->is_hide_name): ?>
	<span class="alsp-field-caption">
		<?php if ($content_field->icon_image): ?>
		<span class="alsp-field-icon fa fa-lg <?php echo $content_field->icon_image; ?>"></span>
		<?php endif; ?>
		<?php if (!$content_field->is_hide_name): ?>
		<span class="alsp-field-name"><?php echo $content_field->name?>:</span>
		<?php endif; ?>
	</span>
	<?php endif; ?>
	<div class="alsp-field-content alsp-field-description" itemprop="description">
		<?php add_filter('the_content', 'wpautop'); ?>
		<?php the_content(); ?>
		<?php remove_filter('the_content', 'wpautop'); ?>
	</div>
</div>
<?php endif; ?>