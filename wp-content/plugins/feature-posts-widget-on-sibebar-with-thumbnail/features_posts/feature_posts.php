<?php
	/**
	Plugin Name: Feature Posts Widget
	Plugin URI: http://jameslao.com/2009/12/30/category-posts-widget-3-0/
	Description: Adds a widget that can display posts from features category.
	Author: Chinmoy Paul
	Version: 3.0
	Author URI: http://chinmoy29.wordpress.com/
	
	This software comes without any warranty, express or otherwise, and if it
	breaks your blog or results in your cat being shaved, it's not my fault.
	**/
	
	function widget_Fwidget_init(){
		if ( !function_exists('register_sidebar_widget') )
			return;
		function widget_Fwidget($args){
			global $wp_query;
			$wp_query_old = $wp_query; // Save the post object.
			$wp_query = null;
			
			extract ($args);
			
			// These are our own options
			$options = get_option('widget_FPwidget');
			// If not title, use the name of the category.
			if( !$options['Feature-title'] ) {
				$category_info = get_category($options['fcat']);
				$options['Feature-title'] = $category_info->name;
			}
			
			echo $before_widget;
	
			// Widget title
			echo $before_title;
			if( $options['Feature-title'] )
				echo '<a href="' . get_category_link($options['fcat']) . '">' . $options['Feature-title'] . '</a>';
			else
				echo $options['Feature-title'];
			echo $after_title;
			
			// Get array of post info.
			$wp_query = new WP_Query("showposts=" . $options['fpost_num'] . "&cat=" . $options['fcat']);
			// Post list
			echo "<div id='featured'>\n";
			echo "<ul id='mycarousel' class='jcarousel-skin-arthemia'>\n";
			
			while ( have_posts() )
			{
				the_post();
	?>
		<li class="fcat-post-item">
  		<div class="clearfloat">
  			<?php
  				if (
  					function_exists('the_post_thumbnail') &&
  					current_theme_supports("post-thumbnails") &&
  					$options["fthumb"] &&
  					has_post_thumbnail()
  				) :
  			?>
  				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
  				<?php the_post_thumbnail( array($options["fthumb_w"], $options["fthumb_h"]) ); ?>
  				</a>
  			
  			<?php endif; ?>
  			
  			<div class="info">
  			  <a class="post-title" href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
  			</div>
    			<?php //if ( $instance['excerpt'] ) : ?>
    			<?php //the_excerpt(); ?> 
    			<?php //endif; ?>
    			<?php if ( $options['fpost_date'] ) : ?>
    			<div class="post-date"><?php the_time("j M Y"); ?></div>
    			<?php endif; ?>
    				
    			<?php if ( $options['fcomment_num'] ) : ?>
    			<div class="fcomment-num"><?php comments_popup_link('0','1','%'); ?></div>
    			<?php endif; ?>
  			
  		</div>
		</li>
	<?php
			}
			
			echo "</ul>\n";
			echo "</div>\n";
			
			echo $after_widget;

			remove_filter('excerpt_length', $new_excerpt_length);
			
			wp_reset_query();
			
			$wp_query = $wp_query_old; // Restore the post object.
		}
		
		function widget_Fwidget_control(){
			// Get options
			$options = get_option('widget_FPwidget');
			
			// form posted?
			if($_POST['Fpost-submit']){
				$options['Feature-title'] = strip_tags(stripslashes($_POST['Feature-title']));
				$options['fcat'] = strip_tags(stripslashes($_POST['fcat']));
				$options['fpost_num'] = strip_tags(stripslashes($_POST['fpost_num']));
				$options['fcomment_num'] = strip_tags(stripslashes($_POST['fcomment_num']));
				$options['fpost_date'] = strip_tags(stripslashes($_POST['fpost_date']));
				$options['fpost_num'] = strip_tags(stripslashes($_POST['fpost_num']));
				$options['fcomment_num'] = strip_tags(stripslashes($_POST['fcomment_num']));
				$options['fthumb'] = strip_tags(stripslashes($_POST['fthumb']));
				$options['fthumb_w'] = strip_tags(stripslashes($_POST['fthumb_w']));
				$options['fthumb_h'] = strip_tags(stripslashes($_POST['fthumb_h']));
				update_option('widget_FPwidget', $options);
			}
			// Get options for form fields to show
			$Feature_title = htmlspecialchars($options['Feature-title'], ENT_QUOTES);
			$fcat = htmlspecialchars($options['fcat'], ENT_QUOTES);
			$fpost_num = htmlspecialchars($options['fpost_num'], ENT_QUOTES);
			$fcomment_num = htmlspecialchars($options['fcomment_num'], ENT_QUOTES);
			$fpost_date = htmlspecialchars($options['fpost_date'], ENT_QUOTES);
			$fthumb = htmlspecialchars($options['fthumb'], ENT_QUOTES);
			$fthumb_w = htmlspecialchars($options['fthumb_w'], ENT_QUOTES);
			$fthumb_h = htmlspecialchars($options['fthumb_h'], ENT_QUOTES);
?>
			<p>
				<label for="title">
					<?php _e( 'Title' ); ?>:
					<input class="widefat" id="Feature-title" name="Feature-title" type="text" value="<?php echo $Feature_title; ?>" />
				</label>
			</p>
			<p>
				<label>
					<?php _e( 'Category' ); ?>:
					<?php wp_dropdown_categories( array( 'name' => "fcat", 'selected' => $fcat ) ); ?>
				</label>
			</p>
			<p>
  			<label for="fpost_num">
  				<?php _e('Number of posts to show'); ?>:
  				<input style="text-align: center;" id="fpost_num" name="fpost_num" type="text" value="<?php echo absint($fpost_num); ?>" size='3' />
  			</label>
  		</p>
		
		<p>
			<label for="fcomment_num">
				<input type="checkbox" class="checkbox" id="fcomment_num" name="fcomment_num"<?php checked( (bool) $fcomment_num, true ); ?> />
				<?php _e( 'Show number of comments' ); ?>
			</label>
		</p>
		
		<p>
			<label for="fpost_date">
				<input type="checkbox" class="checkbox" id="fpost_date" name="fpost_date"<?php checked( (bool) $fpost_date, true ); ?> />
				<?php _e( 'Show post date' ); ?>
			</label>
		</p>
		
		<?php if ( function_exists('the_post_thumbnail') && current_theme_supports("post-thumbnails") ) : ?>
		<p>
			<label for="fthumb">
				<input type="checkbox" class="checkbox" id="fthumb" name="fthumb"<?php checked( (bool) $fthumb, true ); ?> />
				<?php _e( 'Show post thumbnail' ); ?>
			</label>
		</p>
		<p>
			<label>
				<?php _e('Thumbnail dimensions'); ?>:<br />
				<label for="fthumb_w">
					W: <input class="widefat" style="width:40%;" type="text" id="fthumb_w" name="fthumb_w" value="<?php echo $fthumb_w; ?>" />
				</label>
				
				<label for="fthumb_h">
					H: <input class="widefat" style="width:40%;" type="text" id="fthumb_h" name="fthumb_h" value="<?php echo $fthumb_h; ?>" />
				</label>
			</label>
		</p>
<?php
			endif;
			echo '<input type="hidden" id="Fpost-submit" name="Fpost-submit" value="1" />';
		}
		
		add_action( 'wp_head', 'load_fcss' );
		function load_fcss(){		  
			echo '<link rel="stylesheet" href="'.home_url().'/wp-content/plugins/features_posts/features.css" type="text/css" media="screen" />' . "\n";
			echo '<script src="'.home_url().'/wp-content/plugins/features_posts/js/jquery-1.2.6-packed.js" type="text/javascript"> </script>' ."\n";
			echo '<script src="'.home_url().'/wp-content/plugins/features_posts/js/jcarousel.js" type="text/javascript"> </script>' ."\n";
			echo '<script src="'.home_url().'/wp-content/plugins/features_posts/js/feature.js" type="text/javascript"> </script>' ."\n";
		}
		// Register widget for use
		register_sidebar_widget(array('Featured Posts', 'widgets'), 'widget_Fwidget');

		// Register settings for use, 300x200 pixel form
		register_widget_control(array('Featured Posts', 'widgets'), 'widget_Fwidget_control', 280, 200);
	}
	add_action("widgets_init", "widget_Fwidget_init");
?>
