<?php 

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Add custom styling to HEAD
- Add custom typograhpy to HEAD
- Add layout to body_class output
- Featured Slider Settings

-----------------------------------------------------------------------------------*/


add_action( 'woo_head','woo_custom_styling' );			// Add custom styling to HEAD
add_action( 'woo_head','woo_custom_typography' );			// Add custom typography to HEAD
add_filter( 'body_class','woo_layout_body_class' );		// Add layout to body_class output

/*-----------------------------------------------------------------------------------*/
/* Custom before and after post title hooks. */
/*-----------------------------------------------------------------------------------*/

function woo_post_title_before () { woo_do_atomic( 'woo_post_title_before' ); } // End woo_post_title_before()
function woo_post_title_after () { woo_do_atomic( 'woo_post_title_after' ); } // End woo_post_title_after()

/*-----------------------------------------------------------------------------------*/
/* Add Custom Styling to HEAD */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'woo_custom_styling')) {
	function woo_custom_styling() {
	
		global $woo_options;
		
		$output = '';
		// Get options
		$body_color = $woo_options[ 'woo_body_color' ];
		$body_img = $woo_options[ 'woo_body_img' ];
		$body_repeat = $woo_options[ 'woo_body_repeat' ];
		$body_position = $woo_options[ 'woo_body_pos' ];
		$link = $woo_options[ 'woo_link_color' ];
		$hover = $woo_options[ 'woo_link_hover_color' ];
		$button = $woo_options[ 'woo_button_color' ];
			
		// Add CSS to output
		if ($body_color)
			$output .= 'body {background:'.$body_color.'}' . "\n";
			
		if ($body_img)
			$output .= 'body {background-image:url( '.$body_img.')}' . "\n";

		if ($body_img && $body_repeat && $body_position)
			$output .= 'body {background-repeat:'.$body_repeat.'}' . "\n";

		if ($body_img && $body_position)
			$output .= 'body {background-position:'.$body_position.'}' . "\n";

		if ($link)
			$output .= 'a {color:'.$link.'}' . "\n";

		if ($hover)
			$output .= 'a:hover, .post-more a:hover, .post-meta a:hover, .post p.tags a:hover {color:'.$hover.'}' . "\n";

		if ($button) {
			$output .= 'a.button, a.comment-reply-link, #commentform #submit, #contact-page .submit {background:'.$button.';border-color:'.$button.'}' . "\n";
			$output .= 'a.button:hover, a.button.hover, a.button.active, a.comment-reply-link:hover, #commentform #submit:hover, #contact-page .submit:hover {background:'.$button.';opacity:0.9;}' . "\n";
		}
		
		// Output styles
		if (isset($output) && $output != '') {
			$output = strip_tags($output);
			$output = "<!-- Woo Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
			
	}
} 

/*-----------------------------------------------------------------------------------*/
/* Add custom typograhpy to HEAD */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'woo_custom_typography')) {
	function woo_custom_typography() {
	
		// Get options
		global $woo_options;
				
		// Reset	
		$output = '';
		
		// Add Text title and tagline if text title option is enabled
		if ( $woo_options[ 'woo_texttitle' ] == "true" ) {		
			
			if ( $woo_options[ 'woo_font_site_title' ] )
				$output .= '#logo .site-title a {'.woo_generate_font_css($woo_options[ 'woo_font_site_title' ]).'}' . "\n";	
			if ( $woo_options[ 'woo_tagline' ] == "true" AND $woo_options[ 'woo_font_tagline' ] ) 
				$output .= '#logo .site-description {'.woo_generate_font_css($woo_options[ 'woo_font_tagline' ]).'}' . "\n";	
		}

		if ( $woo_options[ 'woo_typography' ] == "true") {
			
			if ( $woo_options[ 'woo_font_body' ] )
				$output .= 'body { '.woo_generate_font_css($woo_options[ 'woo_font_body' ], '1.5').' }' . "\n";	

			if ( $woo_options[ 'woo_font_nav' ] )
				$output .= '#navigation, #navigation .nav a { '.woo_generate_font_css($woo_options[ 'woo_font_nav' ], '1.4').' }' . "\n";	

			if ( $woo_options[ 'woo_font_post_title' ] )
				$output .= '.post .title { '.woo_generate_font_css($woo_options[ 'woo_font_post_title' ]).' }' . "\n";	
		
			if ( $woo_options[ 'woo_font_post_meta' ] )
				$output .= '.post-meta { '.woo_generate_font_css($woo_options[ 'woo_font_post_meta' ]).' }' . "\n";	

			if ( $woo_options[ 'woo_font_post_entry' ] )
				$output .= '.entry, .entry p { '.woo_generate_font_css($woo_options[ 'woo_font_post_entry' ], '1.5').' } h1, h2, h3, h4, h5, h6 { font-family: '.stripslashes($woo_options[ 'woo_font_post_entry' ]['face']).', arial, sans-serif; }'  . "\n";	

			if ( $woo_options[ 'woo_font_widget_titles' ] )
				$output .= '.widget h3 { '.woo_generate_font_css($woo_options[ 'woo_font_widget_titles' ]).' }'  . "\n";	

		// Add default typography Google Font
		} else {
		
		} 
		
		// Output styles
		if (isset($output) && $output != '') {
		
			// Enable Google Fonts stylesheet in HEAD
			if (function_exists( 'woo_google_webfonts')) woo_google_webfonts();
			
			$output = "<!-- Woo Custom Typography -->\n<style type=\"text/css\">\n" . $output . "</style>\n\n";
			echo $output;
			
		}
			
	}
} 

// Returns proper font css output
if (!function_exists( 'woo_generate_font_css')) {
	function woo_generate_font_css($option, $em = '1') {

		// Test if font-face is a Google font
		global $google_fonts;
		foreach ( $google_fonts as $google_font ) {
					
			// Add single quotation marks to font name and default arial sans-serif ending
			if ( $option[ 'face' ] == $google_font[ 'name' ] )
				$option[ 'face' ] = "'" . $option[ 'face' ] . "', arial, sans-serif";		
		
		} // END foreach
		
		if ( !@$option["style"] && !@$option["size"] && !@$option["unit"] && !@$option["color"] )
			return 'font-family: '.stripslashes($option["face"]).';'; 
		else
			return 'font:'.$option["style"].' '.$option["size"].$option["unit"].'/'.$em.'em '.stripslashes($option["face"]).';color:'.$option["color"].';';
	}
}

// Output stylesheet and custom.css after custom styling
remove_action( 'wp_head', 'woothemes_wp_head' );
add_action( 'woo_head', 'woothemes_wp_head' );


/*-----------------------------------------------------------------------------------*/
/* Add layout to body_class output */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'woo_layout_body_class')) {
	function woo_layout_body_class($classes) {
		
		global $woo_options;
		$layout = $woo_options[ 'woo_site_layout' ];

		// Set main layout on post or page
		if ( is_singular() ) {
			global $post;
			$single = get_post_meta($post->ID, '_layout', true);
			if ( $single != "" AND $single != "layout-default" ) 
				$layout = $single;
		}
		
		// Add layout to $woo_options array for use in theme
		$woo_options[ 'woo_layout' ] = $layout;
		
		// Add classes to body_class() output 
		$classes[] = $layout;
		return $classes;						
					
	}
}

/*-----------------------------------------------------------------------------------*/
/* Featured Slider Settings */
/*-----------------------------------------------------------------------------------*/

add_filter( 'woo_head', 'woo_slider_options' );

function woo_slider_options() { 
	
	global $woo_options;
	
	if ( $woo_options['woo_slider'] == 'true' && is_home() && ! is_paged() ) {

	if ( $woo_options['woo_slider_auto'] == 'false' ) {
		$timeout = 0;
	} else {
		$timeout = $woo_options['woo_slider_interval'];
	}
	
	$speed = $woo_options['woo_slider_speed'];
	
	$slider_autoheight = 'false';
	
	$slider_height = $woo_options['woo_slider_height'];
	if ( isset( $woo_options['woo_slider_autoheight'] ) ) { $slider_autoheight = $woo_options['woo_slider_autoheight']; }
	
	$slider_heightsetting = '"auto"';
	
	if ( isset( $woo_options['woo_slider_autoheight'] ) && $slider_autoheight == 'false' && $slider_height > 0 ) {
		$slider_heightsetting = $slider_height;
	}
?>
	
		<script type="text/javascript">
			jQuery(document).ready(function(){
			
				var useAutoHeight = 'true';
				
				if ( "<?php echo $slider_autoheight; ?>" != 'true' ) {
					useAutoHeight = <?php echo $slider_autoheight; ?>;
				}
			
				if ( useAutoHeight == false ) {
					jQuery( '#slides .slide' ).each( function () {
						jQuery( this ).css( 'width', '934' );
					});
				}
			
				var slideTransitions = '';
				
				jQuery( '#slides input[name="transition"]' ).each( function () {
					if ( slideTransitions == '' ) {} else {	slideTransitions += ', '; }
					slideTransitions += jQuery( this ).val();
					jQuery( this ).remove();
				});
				
				if ( slideTransitions == '' ) { slideTransitions = 'scrollHorz'; }
				
				var cycleArgs = {
					fx: slideTransitions,
					randomizeEffects: false,
					height: <?php echo $slider_heightsetting; ?>, 
					fit: true, 
					prev: '.prev',
					next: '.next', 
					activePagerClass: 'activeslide', 
					pause: true, 
					pager: '.pagination', 
					after: function( currSlideElement, nextSlideElement, options, forwardFlag ) {
					
						if ( useAutoHeight == 'true' ) {
					
							var correctHeight = jQuery( this ).height();
							
							if ( correctHeight == 0 ) {
								// Check for an embed, iframe or img.
								if ( jQuery( this ).find( 'embed' ).length ) {
									correctHeight = jQuery( this ).find( 'embed' ).height();
								}
								
								if ( jQuery( this ).find( 'iframe' ).length ) {
									correctHeight = jQuery( this ).find( 'iframe' ).height();
								}
								
								if ( jQuery( this ).find( 'img' ).length ) {
									correctHeight = jQuery( this ).find( 'img' ).height();
								}
							}
						
							if ( correctHeight > 0 ) {
								jQuery( this ).parent( '.slides_container' ).animate({ height : correctHeight });
							}
						
						} // End useAutoHeight IF Statement
						
						currSlideNumber = jQuery( this ).attr( 'id' );
						currSlideNumber = parseInt( currSlideNumber.replace( 'slide-', '' ) );
						
						// Get the next/prev slide titles.
						getSlideTitle( currSlideNumber );
					}
				};
				
				cycleArgs.timeout = <?php echo $timeout; ?>;
				cycleArgs.speed = <?php echo $speed; ?>;
				
				var firstSlide = jQuery( '#slides .slides_container .slide:first' );
				var firstSlideContent = '';
				var firstSlideElementTag = '';
				
				if ( firstSlide.find( 'embed' ).length ) {
					firstSlideContent = firstSlide.find( 'embed' );
					firstSlideElementTag = 'embed';
				}
				
				if ( firstSlide.find( 'iframe' ).length ) {
					firstSlideContent = firstSlide.find( 'iframe' );
					firstSlideElementTag = 'iframe';
				}
				
				if ( firstSlide.find( 'img' ).length ) {
					firstSlideContent = firstSlide.find( 'img' );
					firstSlideElementTag = 'img';
				}
				
				if ( firstSlideContent != '' ) {
				
					jQuery( '#slides' ).before( '<div class="temp" style="display: none;"></div>' ); // We'll remove this when we're done.
					jQuery( '#slides .pagination, #slides .prev, #slides .next, #slides .prev-text, #slides .next-text' ).hide();
					jQuery( '#slides .slides_container' ).css( 'visibility', 'hidden' );
					
					jQuery( '.temp' ).load( '<?php echo home_url( '/' ); ?> ' + firstSlideElementTag + ':first', function () {
						
						jQuery( '#slides .slides_container' ).cycle( cycleArgs );
						
						jQuery( '#slides .slides_container' ).fadeOut( 'fast', function () {
							jQuery( '#slides .slides_container' ).css( 'visibility', 'visible' );
							jQuery( '#slides .slides_container' ).fadeIn( 'slow' );
							
							var correctHeight = jQuery( '#slides .slides_container .slide:first' ).height();
							
							jQuery( '#slides .pagination, #slides .prev, #slides .next, #slides .prev-text, #slides .next-text' ).fadeIn( 'slow', function () {
								jQuery( '.slides_container' ).animate({ height : correctHeight });
							});
							
						});
						
						// Remove the temporary DIV tag.
						jQuery( '.temp' ).remove();
						
					});
				
				} else {
				
					// No need to pre-load. Business as usual.
					jQuery( '#slides .slides_container' ).cycle( cycleArgs );
				}
				
				// Get the next/prev slide titles.
				getSlideTitle( 1 );
								
			});
		</script>
				
	<?php } // End IF Statement

}

/*-----------------------------------------------------------------------------------*/
/* END */
/*-----------------------------------------------------------------------------------*/
?>