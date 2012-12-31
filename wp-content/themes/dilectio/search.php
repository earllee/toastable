<?php get_header(); ?>
<!-- Container -->
<div class="CON">

<!-- Start SC -->
<div class="SC">

<?php if (have_posts()) : ?>
<h2 class="pagetitle">Search Results</h2>

<!-- Start Nav -->
<?php if (function_exists('wp_pagenavi')) { ?><?php wp_pagenavi('','<br />'); ?><?php } ?>
<!-- End Nav -->


<?php while (have_posts()) : the_post(); ?>
<div class="Post" id="post-<?php the_ID(); ?>" style="padding: 15px 0px;">
<div class="PostHead" style="margin-left: 0px;">
<h3><a title="Permanent Link to <?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
<small class="PostAuthor">By: <?php the_author() ?> on: <?php the_time('M j,Y') ?></small>
<small class="PostCat">In: <?php the_category(', ') ?></small>
</div>

<div class="PostContent" style="padding-top:0px;">
<?php the_excerpt() ?>
</div>

<div class="PostCom">
<ul>
 <li class="Com"><?php comments_popup_link('0 Comments', '1 Comment', '% Comments'); ?></li>
 <?php if (function_exists('the_tags')) { ?> <?php the_tags('<li class="Tags">Tags: ', ', ', '</li>'); ?> <?php } ?>
</ul>
</div>

</div>

<?php endwhile; ?>

<!-- Start Nav -->
<?php if (function_exists('wp_pagenavi')) { ?><?php wp_pagenavi('','<br /><br />'); ?><?php } ?>
<!-- End Nav -->

	<?php else : ?>

		<h2 class="pagetitle">No posts found.</h2>
		<p>Try a different search?</p>
	<?php endif; ?>
</div>
<!-- End SC -->

<?php get_sidebar(); ?>
</div>
<!-- End CON -->

<?php get_footer(); ?>