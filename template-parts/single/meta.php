<?php $meta_bar_position = herald_get_single_meta_bar_position(); ?>
<?php if( $meta_bar_position != 'none') : ?>
	<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs <?php echo esc_attr( 'herald-'.$meta_bar_position); ?>">
		<div class="entry-meta-wrapper">
		<?php if(herald_get_option('single_avatar')): ?>
			<div class="entry-meta-author">	
				<?php echo get_avatar( get_the_author_meta('ID'), 112 ); ?>
				<p class="herald-author-name"><?php coauthors_posts_links(); ?></p>
					<?php if( $twitter_url = get_the_author_meta('twitter') ) : ?>
						<?php 
							$pos = strpos($twitter_url, '@');
							$twitter_url = 'https://twitter.com/'.substr($twitter_url,$pos, strlen($twitter_url));
					?>
					<a class="herald-author-twitter" href="<?php echo esc_url( $twitter_url ); ?>" target="_blank"><?php echo basename($twitter_url); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if( $meta = herald_get_meta_data( 'single_big' ) ) : ?>
			<div class="entry-meta entry-meta-single"><?php echo $meta; ?></div>
		<?php endif; ?>
		<?php if( herald_get_option('single_share') ): ?>
			<?php get_template_part('template-parts/single/share'); ?>
		<?php endif; ?>
		<?php if( herald_get_post_display( 'tags' ) && has_tag() ) : ?>
			<p style="font-family:Georgia, serif;"><span ><?php echo "Mais sobre:"; ?></span></p>
			<p style="text-transform: capitalize;"><?php the_tags( false, ' ', false ); ?></p>
		<?php endif; ?>
		</div>
	</div>
<?php endif; ?>