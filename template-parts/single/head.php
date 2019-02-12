<header class="entry-header">
	<?php if( herald_get_option('single_cat')) : ?>
		<span class="meta-category"><?php echo herald_get_category(); ?></span>
	<?php endif; ?>
	<?php the_title( '<h1 class="entry-title h1">', '</h1>' ); ?>
	<?php if( $meta = herald_get_meta_data( 'single' ) ) : ?>
		<div class="entry-meta entry-meta-single"><?php echo $meta; ?></div>
	<?php endif; ?>
	<p>
	<strong><?php if(get_field('manchete'))
		{
			echo '<div class="entry-summary">' . get_field('manchete') . '</div>';
		} ?></strong>
</header>