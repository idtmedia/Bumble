<div id="gdrts-remotecall-intro">
    <input type="hidden" class="gdrts-tr-plugin" value="yet-another-stars-rating">

    <div class="d4p-group d4p-group-import d4p-group-important">
        <h3><?php _e("Important", "gd-rating-system"); ?></h3>
        <div class="d4p-group-inner">
            <?php _e("This tool can import rating data from Yet Another Stars Rating plugin. There are some important things you need to know about import process.", "gd-rating-system"); ?>
            <ul style="list-style: inside disc; font-weight: normal;">
                <li><?php _e("This tool can transfer posts ratings and number of votes, author reviews along with votes log data.", "gd-rating-system"); ?></li>
                <li><?php _e("Imported data will be marked with special import flag and will be skipped later if you decide to use this tool again.", "gd-rating-system"); ?></li>
                <li><?php _e("For import process to work, Yet Another Stars Rating database table 'wp_yasr_log' must be present.", "gd-rating-system"); ?></li>
                <li><?php _e("Yet Another Stars Rating version 1.5 or newer is supported. Data from older versions can't be imported due to the data format differences.", "gd-rating-system"); ?></li>
                <li><?php _e("This tool will skip transfer for missing posts or pages. If you have ratings for posts or pages you deleted, rating for such posts will be skipped.", "gd-rating-system"); ?></li>
                <li><?php _e("Yet Another Stars Rating plugin allows ratings for maximum value of 5, and that value will be used during import and recalculated if needed.", "gd-rating-system"); ?></li>
                <li><?php _e("Yet Another Stars Rating plugin database tables will not be modified in any way or deleted during this import process.", "gd-rating-system"); ?></li>
            </ul>
        </div>
    </div>

    <?php

    require_once(GDRTS_PATH.'core/transfer/yet-another-stars-rating.php');

    $transfer = new gdrts_transfer_yet_another_stars_rating();

    if (!$transfer->db_tables_exist()) {

    ?>

    <div class="d4p-group d4p-group-import d4p-group-important">
        <h3><?php _e("Transfer not possible", "gd-rating-system"); ?></h3>
        <div class="d4p-group-inner">
            <?php _e("Required database tables not found. Import process can't proceed.", "gd-rating-system"); ?>
        </div>
    </div>

    <?php

    } else {

    ?>

    <div class="d4p-group d4p-group-import">
        <h3><?php _e("Import: Stars Rating", "gd-rating-system"); ?></h3>
        <div class="d4p-group-inner">
            <?php if (gdrts_is_method_loaded('stars-rating')) { ?>
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e("Import", "gd-rating-system"); ?></th>
                        <td>
                            <div class="d4p-setting-bool">
                                <label>
                                    <input type="checkbox" class="widefat gdrts-tr-check" value="stars-rating"><?php _e("Enabled", "gd-rating-system"); ?>
                                </label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php } else { ?>
            <p style="text-align: left"><?php _e("Rating method is not active.", "gd-rating-system"); ?></p>
            <?php } ?>
        </div>
    </div>

    <div class="d4p-group d4p-group-import">
        <h3><?php _e("Import: Star Review from Overall / Author Ratings", "gd-rating-system"); ?></h3>
        <div class="d4p-group-inner" style="text-align: left;">
            Stars Review rating method is available only in GD Rating System Pro. You can upgrade to GD Rating System Pro <a target="_blank" href="https://plugins.dev4press.com/gd-rating-system/">here</a>.
            <p style="font-weight: normal; margin: 10px 0 0;">To learn more about the features available in Pro version only, check out this <a target="_blank" href="https://plugins.dev4press.com/gd-rating-system/free-vs-pro-plugin/">FREE vs. PRO</a> comparison.</p>
        </div>
    </div>

    <?php } ?>
</div>

<div id="gdrts-remotecall-process" style="display: none;">
    <?php include(GDRTS_PATH.'forms/shared/transfer-process.php'); ?>
</div>

