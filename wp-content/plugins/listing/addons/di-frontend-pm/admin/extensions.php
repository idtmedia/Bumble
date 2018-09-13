<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="wrap">
    <h2><?php _e( 'DesignInvento Messaging System - Extensions', 'ALSP' ); ?></h2>

    <?php
    $extensions = get_transient( 'difp_extensions' );

    if ( false === $extensions ) {
        $response = wp_remote_get( 'https://www.shamimsplugins.com/wp-json/api/v1/extensions/ALSP', array('timeout' => 15, 'sslverify' => false, 'decompress' => false) );

        if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != 200 ) {
			echo '<div class="error">Error loading extensions. Please reload the page again!</div>';
            return false;
        }
		$extensions  = json_decode( wp_remote_retrieve_body( $response ) );

        set_transient( 'difp_extensions', $extensions, 12 * HOUR_IN_SECONDS );
    }

    if ( count( $extensions ) ) {
        foreach ($extensions as $slug => $extension ) {
            ?>

            <div class="difp-extensions">
                <div class="thumbnail">
                    <a href="<?php echo add_query_arg(array('utm_campaign'=>'admin','utm_source'=>'extensions','utm_medium'=>'thumbnail'),$extension->url); ?>" target="_blank">
                        <img src="<?php echo $extension->thumbnail_url ? $extension->thumbnail_url : DIFP_PLUGIN_URL . 'assets/images/default-extensions-img.jpg'; ?>" alt="<?php echo esc_attr( $extension->title ); ?>" />
                    </a>
                </div>

                <div class="details">
                    <h3 class="title">
                        <a href="<?php echo add_query_arg(array('utm_campaign'=>'admin','utm_source'=>'extensions','utm_medium'=>'title'),$extension->url); ?>" target="_blank"><?php echo $extension->title; ?></a>
                    </h3>

                    <div class="text"><?php echo $extension->excerpt ? difp_get_the_excerpt( 50, $extension->excerpt ) : ''; ?></div>
                </div>

                <div class="links">
                    <?php if ( function_exists( str_replace( '-', '_', $slug ) . '_activate' ) ) { ?>
                        <a class="button button-disabled" href="<?php echo add_query_arg(array('utm_campaign'=>'admin','utm_source'=>'extensions','utm_medium'=>'installed'),$extension->url); ?>" target="_blank"><?php _e( 'Installed', 'ALSP' ); ?></a>
                    <?php } else { ?>
                        <a class="button" href="<?php echo add_query_arg(array('utm_campaign'=>'admin','utm_source'=>'extensions','utm_medium'=>'view_details'),$extension->url); ?>" target="_blank"><?php _e( 'View Details', 'ALSP' ); ?></a>
                    <?php } ?>
                </div>
            </div>

            <?php
        }
    } else {
        echo '<div class="error">Error loading extensions. Please reload the page again!</div>';
    }
    ?>

    <style type="text/css">
        .difp-extensions {
            width: 220px;
            float: left;
            margin: 10px;
            border: 1px solid #E6E6E6;
        }

        .difp-extensions .thumbnail img {
            max-width: 220px;
            max-height: 140px;
        }

        .difp-extensions .details {
            padding: 6px 10px 10px;
            min-height: 10px;
            background: #fff;
        }

        .difp-extensions .details h3.title {
            margin: 5px 0 10px;
            padding: 0;
        }

        .difp-extensions .details h3.title a {
            text-decoration: none;
            color: #111;
        }

        .difp-extensions .links {
            padding: 10px;
            background: #F5F5F5;
            border-top: 1px solid #E6E6E6;
        }

        .difp-extensions .links a.button.disabled {
            background: #eee;
        }
    </style>

</div>
