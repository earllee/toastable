<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<title>
<?php if (function_exists('seo_title_tag')) { seo_title_tag(); } else { bloginfo('name'); wp_title();} ?>
</title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<!-- leave this for stats -->
<style type="text/css" media="screen">
@import url( <?php bloginfo('stylesheet_url');
?> );
</style>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body>
<a name="top"></a>
<div id="wrapper">
<div id="header">
      <ul class="nav">
        <?php
wp_list_pages('title_li='); ?>
      </ul>
<h1><a href="<?php echo get_option('home'); ?>/">  
<img src="http://www.toastable.com/wp-content/themes/modicus-remix/images/headerlogo.gif" width="122" height="48">  

            </a></h1>
<br style="clear:both" />
<div id="headerstripe"></div>
</div>
<!-- end header -->
