<?php 
echo do_action('admin_head');

ob_start();
function register_pacz_demo_page_new() {
	$demo_template_men = add_menu_page('Classiads Templates', 'Classiads Templates', 'activate_plugins', 'classiads-templates', 'pacz_demo_page_new', '', 1);
	//$demo_tuts_men = add_theme_page('PostAds Tutorials Page', 'PostAds Tutorials', 'activate_plugins', 'pacz-tuts', 'pacz_demo_tuts_new', '');
	add_action('admin_print_styles-' . $demo_template_men,'demo_enqueue_style_new');
	//add_action('admin_print_styles-' . $demo_tuts_men,'demo_enqueue_style');
	add_action('admin_print_styles-' . $demo_template_men,'demo_enqueue_script_new');
function demo_enqueue_style_new() {
		wp_enqueue_style('importer-styles', AI1WMDI_URL_DEMO . '/demo-templates/css/demo-templates.css', false, false, 'all');
		
		wp_enqueue_style(
			'ai1wmdi-css-import',
			Ai1wm_Template::asset_link( 'css/import.min.css', 'AI1WMDI' )
		);
    }
function demo_enqueue_script_new() {
	
	do_action( 'ai1mw_register_import_scripts_and_styles' );

		if ( is_rtl() ) {
			wp_enqueue_style(
				'ai1wm_import',
				Ai1wm_Template::asset_link( 'css/import.min.rtl.css' )
			);
		} else {
			wp_enqueue_style(
				'ai1wm_import',
				Ai1wm_Template::asset_link( 'css/import.min.css' )
			);
		}

		wp_enqueue_script(
			'ai1wm_import',
			Ai1wm_Template::asset_link( 'javascript/import.min.js' ),
			array( 'ai1wm_util' )
		);

		wp_localize_script( 'ai1wm_import', 'ai1wm_feedback', array(
			'ajax'       => array(
				'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=ai1wm_feedback' ) ),
			),
			'secret_key' => get_option( AI1WM_SECRET_KEY ),
		) );

		wp_localize_script( 'ai1wm_import', 'ai1wm_report', array(
			'ajax'       => array(
				'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=ai1wm_report' ) ),
			),
			'secret_key' => get_option( AI1WM_SECRET_KEY ),
		) );

		wp_localize_script( 'ai1wm_import', 'ai1wm_uploader', array(
			'chunk_size'  => apply_filters( 'ai1wm_max_chunk_size', AI1WM_MAX_CHUNK_SIZE ),
			'max_retries' => apply_filters( 'ai1wm_max_chunk_retries', AI1WM_MAX_CHUNK_RETRIES ),
			'url'         => wp_make_link_relative( admin_url( 'admin-ajax.php?action=ai1wm_import' ) ),
			'params'      => array(
				'priority'   => 5,
				'secret_key' => get_option( AI1WM_SECRET_KEY ),
			),
			'filters'     => array(
				'ai1wm_archive_extension' => array( 'wpress', 'bin' ),
				'ai1wm_archive_size'      => apply_filters( 'ai1wm_max_file_size', AI1WM_MAX_FILE_SIZE ),
			),
		) );

		wp_localize_script( 'ai1wm_import', 'ai1wm_import', array(
			'ajax'              => array(
				'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=ai1wm_import' ) ),
			),
			'status'            => array(
				'url' => wp_make_link_relative( add_query_arg( array( 'secret_key' => get_option( AI1WM_SECRET_KEY ) ), admin_url( 'admin-ajax.php?action=ai1wm_status' ) ) ),
			),
			'secret_key'        => get_option( AI1WM_SECRET_KEY ),
			'oversize'          => sprintf(
				__(
					'The file that you are trying to import is over the maximum upload file size limit of <strong>%s</strong>.<br />' .
					'You can remove this restriction by purchasing our ' .
					'<a href="https://servmask.com/products/unlimited-extension" target="_blank">Unlimited Extension</a>.',
					AI1WM_PLUGIN_NAME
				),
				size_format( apply_filters( 'ai1wm_max_file_size', AI1WM_MAX_FILE_SIZE ) )
			),
			'invalid_extension' => __(
				'The file type that you have tried to upload is not compatible with this plugin. ' .
				'Please ensure that your file is a <strong>.wpress</strong> file that was created with the All-in-One WP migration plugin. ' .
				'<a href="https://help.servmask.com/knowledgebase/invalid-backup-file/" target="_blank">Technical details</a>',
				AI1WM_PLUGIN_NAME
			),
		) );
		
		wp_enqueue_script(
			'ai1wmdi-js-import',
			Ai1wm_Template::asset_link( 'javascript/import2.min.js', 'AI1WMDI' ),
			array( 'jquery' )
		);
		
    }

	
}


function pacz_demo_tuts_new() { ?>
	
<?php }
 
function pacz_demo_page_new() {
	
	$import_main = new Ai1wmdi_Main_Controller();
	$mainc = new Ai1wmdi_Import_Controller();
				
?>
	<div class="wrap">
		<div class="demo-container">
			<div class="container-row">
				<div class="install-heading">
					<h3>Attention!</h3>
					<h5>After importing demo data your default WordPress user pass will be changed to</h5><br> 
					<p>User: designinvento <br> Pass: designinvento</p>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-fantro.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_fantro(); ?>
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Fantro</h5>
						</div>
						<?php echo $mainc->picker_fantro(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-ultra.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_ultra(); ?>
									
								</div>
							</div>
						</div>
						
						<div class="demo-title">
							<h5>Classiads Ultra</h5>
						</div>
						<?php echo $mainc->picker_ultra(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-mintox.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_mintox(); ?>
									
								</div>
							</div>
						</div>
						
						<div class="demo-title">
							<h5>Classiads Mintox</h5>
						</div>
						<?php echo $mainc->picker_mintox(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-echo.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_echo(); ?>
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Echo</h5>
						</div>
						<?php echo $mainc->picker_echo(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-emo.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_emo(); ?>
									
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Emo</h5>
						</div>
						<?php echo $mainc->picker_emo(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-elca.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_elca(); ?>
									
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Elca</h5>
						</div>
						<?php echo $mainc->picker_elca(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-zee.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_zee(); ?>
									
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Zee</h5>
						</div>
						<?php echo $mainc->picker_zee(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-snow.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_snow(); ?>
									
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Snow</h5>
						</div>
						<?php echo $mainc->picker_snow(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">	
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-exo.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_exo(); ?>
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Exo</h5>
						</div>
						<?php echo $mainc->picker_exo(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">	
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-lemo.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_lemo(); ?>
									
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Lemo</h5>
						</div>
						<?php echo $mainc->picker_lemo(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">	
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-exotic.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_exotic(); ?>
									
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Exotic</h5>
						</div>
						<?php echo $mainc->picker_exotic(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-max.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_max(); ?>
									
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Max</h5>
						</div>
						<?php echo $mainc->picker_max(); ?>
					</div>
				</div>
				<div class="demo-grid">
					<div class="demo-template-wrap">
						<div class="figure">
							<img src="<?php echo AI1WMDI_URL_DEMO . '/demo-templates/thumbs/classiads-shop.jpg'?>" alt="demo">
							<div class="overlay">
								<div class="demo-download-btn">
									<?php echo $mainc->button_shop(); ?>
								</div>
							</div>
						</div>
						<div class="demo-title">
							<h5>Classiads Shop</h5>
						</div>
						<?php echo $mainc->picker_shop(); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
	

				<form action="" method="post" id="ai1wm-import-form" class="ai1wm-clear" enctype="multipart/form-data">


					<?php do_action( 'ai1wm_import_left_end' ); ?>

					<input type="hidden" name="ai1wm_manual_import" value="1" />

				</form>
			

					
	</div>
	</div>
	
	

<?php	
}


add_action('admin_menu', 'register_pacz_demo_page_new');