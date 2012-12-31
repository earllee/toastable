<div id="sidebar">
  <?php if (is_single()) { ?>
  <?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) ?>
  <div style="float:right;margin:3px 0px 0px 3px;"><a href="/author/<?php the_author_login(); ?>" title="<?php echo $curauth->display_name; ?>"> <?php echo get_avatar(get_the_author_email(), '25'); ?> </a></div><small>Posted on <span style="font-weight:bold; color:#00bf94;">
  <?php the_time('m.d.y') ?>
  </span> to
  <?php the_category(', ') ?>
  by <a href="/index.php?author=<?php the_author_ID(); ?>">
  <?php the_author_nickname(); ?>
  </a></small>
  <h1><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
    <?php the_title(); ?>
    </a> </h1>
  <p class="postmetadata alt"> <small> View all posts by <a href="/index.php?author=<?php the_author_ID(); ?>">
    <?php the_author_nickname(); ?>
    </a>.
    <?php comments_rss_link('Subscribe'); ?>
    to follow comments on this post.
    <?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
    <a href="#respond">Add your thoughts</a> or <a href="<?php trackback_url(true); ?>" rel="trackback">trackback</a> from your own site.
    <?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
    Responses are currently closed, but you can <a href="<?php trackback_url(true); ?> " rel="trackback">trackback</a> from your own site.
    <?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {

							// Comments are open, Pings are not ?>
    You can skip to the end and leave a response. Pinging is currently not allowed.
    <?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
    Both comments and pings are currently closed.
    <?php } edit_post_link('Edit this entry.','',''); ?>
    </small> </p>
  <?php } ?>
  <?php if (is_search()) { ?>
  <?php } ?>
  <?php if (is_404()) { ?>
  <h1>404. Fiddle-de-dee, file not found.</h1>
  <p> <small> Fiddlesticks. </small> </p>
  <?php } ?>
  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
  <?php /* If this is a category archive */ if (is_category()) { ?>
  <h1>Archive for the &#8216;
    <?php single_cat_title(); ?>
    &#8217; Category</h1>
  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
  <h1>Archive for
    <?php the_time('F jS, Y'); ?>
  </h1>
  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
  <h1>Archive for
    <?php the_time('F, Y'); ?>
  </h1>
  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
  <h1>Archive for
    <?php the_time('Y'); ?>
  </h1>
  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
  <h1>Posts Tagged &#8216;
    <?php single_tag_title(); ?>
    &#8217;</h1>
  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
  <h1>Author Archive for
    <?php the_author_posts_link(); ?>
  </h1>
  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h1>Blog Archives</h1>
    <?php /* If this is the archives page */ } elseif (is_page('Archives')) { ?>
    <?php } ?>
    
    
	/* here starts the side bar */ 


<ul>  
<li>
    <h2>Socialize
      </h2>
    <span style="color:#F44040;">
<a href="<?php bloginfo('rss2_url'); ?>"<img src="http://toastable.com/wp-content/themes/modicus-remix/images/rss_32.png"></a>
<a href="http://www.flickr.com/photos/frapelkc/"<img src="http://toastable.com/wp-content/themes/modicus-remix/images/flickr_32.png"></a>
<a href="http://delicious.com/frapelkc"<img src="http://toastable.com/wp-content/themes/modicus-remix/images/delicious_32.png"></a>
<a href="http://toastable.tumblr.com/"<img src="http://toastable.com/wp-content/themes/modicus-remix/images/tumblr_32.png"></a>
    </span>
    <div style="margin-top:15px;">
      <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    </div>
  </li>

  <?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar(1) ) : ?>
  <?php endif; ?>
  <li>
<script type="text/javascript"><!--
google_ad_client = "pub-9005201729731795";
/* 300x250, modicus-remix theme */
google_ad_slot = "0336658519";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
  </li>
</ul>
  <div class="bluebox">
    <!--Don't be uncool. Leave the theme credit. :) -->
    <small>Wordpress theme "<a href="http://www.zidalgo.com/modicus-remix-wordpress-theme" title="Minimalistic Wordpress Theme">Modicus Remix</a>" by <a href="http://www.zidalgo.com" title="Premium Wordpress Themes">Zidalgo</a>.</small></div>
</div>
<!-- end sidebar -->
