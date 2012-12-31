<?php get_header(); ?>
<!-- Container -->
<div class="CON">

<!-- Start SC -->
<div class="SC">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="Post" id="post-<?php the_ID(); ?>" style="padding-bottom: 40px;">

<div class="PostHead">
<h2><a title="Permanent Link to <?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<small class="PostTime">
<strong class="day"><?php the_time('j') ?></strong>
<strong class="month"><?php the_time('M') ?></strong>
<strong class="year"><?php the_time('Y') ?></strong>
</small>
<small class="PostAuthor">Author: <?php the_author() ?></small>
<small class="PostCat">In: <?php the_category(', ') ?></small>
</div>
  
<div class="PostContent">
<?php the_content('Read the rest of this entry &raquo;'); ?>
</div>

<div class="PostCom">
<ul>
 <li class="Com"><?php comments_popup_link('0 Comments', '1 Comment', '% Comments'); ?></li>
 <?php if (function_exists('the_tags')) { ?> <?php the_tags('<li class="Tags">Tags: ', ', ', '</li>'); ?> <?php } ?>
</ul>
</div>
</div>

<!--<?php trackback_rdf(); ?>-->
<div class="clearer"></div>
<?php endwhile; ?>
  
<!-- Start Nav -->
<?php if (function_exists('wp_pagenavi')) { ?><?php wp_pagenavi(); ?><?php } ?>
<!-- End Nav -->

<?php else : ?>
<h2><?php _e('Not Found'); ?></h2>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div> 
<!-- End SC -->


<?php if (function_exists('trackTheme')) { ?>
 <?php get_sidebar(); ?><?php trackTheme("dilectio");  ?>
<?php } ?>

<?php get_sidebar(); ?>
<!-- Container -->
</div>

<?php get_footer(); ?>
