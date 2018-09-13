<!-- wp-content/plugins/user-emails/email_welcome.php -->
 
<img src="<?php echo $logoUrl; ?>" alt="MySite"/>
 
<?php if ( $user->first_name != '' ) : ?>
    <h1><?php echo $user->first_name; ?>, Welcome to MySite</h1>
<?php else : ?>
    <h1>Welcome to MySite</h1>
<?php endif; ?>
 
<p>
    We're glad you're here. It's nice to have friends.
</p>
 
<p>
    <a href="<?php echo $siteUrl; ?>">MySite</a>
</p>
 
<p>
    Thank you,<br>
    MySite
</p>