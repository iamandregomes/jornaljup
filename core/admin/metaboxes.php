<?php
add_action( 'load-post.php', 'herald_meta_boxes_setup' );
add_action( 'load-post-new.php', 'herald_meta_boxes_setup' );
if ( !function_exists( 'herald_meta_boxes_setup' ) ) :
	function herald_meta_boxes_setup() {
		global $typenow, $post;
		if ( $typenow == 'page' ) {
			$page_id = isset($_GET['post']) ? $_GET['post'] : 0;
			if( $page_id !== get_option( 'page_for_posts' )){
				add_action( 'add_meta_boxes', 'herald_load_page_metaboxes' );
				add_action( 'save_post', 'herald_save_page_metaboxes', 10, 2 );
			}
		}
	}
endif;
include_once( get_template_directory().'/core/admin/metaboxes/page.php'); //paginas
include_once( get_template_directory().'/core/admin/metaboxes/post.php'); //artigos
include_once( get_template_directory().'/core/admin/metaboxes/category.php'); //categorias
?>