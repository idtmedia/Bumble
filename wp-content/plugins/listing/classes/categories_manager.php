<?php 

class alsp_categories_manager {
	
	public function __construct() {
		global $pagenow;
		$taxonomy = ALSP_CATEGORIES_TAX;
		if ($pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'admin-ajax.php') {
			add_action('add_meta_boxes', array($this, 'removeCategoriesMetabox'));
			add_action('add_meta_boxes', array($this, 'addCategoriesMetabox'));
			
			
		}
		add_action(ALSP_CATEGORIES_TAX . '_add_form_fields', array ( $this, 'add_category_image' ), 10, 2 );
		add_action( 'created_'. ALSP_CATEGORIES_TAX, array ( $this, 'save_category_image' ), 10, 2 );
		add_action( 'edited_'. ALSP_CATEGORIES_TAX, array ( $this, 'update_save_category_image' ));
		add_filter('manage_' . ALSP_CATEGORIES_TAX . '_custom_column', array($this, 'taxonomy_rows'), 15, 3);
		add_filter('manage_edit-' . ALSP_CATEGORIES_TAX . '_columns',  array($this, 'taxonomy_columns'));
		add_action(ALSP_CATEGORIES_TAX . '_edit_form_fields', array($this, 'select_icon_form'));
		add_action(ALSP_CATEGORIES_TAX . '_edit_form_fields', array($this, 'select_icon_form2'));
		add_action(ALSP_CATEGORIES_TAX . '_edit_form_fields', array($this, 'select_marker_icon_form'));
		add_action(ALSP_CATEGORIES_TAX . '_edit_form_fields', array($this, 'select_marker_color_form'));
		add_action(ALSP_CATEGORIES_TAX . '_edit_form_fields', array ( $this, 'update_category_image' ), 10, 2 );
		
		add_action('admin_enqueue_scripts', array($this, 'load_wp_media_files' ));
		add_action( 'admin_footer', array ( $this, 'add_script' ) );
		
		if ($pagenow == 'edit-tags.php' && isset($_GET['taxonomy']) && $_GET['taxonomy'] == ALSP_CATEGORIES_TAX);
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_category_edit_scripts'));
		add_action('wp_ajax_alsp_select_category_icon_dialog2', array($this, 'select_category_icon_dialog2'));
		add_action('wp_ajax_alsp_select_category_icon_dialog', array($this, 'select_category_icon_dialog'));
		add_action('wp_ajax_alsp_select_category_icon2', array($this, 'select_category_icon2'));
		add_action('wp_ajax_alsp_select_category_icon', array($this, 'select_category_icon'));
		add_action('wp_ajax_alsp_select_category_marker_icon', array($this, 'select_category_marker_icon'));
		add_action('wp_ajax_alsp_select_category_marker_color', array($this, 'select_category_marker_color'));
		
		add_filter('manage_' . ALSP_TAGS_TAX . '_custom_column', array($this, 'tags_taxonomy_rows'), 15, 3);
		add_filter('manage_edit-' . ALSP_TAGS_TAX . '_columns',  array($this, 'tags_taxonomy_columns'));

		// 'checked_ontop' for directory categories taxonomy must always be false
		add_filter('wp_terms_checklist_args', array($this, 'unset_checked_ontop'), 100);
	}
	
	// remove native locations taxonomy metabox from sidebar
	public function removeCategoriesMetabox() {
		remove_meta_box(ALSP_CATEGORIES_TAX . 'div', ALSP_POST_TYPE, 'side');
	}

	public function addCategoriesMetabox($post_type) {
		if ($post_type == ALSP_POST_TYPE && ($level = alsp_getCurrentListingInAdmin()->level) && ($level->categories_number > 0 || $level->unlimited_categories)) {
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts_styles'));

			add_meta_box(ALSP_CATEGORIES_TAX,
					__('Listing categories', 'ALSP'),
					'post_categories_meta_box',
					ALSP_POST_TYPE,
					'normal',
					'high',
					array('taxonomy' => ALSP_CATEGORIES_TAX));
		}
	}
	
	public function unset_checked_ontop($args) {
		if (isset($args['taxonomy']) && $args['taxonomy'] == ALSP_CATEGORIES_TAX)
			$args['checked_ontop'] = false;

		return $args;
	}

	public function validateCategories($level, &$postarr, &$errors) {
		global $alsp_instance;

		if (isset($postarr['tax_input'][ALSP_CATEGORIES_TAX][0]) && $postarr['tax_input'][ALSP_CATEGORIES_TAX][0] == 0)
			unset($postarr['tax_input'][ALSP_CATEGORIES_TAX][0]);

		if (
			$alsp_instance->content_fields->getContentFieldBySlug('categories_list')->is_required &&
			(
			!isset($postarr['tax_input'][ALSP_CATEGORIES_TAX]) ||
			!is_array($postarr['tax_input'][ALSP_CATEGORIES_TAX]) ||
			!count($postarr['tax_input'][ALSP_CATEGORIES_TAX])
			)
		)
			$errors[] = __('Select at least one category!', 'ALSP');

		if (isset($postarr['tax_input'][ALSP_CATEGORIES_TAX]) && is_array($postarr['tax_input'][ALSP_CATEGORIES_TAX])) {
			if (!$level->unlimited_categories)
				// remove unauthorized categories
				$postarr['tax_input'][ALSP_CATEGORIES_TAX] = array_slice($postarr['tax_input'][ALSP_CATEGORIES_TAX], 0, $level->categories_number, true);

			if ($level->categories && array_diff($postarr['tax_input'][ALSP_CATEGORIES_TAX], $level->categories))
				$errors[] = __('Sorry, you can not choose some categories for this level!', 'ALSP');

			$post_categories_ids = $postarr['tax_input'][ALSP_CATEGORIES_TAX];
		} else
			$post_categories_ids = array();

		return $post_categories_ids;
	}

	public function validateTags(&$postarr, &$errors) {
		if (isset($postarr[ALSP_TAGS_TAX]) && $postarr[ALSP_TAGS_TAX]) {
			$post_tags_ids = array();
			foreach ($postarr[ALSP_TAGS_TAX] AS $tag) {
				if ($term = term_exists($tag, ALSP_TAGS_TAX)) {
					$post_tags_ids[] = intval($term['term_id']);
				} else {
					if ($newterm = wp_insert_term($tag, ALSP_TAGS_TAX))
						if (!is_wp_error($newterm))
							$post_tags_ids[] = intval($newterm['term_id']);
				}
			}
		} else
			$post_tags_ids = array();

		return $post_tags_ids;
	}
	
	public function tags_taxonomy_columns($original_columns) {
		$new_columns = $original_columns;
		array_splice($new_columns, 1);
		$new_columns['alsp_tags_id'] = __('Tag ID', 'ALSP');
		return array_merge($new_columns, $original_columns);
	}
	
	public function tags_taxonomy_rows($row, $column_name, $term_id) {
		if ($column_name == 'alsp_tags_id') {
			return $row . $term_id;
		}
		return $row;
	}
	
	public function taxonomy_columns($original_columns) {
		$new_columns = $original_columns;
		array_splice($new_columns, 1);
		$new_columns['alsp_category_id'] = __('Category ID', 'ALSP');
		$new_columns['alsp_category_icon'] = __('Icon', 'ALSP');
		$new_columns['alsp_category_icon2'] = __('Icon on Post', 'ALSP');
		//if (get_option('alsp_map_markers_type') == 'icons') {
			$new_columns['alsp_marker_category_icon'] = __('Marker Icon', 'ALSP');
			
		//}
		$new_columns['alsp_marker_category_color'] = __('Marker Color', 'ALSP');
		if (isset($original_columns['description']))
			unset($original_columns['description']);
		return array_merge($new_columns, $original_columns);
	}
	
	public function taxonomy_rows($row, $column_name, $term_id) {
		if ($column_name == 'alsp_category_id') {
			return $row . $term_id;
		}
		if ($column_name == 'alsp_category_icon') {
			return $row . $this->choose_icon_link($term_id);
		}
		if ($column_name == 'alsp_category_icon2') {
			return $row . $this->choose_icon_link2($term_id);
		}
		//if (get_option('alsp_map_markers_type') == 'icons') {
			if ($column_name == 'alsp_marker_category_icon') {
				return $row . $this->choose_marker_icon_link($term_id);
			//}
			
		}
		if ($column_name == 'alsp_marker_category_color') {
				return $row . $this->choose_marker_icon_color($term_id);
			}
		return $row;
	}

	// Category Icon
	public function select_icon_form($term) {
		alsp_frontendRender('categories/select_icon_form.tpl.php', array('term' => $term));
	}
	
	public function choose_icon_link($term_id) {
		$icon_file = $this->getCategoryIconFile($term_id);
		alsp_frontendRender('categories/select_icon_link.tpl.php', array('term_id' => $term_id, 'icon_file' => $icon_file));
	}
	
	public function getCategoryIconFile($term_id) {
		if (($icons = get_option('alsp_categories_icons')) && is_array($icons) && isset($icons[$term_id]))
			return $icons[$term_id];
	}
	
	public function select_category_icon_dialog() {
		$categories_icons = array();
		
		$categories_icons_files = scandir(ALSP_CATEGORIES_ICONS_PATH);
		foreach ($categories_icons_files AS $file)
			if (is_file(ALSP_CATEGORIES_ICONS_PATH . $file) && $file != '.' && $file != '..')
				$categories_icons[] = $file;
		
		alsp_frontendRender('categories/select_icons_dialog.tpl.php', array('categories_icons' => $categories_icons));
		die();
	}
	
	public function select_category_icon() {
		if (isset($_POST['category_id']) && is_numeric($_POST['category_id'])) {
			$category_id = $_POST['category_id'];
			$icons = get_option('alsp_categories_icons');
			if (isset($_POST['icon_file']) && $_POST['icon_file']) {
				$icon_file = $_POST['icon_file'];
				if (is_file(ALSP_CATEGORIES_ICONS_PATH . $icon_file)) {
					$icons[$category_id] = $icon_file;
					update_option('alsp_categories_icons', $icons);
					echo $category_id;
				}
			} else {
				if (isset($icons[$category_id]))
					unset($icons[$category_id]);
				update_option('alsp_categories_icons', $icons);
			}
		}
		die();
	}
	/* icon 2 */
	public function select_icon_form2($term) {
		alsp_frontendRender('categories/select_icon_form2.tpl.php', array('term' => $term));
	}
	public function choose_icon_link2($term_id) {
		$icon_file2 = $this->getCategoryIconFile2($term_id);
		alsp_frontendRender('categories/select_icon_link2.tpl.php', array('term_id' => $term_id, 'icon_file2' => $icon_file2));
	}
	public function getCategoryIconFile2($term_id) {
		if (($icons2 = get_option('alsp_categories_icons2')) && is_array($icons2) && isset($icons2[$term_id]))
			return $icons2[$term_id];
	}
	public function select_category_icon_dialog2() {
		$categories_icons2 = array();
		
		$categories_icons_files = scandir(ALSP_CATEGORIES_ICONS_PATH);
		foreach ($categories_icons_files AS $file)
			if (is_file(ALSP_CATEGORIES_ICONS_PATH . $file) && $file != '.' && $file != '..')
				$categories_icons2[] = $file;
		
		alsp_frontendRender('categories/select_icons_dialog2.tpl.php', array('categories_icons2' => $categories_icons2));
		die();
	}
	public function select_category_icon2() {
		if (isset($_POST['category_id2']) && is_numeric($_POST['category_id2'])) {
			$category_id = $_POST['category_id2'];
			$icons2 = get_option('alsp_categories_icons2');
			if (isset($_POST['icon_file2']) && $_POST['icon_file2']) {
				$icon_file2 = $_POST['icon_file2'];
				if (is_file(ALSP_CATEGORIES_ICONS_PATH . $icon_file2)) {
					$icons2[$category_id] = $icon_file2;
					update_option('alsp_categories_icons2', $icons2);
					echo $category_id;
				}
			} else {
				if (isset($icons2[$category_id]))
					unset($icons2[$category_id]);
				update_option('alsp_categories_icons2', $icons2);
			}
		}
		die();
	}
	
	
	// Category Map Marker Icon
	public function select_marker_icon_form($term) {
		alsp_frontendRender('categories/select_marker_icon_form.tpl.php', array('term' => $term));
	}
	public function choose_marker_icon_link($term_id) {
		$icon_name = $this->getCategoryMarkerIcon($term_id);
		alsp_frontendRender('categories/select_marker_icon_link.tpl.php', array('term_id' => $term_id, 'icon_name' => $icon_name));
	}
	public function getCategoryMarkerIcon($term_id) {
		if (($icons = get_option('alsp_categories_marker_icons')) && is_array($icons) && isset($icons[$term_id]))
			return $icons[$term_id];
	}
	public function select_category_marker_icon() {
		if (isset($_POST['category_id']) && is_numeric($_POST['category_id'])) {
			$category_id = $_POST['category_id'];
			$markers_icons = get_option('alsp_categories_marker_icons');
			if (isset($_POST['icon_name']) && $_POST['icon_name']) {
				$icon_name = $_POST['icon_name'];
				if (in_array($icon_name, alsp_get_fa_icons_names())) {
					$markers_icons[$category_id] = $icon_name;
					update_option('alsp_categories_marker_icons', $markers_icons);
					echo $category_id;
				}
			} else {
				if (isset($markers_icons[$category_id]))
					unset($markers_icons[$category_id]);
				update_option('alsp_categories_marker_icons', $markers_icons);
			}
		}
		die();
	}

	// Category Map Marker Color
	public function select_marker_color_form($term) {
		alsp_frontendRender('categories/select_marker_color_form.tpl.php', array('term' => $term));
	}
	public function choose_marker_icon_color($term_id) {
		$color = $this->getCategoryMarkerColor($term_id);
		alsp_frontendRender('categories/select_marker_color_link.tpl.php', array('term_id' => $term_id, 'color' => $color));
	}
	public function getCategoryMarkerColor($term_id) {
		if (($colors = get_option('alsp_categories_marker_colors')) && is_array($colors) && isset($colors[$term_id]))
			return $colors[$term_id];
	}
	public function select_category_marker_color() {
		if (isset($_POST['category_id']) && is_numeric($_POST['category_id'])) {
			$category_id = $_POST['category_id'];
			$markers_colors = get_option('alsp_categories_marker_colors');
			if (isset($_POST['color']) && $_POST['color']) {
				$color = $_POST['color'];
				$markers_colors[$category_id] = $color;
				update_option('alsp_categories_marker_colors', $markers_colors);
				echo $category_id;
			} else {
				if (isset($markers_colors[$category_id]))
					unset($markers_colors[$category_id]);
				update_option('alsp_categories_marker_colors', $markers_colors);
			}
		}
		die();
	}
	
	public function admin_enqueue_category_edit_scripts() {
		wp_enqueue_script('alsp_categories_edit_scripts');
		wp_localize_script(
				'alsp_categories_edit_scripts',
				'categories_icons',
				'categories_icons2',
				array(
						'categories_icons_url' => ALSP_CATEGORIES_ICONS_URL,
						'ajax_dialog_title' => __('Select category icon', 'ALSP'),
						'ajax_marker_dialog_title' => __('Select marker', 'ALSP'),
				)
		);
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');
	}
	
	public function admin_enqueue_scripts_styles() {
		wp_enqueue_script('alsp_categories_scripts');

		if ($listing = alsp_getCurrentListingInAdmin()) {
			if ($listing->level->unlimited_categories)
				$categories_number = 'unlimited';
			else 
				$categories_number = $listing->level->categories_number;

			wp_localize_script(
					'alsp_categories_scripts',
					'level_categories',
					array(
							'level_categories_array' => $listing->level->categories,
							'level_categories_number' => $categories_number,
							'level_categories_notice_disallowed' => __('Sorry, you can not choose this category for this level!', 'ALSP'),
							'level_categories_notice_number' => sprintf(__('Sorry, you can not choose more than %d categories!', 'ALSP'), $categories_number)
					)
			);
		}
	}
	public function add_category_image ( $term_id ) { ?>
   <div class="form-field term-group">
     <label for="category-image-id"><?php _e('Background Image only Work on Parent Category ', 'ALSP'); ?></label>
     <input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
     <div id="category-image-wrapper" style="width:100px;max-height:100px;overflow:hidden;"></div>
     <p>
       <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'ALSP' ); ?>" />
       <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'ALSP' ); ?>" />
    </p> 
   </div>
   <div class="form-field term-group">
     <label for="category-svg-icon-id"><?php _e('svg icon', 'ALSP'); ?></label>
     <textarea type="text" id="category-svg-icon-id" name="category-svg-icon-id" class="" value=""></textarea>
	 
   </div>
 <?php
 }
 public function save_category_image ( $term_id, $tt_id ) {
   if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
     $image = $_POST['category-image-id'];
     add_term_meta( $term_id, 'category-image-id', $image, true );
   }
   if( isset( $_POST['category-svg-icon-id'] ) && '' !== $_POST['category-svg-icon-id'] ){
	  $cat_svg_icon = $_POST['category-svg-icon-id'];
     add_term_meta( $term_id, 'category-svg-icon-id', $cat_svg_icon, true );
   }
 }
/*
  * Edit the form field
  * @since 1.0.0
 */
 public function update_category_image ( $term, $taxonomy ) { ?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="category-image-id"><?php _e( 'Background Image only Work on Parent Category ', 'ALSP' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ( $term -> term_id, 'category-image-id', true ); ?>
       <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
       <div id="category-image-wrapper" style="width:100px;max-height:100px;overflow:hidden;">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'full' ); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button-secondary ct_tax_media_button button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'ALSP' ); ?>" />
         <input type="button" class="button-secondary ct_tax_media_remove button " id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'ALSP' ); ?>" />
       </p>
     </td>
	</tr>
	<tr class="form-field term-group-wrap">
	 <th scope="row">
       <label for="category-svg-icon-id"><?php _e( 'SVG ICON', 'ALSP' ); ?></label>
     </th>
     <td>
       <?php $cat_svg_icon = get_term_meta ( $term -> term_id, 'category-svg-icon-id', true ); ?>
       <textarea type="text" id="category-svg-icon-id" name="category-svg-icon-id" value=""><?php echo $cat_svg_icon; ?></textarea>
       <div id="category-svg-wrapper" style="width:100px;max-height:100px;overflow:hidden;">
         <?php if ( $cat_svg_icon ) { ?>
           <?php echo $cat_svg_icon; ?>
         <?php } ?>
       </div>
     </td>
   </tr>
   <tr class="form-field term-group-wrap" id="rating-f">
	 <th scope="row">
       <label for="category-fields"><?php _e( 'fields', 'ALSP' ); ?></label>
     </th>
	 <td>
	 <button data-increment="0" class="add-additional-row"><i class="fa fa-plus"></i> <?php esc_html_e( 'Add New', 'houzez' ); ?></button>
	 </td>
   </tr>
 <?php
 }
 /*
 * Update the form field value
 * @since 1.0.0
 */
 public function update_save_category_image ( $term_id) {
   if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
     $image = $_POST['category-image-id'];
     update_term_meta ( $term_id, 'category-image-id', $image );
	 
   } else {
     update_term_meta ( $term_id, 'category-image-id', '' );
   }
   if( isset( $_POST['category-svg-icon-id'] ) && '' !== $_POST['category-svg-icon-id'] ){
     $cat_svg_icon = $_POST['category-svg-icon-id'];
     update_term_meta ( $term_id, 'category-svg-icon-id', $cat_svg_icon );
	 
   } else {
     update_term_meta ( $term_id, 'category-svg-icon-id', '' );
   }
 }
 public function add_script() {

 ?>
 
   <script type="text/javascript">
     jQuery(document).ready( function($) {
       function ct_media_upload(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#category-image-id').val(attachment.id);
               $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#category-image-wrapper .custom_media_image').attr('src',attachment.sizes.thumbnail.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }
     ct_media_upload('.ct_tax_media_button.button'); 
     $('body').on('click','.ct_tax_media_remove',function(){
       $('#category-image-id').val('');
       $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#category-image-wrapper').html('');
         }
       }
     });
   });
   
   $( '.add-additional-row' ).click(function( e ){
            e.preventDefault();

            var numVal = $(this).data("increment") + 1;
            $(this).data('increment', numVal);
            $(this).attr({
                "data-increment" : numVal
            });

            var newAdditionalDetail = '<tr>'+
                '<td class="action-field">'+
                '<span class="sort-additional-row"><i class="fa fa-navicon"></i></span>'+
                '</td>'+
                '<td class="field-title">'+
                '<input class="form-control" type="text" name="additional_features['+numVal+'][fave_additional_feature_title]" id="fave_additional_feature_title_'+numVal+'" value="">'+
                '</td>'+
                '<td>'+
                '<input class="form-control" type="text" name="additional_features['+numVal+'][fave_additional_feature_value]" id="fave_additional_feature_value_'+numVal+'" value="">'+
                '</td>'+
                '<td class="action-field">'+
                '<span data-remove="'+numVal+'" class="remove-additional-row"><i class="fa fa-remove"></i></span>'+
                '</td>'+
                '</tr>';

            $( '#rating-f').append( newAdditionalDetail );
            removeAdditionalDetails();
        });

        var removeAdditionalDetails = function (){

            $( '.remove-additional-row').click(function( event ){
                event.preventDefault();
                var $this = $( this );
                $this.closest( 'tr' ).remove();
            });
        }
        removeAdditionalDetails();
 </script>
 
 <?php 

 }
 public function load_wp_media_files() {
	wp_enqueue_media();
	}


}


?>