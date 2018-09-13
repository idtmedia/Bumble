<?php 
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage ClassiadsPro
 * @since ClassiadsPro 1.0
 */

 global $post,
$pacz_settings;
$layout = $pacz_settings['error-layout'];
$error_temp = $pacz_settings['error_page'];
$error_small_text = $pacz_settings['error_page_small_text'];
get_header(); ?>
<div id="theme-page">
	<div class="pacz-main-wrapper-holder">
		<div class="theme-page-wrapper pacz-main-wrapper <?php echo esc_attr($layout); ?>-layout pacz-grid vc_row-fluid">
			<div class="inner-page-wrapper">
			<div class="theme-content" itemprop="mainContentOfPage">
			<div class="error-404-wrapper">
			<?php if(function_exists('custom_vc_init') && class_exists('WPBakeryShortCode')){ ?>
				<?php if($error_temp == 1){
					echo do_shortcode( '[vc_row margin_top="0" margin_bottom="30px"][vc_column][pacz_fancy_title style="standard" tag_name="h5" border_width="0" size="36" line_height="36" color="" font_weight="bold" text_transform="none" letter_spacing="2" font_family="Montserrat" font_type="google" margin_top="0" margin_bottom="0" align="center"]'.esc_html__("O00ps!! Error", "classiadspro").'[/pacz_fancy_title][pacz_fancy_title style="standard" tag_name="h1" border_width="0" size="200" line_height="160" color="" font_weight="bold" text_transform="uppercase" letter_spacing="5" font_family="Montserrat" font_type="google" margin_top="0" margin_bottom="0" align="center"]404[/pacz_fancy_title][pacz_fancy_title style="standard" tag_name="h5" border_width="0" size="36" line_height="36" color="" font_weight="bold" text_transform="none" letter_spacing="2" font_family="Montserrat" font_type="google" margin_top="0" margin_bottom="30" align="center"]Page not found[/pacz_fancy_title][pacz_custom_box padding_vertical="0" padding_horizental="200" margin_bottom="0"][vc_column_text]

							'.esc_html__("Far far away, behind the word mountains, far from the countries Vokalia and there live the blind texts. Sepraed. they live in Boo marksgrove right at the coast of the Semantics, a large language ocean A small river named Duden flows by their place and su plies it with the necessary regelialia Even the all powe ful Pointing.", "classiadspro").'

						[/vc_column_text]
					[/pacz_custom_box][/vc_column][/vc_row]');
				
				}elseif($error_temp == 2){
					echo do_shortcode( '[vc_row margin_top="150px" margin_bottom="30px"][vc_column][pacz_fancy_title style="standard" tag_name="h1" border_width="0" size="200" line_height="160" color="#5dae4b" font_weight="bolder" text_transform="uppercase" letter_spacing="5" font_family="Lato" font_type="google" margin_top="0" margin_bottom="0" align="center"]'.esc_html__("404", "classiadspro").'[/pacz_fancy_title][pacz_fancy_title style="standard" border_width="0" size="36" line_height="36" color="" font_weight="bold" text_transform="uppercase" letter_spacing="2" font_family="Lato" font_type="google" margin_top="0" margin_bottom="30" align="center"]Page not found[/pacz_fancy_title][pacz_custom_box padding_vertical="0" padding_horizental="200" margin_bottom="0"][vc_column_text]

	'.$error_small_text.'

	[/vc_column_text]

	[/pacz_custom_box][/vc_column][/vc_row]');
				
					
				}
		}else{ 
			echo '<h1>'.esc_html__('404', 'classiadspro').'</h1>';
			echo '<h5>'.esc_html__('Page None Found', 'classiadspro').'</h5>';
		
		}
 ?>

			<div class="searchform"><?php get_search_form(); ?></div>
			</div>
			</div>
		<?php if($layout != 'full') get_sidebar(); ?>	
		<div class="clearboth"></div>	
		</div>
		</div>
		<div class="clearboth"></div>
	</div>
</div>
<?php get_footer(); ?>