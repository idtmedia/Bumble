change log
= 1.3.3 =
* Done the bug fixings and plugin file update in 1.3.2 issue resolved

= 1.3.2 =
* force_ssl_login issue updated

= 1.3.1 =
* Done the bug fixings for the login redirect issue occuring for the google login.
* Updated the note section for twitter app creation for the "Callback locking" functionality.
* Done the bug fixings for declaration of OAuthException class if class already exist.

= 1.3.0 =
* Done the update of the Facebook SDK to latest.
* Done the bug fixings for the error appearing "force_ssl_login" deprecation.
* Updated the information about the creation of the facebook app for social login.
* Done the bug fixings for the issue appearing for the facebook login when "Strict mode for Redirect URIs" is enabled.
* Fixed the height and width of the popup window that is causing issue "Your popup is too small to display this page. Please enlarge it to proceed." for facebook login.
* Added the ajax verification of username so that page shouldn't reload for the username exist error message.

= 1.2.9 =
* Bug fixing for the disappear of the tab when opening the page by clicking from external link source.
* Done the modification of the callBackUrl function to work with custom login url.
* Fixed the issue appearing for the database insert error due to gender input field.
* Fixed the display of the error message when user deny the authorization of the app for login.

= 1.2.8 =
* Added italian language translation files.
* Made the texts translation ready for the text "Welcome" and "Logout" that appears when user logged in.
* Now the plugin can Fetch the VK user email address requesting permission.
* Fixed current page login redirect issue for VK.
* Added the check for the username and if username is empty user's email address will be used as username.
* Added an image size width & height option for the facebook profile image.
* Now a popup module will appear for the social login.
* Add Forget Password link for the social login with login form.
* Addition of the info for the Username creation note during registration.
* Added an option for the login redirect link for the social login shortcode.
* Fixed the issue appearing while the linkedIn APP not authorized for login using linkedin.
* Fixed the issues for making the plugin multisite compactible.
* Now the twitter user's email address can be fetched for new users.
* Fixed the google login issue when user don't have google+ account.

= 1.2.7 =
* Fixed the responsive issues for the registration page.
* Fixed the translation issues for the registration page.
* Fixed the login redirect issue for google account for current page.
* Removed the bio field from the facebook data fetch field as the bio field has been depriciated for the graph API version 2.8.

= 1.2.6 =
* Fixed the google login issues.
* Fixed the facebook login issues.
* Fixed the buddypress integration issue for the plugins backend save settings.

= 1.2.5 =
* Removal of mysql_real_escape_string as this function has been depriciated for PHP7 with sanitize_text_field fuction
