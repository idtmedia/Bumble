<?php if ($content_field->value): ?>
	<a href="mailto:<?php echo esc_attr($content_field->value); ?>"><?php echo $content_field->value; ?></a>
<?php endif; ?>