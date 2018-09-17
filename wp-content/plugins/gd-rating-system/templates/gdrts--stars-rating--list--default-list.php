<?php // GDRTS Template: Default, List // ?>

<div class="<?php gdrts_loop()->render()->classes('gdrts-thumbnail-float-left'); ?>">
    <div class="gdrts-inner-wrapper">

<?php

if (gdrts_list()->have_items()) :

?>

<ol>

<?php

    while (gdrts_list()->have_items()) :
        gdrts_list()->the_item();

        $thumbnail = '';
        if (apply_filters('gdrts-template-stars-rating-default-list-show-thumbnail', true)) {
            $thumbnail_size = apply_filters('gdrts-template-stars-rating-default-list-thumbnail-size', array(64, 64));
            $thumbnail = gdrts_list()->item()->thumbnail($thumbnail_size);
        }

?>

    <li class="gdrts-rating-item">
        <?php if (!empty($thumbnail)) { ?>
        <div class="gdrts-item-thumbnail">
            <a href="<?php echo gdrts_list()->item()->url(); ?>"><?php echo $thumbnail; ?></a>
        </div>
        <?php } ?>
        <div class="gdrts-item-information">
            <a href="<?php echo gdrts_list()->item()->url(); ?>"><?php echo gdrts_list()->item()->title(); ?></a>
            <div class="gdrts-widget-rating"><?php gdrts_loop()->render()->rating(); ?></div>
            <div class="gdrts-widget-rating-stars"><?php gdrts_loop()->render()->stars(); ?></div>
        </div>
    </li>

<?php

    endwhile;

?>

</ol>

<?php

else :

    _e("No items found.", "gd-rating-system");

endif;

?>

        <?php gdrts_list()->json(); ?>

    </div>
</div>
