<?php
define( 'HERALD_THEME_VERSION', '1.5.2' );
if ( !isset( $content_width ) ) {
	$content_width = 1320;
}
load_theme_textdomain( 'herald', get_template_directory()  . '/languages' );
add_action( 'after_setup_theme', 'herald_theme_setup' );
function herald_theme_setup() {

	/* Suporte para thumbnails */
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );

	/* Tamanho das imagens */
	$image_sizes = herald_get_image_sizes();

	if ( !empty( $image_sizes ) ) {
		foreach ( $image_sizes as $id => $size ) {
			add_image_size( $id, $size['args']['w'], $size['args']['h'], $size['args']['crop'] );
		}
	}

	/* Tipos de artigos */
	add_theme_support( 'post-formats', array(
			'audio', 'gallery', 'image', 'video'
		) );

	/* Suporte para HTML5 */
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'automatic-feed-links' );

}

include_once ( get_template_directory() . '/core/enqueue.php' );
include_once ( get_template_directory() . '/core/helpers.php' );
include_once ( get_template_directory() . '/core/modules.php' );
include_once ( get_template_directory() . '/core/template-functions.php' );
include_once ( get_template_directory() . '/core/menus.php' );
include_once ( get_template_directory() . '/core/sidebars.php' );
include_once ( get_template_directory() . '/core/widgets.php' );
include_once ( get_template_directory() . '/core/extensions.php' );
include_once ( get_template_directory() . '/core/mega-menu.php' );

// Execução de código PHP nas widgets (rodapé)
add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}

if ( is_admin() ) {
	include_once ( get_template_directory() . '/core/admin/helpers.php' );
	include_once ( get_template_directory() . '/core/admin/enqueue.php' );
	include_once ( get_template_directory() . '/core/admin/options.php' );
	include_once ( get_template_directory() . '/core/admin/ajax.php' );
	include_once ( get_template_directory() . '/core/admin/extensions.php' );
	include_once ( get_template_directory() . '/core/admin/metaboxes.php' );
}

// Remove caracteres especiais das imagens
function sanitize_filename_on_upload($filename) {
$ext = end(explode('.',$filename));
$sanitized = preg_replace('/[^a-zA-Z0-9-_.]/','', substr($filename, 0, -(strlen($ext)+1)));
$sanitized = str_replace('.','-', $sanitized);
return strtolower($sanitized.'.'.$ext);
}

add_filter('sanitize_file_name', 'sanitize_filename_on_upload', 10);

// Autenticação personalizada do JUP
function my_custom_login_logo() {
    echo '<style type="text/css">
    body.login { background-color: #000;}
        h1 a { background-image:url(/wp-content/uploads/2013/12/jup.png) !important; background-size: 201px 101px !important; width:100% !important; height: 101px !important; }
         .login form {background:transparent !important; border:0px !important; -moz-box-shadow: rgba(200,200,200,0) 0 0px 0px 0px;
-webkit-box-shadow: rgba(255, 255, 255, 0) 0 0px 0px 0px;
box-shadow: rgba(200, 200, 200, 0) 0 0px 0px 0px; }
.login form .input, .login input[type="text"] {background:#000 !important; }
.login #nav a, .login #backtoblog a {color:#fff !important; text-shadow: none !important; }
.login #nav a:hover, .login #backtoblog a:hover {color:#999 !important; }
input.button-primary, button.button-primary, a.button-primary {border-color: #fff !important;
background: #fff !important; color:#000 !important; text-shadow: rgba(0, 0, 0, 0) 0 0px 0 !important;
-webkit-box-shadow: inset 0 0px 0 rgba(120,200,230,0.0) !important;
box-shadow: inset 0 0px 0 rgba(120,200,230,0.0) !important;}
input.button-primary:hover, button.button-primary:hover, a.button-primary:hover {border-color: #fff !important;
background: #999 !important; color:#000 !important; text-shadow: rgba(0, 0, 0, 0) 0 0px 0 !important;}
.login label {
color: #fff !important;
font-size: 14px;
}
    </style>';
}

add_action('login_head', 'my_custom_login_logo');
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
    return 'http://www.juponline.pt/';
}
// Redirecionamento para HelpDesk do JUP
add_filter( 'lostpassword_url',  'wdm_lostpassword_url', 10, 0 );
function wdm_lostpassword_url() {
   return ('https://helpdesk.njap.pt/index.php?a=add');
}

add_action( 'admin_menu', 'linked_url' );
function linked_url() {
 add_menu_page( 'linked_url', 'HelpDesk', 'read', 'HelpDeskJUP', '', 'dashicons-text', 100 );
}

add_action( 'admin_menu' , 'linkedurl_function' );
 function linkedurl_function() {
	global $menu;
	$menu[100][2] = "https://helpdesk.njap.pt/index.php?a=add";
}

/* -----------------------------------------------------------------------------
* Alteração de URL da pagina de autor
* -------------------------------------------------------------------------- */
add_action('init', 'cng_author_base');
function cng_author_base() {
    global $wp_rewrite;
    $author_slug = 'perfil';
    $wp_rewrite->author_base = $author_slug;
}

/* -----------------------------------------------------------------------------
 * Desactivar Actualizações do WordPress devido ao bug na versão 4.7
 * -------------------------------------------------------------------------- */

function remove_core_updates(){
global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');

add_action( 'admin_init', 'wpse_38111' );
function wpse_38111() {
    remove_submenu_page( 'index.php', 'update-core.php' );
}

remove_action('wp_head', 'wp_generator');
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );

//Desactiva actualizaço do plugin de SEO
function my_filter_plugin_updates( $value ) {
    unset( $value->response['wordpress-seo/wp-seo.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'my_filter_plugin_updates' );

//Remove SEO da Yoast da barra principal
function mytheme_admin_bar_render() {
global $wp_admin_bar;
$wp_admin_bar->remove_menu('wpseo-menu');
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

function remove_acf_menu()
{

    // provide a list of usernames who can edit custom field definitions here
    $admins = array(
        'admin',
        'levy-admin',
        'barb'
    );

    // get the current user
    $current_user = wp_get_current_user();

    // match and remove if needed
    if( !in_array( $current_user->user_login, $admins ) )
    {
         remove_menu_page('edit.php?post_type=acf'); //ACF
    }

}
add_action( 'admin_menu', 'remove_acf_menu',999 );


function remove_menus(){
  remove_menu_page( 'plugins.php' );
  remove_menu_page( 'tools.php' );
  remove_menu_page( 'themes.php' );
  remove_menu_page( 'options-general.php' );
}
add_action( 'admin_menu', 'remove_menus' );
add_action('wp_before_admin_bar_render', 'remove_wpseo_menu', 0);
function remove_wpseo_menu() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wpseo-menu');
}

add_action('admin_menu', 'remove_wpseo_admin_menu_links');
function remove_wpseo_admin_menu_links(){
remove_action( 'admin_bar_menu', 'wpseo_admin_bar_menu', 95 );
remove_menu_page( 'wpseo_dashboard' );

}
add_action( 'admin_menu', 'awp_hide_settings' );
function awp_hide_settings() {
    remove_submenu_page( 'options-general.php', 'options-permalink.php' );
}
// Remove caracteres especiais dos ficheiros

add_filter('sanitize_file_name', 'sa_sanitize_chars', 10);
    function sa_sanitize_chars ($filename) {
    return remove_accents( $filename );
}

// Remove query string das folhas de CSS
function remove_cssjs_ver( $src ) {
 if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
 return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );

?>
