=== WPAdverts - Classifieds Plugin ===
Plugin URI: https://wpadverts.com/
Contributors: gwin
Tags: classifieds, classified, classified ads, classified script, classifieds script, wp classified, wp classifieds
Requires PHP: 5.3
Requires at least: 4.0
Tested up to: 5.0
Stable tag: 1.2.8
License: GNU Version 2 or Any Later Version

Build classifieds section in seconds. Allow your visitors to browse and post (paid or free) classified ads on your site.

== Description ==

WPAdverts is a lite weight plugin which allows to build beatufiul classifieds site in minutes. Plugin will work with ANY properly
coded WordPress theme and you can use it on new or existing site.

When building Adverts we are focusing on ease of use, WordPress compatibility and extensibility, the plugin core is small but this
is NOT a demo, this is a fully functional classifieds software with most crucial functionalities builtin.

**Links**

* [WordPress Classifieds Plugin](https://wpadverts.com/) - official site.
* [View User Demo](https://demo.wpadverts.com/) - see plugin frontend.
* [View Admin Demo](https://demo.wpadverts.com/wp-admin/) - see wp-admin panel.
* [Documentation](https://wpadverts.com/documentation/) - mainly for users.
* [Code Snippets](https://github.com/simpliko/wpadverts-snippets) - for programmers and developers.

**Noatble Features**

* Modern, responsive design.
* Intuitive classified Ads browsing and searching ([adverts_list] shortcode).
* Display classifieds categories grid ([adverts_categories] shortcode).
* Allow (registered and/or anonymous) users to post classifieds ([adverts_add] shortcode).
* Allow users to browse, edit and delete their ads ([adverts_manage] shortcode).
* Payments Module to track user payments and transactions logs.
* Bank Transfer payment gateway included.
* Charge users for posting classifieds ads
* Charge users for renewing expired ads
* Easy to use drag and drop image upload.
* Ads will automatically expire after set number of days.
* Detailed user and developer documenation.

**Extensions**

WPAdverts plugin can be extended with premium add-ons.

* [<strong>ALL EXTENSIONS BUNDLE</strong>](https://wpadverts.com/extensions/all-extensions-bundle/) <strong>one price, huge discount</strong>
* [Custom Fields](https://wpadverts.com/extensions/custom-fields/)
* [WooCommerce Integration](https://wpadverts.com/extensions/woocommerce-integration/)
* [BuddyPress Integration](https://wpadverts.com/extensions/buddypress-integration/)
* [Maps and Locations](https://wpadverts.com/extensions/maps-and-locations/)
* [PayPal Payments Standard](https://wpadverts.com/extensions/paypal-payments-standard/)
* [Restricted Categories](https://wpadverts.com/extensions/restricted-categories/)
* [Fee Per Category](https://wpadverts.com/extensions/fee-per-category/)
* [reCAPTCHA Integration](https://wpadverts.com/extensions/recaptcha/)

See all https://wpadverts.com/extensions/

**Available Translations**

* Brazilian
* British (UK)
* Croatian
* French
* Dutch
* German
* Polish
* Portugese
* Russian
* Slovak
* Slovenian
* Spanish

**Get Involved**

* Wording - I am not English native speaker, if you find any typo, grammer mistake or etc. please report it on support forum.
* Translation - If you translated Adverts to your language feel free to submit translation.
* Rate Adverts - If you find this plugin useful please leave [positive review](https://wordpress.org/support/view/plugin-reviews/wpadverts).
* Submit a Bug - If you find some issue please [submit a bug](https://github.com/simpliko/wpadverts/issues/new) on GitHub.

== Installation ==

1. Activate the plugin
2. On activation plugin will create two Pages (in wp-admin / Pages panel)  with [adverts_list] and [adverts_add] shortcodes .
3. Go to Classifieds / Options panel and configure the options.
3. For more detailed instructions visit plugin [documentation](https://wpadverts.com/documentation/)

== Frequently Asked Questions ==

= I have a problem what now? =

Please describe your issue and submit ticket on plugin support forum, you should receive reply within 24 hours (except Sunday).

= Ads pages are showing 404 error? =

Most likely rewrite rules were not registered properly for some reason. Go to wp-admin / Settings / Permalinks panel and click
"Save Changes" button without actually changing anything, this should reset router and fix URLs.

== Changelog ==

= 1.2.8 - 2018-11-29 =

* FEATURE: Allow non-expiring paid listings.
* FIXED: The free listings purchased using Payments module were not featured correctly.
* FIXED: When renewing listings the is_featured flag is never changed.
* FIXED: Pagination in [adverts_manage] displays next to the list (instead of below the list).
* API: wpadverts_filter_pricings_options filter - allows filtering available pricings.
* API: verify_choices form filter - allows checking if selected options (in select or checkboxes list) are valid values.
* API: "disabled" param was added to select, checkbox and radio input options.
* API: adverts_manage_moderate filter allows putting Advert into moderation when renewing.
* API: adext_insert_payment() function allows quickly creating payment programatically.

= 1.2.7 - 2018-10-09 =

* FEATURE: Added Stripe panel in wp-admin / Classifieds / Options
* FIXED: On mobile devices the page background is being scorlled instead of the gallery image editor.
* FIXED: Filling radio input options using callback function does not work.
* FIXED: [adverts_add] prefills values only for the advert_category taxonomy (added support for other taxonomies).
* API: Payments Module /payments.js file allows callback to customize checkout experience for different payment gateways.
* API: wpadverts_filter_pricings filter allows filtering pricings before they will be displayed in [adverts_add]. 
* TRANSLATION: Updated Spanish translation

= 1.2.6 - 2018-08-30 =

* FEATURE: In Settings it is not possible to set a text which will display instead of price if price was not provided.
* FIXED: Boxes on [adverts_list] not reszied correctly, which sometimes broke the grid layout.
* FIXED: max_choices validator shows a warning message when only one value is passed to validation.
* FIXED: Unicode characters in the URL break the file upload.
* TRANSLATION: Updated German translation

= 1.2.5 - 2018-07-04 =

* FIXED: Thumbnails slider not showing all slides.
* FIXED: Not all pricings are shown when there is long list of pricings (over 20).
* FIXED: Allow using .adverts-button CSS class for input[type=submit].
* FIXED: The is_featured param not passed to Advert when renewing.
* FIXED: Incorrect parameter passed to adverts_payment_* filter.

= 1.2.4 - 2018-05-10 =

* FIXED: Fatal Error After 1.2.3 update.

= 1.2.3 - 2018-05-10 =

* TRANSLATION: Improved Polish Translation.
* FEATURE: Ability to handle Expired Adverts pages.
* FEATURE: Added link to Authors extension in wp-admin / Classifieds / Options panel.
* API: adverts_attachment_uploaded action allows modifying attachment after upload.
* FIXED: Updated CSS for textarea, checkbox and radio inputs marings and paddings.
* FIXED: Inline styling in add.php template replaced with actions_class.
* FIXED: Inline styling in form.php template replaced with actions_class.
* FIXED: Updated headers and removed inline styling in manage-edit.php template.

Read release notes here https://wpadverts.com/blog/handling-expired-adverts-pages/

= 1.2.2 - 2018-03-13 =

* TRANSLATION: Improved Brazilian Translation.
* FEATURE: Ability to show an image on the left side in Recent Adverts widget.
* FEATURE: On Advert details page user ID will be used to get an Avatar, the adverts_email will be used as a fallback.
* API: adverts_field_password added to the Forms API
* API: filter wpadverts_module_groups added to allow dynamic group adding in wp-admin / Classifieds / Options
* FIXED: The padlock icon in wp-admin / Plugins list shows too big.
* FIXED: Gallery shows black when jQuery 2.0 or newer is being used.
* FIXED: Warning in Featured Ads module.
* FIXED: Image gallery not showing (when Ad has some images uploaded).

Read release notes here https://wpadverts.com/blog/images-in-recent-ads-widget-wpadverts-1-2-2/

= 1.2.1 - 2018-01-29 =

* TRANSLATION: Slovak
* FEATURE: The first image in the Gallery will be used in [adverts_list] (unless featured image is selected).
* FEATURE: [adverts_list] now accepts list_type param which allows to show only Featured or Normal ads.
* FEATURE: The email and name are prefilled in the Contact Form if logged in user is viewing the page.
* FEATURE: Sri Lankan Rupees added to the currencies list.
* FEATURE: Ability to display forms as either: stacked (input below label) or aligned (input next to label).
* FIXED: Loading icon not spinning when clicking on "Show contact Information".
* FIXED: Uploaded files validation not working properly.
* FIXED: File upload not working with modified jQuery.
* FIXED: Image CW and CCW rotations mixed.

Read release notes here https://wpadverts.com/blog/mark-as-sold-custom-fields/

= 1.2.0 - 2017-12-05 =

* NEW: Image edition in WPAdverts Gallery (available for logged in users by default).
* NEW: Video upload, note only web video (mp4, webm and ogg) is accepted.
* NEW: Redesigned image gallery in the frontend with better optimization for mobile devices.
* NEW: Additional Gallery options in wp-admin / Classifieds / Options / Core / Gallery.
* NEW: Ability to display image gallery with thumbnails slider below image.
* NEW: Lightbox allows displaying images and videos in fullscreen mode on click.
* API: Added file upload validators
* FIXED: "Send Message" phrase marked for translation incorrectly.
* FIXED: It is now possible to disable Money filter in adverts_price field.
* REMOVED: Responsive Slides jQuery plugin

Read release notes here https://wpadverts.com/blog/video-uploads-and-image-editing-v1-2-0/

= 1.1.7 - 2017-11-08 =

* NOTE: The update 1.2 is coming soon, this one is a quick patch to fix incompatibility with WP 4.9
* FIXED: Gallery Upload incompatibility with WordPress 4.9

= 1.1.6 - 2017-09-04 =

* TRANSLATION: British
* FEATURE: Updated [adverts_list] search form CSS
* FEATURE: Added Required PHP version (for infomational purposes only)
* FEATURE: Ability to display Adverts Categories Widget as a categories tree
* FIXED: Display properly [adverts_list] with 4 columns
* FIXED: Use esc_attr() and esc_html() function when needed (for better WP compatibility)
* FIXED: Some flash messages displayed in an old mode
* FIXED: Incorrect tag closing in pt_BR translation
* API: Actions and filters for replacing default icons with custom images
* API: adverts_category_post_count filter allows to recalculate number of Ads in a category

= 1.1.5 - 2017-07-10 =

* FEATURE: Updated design for flash (error and info) messages.
* FEATURE: In wp-admin left menu the Classifieds menu has a red icon with number of pending Ads
* FEATURE: [adverts_add] has now a "requires" param which allows to show the shortcode only to users with specific capability
* FEATURE: When on Ad detail page, the Ad category has an additional CSS class in the Adverts Categories widget
* FIXED: Access to Adverts options requires now manage_options capability instead of install_plugins
* FIXED: Fatal Error in [adverts_manage] (occurs on some installations with BuddyPress enabled)
* FIXED: Impossible to uncheck the "Show Phone" option in Contact Form configuration
* FIXED: Changing number of dcimal places in configuration applies this change to Price field in [adverts_add]

= 1.1.4 - 2017-06-09 =

* TRANSLATION: Croatian
* FEATURE: Beautiful Advert edit forms in wp-admin / Classifieds panel.
* FEATURE: Do not show Contact Form on Ad details page if user did not enter contact email in [adverts_add].
* FEATURE: Display full category tree in Adverts Categories widget.
* FEATURE: CSS class for current category in Adverts Categories widget.
* FEATURE: Small update to Gallery upload layout.
* FIXED: Warning message when displaying drop down field with no options.
* FIXED: Disallow shortcodes and some HTML tags in the Advert content
* API: 2nd param in adverts_list_query filter

= 1.1.3 - 2017-04-26 =

* FEATURE: Google Analytics integration box in wp-admin / Classifieds / Options.
* FEATURE: Display [adverts_list] in list mode on mobile (if selected).
* FEATURE: Removed images from [adverts_manage] on mobile devices.
* FEATURE: Free Ads renewals cannot be used more than once a week.
* FEATURE: Display category description above [adverts_list] when browsing Ads by category.
* FEATURE: Allow sorting Ads in the [adverts_list] (by default disabled).
* API: allow_sorting and order_by params in [adverts_list].
* API: adverts_renewal_time_min filter allows to set how often free renewals can be used.
* API: adverts_sh_manage_actions_after filter.
* FIXED: Renewing updates post publication date (basically renewing bumps Ad to the top).
* FIXED: Missing adverts_filter_number function.
* FIXED: Do not display location icon on [adverts_list] if location was not provided.
* FIXED: Advert renewal page in [adverts_manage] does not load required assets.

= 1.1.2 - 2017-03-30 =

* TRANSLATION: Spanish
* TRANSLATION: Dutch
* API: adverts_data_box_content_exclude filter added
* API: max_choices validator for dropdown and checkbox fields.
* API: show_pagination param added to [adverts_list].
* FIXED: Payments Module not showing all available pricings.
* FIXED: Replaced annonymous sorting function with a static function (to make WPAdverts compatible with PHP 5.2 again).
* FIXED: Adverts are being assigned to user who is editing the Ad from wp-admin.
* FIXED: Incorrect textarea width in the frontend forms.
* FIXED: adverts_price() throwing a warning when price is incorrectly formatted.

= 1.1.1 - 2017-01-06 =

* FIXED: Not displaying warning in [adverts_manage] for unregistered users.
* FIXED: Clearing list saved licenses when saving Core settings.
* FIXED: Typo in plugins list HTML (wp-admin / Plugins)
* FIXED: (API) Binding data to multiselect fields.

= 1.1.0 - 2016-12-30 =

* NEW: Redesigned [adverts_manage] layout
* NEW: "Are you sure?" question before deleting an Ad in [adverts_manage]
* NEW: Drag and drop image sorting in the gallery
* NEW: Renew ads from [adverts_manage]
* API: Ability to extend [adverts_manage] with additional buttons
* FIXED: Do not display Listing Type field in [adverts_manage]
* FIXED: Displaying meta data in [adverts_add]
* FIXED: Allow editing pending ads from [adverts_manage] panel.

= 1.0.12 - 2016-12-01 =

* FIXED: Displaying multiselect values in forms
* FIXED: Using `esc_html_e()` instead of `echo esc_html()`
* FIXED: Aligning fields in [adverts_list] search form
* FIXED: Unique order number for each field in [adverts_add] form
* NEW: Support for "description" in adverts_field_header
* API: Added "adverts_form_scheme" filter
* API: New field filters: Integer, Number, URL
* API: New field validators: Is URL, Is Number

= 1.0.11 - 2016-10-13 =

* NEW: Defaut values for [adverts_list]
* NEW: Custom Fields module link in wp-admin / Options
* NEW: 3 new code snippets in Snippets Library https://github.com/simpliko/wpadverts-snippets
* FIXED: Using `esc_html_e()` instead of `echo esc_html()`
* FIXED: Handle multiple taxonomies (if needed) in [adverts_manage].
* API: Alternative category browsing URLs (easy fix for categories if they are not compatible with your theme).
* API: Ability to Trash posts instead of deleting them in the frontend (to enable this feature add this line to your theme functions.php `add_filter("adverts_skip_trash", "__return_false");`)
* API: Saving Custom Fields as Taxonomies instead of Meta (go to Snippets library to see an example code)
* API: Allow to custom format the Advert price displayed in [adverts_list] and in Ad details.

= 1.0.10 - 2016-09-12 =

* TRANSLATION: Portugese
* NEW: Contact Form Module (you can enable it from wp-admin / Classifieds / Options)
* FIXED: adverts_config() causing a fatal error in WP-CLI
* FIXED: JavaScript error on Pricings list
* FIXED: 'advert' class replaced with 'classified' on Advert details pages (to avoid AdBlockers)

= 1.0.9 - 2016-08-14 = 

* NEW: Customizable "Recents Ads" widget.
* FEATURE: Administrator can save Advert from wp-admin panel even if required fields are not filled (he will saw notification though).
* FEATURE: Featured image will always be displayed as first one in the gallery.
* FEATURE: Communication with WPAdverts updates server (for premium addons) will be handled via secure SSL connection only.
* FEATURE: JavaScript and CSS files are now versioned, so always newest version will be loaded.
* FIXED: Images in Gallery are resized to completely fit inside the gallery box (previously if image was vertical a part of it was not displayed).
* FIXED: Clicking on multiselect dropdown will hide options (if the options are currently displayed).

= 1.0.8 - 2016-07-04 =

* FEATURE: [adverts_list] 'display' param allows to display Ads in a list instead of grid
* FEATURE: [adverts_list] 'switch_views' param allow users to switch between list and grid views
* FEATURE: [adverts_add] custom display for "Listing Type" field, so users will know they are selecting payment type, not filling yet another field
* FIXED: Updated HTML for showing hidden items in [adverts_list]
* FIXED: Removed "Account" field from [adverts_manage] (it's not needed there).
* FIXED: Deleting incorrect media library items when deleting Pricings or Payments History
* FIXED: [adverts_manage] displays "Listing Type" field if post_status = pending.

= 1.0.7 - 2016-06-13 =

* API: adverts_tpl_single_top and adverts_tpl_single_bottom filters on Ad details pages (allow to replace "show contact information" and default gallery)
* FEATURE: Advanced Search button on [adverts_list] (will show when some hidden fields are added to search form, see http://wpadverts.com/documentation/custom-fields-search-form/)
* FEATURE: [adverts_list] has two new params redirect_to and show_results (see https://wpadverts.com/documentation/creating-ads-list-adverts_list/)
* FIXED: Allow to disable money filter for Price field
* FIXED: Allow to set custom empty text for each multiselect field.
* FIXED: "Sign In" redirects user back to [adverts_add] instead of wp-admin
* FIXED: Posts with status 'pending' no longer show on site.

= 1.0.6 - 2016-04-06 =

* FEATURE: CSS classes in form rows (each form row has class name adverts-field-name-{$field_name}).
* FEATURE: Show Temporary Ads in wp-admin / Classifieds panel (this is a list of posts abandoned by users).
* FIXED: Listing duration for free ads not applied properly.
* FIXED: Set default [adverts_list] page on WPAdverts activation.
* FIXED: Using proper ajax URL variable in [adverts_add] when editing an image.
* FIXED: File upload on Edge
* FIXED: File upload on mobile devices
* FIXED: Disallow user registration with email address already existing in wp_users table [adverts_add].
* FIXED: Riderct loop when Ad content is empty.

= 1.0.5 - 2016-01-21 =

* TRANSLATION: Russian (thanks to @Mick Levin)
* FEATURE: [adverts_list] search form API,
* FEATURE: search_bar param in [adverts_list] shortcode.
* FEATURE: adverts_tpl_single_posted_by filter on Ad details page.
* FEATURE: adverts_tpl_single_location on Ad details page.
* FEATURE: autocomplete field API
* FEATURE: in wp-admin when creating Ad required fields are not makred properly.
* FIXED: Multiselect field displayed in wrong place in HTML code.
* FIXED: adverts_template_load for single.php file.
* FIXED: pagination on category pages.
* FIXED: jQuery dependecies.

= 1.0.4 - 2015-12-23 =

* TRANSLATION: French (thanks to @Ceyar)
* FEATURE: 'adverts_list_query'
* FIXED: Some 'Featured Ads' module files not commited.
* FIXED: Default visibility not working in wp-admin

= 1.0.3 - 2015-12-22 =

* TRANSLATION: German Updated
* TRANSLATION: Slovenian (thanks to @gdolenc)
* FEATURE: Category Widget, 'show top categories only' option
* FEATURE: Featured Ads
* FEATURE: Overriding templates using 'adverts_template_load' filter
* FEATURE: String Length Validator
* FEATURE: 'adverts_new_user_notification' filter
* FIXED: [adverts_manage] incorrect edit link
* FIXED: Incorrect Expiration Date on ads list in wp-admin
* FIXED: Is_Integer validator accepts texts
* FIXED: Advert Price reset, when marking payment as complete
* FIXED: Removing not needed 'slashes' in user submitted data
* FIXED: Expiration Date not changing when switching Ad from 'Never Expires'

= 1.0.2 - 2015-09-26 =

* TRANSLATION: German (thanks to @Juliandaddy)
* FEATURE: 'adverts-option-depth-x' class in multiselect dropdowns
* FEATURE: Improved design for search bar in [adverts_list]
* FIXED: Categories display on Android and iPhone/iPad
* FIXED: Sending registration emails in WP 4.3.0 and newer
* FIXED: Saving Ads categories in [adverts_manage]
* FIXED: Loading Adverts_HTML class in Categories widget
* FIXED: Logout link in [adverts_add]
* FIXED: Not translated phrase

= 1.0.1 - 2015-08-25 =

* FEATURE: Improved UX in [adverts_manage]. When unregistered user tries to access this page he will see Login and Register links in addition to error message.
* FIXED: Removed the_editor_content filter.
* FIXED: Set default user role for registered user to Subscriber.
* FIXED: HTML updates for WP 4.3
* FIXED: Default listing type selection in [adverts_add]
* FIXED: In [adverts_add] correct post names are now generated instead of 'Adverts Auto Draft'
* FIXED: Improved Gallery upload/edit/delete security.
* FIXED: Delete link not working on some installations with mod_security enabled.

= 1.0 - 2015-08-11 =

* First Release *

== Screenshots ==

1. Ads list [adverts_list] displayed as a grid (you can select how many columns to display).
2. Ads list [adverts_list] displayed as a list.
3. Ad details page (compatible with all popular SEO plugins to boost your rankings).
4. Top Categories [adverts_categories show="top"] icons are configurable from wp-admin / Classifieds / Categories panel.
5. All Categories [adverts_categories].
6. Post an Ad Form [adverts_add] (allow anonymous and/or registered users to post ads).
7. Ads list in wp-admin panel.
8. Ad edit page in wp-admin panel.
9. Category edition with icon select.
10. Options, modules and premium extensions.
11. Payment history (if you are planning to charge users for posting Ads)
12. Payment details

== Upgrade Notice ==

= 1.0 - 2015-08-11 =

* Just try it, you will like it.
