<?php
add_action( 'wp_enqueue_scripts', 'herald_load_scripts' );
function herald_load_scripts() {
	herald_load_css();
	herald_load_js();
}
function herald_load_css() {
	if( $fonts_link = herald_generate_fonts_link() ){
		wp_enqueue_style( 'herald-fonts', $fonts_link, false, HERALD_THEME_VERSION );
	}
	if(	herald_get_option('minify_css') ){
		wp_enqueue_style( 'herald-main', get_template_directory_uri() . '/assets/css/jup.css' );
	} else {
		$styles = array( 
			'font-awesome' => 'font-awesome.css',
			'bootstrap' => 'bootstrap.css',
			'magnific-popup' => 'magnific-popup.css',
			'owl-carousel' => 'owl.carousel.css',
			'main' => 'main.css'
		);
		foreach ($styles as $id => $style ){
			wp_enqueue_style( 'herald-'.$id, get_template_directory_uri() . '/assets/css/' . $style, false, HERALD_THEME_VERSION );
		}
	}
	wp_add_inline_style( 'herald-main', herald_generate_dynamic_css() );
	wp_dequeue_style( 'mks_shortcodes_fntawsm_css' );	
}
function herald_load_js() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if(	herald_get_option('minify_js') ){	
		wp_enqueue_script( 'herald-main', get_template_directory_uri() . '/assets/js/min.js', array( 'jquery' ), HERALD_THEME_VERSION, true );
	} else {
		$scripts = array( 
			'imagesloaded' => 'imagesloaded.js',
			'fitvids' => 'jquery.fitvids.js',
			'magnific-popup' => 'jquery.magnific-popup.js',
			'sticky-kit' => 'jquery.sticky-kit.js',
			'owl-carousel' => 'owl.carousel.js',
			'main' => 'main.js'
		);
		foreach ($scripts as $id => $script ){
			wp_enqueue_script( 'herald-'.$id, get_template_directory_uri().'/assets/js/'. $script, array( 'jquery' ), HERALD_THEME_VERSION, true );
		}
	}
	wp_localize_script( 'herald-main', 'herald_js_settings', herald_get_js_settings() );
}
?>