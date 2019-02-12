<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<meta charset="UTF-8">
<meta property="og:locale" content="pt_PT"/>
<link rel="canonical" href="http://www.juponline.pt/" />
<meta name="keywords" content="Notícias, Academia, Porto, Academia do Porto, Universidade, Estudantes, actualidade, notícias em português, notícias populares, notícias mais partilhadas, notícias mais lidas, ao minuto, opinião, multimédia, vídeo, fotografia, notícias de política, política, notícias de sociedade, sociedade, notícias de cultura, cultura, notícias de desporto, desporto, notícias de ciência, ciência, notícias de tecnologia, tecnologia" />
<meta property="og:type" content="website">
<link rel="shortcut icon" href="/wp-content/themes/jornaljup/assets/img/favicon.png">		
<link rel="apple-touch-icon" href="/wp-content/themes/jornaljup/assets/img/favicon.png">
<link rel="apple-touch-icon" sizes="114x114" href="/wp-content/themes/jornaljup/assets/img/favicon.png">
<link rel="apple-touch-icon" sizes="72x72" href="/wp-content/themes/jornaljup/assets/img/favicon.png">
<link rel="apple-touch-icon" sizes="144x144" href="/wp-content/themes/jornaljup/assets/img/favicon.png">
<meta property="og:site_name" content="Jornal Universitário do Porto">
<meta property="article:publisher" content="https://www.facebook.com/jornaljup"/>
 <!--                                                           
          JJJJJJJJJJJUUUUUUUU     UUUUUUUUPPPPPPPPPPPPPPPPP   
          J:::::::::JU::::::U     U::::::UP::::::::::::::::P  
          J:::::::::JU::::::U     U::::::UP::::::PPPPPP:::::P 
          JJ:::::::JJUU:::::U     U:::::UUPP:::::P     P:::::P
            J:::::J   U:::::U     U:::::U   P::::P     P:::::P
            J:::::J   U:::::D     D:::::U   P::::P     P:::::P
            J:::::J   U:::::D     D:::::U   P::::PPPPPP:::::P 
            J:::::j   U:::::D     D:::::U   P:::::::::::::PP  
            J:::::J   U:::::D     D:::::U   P::::PPPPPPPPP    
JJJJJJJ     J:::::J   U:::::D     D:::::U   P::::P            
J:::::J     J:::::J   U:::::D     D:::::U   P::::P            
J::::::J   J::::::J   U::::::U   U::::::U   P::::P            
J:::::::JJJ:::::::J   U:::::::UUU:::::::U PP::::::PP          
 JJ:::::::::::::JJ     UU:::::::::::::UU  P::::::::P          
   JJ:::::::::JJ         UU:::::::::UU    P::::::::P          
     JJJJJJJJJ             UUUUUUUUU      PPPPPPPPPP          

	Desenvolvido por @iamandregomes
	marques.andrew@me.com

-->
<?php wp_head(); ?>                                           
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//piwik.juponline.pt/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->
</head>
<body <?php body_class(); ?>>
	<header id="header" class="herald-site-header">
		<?php $header_sections = array_keys( array_filter( herald_get_option( 'header_sections' ) ) ); ?>
		<?php if ( !empty( $header_sections ) ): ?>
			<?php foreach ( $header_sections as $section ): ?>
				<?php get_template_part( 'template-parts/header/'.$section ); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</header>
	<?php if ( herald_get_option( 'header_sticky' ) ): ?>
		<?php get_template_part( 'template-parts/header/sticky' ); ?>
	<?php endif; ?>
	<?php get_template_part( 'template-parts/header/responsive' ); ?>
	<?php get_template_part( 'template-parts/ads/below-header' ); ?>
	<div id="content" class="herald-site-content herald-slide">
	<?php if ( !is_front_page() ) { herald_breadcrumbs(); } ?>
