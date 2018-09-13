<?php

$el_class = $css = $css_animation = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->resetVariables( $atts, $content );
extract( $atts );

$this->setGlobalTtaInfo();
$prepareContent = $this->getTemplateVariable( 'content' );
$sections = WPBakeryShortCode_VC_Tta_Section::$section_info;
$count = count($sections);
?>
<div class="dhvc-form-steps dhvc-form-<?php echo $count?>-steps">
	<?php $i=0;?>
	<?php foreach ($sections as $section): $i++;?>
	<?php $icon_html = $this->constructIcon( $section );?>
	<div data-step-index="<?php echo $i?>" class="dhvc-form-step dhvc-form-step-<?php echo $i?><?php echo ($i===1 ? ' active' :'')?>">
		<div class="dhvc-form-step-line"></div>
		<div class="dhvc-form-step-icon">
			<?php echo $icon_html?>
		</div>
		<?php if(isset($section['title']) && $section['title'] !=''):?>
		<div class="dhvc-form-step-title">
			<?php echo esc_html($section['title'])?>
		</div>
		<?php endif;?>
	</div>
	<?php endforeach;?>
</div>
<div class="dhvc-form-step-contents">
	<?php echo $prepareContent?>
</div>