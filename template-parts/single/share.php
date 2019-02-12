<?php
$share = array();
$share['facebook'] = '<a href="javascript:void(0);" data-url="http://www.facebook.com/sharer/sharer.php?u='.urlencode( esc_url( get_permalink() ) ).'&amp;t='.urlencode( esc_attr( get_the_title() ) ).'"><i class="fa fa-facebook"></i><span>Facebook</span></a>';
$share['twitter'] = '<a href="javascript:void(0);" data-url="http://twitter.com/intent/tweet?url='.urlencode( esc_url( get_permalink() ) ).'&amp;text='.urlencode( esc_attr( get_the_title() ) ).'"><i class="fa fa-twitter"></i><span>Twitter</span></a>';
$pin_img = has_post_thumbnail() ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) : '';
$pin_img = isset( $pin_img[0] ) ? $pin_img[0] : '';
$share['pinterest'] = '<a href="javascript:void(0);" data-url="http://pinterest.com/pin/create/button/?url='.urlencode( esc_url( get_permalink() ) ).'&amp;media='.urlencode( esc_attr( $pin_img ) ).'&amp;description='.urlencode( esc_attr( get_the_title() ) ).'"><i class="fa fa-pinterest"></i><span>Pinterest</span></a>';
$share_options = array_filter( herald_get_option( 'social_share' ) );
?>
<?php if ( !empty( $share_options ) ) : ?>
	<ul class="herald-share">
		<span class="herald-share-meta"><i class="fa fa-share-alt"></i><?php echo __herald( 'share_text' );?></span>
		<div class="meta-share-wrapper">
			<?php foreach ( $share_options as $social => $value ) : ?>
			     <li class="<?php echo esc_attr( $social ); ?>"> <?php echo $share[$social] ?> </li>
			<?php endforeach; ?>
	 	</div>
	</ul>
<?php endif; ?>