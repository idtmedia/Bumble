<?php

$invoice_id = $_GET['invoice_id'];
$invoice = getInvoiceByID($invoice_id);


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
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php wp_head(); ?>
	
	<style type="text/css">
	.alsp-print-buttons {
		margin: 10px;
	}
	@media print {
		.alsp-print-buttons {
			display: none;
		}
	}
	</style>
</head>

<body <?php body_class(); ?> style="background-color: #FFF">
	<div id="page" class="hfeed site">
		<div id="main" class="wrapper">
			<div class="entry-content">
				<div class="alsp-print-buttons">
					<input type="button" onclick="window.print();" value="<?php esc_attr_e('Print invoice', 'ALSP'); ?>">&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.close();" value="<?php esc_attr_e('Close window', 'ALSP'); ?>">
				</div>
				<?php global $ALSP_ADIMN_SETTINGS; ?>
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_allow_bank'] && $ALSP_ADIMN_SETTINGS['alsp_bank_info']): ?>
				<h4><?php _e('Bank transfer information', 'ALSP'); ?></h4>
				<?php echo nl2br($ALSP_ADIMN_SETTINGS['alsp_bank_info']); ?>
				<?php endif; ?>
				
				<br />
				<br />
				<br />
				<h4><?php _e('Invoice Info', 'ALSP'); ?></h4>
				<?php alsp_frontendRender(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'info_metabox.tpl.php'), array('invoice' => $invoice)); ?>
				
				<br />
				<br />
				<br />
				<h4><?php _e('Invoice Log', 'ALSP'); ?></h4>
				<?php alsp_frontendRender(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'log_metabox.tpl.php'), array('invoice' => $invoice)); ?>

				<div class="alsp-print-buttons">
					<input type="button" onclick="window.print();" value="<?php esc_attr_e('Print invoice', 'ALSP'); ?>">&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.close();" value="<?php esc_attr_e('Close window', 'ALSP'); ?>">
				</div>
			</div>
		</div>
	</div>
<?php wp_footer(); ?>
</body>
</html>