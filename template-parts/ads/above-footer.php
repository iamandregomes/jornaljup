<?php if( $ad = herald_get_option('ad_above_footer') ): ?>
	<div class="herald-ad herald-slide herald-above-footer"><?php echo do_shortcode( $ad ); ?></div>
<?php endif; ?>