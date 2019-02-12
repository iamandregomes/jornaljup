<?php
if ( !function_exists( '__herald' ) ):
	function __herald( $string_key ) {
		if ( ( $translated_string = herald_get_option( 'tr_'.$string_key ) ) && herald_get_option( 'enable_translate' ) ) {
			if ( $translated_string == '-1' ) {
				return "";
			}
			return $translated_string;
		} else {
			$translate = herald_get_translate_options();
			return $translate[$string_key]['text'];
		}
	}
endif;

/**
 * Imagem de destaque
 *
 * Esta função obtém a imagem de destaque independentemente do tamanho.
 * Caso não exista uma imagem de destaque irá ser utilizada a imagem "placeholder" definida nos parametros do framework.
 */
if ( !function_exists( 'herald_get_featured_image' ) ):
	function herald_get_featured_image( $size = 'large', $post_id = false, $ignore_default_img = false  ) {
		global $herald_sidebar_opts, $herald_img_flag, $herald_image_matches;
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		if ( $herald_img_flag == 'full' || ( $herald_sidebar_opts['use_sidebar'] == 'none' && $herald_img_flag != 'sid' ) ) {
			$size .= '-full';
		}
		if ( !empty( $herald_image_matches ) && array_key_exists( $size, $herald_image_matches ) ) {
			$size = $herald_image_matches[$size];
		}
		if ( has_post_thumbnail( $post_id ) ) {
			return get_the_post_thumbnail( $post_id, $size );
		} else if ( !$ignore_default_img && ( $placeholder = herald_get_option( 'default_fimg' ) ) )  {

				//Se não existe imagem de destaque ir buscar ao "placeholder"
				global $placeholder_img, $placeholder_imgs;
				if ( empty( $placeholder_img ) ) {
					$img_id = herald_get_image_id_by_url( $placeholder );
				} else {
					$img_id = $placeholder_img;
				}
				if ( !empty( $img_id ) ) {
					if ( !isset( $placeholder_imgs[$size] ) ) {
						$def_img = wp_get_attachment_image( $img_id, $size );
					} else {
						$def_img = $placeholder_imgs[$size];
					}
					if ( !empty( $def_img ) ) {
						$placeholder_imgs[$size] = $def_img;
						return $def_img;
					}
				}
				return '<img src="'.esc_attr($placeholder).'" alt="'.esc_attr( get_the_title( $post_id ) ).'" />';
			}
		return false;
	}
endif;

/**
 * Obter seccão dos posts
 * Esta função obtém a seccão da notícia e coloca-a na respectiva editoria
 */
if ( !function_exists( 'herald_get_category' ) ):
	function herald_get_category() {
		$output = '';
		$cats = get_the_category();
		if ( !empty( $cats ) ) {
			foreach ( $cats as $k => $cat ) {
				$output.= '<a href="'.esc_url( get_category_link( $cat->term_id ) ).'" class="herald-cat-'.$cat->term_id.'">'.$cat->name.'</a>';
				if ( ( $k + 1 ) != count( $cats ) ) {
					$output.= ' <span>&bull;</span> ';
				}
			}
		}
		return $output;
	}
endif;

/* Obter meta dados */
if ( !function_exists( 'herald_get_meta_data' ) ):
	function herald_get_meta_data( $layout = 'a', $force_meta = false ) {
		$meta_data = $force_meta !== false ? $force_meta : array_keys( array_filter( herald_get_option( 'lay_'.$layout .'_meta' ) ) );
		$output = '';
		if ( !empty( $meta_data ) ) {
			$has_time = in_array('time', $meta_data) ? true : false;
			$has_date = in_array('date', $meta_data) ? true : false;
			$time_added = false;
			foreach ( $meta_data as $mkey ) {
				$meta = '';
				switch ( $mkey ) {
				case 'date':
					
					if( $has_time ){
						$time = ' '.get_the_time();
						$time_added = true;
					} else {
						$time = '';
					}
					
					$meta = '<span class="updated">'.get_the_date().$time.'</span>';
					break;

				case 'time':
					if(!$time_added && !$has_date){
						$meta = '<span class="updated">'.get_the_time().'</span>';
					}
					break;
					
				case 'author':
					$author_id = get_post_field( 'post_author', get_the_ID() );
					$meta = '<span class="vcard author"><span class="fn"><a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) ).'">'.get_the_author_meta( 'display_name', $author_id ).'</a></span></span>';
					break;

				case 'views':
					global $wp_locale;
					$thousands_sep = isset( $wp_locale->number_format['thousands_sep'] ) ? $wp_locale->number_format['thousands_sep'] : ',';
					if( strlen( $thousands_sep ) > 1 ) {
						$thousands_sep = trim( $thousands_sep );
					}
					$meta = function_exists( 'ev_get_post_view_count' ) ?  number_format_i18n( absint( str_replace( $thousands_sep, '', ev_get_post_view_count( get_the_ID() ) ) + herald_get_option( 'views_forgery' ) ) )  . ' '.__herald( 'views' ) : '';
					break;

				case 'rtime':
					$meta = herald_read_time( get_post_field( 'post_content', get_the_ID() ) );
					if ( !empty( $meta ) ) {
						$meta .= ' '.__herald( 'min_read' );
					}
					break;

				case 'comments':
					if ( comments_open() || get_comments_number() ) {
						ob_start();
						comments_popup_link( __herald( 'no_comments' ), __herald( 'one_comment' ), __herald( 'multiple_comments' ) );
						$meta = ob_get_contents();
						ob_end_clean();
					} else {
						$meta = '';
					}
					break;				

				default:
					break;
				}
				if ( !empty( $meta ) ) {
					$output .= '<div class="meta-item herald-'.$mkey.'">'.$meta.'</div>';
				}
			}
		}
		return $output;
	}
endif;

/**
 * Obter campo "Manchete"
 * Esta função obtém o texto do campo "manchete", caso o campo não for preenchido é apresentado os primeiros três paragrafos 
 * do corpo da noticia
 */

if ( !function_exists( 'herald_get_excerpt' ) ):
	function herald_get_excerpt( $layout = 'a' ) {
		$manual_excerpt = false;
		if ( has_excerpt() ) {
			$content =  get_the_excerpt();
			$manual_excerpt = true;
		} else {
			$text = get_the_content( '' );
			$text = strip_shortcodes( $text );
			$text = apply_filters( 'the_content', $text );
			$content = str_replace( ']]>', ']]&gt;', $text );
		}
		if ( !empty( $content ) ) {
			$limit = herald_get_option( 'lay_'.$layout.'_excerpt_limit' );
			if ( !empty( $limit ) || !$manual_excerpt ) {
				$more = herald_get_option( 'more_string' );
				$content = wp_strip_all_tags( $content );
				$content = preg_replace( '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content );
				$content = herald_trim_chars( $content, $limit, $more );
			}
			return wpautop( $content );
		}
		return '';
	}
endif;

if ( !function_exists( 'herald_get_archive_heading' ) ):
	function herald_get_archive_heading() {
		if ( is_category() ) {
			$obj = get_queried_object();
			$args['title'] = __herald( 'category' ).single_cat_title( '', false );
			$args['desc'] = herald_get_option('category_desc') ? category_description() : '';
			$args['cat'] = $obj->term_id;
			if ( herald_get_option( 'category_sub' ) ) {
				$sub = get_categories( array( 'parent' => $obj->term_id, 'hide_empty' => false ) );
				if ( !empty( $sub ) ) {
					$args['subnav'] = '';
					foreach ( $sub as $child ) {
						$args['subnav'] .= '<a href="'.esc_url( get_category_link( $child ) ).'">'.$child->name.'</a>';
					}
				}
			}

		} else if ( is_author() ) {
				$obj = get_queried_object();
				$args['title'] = __herald( 'author' ).$obj->display_name;
				if ( herald_get_option( 'author_desc' ) ) {
					$args['desc'] = wpautop( '<div class="authorpage-avatar">'.get_avatar( $obj->ID, 80 ).'</div><div class="authorpage-avatar-text"><p>'. get_the_author_meta( 'description', $obj->ID ).'</p></div>' );
				}
			} else if ( is_tax() ) {
				$args['title'] = single_term_title( '', false );
			} else if ( is_home() && ( $posts_page = get_option( 'page_for_posts' ) ) && !is_page_template( 'template-modules.php' ) ) {
				$args['title'] = get_the_title( $posts_page );
			} else if ( is_search() ) {
				$args['title'] = __herald( 'search_results_for' ).get_search_query();
				$args['desc'] = get_search_form( false );
			} else if ( is_tag() ) {
				$args['title'] = __herald( 'tag' ).single_tag_title( '', false );
				$args['desc'] = tag_description();
			} else if ( is_day() ) {
				$args['title'] = __herald( 'archive' ).get_the_date();
			} else if ( is_month() ) {
				$args['title'] = __herald( 'archive' ).get_the_date( 'F Y' );
			} else if ( is_year() ) {
				$args['title'] = __herald( 'archive' ).get_the_date( 'Y' );
			} else {
			$args['title'] = '';
			$args['desc'] = '';
		}
		if ( !empty( $args['title'] ) ) {
			$args['title'] = '<h1 class="h6 herald-mod-h herald-color">'.$args['title'].'</h1>';
		}
		if ( !empty( $args['desc'] ) ) {
			$args['desc'] = wpautop( $args['desc'] );
		}
		return herald_print_heading( $args );
	}
endif;

if ( !function_exists( 'herald_post_format_icon' ) ):
	function herald_post_format_icon() {
		$format = get_post_format();
		$icons = array(
			'video' => 'fa-play',
			'audio' => 'fa-volume-up',
		);

		//Permite plugins modificar icons do tema
		$icons = apply_filters( 'herald_post_format_icons', $icons );
		if ( $format && array_key_exists( $format, $icons ) ) {
			return '<span class="herald-format-icon"><i class="fa '.esc_attr( $icons[$format] ).'"></i></span>';
		}
		return '';
	}
endif;

if ( !function_exists( 'herald_get_post_display' ) ):
	function herald_get_post_display( $option = false, $post_id = false ) {

		if(empty($option)){
			return false;
		}
		if(!$post_id){
			$post_id = get_the_ID();
		}
		$meta = herald_get_post_meta( $post_id, 'display' );

		if(in_array($option, array('ad_below', 'ad_above'))){
			return $meta[$option];
		}
		if(array_key_exists($option, $meta)){
			$value = $meta[$option] == 'inherit' ? herald_get_option('single_'.$option) : $meta[$option];
			return $value;
		}
		return false;
	}
endif;

if ( !function_exists( 'herald_single_content_class' ) ):
	function herald_single_content_class() {
		$meta_bar_position = herald_get_single_meta_bar_position();
		return $meta_bar_position != 'none' ? 'col-lg-10 col-md-10 col-sm-10' : 'col-lg-12 col-md-12 col-sm-12';
	}
endif;

if ( !function_exists( 'herald_breadcrumbs' ) ):
	function herald_breadcrumbs( $echo = true ) {
		$breadcrumbs = '';
		
		if ( function_exists('yoast_breadcrumb') ) {
				$breadcrumbs = yoast_breadcrumb('<div id="herald-breadcrumbs" class="herald-breadcrumbs">','</div>', false );
		}

		if( $echo ){
			echo $breadcrumbs;
		} else {
			return $breadcrumbs;
		}
		
	}
endif;

?>