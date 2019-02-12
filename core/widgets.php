<?php
add_action( 'widgets_init', 'herald_register_widgets' );
if(!function_exists('herald_register_widgets')) :
	function herald_register_widgets(){
	 		include_once( get_template_directory() .'/core/widgets/posts.php');
	 		include_once( get_template_directory() .'/core/widgets/video.php');
	 		include_once( get_template_directory() .'/core/widgets/adsense.php');
			register_widget('HRD_Posts_Widget');
			register_widget('HRD_Video_Widget');
			register_widget('HRD_Adsense_Widget');
	}
endif;
?>