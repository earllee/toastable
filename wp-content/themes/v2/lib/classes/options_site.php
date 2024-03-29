<?php
/**
 * class thesis_site_options (formerly called Options)
 *
 * This class consists of functions used to set and retrieve the different site options
 * available on the Thesis Theme. The WordPress API saves everything to your database,
 * but the rest of the magic occurs in functions native to this class. To set your
 * options, enter your WordPress dashboard and visit: Thesis -> Thesis Options
 * Or, if you prefer, you can visit /wp-admin/admin.php?page=thesis-options
 *
 * @package Thesis
 * @since 1.0
 */

class thesis_site_options {
	function default_options() {
		// Document head
		$this->head = array(
			'title' => array(
				'branded' => false,
				'separator' => false
			),
			'meta' => array(
				'robots' => array(
					'noindex' => array(
						'sub' => true,
						'category' => false,
						'tag' => true,
						'author' => true,
						'day' => true,
						'month' => true,
						'year' => true
					),
					'nofollow' => array(
						'sub' => false,
						'category' => false,
						'tag' => true,
						'author' => true,
						'day' => true,
						'month' => true,
						'year' => true
					),
					'noarchive' => array(
						'sub' => false,
						'category' => false,
						'tag' => false,
						'author' => false,
						'day' => false,
						'month' => false,
						'year' => false
					),
					'noodp' => true,
					'noydir' => true
				)
			),
			'links' => array(
				'canonical' => true
			),
			'feed' => array(
				'url' => false
			),
			'scripts' => false
		);

		$this->javascript = array(
			'scripts' => false
		);

		// Nav menu
		$this->nav = array(
			'type' => 'wp',
			'pages' => false,
			'categories' => false,
			'links' => false,
			'home' => array(
				'show' => true,
				'text' => false,
				'nofollow' => false
			),
			'feed' => array(
				'show' => true,
				'text' => false,
				'nofollow' => true
			)
		);

		$this->home = array(
			'head' => array(
				'title' => false,
				'meta' => array(
					'robots' => array(
						'noindex' => false,
						'nofollow' => false,
						'noarchive' => false
					),
					'description' => false,
					'keywords' => false
				)
			)
		);

		$this->publishing = array(
			'wlw' => true
		);

		$this->custom = array(
			'stylesheet' => true
		);

		// Save button text
		$this->save_button_text = false;

		// Thesis version
		$this->version = thesis_version();
	}

	function get_options() {
		$saved_options = maybe_unserialize(get_option('thesis_options'));

		if (!empty($saved_options) && is_object($saved_options)) {
			foreach ($saved_options as $option_name => $value)
				$this->$option_name = $value;
		}
	}

	function update_options() {
		// Document head
		$head = $_POST['head'];
		$this->head['title']['branded'] = (bool) $head['title']['branded'];
		$this->head['title']['separator'] = ($head['title']['separator']) ? urlencode(strip_tags(stripslashes($head['title']['separator']))) : false;
		$meta_types = array('noindex', 'nofollow', 'noarchive');
		$page_types = array('sub', 'category', 'tag', 'author', 'day', 'month', 'year');
		foreach ($meta_types as $meta_type) {
			foreach ($page_types as $page_type)
				$this->head['meta']['robots'][$meta_type][$page_type] = (bool) $head['meta']['robots'][$meta_type][$page_type];
		}
		$this->head['meta']['robots']['noodp'] = (bool) $head['meta']['robots']['noodp'];
		$this->head['meta']['robots']['noydir'] = (bool) $head['meta']['robots']['noydir'];
		$this->head['links']['canonical'] = (bool) $head['links']['canonical'];
		$this->head['feed']['url'] = ($head['feed']['url']) ? strip_tags(stripslashes($head['feed']['url'])) : false;
		$this->head['scripts'] = ($head['scripts']) ? $head['scripts'] : false;

		// JavaScript
		$javascript = $_POST['javascript'];
		$this->javascript['scripts'] = ($javascript['scripts']) ? $javascript['scripts'] : false;

		// Nav menu
		$nav = $_POST['nav'];
		$this->nav['type'] = ($nav['type']) ? $nav['type'] : 'wp';
		if ($this->nav['type'] == 'thesis') {
			if ($nav['pages']) {
				$this->nav['pages'] = $nav['pages'];
				foreach ($nav['pages'] as $id => $nav_page) {
					$this->nav['pages'][$id]['show'] = (bool) $nav_page['show'];
					$this->nav['pages'][$id]['text'] = ($nav_page['text'] != '') ? stripslashes($nav_page['text']) : false;
				}
			}
			$this->nav['style'] = (bool) $nav['style'];
			$this->nav['categories'] = ($nav['categories']) ? implode(',', $nav['categories']) : false;
			$this->nav['links'] = ($nav['links']) ? $nav['links'] : false;
			$this->nav['home']['show'] = (bool) $nav['home']['show'];
			$this->nav['home']['text'] = ($nav['home']['text']) ? stripslashes($nav['home']['text']) : false;
			$this->nav['home']['nofollow'] = (bool) $nav['home']['nofollow'];
			$this->nav['feed']['show'] = (bool) $nav['feed']['show'];
			$this->nav['feed']['text'] = ($nav['feed']['text']) ? stripslashes($nav['feed']['text']) : false;
			$this->nav['feed']['nofollow'] = (bool) $nav['feed']['nofollow'];
		}

		$home = $_POST['home'];
		$this->home['head']['title'] = ($home['head']['title']) ? urlencode(strip_tags(stripslashes($home['head']['title']))) : false;
		$this->home['head']['meta']['description'] = ($home['head']['meta']['description']) ? urlencode(strip_tags(stripslashes($home['head']['meta']['description']))) : false;
		$this->home['head']['meta']['keywords'] = ($home['head']['meta']['keywords']) ? urlencode(strip_tags(stripslashes($home['head']['meta']['keywords']))) : false;
		$this->home['head']['meta']['robots']['noindex'] = (bool) $home['head']['meta']['robots']['noindex']; 		
		$this->home['head']['meta']['robots']['nofollow'] = (bool) $home['head']['meta']['robots']['nofollow'];
		$this->home['head']['meta']['robots']['noarchive'] = (bool) $home['head']['meta']['robots']['noarchive'];

		// Publishing tools
		$publishing = $_POST['publishing'];
		$this->publishing['wlw'] = (bool) $publishing['wlw'];

		// Custom stylesheet
		$custom = $_POST['custom'];
		$this->custom['stylesheet'] = (bool) $custom['stylesheet'];

		// Misc. options
		$this->save_button_text = ($_POST['save_button_text']) ? strip_tags(stripslashes($_POST['save_button_text'])) : false;
	}
	
	function save_options() {
		if (!current_user_can('edit_themes'))
			wp_die(__('Easy there, homey. You don&#8217;t have admin privileges to access theme options.', 'thesis'));

		if (isset($_POST['submit'])) {
			$site_options = new thesis_site_options;
			$site_options->get_options();
			$site_options->update_options();
			update_option('thesis_options', $site_options);
		}

		wp_redirect(admin_url('admin.php?page=thesis-options&updated=true'));
	}
	
	function upgrade_options() {
		$site_options = new thesis_site_options;
		$site_options->get_options();

		$default_site_options = new thesis_site_options;
		$default_site_options->default_options();

		$design_options = new thesis_design_options;
		$design_options->get_options();

		$default_design_options = new thesis_design_options;
		$default_design_options->default_options();

		// This is necessary for the 1.8 upgrade
		$page_options = new thesis_page_options;
		$page_options->get_options();

		// Begin code to upgrade all Thesis Options to the newest data structures
		if (isset($site_options->multimedia_box))
			$multimedia_box = $site_options->multimedia_box;
		if (isset($design_options->home_layout)) {
			if ($design_options->home_layout) {
				$features = $design_options->teasers;
				unset($design_options->teasers);
			}
			else
				$features = get_option('posts_per_page');
		}

		// If any new data structures have been introduced, incorporate them now
		foreach ($default_site_options as $option_name => $value) {
			if (!isset($site_options->$option_name)) 
				$site_options->$option_name = $default_site_options->$option_name;
		}

		foreach ($default_design_options as $option_name => $value) {
			if (!isset($design_options->$option_name))
				$design_options->$option_name = $value;
		}

		// 1.8 nav upgrade and cleanup
		if (isset($site_options->nav)) {
			if (!isset($site_options->nav['type']))
				$site_options->nav['type'] = 'thesis';
			if (isset($site_options->nav['submenu_width']))
				unset($site_options->nav['submenu_width']);
			if (isset($site_options->nav['border']))
				unset($site_options->nav['border']);
			if (isset($site_options->nav['style']))
				unset($site_options->nav['style']);
		}

		// Home page options upgrade for 1.8
		if (isset($site_options->home)) {
			if (isset($site_options->home['meta']['description'])) {
				$site_options->home['head']['meta']['description'] = $site_options->home['meta']['description'];
				unset($site_options->home['meta']['description']);
			}
			elseif (isset($site_options->head['meta']['description'])) {
				$site_options->home['head']['meta']['description'] = $site_options->head['meta']['description'];
				unset($site_options->head['meta']['description']);
			}
			if (isset($site_options->home['meta']['keywords'])) {
				$site_options->home['head']['meta']['keywords'] = $site_options->home['meta']['keywords'];
				unset($site_options->home['meta']['keywords']);
			}
			elseif (isset($site_options->head['meta']['keywords'])) {
				$site_options->home['head']['meta']['keywords'] = $site_options->head['meta']['keywords'];
				unset($site_options->head['meta']['keywords']);
			}
			if (isset($site_options->home['features'])) {
				$design_options->home['body']['content']['features'] = $site_options->home['features'];
				unset($site_options->home['features']);
			}
		}
		else {
			if (isset($site_options->meta_description))
				$site_options->home['head']['meta']['description'] = $site_options->meta_description;
			if (isset($site_options->meta_keywords))
				$site_options->home['head']['meta']['keywords'] = $site_options->meta_keywords;
		}

		if (isset($design_options->layout['home'])) {
			if ($design_options->layout['home'] == 'teasers') {
				$design_options->home['body']['content']['features'] = ($design_options->teasers['features']) ? $design_options->teasers['features'] : 2;
				unset ($design_options->teasers['features']);
			}
			else
				$design_options->home['body']['content']['features'] = get_option('posts_per_page'); #wp

			foreach ($design_options->layout as $layout_var => $value) {
				if ($layout_var != 'home')
					$new_layout[$layout_var] = $value;
			}

			if ($new_layout)
				$design_options->layout = $new_layout;
		}
		elseif (isset($features))
			$design_options->home['body']['content']['features'] = $features;

		// Display options move for 1.8
		if (isset($site_options->display)) {
			$design_options->display = $site_options->display;
			if (isset($site_options->comments))
				$design_options->display['comments'] = $site_options->comments;
		}

		// Home page options move for 1.8
		if (isset($page_options->home)) {
			if (isset($page_options->home['head']))
				$site_options->home['head'] = $page_options->home['head'];
			if (isset($page_options->home['body']))
				$design_options->home['body'] = $page_options->home['body'];
			if (isset($page_options->home['javascript']))
				$design_options->home['javascript'] = $page_options->home['javascript'];
		}

		// Updated $head array for 1.7
		if (isset($site_options->head['title']['title']) || isset($site_options->head['title']['tagline'])) {
			$separator = ($site_options->head['title']['separator']) ? urldecode($site_options->head['title']['separator']) : '&#8212;';

			if ($site_options->head['title']['title'] && $site_options->head['title']['tagline'])
				$title = ($site_options->head['title']['tagline_first']) ? get_bloginfo('description') . " $separator " . get_bloginfo('name') : get_bloginfo('name') . " $separator " . get_bloginfo('description');
			elseif ($site_options->head['title']['title'])
				$title = get_bloginfo('name');
			else
				$title = get_bloginfo('description');

			$site_options->home['head']['title'] = urlencode($title);
			unset($site_options->head['title']['title'], $site_options->head['title']['tagline'], $site_options->head['title']['tagline_first']);
		}
		if (isset($site_options->head['noindex'])) {
			$site_options->head['meta']['robots']['noindex'] = $site_options->head['meta']['robots']['nofollow'] = $site_options->head['noindex'];
			$site_options->head['meta']['robots']['noindex']['sub'] = true;
			unset($site_options->head['noindex']);
		}
		if (!isset($site_options->head['meta']['robots']['nofollow']))
			$site_options->head['meta']['robots']['nofollow'] = $default_site_options->head['meta']['robots']['nofollow'];
		if (!isset($site_options->head['meta']['robots']['noarchive']))
			$site_options->head['meta']['robots']['noarchive'] = $default_site_options->head['meta']['robots']['noarchive'];
		if (!isset($site_options->head['meta']['robots']['noodp']))
			$site_options->head['meta']['robots']['noodp'] = $default_site_options->head['meta']['robots']['noodp'];
		if (!isset($site_options->head['meta']['robots']['noydir']))
			$site_options->head['meta']['robots']['noydir'] = $default_site_options->head['meta']['robots']['noydir'];
		if (isset($site_options->head['canonical'])) {
			$site_options->head['links']['canonical'] = $site_options->head['canonical'];
			unset($site_options->head['canonical']);
		}
		if (isset($site_options->head['version']))
			unset($site_options->head['version']);
		if ($site_options->feed['url'])
			$site_options->head['feed']['url'] = $site_options->feed['url'];
		elseif (isset($site_options->feed_url))
			$site_options->head['feed']['url'] = $site_options->feed_url;
		if (isset($site_options->scripts)) {
			$site_options->head['scripts'] = $site_options->scripts['header'];
			$site_options->javascript['scripts'] = $site_options->scripts['footer'];
		}
		if (isset($site_options->header_scripts))
			$site_options->head['scripts'] = $site_options->header_scripts;
		elseif (isset($site_options->mint))
			$site_options->head['scripts'] = $site_options->mint;
		if (isset($site_options->footer_scripts))
			$site_options->javascript['scripts'] = $site_options->footer_scripts;
		elseif (isset($site_options->analytics))
			$site_options->javascript['scripts'] = $site_options->analytics;
			
		// Custom stylesheet option, updated for 1.8
		if (isset($design_options->layout['custom'])) {
			$site_options->custom['stylesheet'] = $design_options->layout['custom'];
			unset($design_options->layout['custom']);
		}
		elseif (isset($site_options->style))
			$site_options->custom['stylesheet'] = (bool) $site_options->style['custom'];

		// Display options (updated for 1.8)
		if (isset($site_options->show_title))
			$design_options->display['header']['title'] = (bool) $site_options->show_title;
		if (isset($site_options->show_tagline))
			$design_options->display['header']['tagline'] = (bool) $site_options->show_tagline;
		if (isset($site_options->show_author))
			$design_options->display['byline']['author']['show'] = (bool) $site_options->show_author;
		if (isset($site_options->link_author_names))
			$design_options->display['byline']['author']['link'] = (bool) $site_options->link_author_names;
		if (isset($site_options->author_nofollow))
			$design_options->display['byline']['author']['nofollow'] = (bool) $site_options->author_nofollow;
		if (isset($site_options->show_date))
			$design_options->display['byline']['date']['show'] = (bool) $site_options->show_date;
		if (isset($site_options->show_author_on_pages))
			$design_options->display['byline']['page']['author'] = (bool) $site_options->show_author_on_pages;
		if (isset($site_options->show_date_on_pages))
			$design_options->display['byline']['page']['date'] = (bool) $site_options->show_date_on_pages;
		if (isset($site_options->show_num_comments))
			$design_options->display['byline']['num_comments']['show'] = (bool) $site_options->show_num_comments;
		if (isset($site_options->show_categories))
			$design_options->display['byline']['categories']['show'] = (bool) $site_options->show_categories;
		if (isset($site_options->read_more_text))
			$design_options->display['posts']['read_more_text'] = $site_options->read_more_text;
		elseif (isset($site_options->display['read_more_text']))
			$design_options->display['posts']['read_more_text'] = $site_options->display['read_more_text'];
		if (isset($site_options->show_post_nav))
			$design_options->display['posts']['nav'] = (bool) $site_options->show_post_nav;
		elseif (isset($site_options->display['navigation']))
			$design_options->display['posts']['nav'] = (bool) $site_options->display['navigation'];
		if (isset($site_options->archive_style))
			$design_options->display['archives']['style'] = $site_options->archive_style;
		if (isset($site_options->tags_single))
			$design_options->display['tags']['single'] = (bool) $site_options->tags_single;
		if (isset($site_options->tags_index))
			$design_options->display['tags']['index'] = (bool) $site_options->tags_index;
		if (isset($site_options->tags_nofollow))
			$design_options->display['tags']['nofollow'] = (bool) $site_options->tags_nofollow;
		if (isset($site_options->show_default_widgets))
			$design_options->display['sidebars']['default_widgets'] = (bool) $site_options->show_default_widgets;
		if (isset($site_options->edit_post_link))
			$design_options->display['admin']['edit_post'] = (bool) $site_options->edit_post_link;
		if (isset($site_options->admin_link))
			$design_options->display['admin']['link'] = ($site_options->admin_link == 'always') ? true : false;

		// Update old comment options for version 1.8
		if (isset($site_options->display['comments'])) {
			// Thesis Options
			$design_options->display['comments']['disable_pages'] = (bool) $site_options->display['comments']['disable_pages'];
			// Design Options
			$design_options->comments['comments']['options']['meta']['number']['show'] = (bool) $site_options->display['comments']['numbers'];
			$design_options->comments['comments']['options']['meta']['avatar']['options']['size'] = $site_options->display['comments']['avatar_size'];
		}
		if (isset($site_options->show_comment_numbers))
			$design_options->comments['comments']['options']['meta']['number']['show'] = (bool) $site_options->show_comment_numbers;
		if (isset($site_options->avatar_size))
			$design_options->comments['comments']['options']['meta']['avatar']['options']['size'] = $site_options->avatar_size;
		if (isset($site_options->disable_comments))
			$design_options->display['comments']['disable_pages'] = (bool) $site_options->disable_comments;

		// Nav menu
		if (isset($site_options->nav_menu_pages)) {
			$nav_menu_pages = explode(',', $site_options->nav_menu_pages);
			foreach ($nav_menu_pages as $nav_page) {
				if ($nav_page)
					$site_options->nav['pages'][$nav_page]['show'] = true;
			}
		}
		if (isset($site_options->nav_category_pages))
			$site_options->nav['categories'] = $site_options->nav_category_pages;
		if (isset($site_options->nav_link_category))
			$site_options->nav['links'] = $site_options->nav_link_category;
		if (isset($site_options->nav_home_text))
			$site_options->nav['home']['text'] = $site_options->nav_home_text;
		if (isset($site_options->show_feed_link))
			$site_options->nav['feed']['show'] = (bool) $site_options->show_feed_link;
		if (isset($site_options->feed_link_text))
			$site_options->nav['feed']['text'] = $site_options->feed_link_text;

		// Post images and thumbnails
		if (isset($site_options->image)) // This is for 1.7
			$design_options->image = $site_options->image;
		else { // This is suuuuper legacy
			if (isset($design_options->post_image_horizontal))
				$design_options->image['post']['x'] = $design_options->post_image_horizontal;
			if (isset($design_options->post_image_vertical))
				$design_options->image['post']['y'] = $design_options->post_image_vertical;
			if (isset($design_options->post_image_frame))
				$design_options->image['post']['frame'] = ($design_options->post_image_frame) ? 'on' : 'off';
			if (isset($design_options->post_image_single))
				$design_options->image['post']['single'] = $design_options->post_image_single;
			if (isset($design_options->post_image_archives))
				$design_options->image['post']['archives'] = $design_options->post_image_archives;
			if (isset($design_options->thumb_horizontal))
				$design_options->image['thumb']['x'] = $design_options->thumb_horizontal;
			if (isset($design_options->thumb_vertical))
				$design_options->image['thumb']['y'] = $design_options->thumb_vertical;
			if (isset($design_options->thumb_frame))
				$design_options->image['thumb']['frame'] = ($design_options->thumb_frame) ? 'on' : 'off';
			if (isset($design_options->thumb_size)) {
				$design_options->image['thumb']['width'] = $design_options->thumb_size['width'];
				$design_options->image['thumb']['height'] = $design_options->thumb_size['height'];
			}
		}

		// Multimedia box
		if (isset($multimedia_box) && is_array($multimedia_box)) {
			foreach ($multimedia_box as $item => $value)
				$design_options->multimedia_box[$item] = $value;
		}
		elseif (isset($multimedia_box)) {
			$design_options->multimedia_box['status'] = $multimedia_box;

			if ($site_options->image_alt_tags) {
				foreach ($site_options->image_alt_tags as $image_name => $alt_text) {
					if ($alt_text != '')
						$design_options->multimedia_box['alt_tags'][$image_name] = $alt_text;
				}
			}
			if ($site_options->image_link_urls) {
				foreach ($site_options->image_link_urls as $image_name => $link_url) {
					if ($link_url != '')
						$design_options->multimedia_box['link_urls'][$image_name] = $link_url;
				}
			}
			if ($site_options->video_code)
				$design_options->multimedia_box['video'] = $site_options->video_code;
			if ($site_options->custom_code)
				$design_options->multimedia_box['code'] = $site_options->custom_code;
		}

		// Loop back through all existing Thesis Options and make changes as necessary
		foreach ($site_options as $option_name => $value) {
			if (!isset($default_site_options->$option_name))
				unset($site_options->$option_name); // Has this option been nuked? If so, kill it!
		}

		if (version_compare($site_options->version, thesis_version(), '<'))
			$site_options->version = thesis_version();

		update_option('thesis_options', $site_options); // Save upgraded Thesis Options
		update_option('thesis_design_options', $design_options); // Save upgraded Design Options
		delete_option('thesis_pages');
	}
	
	function options_page() {
		global $thesis_site;
		$head = $thesis_site->head;
		$javascript = $thesis_site->javascript;
		$nav = $thesis_site->nav;
		$home = $thesis_site->home;
		$publishing = $thesis_site->publishing;
		$custom = $thesis_site->custom;
		$rtl = (get_bloginfo('text_direction') == 'rtl') ? ' rtl' : ''; #wp

		echo "<script>jQuery.noConflict();function charCount(ctrlId, counterId){jQuery(counterId).val(jQuery(ctrlId).val().trim().length);}</script>\n";
		echo "<div id=\"thesis_options\" class=\"wrap$rtl\">\n";
		thesis_version_indicator();
		thesis_options_title(__('Thesis Site Options', 'thesis'));
		thesis_options_nav();
		thesis_options_status_check();

		if (version_compare($thesis_site->version, thesis_version()) < 0) {
?>
	<form id="upgrade_needed" action="<?php echo admin_url('admin-post.php?action=thesis_upgrade'); ?>" method="post">
		<h3><?php _e('Oooh, Exciting!', 'thesis'); ?></h3>
		<p><?php _e('It&#8217;s time to upgrade your Thesis, which means there&#8217;s new awesomeness in your immediate future. Click the button below to fast-track your way to the awesomeness!', 'thesis'); ?></p>
		<p><input type="submit" class="upgrade_button" id="teh_upgrade" name="upgrade" value="<?php _e('Upgrade Thesis', 'thesis'); ?>" /></p>
	</form>
<?php
		}
		else {
			thesis_is_css_writable();
?>

	<form class="thesis" action="<?php echo admin_url('admin-post.php?action=thesis_options'); ?>" method="post">
		<div class="options_column">
			<div class="options_module" id="document-head">
				<h3><?php _e('Document Head', 'thesis'); ?> <code>&lt;head&gt;</code></h3>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Title Tag Settings', 'thesis'); ?> <code>&lt;title&gt;</code></h4>
					<div class="more_info">
						<p><?php _e('As far as <acronym title="Search Engine Optimization">SEO</acronym> is concerned, this is the single most important element on your site. For all pages except the home page, Thesis will construct your <code>&lt;title&gt;</code> tags automatically according to the settings below, but you can override these settings by adding a custom <code>&lt;title&gt;</code> to any post or page via the post editing screen.', 'thesis'); ?></p>
						<ul class="add_margin">
							<li><input type="checkbox" id="head[title][branded]" name="head[title][branded]" value="1" <?php if ($head['title']['branded']) echo 'checked="checked" '; ?>/><label for="head[title][branded]"><?php _e('Append site name to page titles', 'thesis'); ?></label></li>
						</ul>
						<p class="form_input add_margin">
							<input type="text" class="text_input short" id="head[title][separator]" name="head[title][separator]" value="<?php echo ($head['title']['separator']) ? urldecode($head['title']['separator']) : '&#8212;' ?>" />
							<label for="head[title][separator]"><?php _e('Character separator in titles', 'thesis'); ?></label>
						</p>
						<p class="tip"><?php printf(__('You can set your home page <code>&lt;title&gt;</code> tag in the Home Page SEO box on this page. For categories and tags, visit the <a href="%1$s">edit category</a> and <a href="%2$s">edit tag</a> pages within WordPress.', 'thesis'), admin_url('edit-tags.php?taxonomy=category'), admin_url('edit-tags.php')); ?></p>
					</div>
				</div>
				<div class="module_subsection" id="robots-meta">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Robots Meta Tags', 'thesis'); ?> <code>&lt;meta&gt;</code></h4>
					<div class="more_info">
						<div class="mini_module indented_module" id="robots-noindex">
							<h5 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Noindex', 'thesis'); ?> <code>noindex</code></h5>
							<div class="more_info">
								<p><?php _e('Adding the <code>noindex</code> robot meta tag is a great way to fine-tune your site&#8217;s <acronym title="Search Engine Optimization">SEO</acronym> by streamlining the amount of pages that get indexed by the search engines. The options below will help you prevent the indexing of &#8220;bloat&#8221; pages that do nothing but dilute your search results and keep you from ranking as well as you should.', 'thesis'); ?></p>
								<ul>
<?php
								foreach ($head['meta']['robots']['noindex'] as $page_type => $value) {
									$checked = ($value) ? 'checked="checked" ' : '';
									echo "\t\t\t\t\t\t\t\t\t" . '<li><input type="checkbox" id="head[meta][robots][noindex][' . $page_type . ']" name="head[meta][robots][noindex][' . $page_type . ']" value="1" ' . $checked . '/><label for="head[meta][robots][noindex][' . $page_type . ']">' . sprintf(__('<code>noindex</code> %s pages', 'thesis'), $page_type) . '</label></li>' . "\n";
								}
?>
								</ul>
							</div>
						</div>
						<div class="mini_module indented_module" id="robots-nofollow">
							<h5 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Nofollow', 'thesis'); ?> <code>nofollow</code></h5>
							<div class="more_info">
								<p><?php _e('The <code>nofollow</code> robot meta tag is another useful tool for nailing down your site&#8217;s <acronym title="Search Engine Optimization">SEO</acronym>. Links from pages with the <code>nofollow</code> meta tag won&#8217;t pass any juice.', 'thesis'); ?></p>
								<ul>
<?php
								foreach ($head['meta']['robots']['nofollow'] as $page_type => $value) {
									$checked = ($value) ? 'checked="checked" ' : '';
									echo "\t\t\t\t\t\t\t\t\t" . '<li><input type="checkbox" id="head[meta][robots][nofollow][' . $page_type . ']" name="head[meta][robots][nofollow][' . $page_type . ']" value="1" ' . $checked . '/><label for="head[meta][robots][nofollow][' . $page_type . ']">' . sprintf(__('Add <code>nofollow</code> to %s pages', 'thesis'), $page_type) . '</label></li>' . "\n";
								}
?>
								</ul>
							</div>
						</div>
						<div class="mini_module indented_module" id="robots-noarchive">
							<h5 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Noarchive', 'thesis'); ?> <code>noarchive</code></h5>
							<div class="more_info">
								<p><?php _e('The <code>noarchive</code> robot meta tag prevents search engines and Internet archive services from saving cached versions of pages on your site. Generally, people use this to protect their privacy, but there are certainly times when having access to archived versions of your pages might prove useful.', 'thesis'); ?></p>
								<ul>
<?php
								foreach ($head['meta']['robots']['noarchive'] as $page_type => $value) {
									$checked = ($value) ? 'checked="checked" ' : '';
									echo "\t\t\t\t\t\t\t\t\t" . '<li><input type="checkbox" id="head[meta][robots][noarchive][' . $page_type . ']" name="head[meta][robots][noarchive][' . $page_type . ']" value="1" ' . $checked . '/><label for="head[meta][robots][noarchive][' . $page_type . ']">' . sprintf(__('Add <code>noarchive</code> to %s pages', 'thesis'), $page_type) . '</label></li>' . "\n";
								}
?>
								</ul>
							</div>
						</div>
						<div class="mini_module indented_module" id="robots-noodp">
							<h5 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Directory Tags', 'thesis'); ?> <code>noodp</code> <code>noydir</code></h5>
							<div class="more_info">
								<p><?php _e('Using the <code>noodp</code> robot meta tag will prevent search engines from displaying Open Directory Project (DMOZ) listings in your meta descriptions. The <code>noydir</code> tag is pretty much the same, except that it only affects the Yahoo! Directory. Both of these options are sitewide.', 'thesis'); ?></p>
								<ul>
									<li><input type="checkbox" id="head[meta][robots][noodp]" name="head[meta][robots][noodp]" value="1" <?php if ($head['meta']['robots']['noodp']) echo 'checked="checked" '; ?>/><label for="head[meta][robots][noodp]"><?php _e('Add <code>noodp</code> to your site', 'thesis'); ?></label></li>
									<li><input type="checkbox" id="head[meta][robots][noydir]" name="head[meta][robots][noydir]" value="1" <?php if ($head['meta']['robots']['noydir']) echo 'checked="checked" '; ?>/><label for="head[meta][robots][noydir]"><?php _e('Add <code>noydir</code> to your site', 'thesis'); ?></label></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Canonical <acronym title="Uniform Resource Locator">URL</acronym>s', 'thesis'); ?></h4>
					<ul class="more_info">
						<li><input type="checkbox" id="head[links][canonical]" name="head[links][canonical]" value="1" <?php if ($head['links']['canonical']) echo 'checked="checked" '; ?>/><label for="head[links][canonical]"><?php _e('Add canonical <acronym title="Uniform Resource Locator">URL</acronym>s to your site', 'thesis'); ?></label></li>
					</ul>
				</div>
				<div class="module_subsection" id="syndication">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Syndication/Feed <acronym title="Uniform Resource Locator">URL</acronym>', 'thesis'); ?></h4>
					<div class="more_info">
						<p><?php printf(__('If you&#8217;re using a service like <a href="%s">Feedburner</a> to manage your <acronym title="Really Simple Syndication">RSS</acronym> feed, you should enter the <acronym title="Uniform Resource Locator">URL</acronym> of your feed in the box below. If you&#8217;d prefer to use the default WordPress feed, simply leave this box blank.', 'thesis'), 'http://www.feedburner.com/'); ?></p>
						<p class="form_input">
							<input type="text" class="text_input" id="head[feed][url]" name="head[feed][url]" value="<?php if ($head['feed']['url']) echo $head['feed']['url']; ?>" />
							<label for="head[feed][url]"><?php _e('Feed <acronym title="Uniform Resource Locator">URL</acronym> (including &#8216;http://&#8217;)', 'thesis'); ?></label>
						</p>
					</div>
				</div>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Additional Scripts', 'thesis'); ?></h4>
					<div class="more_info">
						<p><?php printf(__('If you need to add scripts to your document <code>&lt;head&gt;</code>, you should enter them in the box below; however, if you&#8217;re adding stat-tracking code, you should add that to the <a href="%s">Stats and Scripts section below</a>.', 'thesis'), '#javascript-options'); ?></p>
						<p class="form_input">
							<label for="head[scripts]"><?php _e('Additional <code>&lt;head&gt;</code> scripts (code)', 'thesis'); ?></label>
							<textarea class="scripts" id="head[scripts]" name="head[scripts]"><?php if ($head['scripts']) thesis_massage_code($head['scripts']); ?></textarea>
						</p>
					</div>
				</div>
			</div>
			<div class="options_module" id="javascript-options">
				<h3><?php _e('Stats Software/Scripts', 'thesis'); ?></h3>
				<div class="module_subsection" id="javascript-scripts">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Stat and Tracking Scripts', 'thesis'); ?></h4>
					<div class="more_info">
						<p><?php _e('If you&#8217;ve got a stat-tracking script (from, say, Mint or Google Analytics), you&#8217;ll want to place it here. Anything you add here will be served after the <acronym title="HyperText Markup Language">HTML</acronym> on <em>every page of your site</em>. This is the preferred position because it prevents the scripts from interrupting the page load.', 'thesis'); ?></p>
						<p class="form_input">
							<label for="javascript[scripts]"><?php _e('Tracking scripts (include <code>&lt;script&gt;</code> tags!)', 'thesis'); ?></label>
							<textarea class="scripts" id="javascript[scripts]" name="javascript[scripts]"><?php if ($javascript['scripts']) thesis_massage_code($javascript['scripts']); ?></textarea>
						</p>
					</div>
				</div>
			</div>
			<div class="options_module" id="home-page-options">
				<h3><?php _e('Custom Stylesheet Options', 'thesis'); ?></h3>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Enable Stylesheet', 'thesis'); ?></h4>
					<div class="more_info">
						<p class="add_margin"><?php _e('The only reason to deselect this option is to reduce the total number of <code>http</code> requests your site makes because this will improve your page load speed. If you&#8217;re not using your custom stylesheet, then you may consider deselecting this option.', 'thesis'); ?></p>
						<ul>
							<li><input type="checkbox" id="custom[stylesheet]" name="custom[stylesheet]" value="1" <?php if ($custom['stylesheet']) echo 'checked="checked" '; ?>/><label for="custom[stylesheet]"><?php _e('Enable custom stylesheet', 'thesis'); ?></label></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div class="options_column">
			<div class="options_module button_module">
				<input type="submit" class="save_button" id="options_submit" name="submit" value="<?php thesis_save_button_text(); ?>" />
			</div>
			<div class="options_module" id="thesis-nav-menu">
				<h3><?php _e('Navigation Menu', 'thesis'); ?></h3>
<?php
				global $wp_version;
				if (version_compare($wp_version, '3', '>=')) {
?>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Select Menu Type', 'thesis') ?></h4>
					<div class="more_info">
						<ul id="nav_switch">
							<li><input type="radio" name="nav[type]" value="wp" <?php if ($nav['type'] == 'wp') echo 'checked="checked" '; ?>/><label><?php _e('WordPress nav menu', 'thesis'); ?> <a href="<?php echo admin_url("nav-menus.php"); ?>" target="_blank">[?]</a></label></li>
							<li><input type="radio" name="nav[type]" value="thesis" <?php if ($nav['type'] == 'thesis') echo 'checked="checked" '; ?>/><label><?php _e('Thesis nav menu', 'thesis'); ?></label></li>
						</ul>
					</div>
				</div>
<?php
				}
?>
				<div id="thesis_nav_controls">
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Pages', 'thesis') ?></h4>
					<div class="more_info">
						<p><?php _e('Start by selecting the pages you want to include in your nav menu. Next, drag and drop the pages to change their display order (topmost item displays first), and if you <em>really</em> want to get crazy, you can even edit the display text on each item. <strong>Try it!</strong>', 'thesis'); ?></p>
						<p><?php _e('Thesis features automatic dropdown menus, so if you have nested pages or categories, you&#8217;ll save space <em>and</em> gain style points with your slick new nav menu!', 'thesis'); ?></p>
						<ul id="nav_pages" class="sortable add_margin">
<?php
					$pages = &get_pages('sort_column=post_parent,menu_order');
					$active_pages = array();

					if ($nav['pages']) {
						foreach ($nav['pages'] as $id => $nav_page) {
							$active_page = get_page($id);
							if (post_exists($active_page->post_title)) {
								$checked = ($nav_page['show']) ? ' checked="checked"' : '';
								$link_text = ($nav['pages'][$id]['text'] != '') ? $nav['pages'][$id]['text'] : $active_page->post_title;
								echo "\t\t\t\t\t\t\t<li><input class=\"checkbox\" type=\"checkbox\" id=\"nav[pages][$id][show]\" name=\"nav[pages][$id][show]\" value=\"1\"$checked /><input type=\"text\" class=\"text_input\" id=\"nav[pages][$id][text]\" name=\"nav[pages][$id][text]\" value=\"$link_text\" /></li>\n";
								$active_pages[] = $id;
							}
						}
					}
					if ($pages) {
						foreach ($pages as $page) {
							if (!in_array($page->ID, $active_pages)) {
								$link_text = ($nav['pages'][$page->ID]['text'] != '') ? $nav['pages'][$page->ID]['text'] : $page->post_title;
								echo "\t\t\t\t\t\t\t<li><input class=\"checkbox\" type=\"checkbox\" id=\"nav[pages][$page->ID][show]\" name=\"nav[pages][$page->ID][show]\" value=\"1\" /><input type=\"text\" class=\"text_input\" id=\"nav[pages][$page->ID][text]\" name=\"nav[pages][$page->ID][text]\" value=\"$link_text\" /></li>\n";
							}
						}
					}

?>
						</ul>
					</div>
				</div>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Categories', 'thesis') ?></h4>
					<div class="more_info">
						<p><?php _e('If you&#8217;d like to include category pages in your nav menu, simply select the appropriate categories from the list below (you can select more than one).', 'thesis'); ?></p>
						<p class="form_input">
							<select class="select_multiple" id="nav[categories]" name="nav[categories][]" multiple="multiple" size="1">
								<option value="0"><?php _e('No category page links', 'thesis'); ?></option>
<?php
					$categories = &get_categories('type=post&orderby=name&hide_empty=0');

					if ($categories) {
						$nav_category_pages = explode(',', $nav['categories']);
						foreach ($categories as $category) {
							$selected = (in_array($category->cat_ID, $nav_category_pages)) ? ' selected="selected"' : '';
							echo "\t\t\t\t\t\t\t\t<option value=\"$category->cat_ID\"$selected>$category->cat_name</option>\n";
						}
					}
?>
							</select>
						</p>
					</div>
				</div>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Add More Links', 'thesis'); ?></h4>
					<div class="more_info">
						<p><?php printf(__('You can insert additional navigation links on the <a href="%1$s">Manage Links</a> page. To ensure that things go smoothly, you should first <a href="%2$s">create a link category</a> solely for your navigation menu, and then make sure you place your new links in that category. Once you&#8217;ve done that, you can select your category below to include it in your nav menu.', 'thesis'), get_bloginfo('wpurl') . '/wp-admin/link-manager.php', get_bloginfo('wpurl') . '/wp-admin/edit-link-categories.php#addcat'); ?></p>
						<p class="form_input">
							<select id="nav[links]" name="nav[links]" size="1">
								<option value="0"><?php _e('No additional links', 'thesis'); ?></option>
<?php
					$link_categories = &get_categories('type=link&hide_empty=0');
					
					if ($link_categories) {
						foreach ($link_categories as $link_category) {
							$selected = ($nav['links'] == $link_category->cat_ID) ? ' selected="selected"' : '';
							echo "\t\t\t\t\t\t\t\t<option value=\"$link_category->cat_ID\"$selected>$link_category->cat_name</option>\n";
						}
					}
?>
							</select>
						</p>
					</div>
				</div>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Home Link', 'thesis'); ?></h4>
					<div class="control_box more_info">
						<ul class="control">
							<li><input type="checkbox" id="nav[home][show]" name="nav[home][show]" value="1" <?php if ($nav['home']['show']) echo 'checked="checked" '; ?>/><label for="nav[home][show]"><?php _e('Show home link in nav menu', 'thesis'); ?></label></li>
						</ul>
						<div class="dependent">
							<p class="form_input add_margin">
								<input type="text" id="nav[home][text]" name="nav[home][text]" value="<?php echo thesis_home_link_text(); ?>" />
								<label for="nav[home][text]"><?php _e('home link text', 'thesis'); ?></label>
							</p>
							<ul>
								<li><input type="checkbox" id="nav[home][nofollow]" name="nav[home][nofollow]" value="1" <?php if ($nav['home']['nofollow']) echo 'checked="checked" '; ?>/><label for="nav[home][nofollow]"><?php _e('Add <code>nofollow</code> to home link', 'thesis'); ?></label></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Feed Link', 'thesis'); ?></h4>
					<div class="control_box more_info">
						<ul class="control">
							<li><input type="checkbox" id="nav[feed][show]" name="nav[feed][show]" value="1" <?php if ($nav['feed']['show']) echo 'checked="checked" '; ?>/><label for="nav[feed][show]"><?php _e('Show feed link in nav menu', 'thesis'); ?></label></li>
						</ul>
						<div class="dependent">
							<p class="form_input add_margin">
								<input type="text" class="text_input" id="nav[feed][text]" name="nav[feed][text]" value="<?php echo thesis_feed_link_text(); ?>" />
								<label for="nav[feed][text]"><?php _e('Change your feed link text', 'thesis'); ?></label>
							</p>
							<ul>
								<li><input type="checkbox" id="nav[feed][nofollow]" name="nav[feed][nofollow]" value="1" <?php if ($nav['feed']['nofollow']) echo 'checked="checked" '; ?>/><label for="nav[feed][nofollow]"><?php _e('Add <code>nofollow</code> to feed link', 'thesis'); ?></label></li>
							</ul>
						</div>
					</div>
				</div>
				</div>
			</div>
			<div class="options_module" id="home-page-options">
				<h3><?php _e('Home Page <acronym title="Search Engine Optimization">SEO</acronym>', 'thesis'); ?></h3>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Document Head', 'thesis'); ?> <code>&lt;head&gt;</code></h4>
					<div class="more_info">
						<p class="form_input add_margin">
							<input type="text" class="text_input" id="home_head_title" name="home[head][title]" value="<?php if ($home['head']['title']) echo urldecode($home['head']['title']); ?>" />
							<script>jQuery('#home_head_title').keyup(function(){charCount('#home_head_title', '#length_home_title');});</script>
							<label for="home[head][title]"><?php _e('home page <code>&lt;title&gt;</code> tag', 'thesis'); ?> <input type="text" readonly="readonly" class="counter" id="length_home_title" size="3" maxlength="3" value="0"></label>
						</p>
						<p class="form_input add_margin">
							
							<textarea class="scripts" id="home_head_description" name="home[head][meta][description]"><?php if ($home['head']['meta']['description']) echo urldecode($home['head']['meta']['description']); ?></textarea>
							<script>jQuery('#home_head_description').keyup(function(){charCount('#home_head_description', '#length_home_description');});</script>
							<label for="home[head][meta][description]"><?php _e('home page <code>&lt;meta&gt;</code> description', 'thesis'); ?> <input type="text" readonly="readonly" class="counter" id="length_home_description" size="3" maxlength="3" value="0"></label>
						</p>
						<p class="form_input add_margin">
							<input type="text" class="text_input" id="home[head][meta][keywords]" name="home[head][meta][keywords]" value="<?php if ($home['head']['meta']['keywords']) echo urldecode($home['head']['meta']['keywords']); ?>" />
							<label for="home[head][meta][keywords]"><?php _e('home page <code>&lt;meta&gt;</code> keywords', 'thesis'); ?></label>
						</p>
						<ul>
							<li><input type="checkbox" id="home[head][meta][robots][noindex]" name="home[head][meta][robots][noindex]" value="1" <?php if ($home['head']['meta']['robots']['noindex']) echo 'checked="checked" '; ?>/><label for="home[head][meta][robots][noindex]"><?php _e('<code>noindex</code> this page', 'thesis'); ?></label></li>
							<li><input type="checkbox" id="home[head][meta][robots][nofollow]" name="home[head][meta][robots][nofollow]" value="1" <?php if ($home['head']['meta']['robots']['nofollow']) echo 'checked="checked" '; ?>/><label for="home[head][meta][robots][nofollow]"><?php _e('<code>nofollow</code> this page', 'thesis'); ?></label></li>
							<li><input type="checkbox" id="home[head][meta][robots][noarchive]" name="home[head][meta][robots][noarchive]" value="1" <?php if ($home['head']['meta']['robots']['noarchive']) echo 'checked="checked" '; ?>/><label for="home[head][meta][robots][noarchive]"><?php _e('<code>noarchive</code> this page', 'thesis'); ?></label></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="options_column">
			<div class="options_module" id="publishing-tools">
				<h3><?php _e('Publishing Tools', 'thesis'); ?></h3>
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Windows Live Writer', 'thesis'); ?></h4>
					<div class="more_info">
						<ul>
							<li><input type="checkbox" id="publishing[wlw]" name="publishing[wlw]" value="1" <?php if ($publishing['wlw']) echo 'checked="checked" '; ?>/><label for="publishing[wlw]"><?php _e('Enable support for Windows Live Writer', 'thesis'); ?></label></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="options_module" id="save_button_control">
				<div class="module_subsection">
					<h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'thesis'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Change Save Button Text', 'thesis'); ?></h4>
					<p class="form_input more_info">
						<input type="text" id="save_button_text" name="save_button_text" value="<?php if ($thesis_site->save_button_text) echo $thesis_site->save_button_text; ?>" />
						<label for="save_button_text"><?php _e('not recommended (heh)', 'thesis'); ?></label>
					</p>
				</div>
			</div>
		</div>
	</form>
<?php
		}
?>
</div>
<?php
	}
}

function thesis_get_date_formats() {
	$date_formats = array(
		'standard' => 'F j, Y',
		'no_comma' => 'j F Y',
		'numeric' => 'm.d.Y',
		'reversed' => 'd.m.Y'
	);
	
	return $date_formats;
}