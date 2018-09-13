<?php defined('ABSPATH') or die;
	/* @var DiRFFd $field */
	/* @var DiRF $form */
	/* @var mixed $default */
	/* @var string $name */
	/* @var string $idname */
	/* @var string $label */
	/* @var string $desc */
	/* @var string $rendering */

	isset($type) or $type = 'text';

	$attrs = array (
		'name' => $name,
		'id' => $idname,
		'type' => 'text',
		'value' => $form->autovalue($name),
	);

if ( $field->hasmeta('size') ) {
	$attrs['size'] = $field->getmeta('size');
}
?>

<?php if ($rendering == 'inline'): ?>
	<input <?php echo $field->htmlattributes($attrs) ?>/>
<?php elseif ($rendering == 'blocks'):  ?>
<div class="text">
	<label id="<?php echo $name ?>"><?php echo $label ?></label>
	<input <?php echo $field->htmlattributes($attrs) ?> />
	<span><?php echo $desc ?></span>
</div>
<?php else: # ?>
	<div>
		<p><?php echo $desc ?></p>
		<label id="<?php echo $name ?>">
			<?php echo $label ?>
			<input <?php echo $field->htmlattributes($attrs) ?>/>
		</label>
	</div>
<?php endif; ?>
