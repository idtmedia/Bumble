<?php

if (!defined('ABSPATH')) { exit; }

if (!function_exists('gdrts_get_hashed_ip')) {
    function gdrts_get_hashed_ip($ip = null) {
        if (is_null($ip)) {
            $ip = d4p_visitor_ip();
        }

        $md5 = function_exists('hash') ? hash('md5', $ip) : md5($ip);

        return 'md5:'.strtolower($md5);
    }
}

if (!function_exists('gdrts_get_user_agent')) {
    function gdrts_get_user_agent() {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = trim($_SERVER['HTTP_USER_AGENT']);

            return $user_agent;
        }

        return '';
    }
}
