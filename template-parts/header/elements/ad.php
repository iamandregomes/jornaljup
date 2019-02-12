<?php if( $ad = herald_get_option('ad_header') ): ?>
	<div class="herald-ad hidden-xs"><?php echo do_shortcode( $ad ); ?></div>
<?php endif; ?>