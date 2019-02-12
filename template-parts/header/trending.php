<?php $trending = herald_get_trending_posts(); ?>
<?php if( $trending->have_posts() ) : ?>
<div class="header-trending hidden-xs hidden-sm">
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">		
			<div class="row">
				<?php herald_set_img_flag('sid'); ?>
				<?php while(  $trending->have_posts() ): $trending->the_post(); ?>
					<div class="col-lg-2 col-md-2">
						<?php if ( $fimg = herald_get_featured_image( 'thumbnail' ) ) : ?>
							<div class="herald-post-thumbnail">
								<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo $fimg; ?></a>
							</div>
						<?php endif; ?>
						<?php the_title( sprintf( '<h4 class="h6"><a href="%s">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
					</div>
				<?php endwhile; ?>
				<?php herald_set_img_flag(false); ?>
			</div>	
		</div>		
	</div>
</div>
</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>