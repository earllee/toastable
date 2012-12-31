<?php

// You can find the different variables (ie. twitter username) in your Appearance tab (where your other thesis options are), under Edit Skin in the Wordpress Dashboard!

//
//  FUNCTIONS
//

	/* Global Functions */
	remove_action('thesis_hook_custom_template', 'thesis_custom_template_sample'); // Remove sample
	
	/* Header Functions */
	remove_action('thesis_hook_before_header', 'thesis_nav_menu'); // Remove top nav menu
	add_action('thesis_hook_after_title', 'thesis_nav_menu'); // Input menu under the header
	add_action('wp_head', 'base_css'); //Get base.css
	
	/* Main Functions */
	add_action('thesis_hook_after_header', 'tt_special_header'); // Input special header
	add_action('thesis_hook_multimedia_box', 'tt_multimediabox'); // Input custom box (twitter, rss, search) and sponsers (see below for customization)
	
	/* Post Functions */
	add_action('thesis_hook_before_headline', 'tt_comment_box'); // Remove default comments
	remove_action('thesis_hook_after_post', 'thesis_comments_link'); // Remove Thesis Comments
	add_action('thesis_hook_before_post_box', 'tt_open_post'); // Start our post (fixes indent / css)
	add_action('thesis_hook_after_post_box', 'tt_close_post'); // Close our post (fixes indent / css)
	
	/* Footer Functions */
	remove_action('thesis_hook_footer', 'thesis_attribution'); // Remove Thesis attribution
	add_action('thesis_hook_footer', 'tt_footer'); // Input custom footer
	
	/* ADMIN */
	add_action('admin_menu', 'thesis_custom_add_page'); // Moves the add page function in the WP dashboard admin menu via WP hook
	
// 
//  END OF FUNCTIONS
// 




// 
//  CUSTOM VARIABLES
// 

	// defaults
	if (get_option('tt_logo_opt')) {} else { add_option('tt_logo_opt', 'true'); }
	if (get_option('tt_header_opt')) {} else { add_option('tt_header_opt', 'true'); }
	if (get_option('tt_header_page_opt')) {} else { add_option('tt_header_page_opt', 'true'); }
	if (get_option('tt_header_title_opt')) {} else { add_option('tt_header_title_opt', 'Your Header Title'); }
	if (get_option('tt_header_para_opt')) {} else { add_option('tt_header_para_opt', 'Check out Wordpress Dashboard -> Appearance -> Edit Skin to edit this section! Note: Yes, you are able to have HTML tags in here.'); }
	if (get_option('tt_footer_opt')) {} else { add_option('tt_footer_opt', 'false'); }

	$tt_footer_removal = get_option('tt_footer_opt');
	$tt_use_logo = get_option('tt_logo_opt');
	$tt_use_header = get_option('tt_header_opt');
	$tt_use_header_on_every_page = get_option('tt_header_page_opt');
	$tt_special_header = get_option('tt_header_title_opt');
	$tt_special_paragraph = get_option('tt_header_para_opt');
	
	$tt_twitter_username = get_option('tt_twitter_name');
	
// 
//  END OF CUSTOM VARIABLES
// 

//
function thesis_custom_add_page() { // Adds our test page to Thesis menu
	add_submenu_page('thesis-options',__('Edit Skin', 'thesis'), __('Edit Skin', 'thesis'), 'edit_themes', 'tt_admin', 'tt_page_admin');
}

	function base_css() { ?>
    <link media="screen, projection" type="text/css" href="<?php echo SKINURL; ?>base.css" rel="stylesheet" /> 
    <?php }

require_once ('tt_admin.php');
require_once('tt_functions.php'); // load our custom functions
// 