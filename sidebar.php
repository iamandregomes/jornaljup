<?php global $herald_sidebar_opts; ?>
<?php if( $herald_sidebar_opts['use_sidebar'] != 'none') : ?>
	<div class="herald-sidebar col-lg-3 col-md-3 herald-sidebar-<?php echo esc_attr($herald_sidebar_opts['use_sidebar']); ?>">
		<?php if ( is_active_sidebar( $herald_sidebar_opts['sidebar'] ) ) : ?>
			<?php dynamic_sidebar( $herald_sidebar_opts['sidebar'] ); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>