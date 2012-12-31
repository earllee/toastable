<?php

// NOTE: TO MAKE USER CONFIGURATIONS, OPEN custom_functions.php

global $tt_use_logo;

if ($tt_use_logo == "false") {
	add_action('wp_head', 'tt_use_logo'); // adds css to disable logo (if not true)
}

function tt_use_logo() {
	?>
    <style type="text/css">
	.custom #header #logo, .custom #header #tagline {
		text-indent: 0px;
		margin-top: .2em;
	}
	.custom #header #logo a {
		background: none;
		display: inline;
	}
	</style>
    <?php
    }

function tt_multimediabox() {
global $tt_twitter_username;
?>
<p class="tt_rss"><a href="<?php echo thesis_feed_url(); ?>">Subscribe to RSS</a></p>
<p class="tt_twitter"><a href="http://www.twitter.com/<?php echo $tt_twitter_username; ?>">Follow on Twitter</a></p>
  <form method="get" class="search_form" action="<?php echo bloginfo('url'); ?>">
  	<p>
  		<input class="text_input" type="text" value="To search, type and hit enter" name="s" id="s" onfocus="if (this.value == 'To search, type and hit enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'To search, type and hit enter';}" />
  		<input type="hidden" id="searchsubmit" value="Search" />
  	</p>
</form>

<?php
} //end media box 

function tt_footer() {
	global $post;
?>
  <p style="float:left">&copy; 2009 <a href="<?php echo bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a></p>
  <?php global $tt_footer_removal;
  if ($tt_footer_removal == 'true') { } else { ?>
  <p style="float:right">Powered by <a href="http://thesisthemes.com/u.php?1">Thesis</a>, <a href="http://wordpress.org/">Wordpress</a> and <a href="http://www.thesisthemes.com">Thesis Themes</a></p>
<?php 
}
}

function tt_special_header() {
	global $tt_special_header;
	global $tt_special_paragraph;
	global $tt_use_header;
	global $tt_use_header_on_every_page;
if ($tt_use_header == 'false') {  } else {
	if ($tt_use_header_on_every_page == 'false') {
		if (is_front_page()) {
	?>
<div id="tt_special_header">
	<div class="tt_icon"></div>
    <h3><?php echo stripslashes(html_entity_decode($tt_special_header)); ?></h3>
    <p><?php echo stripslashes(html_entity_decode($tt_special_paragraph)); ?></p>
</div>
<div class="clearall"></div>
<?php 			
				}
			}
			else {
	?>
<div id="tt_special_header">
<div class="tt_icon"></div>
<h3><?php echo stripslashes(html_entity_decode($tt_special_header)); ?></h3>
<p><?php echo stripslashes(html_entity_decode($tt_special_paragraph)); ?></p>
</div>
<div class="clearall"></div>
<?php
		}
}
}

function tt_comment_box() {
$num_comments = get_comments_number();
if (is_home()) { ?>
<div class="tt_comment_box"><?php echo $num_comments; ?></div>

<?php 
	} 
}

function tt_open_post() {
if (is_home()) {
	?>
<div class="tt_post">
<?php
	}
}

function tt_close_post() {
if (is_home()) {
	?>
</div>
<?php
	}
}