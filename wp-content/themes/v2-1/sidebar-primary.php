<?php
/**
 * The left fixed Sidebar containing the primary widget areas (some default hard-coded widgets are included).
 */
?>

	<ul id="sidebar_left" class="sidebar">

	<?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>
			
			<?php wp_list_pages('title_li=<h3 class="widget-title">' . __('Pages') . '</h3>'); ?>

	<?php endif; // end primary widget area ?>
	</ul>
	<!--end Sidebar -->
