<div class="d4p-group d4p-group-reset d4p-group-important">
    <h3><?php _e("Important", "gd-rating-system"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("This tool will replace all regular IP's in the votes log with the MD5 hashed string of the IP.", "gd-rating-system"); ?><br/>
        <?php _e("This operation is not reversible! Once hashed, IP MD5 strings can't be converted back into regular IP.", "gd-rating-system"); ?><br/>
        <?php _e("Use this tool only if you have enabled storing IP's as MD5 string in the Settings -> Security panel.", "gd-rating-system"); ?>
    </div>
</div>

<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("MD5 all IP's in the database votes log", "gd-rating-system"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdrtstools[ipmd5][hash]" value="on" /> <?php _e("MD5 hash all IP's", "gd-rating-system"); ?>
        </label>
    </div>
</div>