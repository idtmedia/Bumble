<?php if ($content_field->value): ?>
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
	<ul class="alsp-field-content">
	<?php if ($content_field->how_display_items == 'all'): ?>
	
	<?php foreach ($content_field->selection_items AS $key=>$item): ?>
		<?php 
			if(in_array($key, $content_field->value)){
				$icon = '<span class="pacz-icon-check-circle"></span>';
			}else{
				$icon = '<span class="pacz-icon-times-circle"></span>';
			}
		?>
		<li><?php echo $icon; ?><?php echo $item; ?></li>
	<?php endforeach; ?>
	<?php elseif ($content_field->how_display_items == 'checked'): ?>
	<?php foreach ($content_field->value AS $key): ?>
	<?php 
	if(isset($content_field->icon_selection_items[$key]) && $content_field->check_icon_type == 'custom_icon'){
		$icon = '<span class="'.$content_field->icon_selection_items[$key].'"></span>';
	}elseif(isset($content_field->icon_selection_items[$key]) && $content_field->check_icon_type == 'default'){
		$icon = '<span class="pacz-icon-check-circle"></span>';
	}else{
		$icon = '<span class="pacz-icon-check-circle"></span>';
	}
	?>
		<?php if (isset($content_field->selection_items[$key])): ?><li><?php echo $icon; ?><?php echo $content_field->selection_items[$key]; ?></li><?php endif; ?>
	<?php endforeach; ?>
	<?php endif; ?>
	</ul>
</div>
<?php endif; ?>