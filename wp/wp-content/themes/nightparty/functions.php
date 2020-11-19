<?php
function init_session_start(){
/*
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
*/
        session_start();
}
//add_action('init', 'init_session_start');

function nightparty() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus');
}
add_action('after_setup_theme', 'nightparty' );

function geotag_queryvars( $qvars ){
	$qvars[] = 'val';
	return $qvars;
}
add_filter('query_vars', 'geotag_queryvars' );
?>
