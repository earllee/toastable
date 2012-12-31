<div class="SR">

<!-- Start SideBar1 -->
<div class="SRL">


<!-- Start Search -->
<div class="Search">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="text" name="s" class="keyword" />
<div class="bt">
<input name="submit" type="image" class="search" title="Search" src="<?php bloginfo('template_url'); ?>/images/ButtonTransparent.png" alt="Search" />
</div>
</form>
<div class="Syn">
 <ul>
  <li><a href="<?php bloginfo('rss2_url'); ?>">Subscribe to RSS</a></li>

 </ul>
</div>
</div>
<!-- End Search -->

<!-- Start About This Blog -->
<?php include (TEMPLATEPATH . "/about-blog.php"); ?>
<!-- End About This Blog -->



<!-- Start Recent Comments/Articles -->
<div class="Recent">
<ul class="TabMenu">
 <li class="TabLink"><a href="#top" id="tab0" onclick="ShowTab(0)"><span>Featured Posts</span></a></li>
 <li class="TabLink"><a href="#top" id="tab1" onclick="ShowTab(1)"><span>Recent Articles</span></a></li>
 <li class="NavLinks" id="paging0"><div style="display:none"></div></li>
 <li class="NavLinks" id="paging1"><div style="display:none"></div></li>
</ul>
<?php if (function_exists('featuredpostsList2')) { ?>
<div class="TabContent" style="display:none" id="div0">
 <ul>
 <?php featuredpostsList2(); ?> 
 </ul>
</div>
<?php } ?>
<?php if (function_exists('mdv_recent_posts')) { ?>
<div class="TabContent" style="display: none" id="div1">	
 <ul>
  <?php mdv_recent_posts(); ?>
 </ul>
</div>
<?php } ?>
<script type="text/javascript">ShowTab(0);</script>
</div>
<!-- End Recent Comments/Articles -->

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
<?php endif; ?>



<!-- Start Lifestream -->

<div class="widget widget_flickrrss" style="border-bottom: none;">
  <ul>
   <?php lifestream(); ?>
  </ul>
</div>

<!-- End Lifestream -->

<br clear="all" />

</div>
<!-- End SideBar1 -->

<!-- Start SideBar2 -->
<div class="SRR">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>	



<!-- Start Flickr Photostream -->
<?php if (function_exists('get_flickrrss')) { ?>
<div class="widget widget_flickrrss" style="border-bottom: none;">
  <ul>
   <?php get_flickrrss(); ?> 
  </ul>
</div>
<?php } ?>
<!-- End Flickr Photostream -->

<?php endif; ?>
</div>
<!-- End SideBar2 -->

</div>