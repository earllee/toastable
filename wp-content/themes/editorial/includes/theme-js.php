<?php
/*-----------------------------------------------------------------------------------*/
/* Theme Frontend JavaScript */
/*-----------------------------------------------------------------------------------*/

if ( ! is_admin() ) { add_action( 'wp_print_scripts', 'woothemes_add_javascript' ); }

if ( ! function_exists( 'woothemes_add_javascript' ) ) {
	function woothemes_add_javascript() { 
		wp_enqueue_script( 'superfish', get_template_directory_uri() . '/includes/js/superfish.js', array( 'jquery' ) );
		wp_enqueue_script( 'general', get_template_directory_uri() . '/includes/js/general.js', array( 'jquery' ), '1.0.0', true );
		if (( is_active_widget( false, false, 'woo_gallery' ) ) || ( is_single() ) ) { 
			wp_enqueue_script( 'loopedSlider', get_bloginfo('template_directory').'/includes/js/slides.min.jquery.js', array( 'jquery' ) );	
		}
		if ((get_option('woo_slider') == "true") && is_home()) {
			wp_enqueue_script( 'slides', get_template_directory_uri().'/includes/js/jquery.cycle.all.min.js', array( 'jquery' ) );
		}
	} // End woothemes_add_javascript()
}

/*-----------------------------------------------------------------------------------*/
/* Theme Admin JavaScript */
/*-----------------------------------------------------------------------------------*/

if ( is_admin() ) { add_action( 'admin_print_scripts', 'woothemes_add_admin_javascript' ); }
if ( is_admin() ) { add_action( 'admin_print_styles', 'woothemes_add_admin_css' ); }

if ( ! function_exists( 'woothemes_add_admin_javascript' ) ) {
	function woothemes_add_admin_javascript() {
		global $pagenow;
		
		if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) {
			wp_enqueue_script( 'woo-post-meta-options', get_template_directory_uri() . '/includes/js/theme-options.js', array( 'jquery', 'jquery-ui-tabs' ), '1.0.0' );
		}
		
		if ( $pagenow == 'admin.php' || get_query_var( 'page' ) == 'woothemes' ) {
			wp_enqueue_script( 'woo-theme-options-custom-toggle', get_template_directory_uri() . '/includes/js/theme-options-custom-toggle.js', array( 'jquery' ), '1.0.0' );
		}
		
	} // End woothemes_add_admin_javascript()
}

if ( ! function_exists( 'woothemes_add_admin_css' ) ) {
	function woothemes_add_admin_css() {
		wp_enqueue_style( 'woo-post-meta-options', get_template_directory_uri() . '/includes/css/meta-options.css' );
	} // End woothemes_add_admin_css()
}
?>