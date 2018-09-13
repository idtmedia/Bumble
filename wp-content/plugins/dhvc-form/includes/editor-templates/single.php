<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
if ( ! defined( 'DHVC_FORM_IS_FRONTEND_EDITOR' ) ) {
	define( 'DHVC_FORM_IS_FRONTEND_EDITOR', true );
}
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width"/>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php wp_head(); ?>
	<style type="text/css">
		.dhvc_form_preview-content{
			background: #fff none repeat scroll 0 0;
		    margin: 40px auto;
		    max-width: 800px;
		    padding: 20px;
		}
	</style>
</head>
<body <?php body_class()?>>
<div id="dhvc_form_editor_frontend-primary" class="dhvc_form_preview-content"> 
		<?php //echo apply_filters('the_content',$post->post_content) ?>
		<?php while ( have_posts() ) : the_post(); global $post; ?>
		<?php if('dhvcform' === get_post_type($post->ID) && 'publish'===$post->post_status){?>
			<?php echo do_shortcode('[dhvc_form id="'.$post->ID.'"]') ?>
		<?php }else{?> 
		<?php 
		wp_enqueue_style('js_composer_front');
		wp_enqueue_style('js_composer_custom_css');
		wp_enqueue_script('dhvc-form-jquery-cookie');
		wp_enqueue_script('dhvc-form');
		?>
			<?php echo '<div id="dhvcform-' . $post->ID . '"  class="dhvc-form-container dhvc-form-icon-pos-' . get_post_meta($post->ID, '_input_icon_position', true) . ' dhvc-form-' . get_post_meta($post->ID, '_form_layout', true) . ' dhvc-form-flat">' . "\n";?>
			<?php echo apply_filters('the_content',$post->post_content) ?>
			<?php echo '</div>';?>
		<?php } ?>
		<?php endwhile;?>
</div>
<?php wp_footer();?>
<?php dhvc_form_print_js_declaration();?>
</body>
</html>
