<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

<div class="post">
  <h1>The Archives</h1>
  It's probably in here somewhere. Have a look around. Explore the archives by author, time, and category. Or give the search on the right a spin.<br/>
  <br/>
  <h2>By Author</h2>
  <?php list_authors(TRUE, FALSE, TRUE); ?>

  <br style="clear:both;" />

  <h2>Archives by Month:</h2>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>
  <br />
  <h2>Archives by Subject:</h2>
  <ul>
    <?php wp_list_cats(); ?>
  </ul>
</div>
<!-- end post -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
