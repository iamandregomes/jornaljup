<?php
add_action( 'widgets_init', 'herald_register_sidebars' );
if ( !function_exists( 'herald_register_sidebars' ) ) :
	function herald_register_sidebars() {
		register_sidebar(
			array(
				'id' => 'herald_default_sidebar',
				'name' => esc_html__( 'Barra pre-definida', 'herald' ),
				'description' => esc_html__( 'Barra lateral padrao.', 'herald' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title h6"><span>',
				'after_title' => '</span></h4>'
			)
		);
		register_sidebar(
			array(
				'id' => 'herald_footer_sidebar_1',
				'name' => esc_html__( 'Coluna 1', 'herald' ),
				'description' => esc_html__( 'Caixa do rodape 1.', 'herald' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title h6"><span>',
				'after_title' => '</span></h4>'
			)
		);
		register_sidebar(
			array(
				'id' => 'herald_footer_sidebar_2',
				'name' => esc_html__( 'Coluna 2', 'herald' ),
				'description' => esc_html__( 'Caixa do rodape 2.', 'herald' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title h6"><span>',
				'after_title' => '</span></h4>'
			)
		);
		register_sidebar(
			array(
				'id' => 'herald_footer_sidebar_3',
				'name' => esc_html__( 'Coluna 3', 'herald' ),
				'description' => esc_html__( 'Caixa do rodape 3.', 'herald' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title h6"><span>',
				'after_title' => '</span></h4>'
			)
		);
		register_sidebar(
			array(
				'id' => 'herald_footer_sidebar_4',
				'name' => esc_html__( 'Coluna 4', 'herald' ),
				'description' => esc_html__( 'Caixa do rodape 4.', 'herald' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title h6"><span>',
				'after_title' => '</span></h4>'
			)
		);
	}
endif;
add_action( 'wp', 'herald_set_current_sidebar' );
if ( !function_exists( 'herald_set_current_sidebar' ) ):
	function herald_set_current_sidebar() {
		global $herald_sidebar_opts;
		$use_sidebar = 'none';
		$sidebar = 'herald_default_sidebar';
		$sticky_sidebar = 'herald_default_sticky_sidebar';
		$herald_template = herald_detect_template();
		if ( in_array( $herald_template, array( 'search', 'tag', 'author', 'archive', 'product', 'product_cat', 'forum', 'topic' ) ) ) {
			$use_sidebar = herald_get_option( $herald_template.'_use_sidebar' );
			if ( $use_sidebar != 'none' ) {
				$sidebar = herald_get_option( $herald_template.'_sidebar' );
				$sticky_sidebar = herald_get_option( $herald_template.'_sticky_sidebar' );
			}
		} else if ( $herald_template == 'category' ) {
				$obj = get_queried_object();
				if ( isset( $obj->term_id ) ) {
					$meta = herald_get_category_meta( $obj->term_id );
				}
				if ( $meta['use_sidebar'] != 'none' ) {
					$use_sidebar = ( $meta['use_sidebar'] == 'inherit' ) ? herald_get_option( $herald_template.'_use_sidebar' ) : $meta['use_sidebar'];
					if ( $use_sidebar ) {
						$sidebar = ( $meta['sidebar'] == 'inherit' ) ?  herald_get_option( $herald_template.'_sidebar' ) : $meta['sidebar'];
						$sticky_sidebar = ( $meta['sticky_sidebar'] == 'inherit' ) ?  herald_get_option( $herald_template.'_sticky_sidebar' ) : $meta['sticky_sidebar'];
					}
				}
			} else if ( $herald_template == 'single' ) {
				$meta = herald_get_post_meta();
				$use_sidebar = ( $meta['use_sidebar'] == 'inherit' ) ? herald_get_option( $herald_template.'_use_sidebar' ) : $meta['use_sidebar'];
				if ( $use_sidebar != 'none' ) {
					$sidebar = ( $meta['sidebar'] == 'inherit' ) ?  herald_get_option( $herald_template.'_sidebar' ) : $meta['sidebar'];
					$sticky_sidebar = ( $meta['sticky_sidebar'] == 'inherit' ) ?  herald_get_option( $herald_template.'_sticky_sidebar' ) : $meta['sticky_sidebar'];
				}
			} else if ($herald_template == 'page' ) {
				$meta = herald_get_page_meta();
				$use_sidebar = ( $meta['use_sidebar'] == 'inherit' ) ? herald_get_option( 'page_use_sidebar' ) : $meta['use_sidebar'];
				if ( $use_sidebar != 'none' ) {
					$sidebar = ( $meta['sidebar'] == 'inherit' ) ?  herald_get_option( 'page_sidebar' ) : $meta['sidebar'];
					$sticky_sidebar = ( $meta['sticky_sidebar'] == 'inherit' ) ?  herald_get_option( 'page_sticky_sidebar' ) : $meta['sticky_sidebar'];
				}
			}
		$herald_sidebar_opts = array(
			'use_sidebar' => $use_sidebar,
			'sidebar' => $sidebar,
			'sticky_sidebar' => $sticky_sidebar
		);
	}
endif;
?>