<?php if ($listing->locations): ?>
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
	<span class="alsp-field-content">
	<?php foreach ($listing->locations AS $location): ?>
		<span class="alsp-location" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
			<?php if ($location->map_coords_1 && $location->map_coords_2): ?><span class="alsp-show-on-map" data-location-id="<?php echo $location->id; ?>"><?php endif; ?>
			<?php echo $location->getWholeAddress(); ?>
			<?php if ($location->map_coords_1 && $location->map_coords_2): ?></span><?php endif; ?>
		</span>
		<?php //endif; ?>
	<?php endforeach; ?>
	</span>
</div>
<?php endif; ?>