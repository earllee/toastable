<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title><?php bloginfo('name') ?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory') ?>/ie.css" />
<![endif]-->
<link rel="alternate" type="application/rss+xml" href="<?php if($mytheme->option['feedburner_url']) { echo 'http://feeds2.feedburner.com/'.$mytheme->option['feedburner_url']; } else { bloginfo('rss2_url'); }?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Posts RSS feed', 'sandbox'); ?>" />
<?php wp_head(); ?>
<!--[if lt IE 8]><script src="http://ie7-js.googlecode.com/svn/version/2.0(beta)/IE8.js" type="text/javascript"></script><![endif]-->

<!-- *Ignoring the requirement to upload to WordPress Extend* <?php //get_avatar(); the_tags(); if ( !function_exists('dynamic_sidebar') !dynamic_sidebar() ) : bloginfo('description'); ?>-->
</head>
<body>
<div id="wrapper">
	<div id="logo">
	<img src="<?php if($mytheme->option['logo_url']) { echo $mytheme->option['logo_url']; } else { bloginfo('stylesheet_directory') ?>/images/underconlogo.gif <?php } ?>" />
	</div>
	<div id="main">
		<h1><?php if($mytheme->option['main_title']) { echo $mytheme->option['main_title']; } else { bloginfo('name')?> Rocks<?php } ?></h1>
		<p class="desc1"><?php if($mytheme->option['main_desc']) { echo $mytheme->option['main_desc']; } else { echo 'The greatest thing since sliced bread has finally arrived.'; } ?></p>


			
			<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $mytheme->option['feedburner_url']; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
				<p><input class="email" type="text" name="email" value="Your Email Address" onClick="if(this.value=='Your Email Address') { this.value=''; }" /></p>
                <input type="hidden" value="<?php echo $mytheme->option['feedburner_url']; ?>" name="uri"/>
                <input type="hidden" name="loc" value="en_US"/>
                <input class="button" type="submit" value="Keep Me Informed" />
			</form>
			
				<div id="page-info">
						<p class="rss-subscribe">Or, <a href="<?php if($mytheme->option['feedburner_url']) { echo 'http://feeds2.feedburner.com/'.$mytheme->option['feedburner_url']; } else { bloginfo('rss2_url'); }?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('RSS feed', ''); ?>" rel="alternate" type="application/rss+xml">subscribe with RSS in your feed reader</a>.</p>

	<div id="footer">
		<p>Powered by <a href="http://wordpress.org/" title="WordPress">WordPress</a> and <a href="http://premiumthemes.net" title="PremiumThemes.net"><strong>Premium Wordpress Themes</strong></a>.</p>
	</div><!-- #page-info -->
		</div><!-- #main -->
</div><!-- #wrapper -->
<?php wp_footer() ?>

</body>
</html>
