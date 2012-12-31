<?php
/**
 * The right, additional Sidebar containing the secondary widget areas (some default hard-coded widgets are included).
 */
?>

<div id="sidebar-secondary">
	<ul class="sidebar">

	<?php if ( ! dynamic_sidebar( 'secondary-widget-area' ) ) : ?>
				
		<?php wp_list_categories('title_li=<h3 class="widget-title">' . __('Categories') . '</h3>' ); ?>
			
		<li class="widget-container">
		<h3 class="widget-title"><?php _e( 'Archives', 'ari' ); ?></h3>
			<ul>
				<?php wp_get_archives( 'type=monthly' ); ?>
			</ul>
		</li>
			
		<li class="widget-container">
		<h3 class="widget-title"><?php _e( 'Search', 'ari' ); ?></h3>
			<ul>
				<?php get_search_form(); ?>
			</ul>
		</li>
			
		<li class="widget-container">
		<h3 class="widget-title"><?php _e( 'Meta', 'ari' ); ?></h3>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</li>

	<?php endif; // end secondary widget area ?>
	</ul>

</div>
<!--end Sidebar Secondary-->