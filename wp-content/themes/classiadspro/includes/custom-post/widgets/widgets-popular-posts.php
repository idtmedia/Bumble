<?php

/*
	Popular POSTS
*/

class Classiadspro_Widget_Popular_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array( "classname" => "widget_posts_lists", "description" => "Displays the Popular posts" );
		WP_Widget::__construct( "popular_posts", PACZ_THEME_SLUG . " - Popular Posts", $widget_ops );
		$this-> alt_option_name = "widget_popular_posts";
	}


	function widget( $args, $instance ) {
		$output = '';
		
		ob_start();
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		if ( !$posts_number = (int) $instance['posts_number'] )
			$posts_number = 10;
		else if ( $posts_number < 1 )
				$posts_number = 1;
			else if ( $posts_number > 15 )
					$posts_number = 15;

			$disable_time = $instance["disable_time"] ? "1" : "0";
			$disable_cats = $instance["disable_cats"] ? "1" : "0";
		



		$query = array( 'showposts' => $posts_number, 'nopaging' => 0, "orderby" => "comment_count", "order" => "DSC", 'post_status' => 'publish', 'ignore_sticky_posts' => 1 );
		if ( !empty( $instance["cats"] ) ) {
			$query["cat"] = implode( ",", $instance["cats"] );
		}

		$recent = new WP_Query( $query );

		if ( $recent-> have_posts() ) :
			
		$widget_id = $args['widget_id'];
			echo '<section id="'.$widget_id.'" class="widget widget_posts_lists">';

		if ( $title ) echo '<div class="widgettitle">'. $title .'</div>' ?>

        <ul>

		<?php

		while ( $recent-> have_posts() ) : $recent -> the_post();

		global $post;
		 $no_thumb_css = '';
		 ?>

        <li>
        <?php 
	    if ( has_post_thumbnail() ) :
	    ?>
        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" class="featured-image">
        <?php	$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );	
				$image_src = bfi_thumb( $image_src_array[ 0 ], array('width' => 90, 'height' => 80, 'crop'=>true));	
		 ?>
		
			<img width="90" height="90" src="<?php echo pacz_thumbnail_image_gen($image_src, 90, 80); ?>" alt="<?php the_title(); ?>" />
		 	 <div class="hover-overlay"></div>
		 	 <i class="hover-plus-icon-small pacz-theme-icon-plus"></i>
		</a>
		<?php else:
			$no_thumb_css = 'posts-no-thumb';
			endif;
		 ?>
        <div class="post-list-info <?php echo esc_attr($no_thumb_css); ?>">
       	<a href="<?php the_permalink(); ?>" class="post-list-title"><?php the_title(); ?></a>        	
        <div class="post-list-meta">
	       <?php if($disable_time == true) {  ?>
	       <data value="<?php the_date('M j, Y') ?>" itemprop="datePublished"><?php echo get_the_date(); ?></data>
	       <?php } 
	       if($disable_cats == true) { ?>
	       <div class="cats"><?php echo get_the_category_list( ', ' ); ?></div>
	       <?php } ?>
   	   </div>	
       </div>

       <div class="clearboth"></div>
       </li>
        
        <?php endwhile;  ?>

        </ul>
        <?php
		echo '</section>';
		wp_reset_postdata();


		endif;



	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance["title"] = strip_tags( $new_instance["title"] );
		$instance["posts_number"] = (int) $new_instance["posts_number"];
		$instance["disable_time"] = !empty( $new_instance["disable_time"] ) ? 1 : 0;
		$instance["disable_cats"] = !empty( $new_instance["disable_cats"] ) ? 1 : 0;
		$instance["cats"] = $new_instance["cats"];

		

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['Classiadspro_Widget_Popular_Posts'] ) )
			delete_option( 'Classiadspro_Widget_Popular_Posts' );

		return $instance;
	}



	




	function form( $instance ) {

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

		$disable_time = isset( $instance["disable_time"] ) ? (bool) $instance["disable_time"] : true;
		$disable_cats = isset( $instance["disable_cats"] ) ? (bool) $instance["disable_cats"] : true;
		$cats = isset( $instance['cats'] ) ? $instance['cats'] : array();

		if ( !isset( $instance['posts_number'] ) || !$posts_number = (int) $instance['posts_number'] )
			$posts_number = 3;


		$categories = get_categories( 'orderby=name&hide_empty=0' );


?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">Title:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'posts_number' )); ?>">Number of posts:</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'posts_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'posts_number' )); ?>" type="text" value="<?php echo esc_attr($posts_number); ?>" class="widefat" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'disable_time' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'disable_time' )); ?>"<?php checked( $disable_time ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id( 'disable_time' )); ?>">Show Date</label></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'disable_cats' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'disable_cats' )); ?>"<?php checked( $disable_cats ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id( 'disable_cats' )); ?>">Show Category</label></p>

	
			<label for="<?php echo esc_attr($this->get_field_id( 'cat' )); ?>">Which Categories to show?</label>
			<select style="height:15em" name="<?php echo esc_attr($this->get_field_name( 'cats' )); ?>[]" id="<?php echo esc_attr($this->get_field_id( 'cats' )); ?>" class="widefat" multiple="multiple">
				<?php foreach ( $categories as $category ):?>
				<option value="<?php echo esc_attr($category->term_id);?>"<?php echo in_array( $category->term_id, $cats )? ' selected="selected"':'';?>><?php echo esc_attr($category->name);?></option>
				<?php endforeach;?>
			</select>
		</p>
<?php


	}
}
