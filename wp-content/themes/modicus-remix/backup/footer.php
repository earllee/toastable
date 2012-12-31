<br style="clear:both;" />
<?php wp_footer(); ?>
<div id="footer2"> 
  <div class="blackbar" style="text-transform:uppercase;">
    <ul class="nav">
      <?php
wp_list_pages('title_li='); ?>
    </ul>
    &copy;  Copyright 2007 <a href="<?php echo get_option('home'); ?>/">
    <?php bloginfo('name'); ?>
    </a>. Thanks for visiting!</div>
  <br />
</div>
<!-- end footer -->
</div>
<!-- end wrapper -->
</body></html>