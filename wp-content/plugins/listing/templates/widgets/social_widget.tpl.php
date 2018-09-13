<?php echo $args['before_widget']; ?>
<?php if (!empty($title))
echo $args['before_title'] . $title . $args['after_title'];
?>
<div class="alsp-content alsp-widget alsp-social-widget">
	<ul class="alsp-social clearfix">
		<?php if ($instance['is_facebook']): ?>
		<li>
			<a target="_blank" href="<?php echo esc_url($instance['facebook']); ?>"><i class="pacz-icon-facebook"></i></a>
		</li>
		<?php endif; ?>

		<?php if ($instance['is_twitter']): ?>
		<li>
			<a target="_blank" href="<?php echo esc_url($instance['twitter']); ?>"><i class="pacz-icon-twitter"></i></a>
		</li>
		<?php endif; ?>
		
		<?php if ($instance['is_google']): ?>
		<li>
			<a target="_blank" href="<?php echo esc_url($instance['google']); ?>"><i class="pacz-icon-google-plus"></i></a>
		</li>
		<?php endif; ?>
		
		<?php if ($instance['is_linkedin']): ?>
		<li>
			<a target="_blank" href="<?php echo esc_url($instance['linkedin']); ?>"><i class="pacz-icon-linkedin"></i></a>
		</li>
		<?php endif; ?>
		
		<?php if ($instance['is_youtube']): ?>
		<li>
			<a target="_blank" href="<?php echo esc_url($instance['youtube']); ?>"><i class="pacz-icon-youtube"></i></a>
		</li>
		<?php endif; ?>
		
		<?php if ($instance['is_rss']): ?>
		<li>
			<a target="_blank" href="<?php echo esc_url($instance['rss']); ?>"><i class="pacz-icon-rss"></i></a>
		</li>
		<?php endif; ?>
	</ul>
</div>
<?php echo $args['after_widget']; ?>