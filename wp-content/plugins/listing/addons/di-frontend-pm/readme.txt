=== DesignInvento Messaging System ===
Contributors: shamim51
Tags: DesignInvento Messaging System,ALSP,pm,private message,personal message,front end,frontend pm,frontend,message,widget,plugin,sidebar,shortcode,page,email,mail,contact form, secure contact form, simple contact form
Donate link: https://www.paypal.me/hasanshamim
Requires at least: 4.4
Tested up to: 4.8.2
Requires PHP: 5.3
Stable tag: 5.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

DesignInvento Messaging System is a Private Messaging system and a secure contact form to your WordPress site.This is full functioning messaging system from front end.

== Description ==
DesignInvento Messaging System is a Private Messaging system to your WordPress site.This is full functioning messaging system from front end. The messaging is done entirely through the front-end of your site rather than the Dashboard. This is very helpful if you want to keep your users out of the Dashboard area.

> Some **DesignInvento Messaging System PRO** Features
>
> * Multiple Recipients
> * Only admin
> * Email Piping
> * Read Receipt
> * Email template
> * Announcement Email queue
> * Role to Role Block
>
> [View Details](https://www.shamimsplugins.com/products/ALSP-pro/?utm_campaign=wordpress&utm_source=readme_pro&utm_medium=description)

**Some Useful Link**

* [Basic Admin Settings](https://www.shamimsplugins.com/docs/ALSP/getting-started/basic-admin-settings/?utm_campaign=wordpress&utm_source=readme&utm_medium=description)
* [Basic Walkthrough](https://www.shamimsplugins.com/docs/ALSP/getting-started/basic-front-end-walkthrough/?utm_campaign=wordpress&utm_source=readme&utm_medium=description)
* [Remove minlength](https://www.shamimsplugins.com/docs/ALSP/customization/remove-minlength-message-title/?utm_campaign=wordpress&utm_source=readme&utm_medium=description)
* [Remove menu button](https://www.shamimsplugins.com/docs/ALSP/customization/remove-settings-menu-button/?utm_campaign=wordpress&utm_source=readme&utm_medium=description)

* If you want paid support you can contact with me through [DesignInvento Messaging System paid support](https://www.shamimsplugins.com/contact-us/?utm_campaign=wordpress&utm_source=readme&utm_medium=description)

[youtube http://www.youtube.com/watch?v=SHKHTIlzr3w]

**Features**

* Works through a Page rather than the dashboard. This is very helpful if you want to keep your users out of the Dashboard area!
* Users can privately message one another
* Threaded messages/Individual message
* Ability to embed things into messages like YouTube, Photobucket, Flickr, Wordpress TV, more.
* Admins can send a public announcement for all users to see or to perticular role(s).
* Admins can set the max amount of messages a user can keep in his/her box per role basis. This is helpful for keeping Database sizes down.
* Admins can set how many messages to show per page in the message box.
* Admins can set how many user to show per page in front end directory.
* Admins can set will email be sent to all users when a new announcement is published or not.
* Admins can set "to" field of announcement email.
* Admins can set Directory will be shown to all or not.
* Admins can block any user to send private message.
* Admins can set time delay between two messages send by a user.
* Admins can see all other's private message.
* Admins can block all users to send new message but they can send reply of their messages.
* Admins can hide autosuggestion for users.
* There are three types of sidebar widget.
* Users can select whether or not they want to receive messages
* Users can select whether or not they want to be notified by email when they receive a new message.
* Users can select whether or not they want to be notified by email when a new announcement is published.

**Translation**

* please use [wordpress translation](https://translate.wordpress.org/projects/wp-plugins/ALSP).

**Github**

[https://github.com/shamim2883/ALSP/](https://github.com/shamim2883/ALSP/)

== Installation ==
1. Upload "ALSP" to the "/wp-content/plugins/" directory.
1. Activate the plugin through the "Plugins" menu in WordPress.
1. Create a new page.
1. Paste code `[ALSP]` for DesignInvento Messaging System under the HTML tab of the page editor.
1. Publish the page add select this page as "DesignInvento Messaging System Page" in settings page of this plugin.

Need more instruction? you can visit [DesignInvento Messaging System](https://www.shamimsplugins.com/contact-us/?utm_campaign=wordpress&utm_source=readme&utm_medium=installation) and contact with me for paid support.

== Frequently Asked Questions ==
= How to update? =
DO NOT UPDATE IN PRODUCTION SITE BEFORE TEST IN STAGING SITE.
Please full backup first before update so that if anything goes wrong you can recover easily.

= Can i use this plugin to my language? =
Yes. this plugin is translate ready. But If your language is not available you can make one. If you want to help us to translate this plugin to your language you are welcome. please use [wordpress translation](https://translate.wordpress.org/projects/wp-plugins/ALSP).

= Where is "DIFP Contact Form" which was added from version 2.0? =
"DIFP Contact Form" is now a separate plugin from version 3.1, so that you can use that plugin with "DesignInvento Messaging System" or without. 

= Why code comments is less? =
I am very busy with my job. In my leisure i code for plugins. If you want to help to add comments to the code or indentation you are welcome. [https://github.com/shamim2883/ALSP/](https://github.com/shamim2883/ALSP/).

= Where to contact for paid support? =
You can visit [DesignInvento Messaging System](https://www.shamimsplugins.com/contact-us/?utm_campaign=wordpress&utm_source=readme&utm_medium=faq) and contact with me for paid support.

== Screenshots ==

1. Responsive
2. Messagebox.
3. Front End Directory.
4. Admin settings page.
5. Messagebox settings.
6. Security settings.

== Changelog ==

= 5.3 =

* Security update for all previous versions

= 5.2 =

* New feature: search messages in Message Box
* new filter hook difp_filter_hide_message_initially_if_read added.
* new filter hook difp_eb_announcement_email_return_check_bypass added.
* Fix: announcement count wrong when user role changed.
* Fix: One character cut from From Email Name
* New feature: Role to Role Block (PRO)

= 5.1 =

**If YOU HAVE CUSTOM CODE FOR THIS PLUGIN MAKE SURE THEY ARE UP TO DATE BEFORE UPDATE THIS PLUGIN.**

* id -> difp_id, to -> difp_to, search -> difp_search, _participants -> _difp_participants, _message_key -> _difp_message_key, _participant_roles -> _difp_participant_roles changes due to compitablity
* difp_no_role_access filter to grand access to message system for users who do not have any role for the site.
* Message box thread now show last message of the thread instead of first message
* Inbox/ Sent box now determine by last message of the thread instead of first message
* Show reply form after sent reply message.
* New shortcodes - difp_shortcode_new_message_count, difp_shortcode_message_to, difp_shortcode_new_message_form
* ALSP shortcode now support difpaction and difp-filter args
* Pre-populate "To" and "Subject" now by shortcode.
* Show link to send message to author by shortcode
* Ability to send message directly to post author from post page ( Ajax/ non-Ajax )
* Email From and From Email now pass through headers so that other can easily change that easily.
* New classes - Difp_Ajax, Difp_Shortcodes
* New functions - difp_update_option, difp_form_posted, difp_get_participants, difp_get_participant_roles, difp_get_message_view
* New action hooks - difp_action_before_announcement_email_send
* New filter hooks - difp_template_locations, difp_get_message_view, difp_autosuggestion_user_name, difp_no_role_access
* New template - shortcode_newmessage_form.php,
* Plugin update process improved.
* Minor performance improved.

= 4.8 =

* New feature, search users in directory
* New feature, toggle all messages when view message
* new filter hook difp_filter_display_participants added.
* new filter hook difp_query_url_filter added.

= 4.7 =

* Security update
* new action hook difp_get_announcement_column_content_{$column} added.
* new action hook difp_message_table_column_content_{$column} added.
* new filter hook difp_get_option added.
* new filter hook difp_get_user_option added.

= 4.6 =

* Introduce template system
* Better error handler
* More developer friendly
* Performance improved

= 4.5 =

* Full WP Editor support
* Allow attachment by default checked
* Translation issue fix.
* new action hook difp_action_after_add_email_filters added.
* new action hook difp_action_after_remove_email_filters added.
* Email piping (PRO)
* Read receipt (PRO)

= 4.4 =

* Announcement count fix
* Announcement filter fix
* Magic quote fix.
* new class Di_Frontend_Pm added.
* Add difp_filter_ajax_notification_interval.
* new tab added in admin settings.
* javascript error fix.
* Better plugin uninstal handle.
* PRO version release.

= 4.3 =

* Inbox Outbox message count fix
* Inbox Outbox message alternate output fix
* Message delete bug fix.
* Show participants in message.
* new function difp_is_user_admin added.
* remove unnecessary function call.
* Show login link instead of redirect user to login page.
* uninstall.php added.
* Extensions page added. Now available extensions can be seen from dashboard extensions page of this plugin.

= 4.2 =

* If you are updating from version 3.3 or less please read also changelog for 4.1
* Use custom capability for messages and announcements.
* Better control of messages and announcements.
* Minor bug fixed.
* POT file updated.

= 4.1 =

* This is almost a new plugin. If you are updating from any previous version please See screenshots and others changes first.
* It is highly recommended to update any staging site first.
* If you have any customized code (or plugin ) for this plugin make sure they are updated first to work with this new version.
* Use custom post type rather than custom database table for both message and announcement.
* Use settings API for back-end settings page of this plugin.
* UI changed.
* Better hook.
* Better options for admin.
* Now you can switch between thereded message view or individual message view.
* textdomain changed to use wordpress online translation.
* Now announcement can be published per role basis.
* Better controling who can send message or reply or use any other options.
* Embed issue fixed.

= 3.3 =

* Critical Security update. Found cross-site scripting (XSS) vulnerability and fixed.
* Please update as soon as possible.

= 3.2 =

* Security update. Admin could accidently delete all messages from database. fixed.
* Now header notification is in real time by ajax.
* DIFP Contact Form link added.
* Translation issues fixed.
* Admin page changed.
* Some CSS and JS bug fixes.
* Other some minor bug fixes.
* POT file updated.

= 3.1 =

* Many useful hooks are added. so anyone can change almost anything of this plugin without changing any core code of this plugin.
* Message and announcement editor now support Wp Editor.
* Now code can be posted between backticks.
* Multiple attachment in same message.
* Now you can add multiple attachment in announcement also.
* Attachment size, amount configurable.
* Now show any new message or new announcement notification in header (configurable).
* Announcement now reset after seen. User can also delete announcement from their announcement box (only for him/her).
* Now admin can see how many users seen that announcement.
* Use of transient increases so less db query.
* Now Widgets can be used multiple times.You can cofigure widgets now. You can also use hooks.
* Now use wordpress ajax for autosuggestion when typing recipent name.
* Custom CSS support. admin can add CSS from backend to add or override this plugins CSS.
* Now script and plugin files added only when needed.
* You can also add or remove any file of this plugin using hook.
* Messages between two users can be seen.
* New options are added in admin settings.
* Some CSS and JS bug fixes.
* Other some minor bug fixes.
* POT file updated.

= 2.2 =

* New option to send attachment in both pm and contact form.
* Attachment in stored in ALSP folder inside upload folder and contact form attachment is stored inside ALSP/contact-form folder.
* Message count in header bug fixes.
* Security bug fixes where non-admin user could see all messages.

= 2.1 =

* IP blacklist now support range and wildcard.
* Email address blacklist,whitelist.
* Time delay for logged out visitors also.
* Double name when auto suggestion off fixes.
* Department name bug fixes.
* Other some small bug fixes.

= 2.0 =

* Added a secure contact form.
* Manual check of contact message.
* AKISMET check of contact message.
* Can configure CAPTCHA for contact message form.
* Separate settings page for contact message.
* Can select department and to whom message will be send for that department.
* Can set separate time delay to send message of a user via contact message.
* Reply directly to Email address from front end.
* Send Email to any email addresss from front end.
* Use wordpress nonce instead of cookie.
* All forms nonce check before process.
* Added capability check to use messaging.
* Capability and nonce check before any action.
* Security Update.
* Some css fix.
* POT file updated.

= 1.3 =

* Parent ID and time check server side.
* Escape properly before input into database.
* Some css fix.
* Email template change.
* Recommended to update because some core functions have been changed and from this version (1.3) those functions will be used.

= 1.2 =

* Using display name instead of user_login to send message (partially).
* Send email to all users when a new announcement is published (there are options to control).
* Now admins can set time delay between two messages send by a user.
* Bug fixes in bbcode and code in content when send message.
* Security fixes in autosuggestion.
* New options are added in admin settings.
* No more sending email to sender.
* Javascript fixes.

= 1.1 =

* Initial release.

== Upgrade Notice ==

= 5.3 =

* Security update for all previous versions

= 5.2 =

* New feature: search messages in Message Box
* new filter hook difp_filter_hide_message_initially_if_read added.
* new filter hook difp_eb_announcement_email_return_check_bypass added.
* Fix: announcement count wrong when user role changed.
* Fix: One character cut from From Email Name
* New feature: Role to Role Block (PRO)

= 5.1 =

**If YOU HAVE CUSTOM CODE FOR THIS PLUGIN MAKE SURE THEY ARE UP TO DATE BEFORE UPDATE THIS PLUGIN.**

* id -> difp_id, to -> difp_to, search -> difp_search, _participants -> _difp_participants, _message_key -> _difp_message_key, _participant_roles -> _difp_participant_roles changes due to compitablity
* difp_no_role_access filter to grand access to message system for users who do not have any role for the site.
* Message box thread now show last message of the thread instead of first message
* Inbox/ Sent box now determine by last message of the thread instead of first message
* Show reply form after sent reply message.
* New shortcodes - difp_shortcode_new_message_count, difp_shortcode_message_to, difp_shortcode_new_message_form
* ALSP shortcode now support difpaction and difp-filter args
* Pre-populate "To" and "Subject" now by shortcode.
* Show link to send message to author by shortcode
* Ability to send message directly to post author from post page ( Ajax/ non-Ajax )
* Email From and From Email now pass through headers so that other can easily change that easily.
* New classes - Difp_Ajax, Difp_Shortcodes
* New functions - difp_update_option, difp_form_posted, difp_get_participants, difp_get_participant_roles, difp_get_message_view
* New action hooks - difp_action_before_announcement_email_send
* New filter hooks - difp_template_locations, difp_get_message_view, difp_autosuggestion_user_name, difp_no_role_access
* New template - shortcode_newmessage_form.php,
* Plugin update process improved.
* Minor performance improved.

= 4.8 =

* New feature, search users in directory
* New feature, toggle all messages when view message
* new filter hook difp_filter_display_participants added.
* new filter hook difp_query_url_filter added.

= 4.7 =

* Security update
* new action hook difp_get_announcement_column_content_{$column} added.
* new action hook difp_message_table_column_content_{$column} added.
* new filter hook difp_get_option added.
* new filter hook difp_get_user_option added.

= 4.6 =

* Introduce template system
* Better error handler
* More developer friendly
* Performance improved

= 4.5 =

* Full WP Editor support
* Allow attachment by default checked
* Translation issue fix.
* new action hook difp_action_after_add_email_filters added.
* new action hook difp_action_after_remove_email_filters added.
* Email piping (PRO)
* Read receipt (PRO)

= 4.4 =

* Announcement count fix
* Announcement filter fix
* Magic quote fix.
* new class Di_Frontend_Pm added.
* Add difp_filter_ajax_notification_interval.
* new tab added in admin settings.
* javascript error fix.
* Better plugin uninstal handle.
* PRO version release.

= 4.3 =

* Inbox Outbox message count fix
* Inbox Outbox message alternate output fix
* Message delete bug fix.
* Show participants in message.
* new function difp_is_user_admin added.
* remove unnecessary function call.
* Show login link instead of redirect user to login page.
* uninstall.php added.
* Extensions page added. Now available extensions can be seen from dashboard extensions page of this plugin.

= 4.2 =

* If you are updating from version 3.3 or less please read also changelog for 4.1
* Use custom capability for messages and announcements.
* Better control of messages and announcements.
* Minor bug fixed.
* POT file updated.

= 4.1 =

* This is almost a new plugin. If you are updating from any previous version please See screenshots and others changes first.
* It is highly recommended to update any staging site first.
* If you have any customized code (or plugin ) for this plugin make sure they are updated first to work with this new version.
* Use custom post type rather than custom database table for both message and announcement.
* Use settings API for back-end settings page of this plugin.
* UI changed.
* Better hook.
* Better options for admin.
* Now you can switch between thereded message view or individual message view.
* textdomain changed to use wordpress online translation.
* Now announcement can be published per role basis.
* Better controling who can send message or reply or use any other options.
* Embed issue fixed.

= 3.3 =

* Critical Security update. Found cross-site scripting (XSS) vulnerability and fixed.
* Please update as soon as possible.

= 3.2 =

* Security update. Admin could accidently delete all messages from database. fixed.
* Now header notification is in real time by ajax.
* DIFP Contact Form link added.
* Translation issues fixed.
* Admin page changed.
* Some CSS and JS bug fixes.
* Other some minor bug fixes.
* POT file updated.

= 3.1 =

* Many useful hooks are added. so anyone can change almost anything of this plugin without changing any core code of this plugin.
* Message and announcement editor now support Wp Editor.
* Now code can be posted between backticks.
* Multiple attachment in same message.
* Now you can add multiple attachment in announcement also.
* Attachment size, amount configurable.
* Now show any new message or new announcement notification in header (configurable).
* Announcement now reset after seen. User can also delete announcement from their announcement box (only for him/her).
* Now admin can see how many users seen that announcement.
* Use of transient increases so less db query.
* Now Widgets can be used multiple times.You can cofigure widgets now. You can also use hooks.
* Now use wordpress ajax for autosuggestion when typing recipent name.
* Custom CSS support. admin can add CSS from backend to add or override this plugins CSS.
* Now script and plugin files added only when needed.
* You can also add or remove any file of this plugin using hook.
* Messages between two users can be seen.
* New options are added in admin settings.
* Some CSS and JS bug fixes.
* Other some minor bug fixes.
* POT file updated.

= 2.2 =

* New option to send attachment in both pm and contact form.
* Attachment is stored in ALSP folder inside upload folder and contact form attachment is stored inside ALSP/contact-form folder.
* Message count in header bug fixes.
* Security bug fixes where non-admin user could see all messages.

= 2.1 =

* IP blacklist now support range and wildcard.
* Email address blacklist,whitelist.
* Time delay for logged out visitors also.
* Double name when auto suggestion off fixes.
* Department name bug fixes.
* Other some small bug fixes.

= 2.0 =

* Added a secure contact form.
* Manual check of contact message.
* AKISMET check of contact message.
* Can configure CAPTCHA for contact message form.
* Separate settings page for contact message.
* Can select department and to whom message will be send for that department.
* Can set separate time delay to send message of a user via contact message.
* Reply directly to Email address from front end.
* Send Email to any email addresss from front end.
* Use wordpress nonce instead of cookie.
* All forms nonce check before process.
* Added capability check to use messaging.
* Capability and nonce check before any action.
* Security Update.
* Some css fix.
* POT file updated.

= 1.3 =

* Parent ID and time check server side.
* Escape properly before input into database.
* Some css fix.
* Email template change.
* Recommended to update this plugin because some core functions (this plugin) have been changed and from this version (1.3) those functions will be used.

= 1.2 =

* Using display name instead of user_login to send message (partially).
* Send email to all users when a new announcement is published (there are options to control).
* Now admins can set time delay between two messages send by a user.
* Bug fixes in bbcode and code in content when send message.
* Security fixes in autosuggestion.
* New options are added in admin settings.
* No more sending email to sender.
* Javascript fixes.

= 1.1 =

* Initial release.
