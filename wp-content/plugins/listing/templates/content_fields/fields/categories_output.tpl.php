<?php global $ALSP_ADIMN_SETTINGS; ?>

<?php if (has_term('', ALSP_CATEGORIES_TAX, $listing->post->ID)): ?>
<div class="alsp-field-output-block alsp-field-output-block-<?php echo $content_field->type; ?> alsp-field-output-block-<?php echo $content_field->id; ?>">
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
	<span class="alsp-field-content">
	<?php //echo get_the_term_list($listing->post->ID, ALSP_CATEGORIES_TAX, '', ', ', ''); ?>
	
		<?php
		$terms = get_the_terms($listing->post->ID, ALSP_CATEGORIES_TAX);
		foreach ($terms as $term):?>
		<?php 
		global $pacz_settings, $accent_color;
		if($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 4){
			$alsp_cat_color = alsp_getCategorycolor($term->term_id);
			if(!empty($alsp_cat_color)){
			$icon_color = alsp_getCategorycolor($term->term_id); 
			}else{
				$icon_color = $pacz_settings['accent-color'];
			}
		}else{
			
			$icon_color = '';
		}
		?>
			<span class="alsp-label alsp-label-primary"><a style="background-color:<?php echo $icon_color; ?>;" href="<?php echo get_term_link($term, ALSP_CATEGORIES_TAX); ?>" rel="tag"><?php echo $term->name; ?></a>&nbsp;&nbsp;<span class="glyphicon glyphicon-tag"></span></span>
		<?php endforeach; ?>
	</span>
</div>
<?php endif; ?>