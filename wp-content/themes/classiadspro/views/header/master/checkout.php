<?php

/**
 * template part for WooCommerce Checkout. views/header/master
 *
 * @author      Artbees
 * @package     jupiter/views
 * @version     5.0.0
 */


global $mk_options;

$height = ($view_params['header_style'] != 2) ? 'add-header-height' : '';

?>

<div class="shopping-cart-header <?php echo $height; ?>">
	
	<a class="mk-shoping-cart-link" href="<?php echo wc_get_cart_url(); ?>">
		<?php Mk_SVG_Icons::get_svg_icon_by_class_name( true, 'mk-moon-cart-2' ); ?>
		<span class="mk-header-cart-count"><?php echo WC()->cart->cart_contents_count; ?></span>
	</a>

	<div class="mk-shopping-cart-box">
		<?php the_widget( 'WC_Widget_Cart' ); ?>
		<div class="clearboth"></div>
	</div>

</div>
