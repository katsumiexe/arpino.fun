<?php
function nightparty() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus');
}
function init_session_start(){
	session_start();
}




add_action('init', 'init_session_start');
add_action( 'after_setup_theme', 'nightparty' );
?>