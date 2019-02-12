<div id="herald-responsive-header" class="herald-responsive-header herald-slide hidden-lg hidden-md">
	<div class="container">
		<div class="herald-nav-toggle"><i class="fa fa-bars"></i></div>
		<?php $logo = herald_get_option('logo_mini') ? 'logo-mini' : 'logo'; ?>
		<?php get_template_part('template-parts/header/elements/'.$logo ); ?>
		<?php get_template_part('template-parts/header/elements/search-drop'); ?>
	</div>
</div>
<div class="herald-mobile-nav herald-slide hidden-lg hidden-md">
	<?php wp_nav_menu( array( 'theme_location' => 'herald_main_menu', 'container'=> '', 'menu_class' => 'herald-mob-nav' ) ); ?>
</div>