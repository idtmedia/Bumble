<aside id="pacz-sidebar" class="pacz-builtin ">
    <div class="sidebar-wrapper">
	    <?php
		if(is_home()){
			pacz_sidebar_generator( 'get_sidebar', 'blog');
		}elseif ( isset( $post ) ) {
			pacz_sidebar_generator( 'get_sidebar', $post->ID);

		}else {
			pacz_sidebar_generator( 'get_sidebar');
		}
		
		?>
    </div>
</aside>
