<?php if ($content_field->value): ?>
	<ul class="alsp-field-content">
	<?php foreach ($content_field->value AS $key): ?>
		<li><?php echo $content_field->selection_items[$key]; ?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>