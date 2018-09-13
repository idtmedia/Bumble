<form class="pacz-searchform" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<input type="text" class="text-input" placeholder="<?php esc_html_e('Type your keyword', 'classiadspro'); ?>" value="<?php if(!empty($_GET['s'])) echo get_search_query(); ?>" name="s" id="s" />
	<i class="pacz-icon-search"><input value="" type="submit" class="search-button" type="submit" /></i>
</form> 