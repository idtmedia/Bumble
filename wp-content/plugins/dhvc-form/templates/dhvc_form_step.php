<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->resetVariables( $atts, $content );
WPBakeryShortCode_VC_Tta_Section::$self_count ++;
$count = WPBakeryShortCode_VC_Tta_Section::$self_count;
WPBakeryShortCode_VC_Tta_Section::$section_info[] = $atts;
?>
<div class="dhvc-form-step-content dhvc-form-step-content-<?php echo $count ?><?php echo ($count == '1' ? ' active':'')?>">
	<?php echo $this->getTemplateVariable( 'content' )?>
</div>