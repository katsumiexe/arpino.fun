<?php
/*
Plugin Name:higashino_tarot
Plugin URI:https://arpino.fun
Description:prigin
Version: 0.1
Author: KatsumiArai
Author URI:
*/

/*
require_once ("../wp-load.php");
global $wpdb;
*/

add_action('admin_menu', 'custom_menu_tarot');
function custom_menu_tarot(){
	add_menu_page('タロット設定', 'タロット設定', 'manage_options', 'set_tarot','set_tarot', 'dashicons-images-alt2', 9);
	add_submenu_page('set_tarot', 'タロット：ベース設定', 'ベース設定', 'manage_options', 'set_tarot_base', 'set_tarot_base');
	add_submenu_page('set_tarot', 'タロット：詳細設定', '詳細設定', 'manage_options', 'set_tarot_detail', 'set_tarot_detail');
}

function set_tarot(){

}
function set_tarot_base(){
	global $wpdb;
	$n=0;
	$sql	 ="SELECT * FROM tarot_base";
	$sql	.=" ORDER BY id ASC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$card[$n]=$res;
		$n++;
	}
    esc_html_e(include_once('tarot_base.php'),'textdomain');  
}

function set_tarot_detail(){

}
