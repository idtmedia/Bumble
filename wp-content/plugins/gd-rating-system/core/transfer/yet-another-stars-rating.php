<?php

if (!defined('ABSPATH')) { exit; }

class gdrts_transfer_yet_another_stars_rating {
    public $page = 500;

    public function __construct() {
        $this->page = gdrts_settings()->get('step_transfer');
    }

    public function round_to_page($number) {
        return ceil(intval($number) / $this->page) * $this->page;
    }

    public function db_tables_exist() {
        $tables = array(
            gdrts_db()->wpdb()->prefix.'yasr_log'
        );

        $ok = true;

        foreach ($tables as $table) {
            $rows = gdrts_db()->run("SHOW TABLES LIKE '".$table."'");

            if (count($rows) == 0) {
                $ok = false;
            }
        }

        return $ok;
    }

    public function count_stars_rating() {
        $count = 0;

        $sql = "SELECT COUNT(*) FROM ".gdrts_db()->wpdb()->prefix."yasr_log r WHERE r.`multi_set_id` = -1 AND r.id NOT IN
                (SELECT CAST(meta_value as UNSIGNED) FROM ".gdrts_db()->logmeta." WHERE meta_key = 'yasr-import')";
        $count+= $this->round_to_page(gdrts_db()->get_var($sql));

        return $count;
    }

    public function transfer_stars_rating($max = 5, $offset = 0) {
        $this->_transfer_stars_rating_log($max, $offset);
    }

    private function _transfer_stars_rating_log($max = 5, $offset = 0) {
        $sql = "SELECT r.* FROM ".gdrts_db()->wpdb()->prefix."yasr_log r WHERE r.`multi_set_id` = -1 AND r.id NOT IN
                (SELECT CAST(meta_value as UNSIGNED) FROM ".gdrts_db()->logmeta." WHERE meta_key = 'yasr-import') 
                ORDER BY r.id ASC LIMIT ".$this->page;
        $raw = gdrts_db()->run($sql);

        if (!empty($raw)) {
            foreach ($raw as $rating) {
                $post_type = get_post_type($rating->post_id);

                if (!$post_type) {
                    $post_type = 'post';
                }

                gdrtsm_stars_rating()->_load_settings_rule('posts', $post_type);

                $args = array(
                    'entity' => 'posts', 
                    'name' => $post_type, 
                    'id' => $rating->post_id
                );

                $item = gdrts_get_rating_item($args);

                $factor = gdrtsm_stars_rating()->get_rule('stars') / $max;

                $data = array(
                    'action' => 'vote',
                    'ip' => $rating->ip,
                    'logged' => $rating->date
                );

                $meta = array(
                    'vote' => $rating->vote * $factor,
                    'max' => gdrtsm_stars_rating()->get_rule('stars'),
                    'yasr-import' => $rating->id
                );

                gdrtsm_stars_rating()->calculate($item, 'vote', $meta['vote'], $meta['max']);

                gdrts_db()->add_to_log($item->item_id, $rating->user_id, gdrtsm_stars_rating()->method(), $data, $meta);
            }
        }
    }
}
