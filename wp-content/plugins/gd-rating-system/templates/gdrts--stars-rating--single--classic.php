<?php // GDRTS Template: Classic // ?>

<div class="<?php gdrts_loop()->render()->classes(); ?>">
    <div class="gdrts-inner-wrapper">

        <?php do_action('gdrts-template-rating-block-before'); ?>

        <?php gdrts_loop()->render()->stars(); ?>

        <div class="gdrts-rating-text">
            <?php

            if (gdrts_loop()->render()->has_votes()) {
                gdrts_loop()->render()->rating();
            } else {
                _e("No votes yet.", "gd-rating-system");
            }

            ?>
        </div>

        <?php

        if (gdrts_loop()->user()->has_voted()) {

        ?>

            <div class="gdrts-rating-user">
                <?php gdrts_loop()->render()->vote_from_user(); ?>
            </div>

        <?php

        }

        if (gdrts_loop()->is_save()) {

        ?>

            <div class="gdrts-rating-thanks">
                <?php _e("Thanks for your vote!", "gd-rating-system"); ?>
            </div>

        <?php

        } else {
            gdrts_loop()->please_wait();
        }

        gdrts_loop()->json();

        do_action('gdrts-template-rating-block-after');
        do_action('gdrts-template-rating-rich-snippet');

        ?>

    </div>
</div>