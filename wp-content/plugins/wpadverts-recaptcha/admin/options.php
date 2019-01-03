<?php
/**
 * Displays WPAdverts reCAPTCHA Options Page
 * 
 * This file is a template for wp-admin / Classifieds / Options / reCAPTCHA panel. 
 * 
 * It is being loaded by wpadverts_recaptcha_page_options function.
 * 
 * @see wpadverts_recaptcha_page_options()
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="wrap">
    <h2 class="">
        <?php _e("reCAPTCHA", "wpadverts-recaptcha") ?>
    </h2>

    <?php adverts_admin_flash() ?>

    <form action="" method="post" class="adverts-form">
        <table class="form-table">
            <tbody>
            <?php echo adverts_form_layout_config($form) ?>
            </tbody>
        </table>

        <p class="submit">
            <input type="submit" value="<?php esc_attr_e($button_text) ?>" class="button-primary" name="<?php _e("Submit") ?>" />
        </p>

    </form>

</div>
