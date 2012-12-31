<div class="yarpp"><?php /*
List template
This template returns the related posts as a comma-separated list.
Author: mitcho (Michael Yoshitaka Erlewine)
*/ 
?><h3>Related Posts</h3>
<ul>
<?php if ($related_query->have_posts()):
	$postsArray = array();
	while ($related_query->have_posts()) : $related_query->the_post();
		$postsArray[] = '<li><a href="'.get_permalink().'" rel="bookmark">'.get_the_title().'</a></li>';
	endwhile;
	
echo implode(', '."\n",$postsArray); // print out a list of the related items, separated by commas

else:?>
</ul>
<p>No related posts.</p>
<?php endif; ?>
</div>