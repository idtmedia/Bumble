(function($) {

	"use strict";


	$(document).ready(function() {


		pacz_megamenu.menu_item_mouseup();
		pacz_megamenu.megamenu_status_update();

		pacz_megamenu.update_megamenu_fields();

		$( '.remove-pacz-megamenu-background' ).manage_thumbnail_display();
		$( '.pacz-megamenu-background-image' ).css( 'display', 'block' );
		$( ".pacz-megamenu-background-image[src='']" ).css( 'display', 'none' );

		pacz_media_frame_setup();

	});


	var pacz_megamenu = {

		menu_item_mouseup: function() {
			$( document ).on( 'mouseup', '.menu-item-bar', function( event, ui ) {
				if( ! $( event.target ).is( 'a' )) {
					setTimeout( pacz_megamenu.update_megamenu_fields, 300 );
				}
			});
		},

		megamenu_status_update: function() {

			$( document ).on( 'click', '.edit-menu-item-pacz-megamenu-check', function() {
				var parent_li_item = $( this ).parents( '.menu-item:eq( 0 )' );

				if( $( this ).is( ':checked' ) ) {
					parent_li_item.addClass( 'pacz-megamenu' );
				} else 	{
					parent_li_item.removeClass( 'pacz-megamenu' );
				}
				pacz_megamenu.update_megamenu_fields();
			});
		},

		update_megamenu_fields: function() {
			var menu_li_items = $( '.menu-item');

			menu_li_items.each( function( i ) 	{

				var megamenu_status = $( '.edit-menu-item-pacz-megamenu-check', this );

				if( ! $( this ).is( '.menu-item-depth-0' ) ) {
					var check_against = menu_li_items.filter( ':eq(' + (i-1) + ')' );


					if( check_against.is( '.pacz-megamenu' ) ) {

						megamenu_status.attr( 'checked', 'checked' );
						$( this ).addClass( 'pacz-megamenu' );
					} else {
						megamenu_status.attr( 'checked', '' );
						$( this ).removeClass( 'pacz-megamenu' );
					}
				} else {
					if( megamenu_status.attr( 'checked' ) ) {
						$( this ).addClass( 'pacz-megamenu' );
					}
				}
			});
		}

	}


	$.fn.manage_thumbnail_display = function( variables ) {
		var button_id;

		return this.click( function( e ){
			e.preventDefault();

			button_id = this.id.replace( 'pacz-media-remove-', '' );
			$( '#edit-menu-item-megamenu-background-'+button_id ).val( '' );
			$( '#pacz-media-img-'+button_id ).attr( 'src', '' ).css( 'display', 'none' );
		});
	}

	function pacz_media_frame_setup() {
		var ClassiadsProMediaFrame;
		var item_id;

		$( document.body ).on( 'click.classiadsproOpenMediaManager', '.pacz-open-media', function(e){

			e.preventDefault();

			item_id = this.id.replace('pacz-media-upload-', '');

			if ( ClassiadsProMediaFrame ) {
				ClassiadsProMediaFrame.open();
				return;
			}

			ClassiadsProMediaFrame = wp.media.frames.ClassiadsProMediaFrame = wp.media({

				className: 'media-frame pacz-media-frame',
				frame: 'select',
				multiple: false,
				library: {
					type: 'image'
				}
			});

			ClassiadsProMediaFrame.on('select', function(){

				var media_attachment = ClassiadsProMediaFrame.state().get('selection').first().toJSON();

				$( '#edit-menu-item-megamenu-background-'+item_id ).val( media_attachment.url );
				$( '#pacz-media-img-'+item_id ).attr( 'src', media_attachment.url ).css( 'display', 'block' );

			});

			ClassiadsProMediaFrame.open();
		});

	}

	
	function pacz_menus_icon_selector() {
		jQuery('.pacz-visual-selector').find('a').each(function() {
			default_value = jQuery(this).siblings('input').val();
			if(jQuery(this).attr('rel')==default_value){
					jQuery(this).addClass('current');
				}
				jQuery(this).click(function(){

					jQuery(this).siblings('input').val(jQuery(this).attr('rel'));
					jQuery(this).parent('.pacz-visual-selector').find('.current').removeClass('current');
					jQuery(this).addClass('current');
					return false;
				})
		});
	}
	pacz_menus_icon_selector();

	function pacz_use_icon() {

		jQuery('.pacz-add-icon-btn').on('click', function() {

			this_el_id = "#edit-menu-item-menu-icon-" + jQuery(this).attr('data-id');
			icon_el_id = "#pacz-view-icon-" + jQuery(this).attr('data-id');
			//console.log(this_el_id);

			jQuery('.pacz-icon-use-this').on('click', function() {
				icon_value = jQuery('#pacz-icon-value-holder').val();
				if(icon_value == '') {
					jQuery(icon_el_id).attr("class", "");
					jQuery(this_el_id).val("");
				} else {
					jQuery(icon_el_id).attr("class", icon_value);
					jQuery(this_el_id).val(icon_value);
				}
				
				window.parent.tb_remove();
				return false;
			});
		});

		jQuery('.pacz-remove-icon').on('click', function() {
			jQuery(this).siblings('input').val('');
			jQuery(this).siblings('i').attr('class', '');
			return false;

		});

	}
	pacz_use_icon();

})(jQuery);


