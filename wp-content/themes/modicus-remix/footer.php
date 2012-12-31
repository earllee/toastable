<br style="clear:both;" />
<?php wp_footer(); ?>
<div id="footer2"> 
  <div class="blackbar" style="text-transform:uppercase;">
    <ul class="nav">
      <?php
wp_list_pages('title_li='); ?>
    </ul>
    &copy;  Copyright 2010 <a href="<?php echo get_option('home'); ?>/">
    <?php bloginfo('name'); ?>
    </a>. Thanks for visiting!</div>
  <br />
</div>
<!-- end footer -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-10750769-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body></html>