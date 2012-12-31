<?php

// Using hooks is absolutely the smartest, most bulletproof way to implement things like plugins,
// custom design elements, and ads. You can add your hook calls below, and they should take the 
// following form:
// add_action('thesis_hook_name', 'function_name');
// The function you name above will run at the location of the specified hook. The example
// hook below demonstrates how you can insert Thesis' default recent posts widget above
// the content in Sidebar 1:
// add_action('thesis_hook_before_sidebar_1', 'thesis_widget_recent_posts');

// Delete this line, including the dashes to the left, and add your hooks in its place.

/**
 * function custom_bookmark_links() - outputs an HTML list of bookmarking links
 * NOTE: This only works when called from inside the WordPress loop!
 * SECOND NOTE: This is really just a sample function to show you how to use custom functions!
 *
 * @since 1.0
 * @global object $post
*/

function custom_bookmark_links() {
	global $post;
?>
<ul class="bookmark_links">
	<li><a rel="nofollow" href="http://delicious.com/save?url=<?php urlencode(the_permalink()); ?>&amp;title=<?php urlencode(the_title()); ?>" onclick="window.open('http://delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url=<?php urlencode(the_permalink()); ?>&amp;title=<?php urlencode(the_title()); ?>', 'delicious', 'toolbar=no,width=550,height=550'); return false;" title="Bookmark this post on del.icio.us">Bookmark this article on Delicious</a></li>
</ul>
<?php
}

// Start functions import
// You can copy and paste this code block into your own custom_functions.php if you want
require_once(TEMPLATEPATH . '/custom/skins/skins_admin.php'); 
// End function import

// Add your Thesis functions after this line as you normally would!

/*//WIDGETIZED FOOTER
register_sidebars(1,
    array(
        'name' => 'Footer',
        'before_widget' => '<li class="widget %2$s" id="%1$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    )
);
function custom_footer() { ?>
	<div id="footer_1" class="sidebar">
		<ul class="sidebar_list">
			<?php thesis_default_widget(3); ?>
		</ul>
	</div>
<?php }
add_action('thesis_hook_footer', 'custom_footer', '1');
//End of Widgetized footer*/

//CUSTOM FOOTER
function custom_footer() { ?>
	<div id="singlefooter" class="sidebar">
	
				Powered by WordPress | Copyright © 2011 Toastable | All rights reserved |
                by Earl Lee
<?php }
add_action('thesis_hook_footer', 'custom_footer', '1');



//REMOVE THESIS ATTRIBUTION
remove_action('thesis_hook_footer', 'thesis_attribution');

//FULL WIDTH HEADER
remove_action('thesis_hook_before_header','thesis_nav_menu');
add_action('thesis_hook_before_html','custom_nav');

function custom_nav() { ?>
<div id="nav_area" class="full_width">	 <div class="page">	 <?php thesis_nav_menu();?>  </div>	</div>
<?php } 

function add_search_nav() {
?>
	<li class="search"><?php thesis_search_form(); ?></li>
<?php
}
add_action('thesis_hook_last_nav_item','add_search_nav');

// ADDME MENU

/* No buttons selected. All buttons are unselected. All button images are unselected versions. */
function addme_menu() {
?>
        <div id="button_nav">
                <ul>
                        <li><a class="addme" href="http://feeds.feedburner.com/Toastable"><img src="http://toastable.com/wp-content/themes/v2/custom/images/addme_icons/rss.png" alt="RSS" /></a></li>
                        <li><a class="addme" href="http://www.facebook.com/pages/Toastable/131959420153836"><img src="http://toastable.com/wp-content/themes/v2/custom/images/addme_icons/facebook.png" alt="Facebook" /></a></li>
                          <li><a class="addme" href="http://toastable.tumblr.com/"><img src="http://toastable.com/wp-content/themes/v2/custom/images/addme_icons/tumblr.png" alt="Tumblr" /></a></li>
  <li><a class="addme" href="http://twitter.com/EarlVLee"><img src="http://toastable.com/wp-content/themes/v2/custom/images/addme_icons/twitter.png" alt="Twitter"  /></a></li>                </ul>
        </div><?php
}

add_action('thesis_hook_header', 'addme_menu');

        /* =====SAMPLE STATEMENTS FOR OTHER KINDS OF DOCUMENTS===== */
        /* Add or substitute these in Function 4 as needed */
        /* For both blog home pages and static front pages only */
        /*elseif (is_front_page())
                add_action('thesis_hook_after_header', 'button_nav_menu_PAGE1_selected', '90');*/
        /* For posts only */
        /*elseif (is_single('POST-NAME'))
                add_action('thesis_hook_after_header', 'button_nav_menu_PAGE1_selected', '90');*/
        /* For category pages only */
        /*elseif (is_category('CATEGORY-NAME'))
                add_action('thesis_hook_after_header', 'button_nav_menu_PAGE1_selected', '90');*/
        /* For tag pages only */
        /*elseif (is_tag('TAG-NAME'))
                add_action('thesis_hook_after_header', 'button_nav_menu_PAGE1_selected', '90');*/


/* BREAD CRUMBS
function the_crumbs() {
	if (!is_home()) {
		echo '<a href="';
		echo get_option('home');
		echo '">';
		echo 'Home'; // Home Link Text, change this to meet your needs
		echo "</a> >> ";
		if (is_category() || is_single()) {
			the_category(', ','&title_li=');
			if (is_single()) {
				echo " > ";
				the_title();
			}
		} elseif (is_page()) {
			echo the_title();
}}}

function show_crumbs() { ?>
<div id="crumbs">
	<?php the_crumbs(); ?>
</div>
<?php }
add_action('thesis_hook_before_content','show_crumbs');
*/

//NICE ARCHIVE
function my_archive() {
?>
<div class="archive">
<div class="archivel">
  <h3>Categories:</h3>
  <ul>
    <?php wp_list_categories('sort_column=name&title_li='); ?>
  </ul>

  <h3>Time:</h3>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>

</div>

<div class="archiver">

   <h3>Posts: (Last 100 articles)</h3>
   <ul>
     <?php wp_get_archives('type=postbypost&limit=100'); ?>
   </ul>
</div>
</div>
<?php
}

remove_action('thesis_hook_archives_template', 'thesis_archives_template');
add_action('thesis_hook_archives_template', 'my_archive');


/*HIDE DATES ON MORE THAN 30 DAY OLD ARTICLES
function add_date_to_byline() {
  $daysold = (current_time(timestamp) - get_the_time('U') -
(get_settings('gmt_offset')))/(24*60*60);

  if ($daysold < 30 ) {
      echo ' on <abbr class="published" title="' . get_the_time('Y-m-d') . '">' . get_the_time(get_option('date_format')) . '</abbr>';
  }
}

add_action('thesis_hook_byline_item', 'add_date_to_byline'); */


/*SOCIAL MEDIA LINKS
function social_media_links() { ?>
<div class="sociallinksall">
<a  class="sociallinks" href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;amp;title=<?php echo urlencode(the_title('','', false)) ?>"><img src="http://toastable.com/wp-content/themes/thesis_18b1/custom/images/social_icons/delicious.png" alt="Bookmark on Delicious"></a>
<a class="sociallinks" href="http://digg.com/submit?phase=2&amp;amp;url=<?php the_permalink() ?>&amp;amp;title=<?php echo urlencode(the_title('','', false)) ?>"><img src="http://toastable.com/wp-content/themes/thesis_18b1/custom/images/social_icons/digg.png" alt="Bookmark on Digg"></a>
<a class="sociallinks" href="http://facebook.com/share.php?u=<?php the_permalink() ?>&amp;amp;t=<?php echo urlencode(the_title('','', false)) ?>"><img src="http://toastable.com/wp-content/themes/thesis_18b1/custom/images/social_icons/facebook.png" alt="Bookmark on Facebook"></a>
<a class="sociallinks" href="http://reddit.com/submit?url=<?php the_permalink() ?>&amp;amp;title=<?php echo urlencode(the_title('','', false)) ?>"><img src="http://toastable.com/wp-content/themes/thesis_18b1/custom/images/social_icons/reddit.png" alt="Bookmark on Reddit"></a>
<a class="sociallinks" href="http://stumbleupon.com/submit?url=<?php the_permalink() ?>&amp;amp;title=<?php echo urlencode(the_title('','', false)) ?>"><img src="http://toastable.com/wp-content/themes/thesis_18b1/custom/images/social_icons/stumbleupon.png" alt="Bookmark on Stumbleupon"></a>
<a class="sociallinks" href="http://technorati.com/faves?add=<?php the_permalink() ?>&amp;amp;title=<?php echo urlencode(the_title('','', false)) ?>"><img src="http://toastable.com/wp-content/themes/thesis_18b1/custom/images/social_icons/technorati.png" alt="Bookmark on Technorati"></a>
</div>
<?php };
add_action('thesis_hook_after_content', 'social_media_links');
*/

//NO COMMENTS
remove_action('thesis_hook_after_post', 'thesis_comments_link');

//Post Box
function post_footer() {
        if (is_single())
        {
        ?>
        <div class="postauthor">
                <?php echo get_avatar( get_the_author_id() , 100 ); ?>
                <h4>Meet <a href="<?php the_author_url(); ?>">Earl</a></h4>
                <p><?php the_author_description(); ?></p>
                <p class="hlight">Don't leave! Read one of the other articles on Toastable!</p>
        </div>

        <div id="similar">
                <h3>You May Also Be Interested In...</h3><br />
                <div style="margin-left:30px;"><?php related_entries() ?></div>
        </div>

        <div id="rightcol">
                <div id="subscribe">
                        <h3>Subscribe Now</h3>
                        <p>If you enjoyed this post, please subscribe to get notifications about new posts!</p>
                        <ul>
                                <li><a href="http://feeds.feedburner.com/Toastable">Subscribe to our RSS Feed</a></li>
                                <li><a href="http://twitter.com/earlvlee">Follow me on Twitter</a></li>
                                <li><a href="http://facebook.com/earlvlee">Friend me on Facebook</a></li>
                  </ul>
                        <div id="custom"><h3>Subscribe via email</h3><br />
	<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=Toastable', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><input type="text" value="Your email address" onfocus="if (this.value == 'Your email address') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Your email address';}"style="width:140px" name="email"/><input type="hidden" value="Toastable" name="uri"/><input type="hidden" name="loc" value="en_US"/><input type="submit" value="Subscribe"/></form>
		</div>
                </div>
        </div>
        <?php
        }
}
        add_action('thesis_hook_after_post_box', 'post_footer');
		
		//SOCIAL MEDIA ICONS BAR
		
function social_icons(){
  if(is_single()){
$twitter='earlvlee';
	global $post;
?>
			<div class="social">
					<strong>Spread it!</strong>

				<div class="social_button dg">
                	<a class="DiggThisButton"><img src="http://digg.com/img/diggThisCompact.png" height="18" width="120" alt="DiggThis" /></a>
                </div>

                <div class="social_button tm">
				<script type="text/javascript">	tweetmeme_source = '<?php echo $twitter; ?>';	tweetmeme_style = 'compact';	</script>
				<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>
                </div>

                <div class="social_button fb">
                <a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php">Share</a>
                </div>

                <div class="social_button su">
                <a href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" id="stumbleupon" target="_blank"><img src="http://cdn.stumble-upon.com/images/badgeStumble.png" alt="submit to Stumble Upon"/>
                </a>
                </div>
                <div class="social_button em">
              <a href="mailto:?subject=Sharing: <?php the_title(); ?>&body=I wanted to share this with you. Thought you might enjoy it:%0A%0A<?php the_permalink(); ?>" title="Email This" target="_blank">Email This</a>
              </div>
			</div>
			<div class="clear"></div>
			<? 

			function digg_footer(){
				echo '<script src="http://digg.com/tools/diggthis.js" type="text/javascript"></script>';
				echo '<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>';
					}
			add_action('wp_footer','digg_footer');
   }
}
add_action('thesis_hook_before_post','social_icons'); ?>