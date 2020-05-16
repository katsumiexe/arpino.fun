<?php
function nightparty() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus');
}
add_action('after_setup_theme', 'nightparty' );

function custom_menu() {
	register_nav_menus( array(
		'global' => 'メインメニュー',
		'sns' => 'SNSリンク',
	));
}
add_action('after_setup_theme','custom_menu');

function geotag_queryvars( $qvars )
{
	$qvars[] = 'val';
	return $qvars;
}
add_filter('query_vars', 'geotag_queryvars' );

?>
