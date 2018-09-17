<?php

if (!defined('ABSPATH')) { exit; }

function gdrts_load_template($templates, $load = true) {
    _deprecated_function(__FUNCTION__, '2.4', 'gdrts()->find_template()');

    return gdrts()->find_template($templates, $load);
}

function gdrts_return_template($templates, $type = 'single') {
    _deprecated_function(__FUNCTION__, '2.4', 'gdrts()->render_template()');

    return gdrts()->render_template($templates, $type);
}

function gdrts_list_all_method($include_series = false) {
    _deprecated_function(__FUNCTION__, '2.4', 'gdrts_list_all_methods()');

    return gdrts_list_all_methods($include_series);
}
