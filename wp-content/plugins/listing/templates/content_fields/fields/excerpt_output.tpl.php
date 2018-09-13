<?php global $ALSP_ADIMN_SETTINGS; ?>

<?php if (has_excerpt() || ($ALSP_ADIMN_SETTINGS['alsp_cropped_content_as_excerpt'] && get_post()->post_content !== '')): ?>
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
	<?php  
		ob_start();
		the_excerpt_max_charlength($ALSP_ADIMN_SETTINGS['alsp_excerpt_length']);
	?>
	<span class="alsp-field-content">
		<?php
			
			echo ob_get_clean();
		//echo alsp_crop_content(get_option('alsp_excerpt_length'), get_option('alsp_strip_excerpt'), $listing->level->listings_own_page, $listing->level->nofollow); ?>
	</span>
</div>
<?php endif; ?>