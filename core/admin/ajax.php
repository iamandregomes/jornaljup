<?php 

/* Update latest theme version (we use internally for new version introduction text) */

add_action('wp_ajax_herald_update_version', 'herald_update_version');

if(!function_exists('herald_update_version')):
function herald_update_version(){
	update_option('herald_theme_version',HERALD_THEME_VERSION);
	die();
}
endif;


/* Hide welcome screen */

add_action('wp_ajax_herald_hide_welcome', 'herald_hide_welcome');

if(!function_exists('herald_hide_welcome')):
function herald_hide_welcome(){
	update_option('herald_welcome_box_displayed', true);
	die();
}
endif;




?>