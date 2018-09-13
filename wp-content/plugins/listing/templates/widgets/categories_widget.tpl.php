<?php
$scroll = 0;
 ?>

<?php echo $args['before_widget']; ?>
<?php if (!empty($title)){
	if (isset($style) && $style == 1){
		echo '<div class="alsp_category_widget_inner">'.$args['before_title'] . $title . $args['after_title'].'</div>';
	}else{
		echo '<div class="alsp_category_widget_inner style2">'.$args['before_title'] . $title . $args['after_title'].'</div>';
	}
	
}
?>
<div class="alsp-widget alsp-categories-widget">
	<?php
		if ($style == 1){
			echo '<div class="alsp_category_widget_inner">';
		}else{
			echo '<div class="alsp_category_widget_inner style2">';
		}
			echo alsp_renderAllCategories($parent, $depth, 1, $counter, $subcats); 
		echo '<div>';
	 ?>
</div>
<?php echo $args['after_widget']; ?>