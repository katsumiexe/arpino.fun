<?php
/*
Plugin Name:nightparty
Plugin URI:https://onlyme.fun
Description:prigin
Version: 0
Author: KatsumiArai
Author URI:
*/

add_action('admin_menu', 'custom_menu_page');
function custom_menu_page(){
	add_menu_page(
		'キャスト登録ページ', 
		'キャスト登録', 
		'manage_options', 
		'cast_regist', 
		'cast_regist', 
		'dashicons-businesswoman', 
		5
	);

	add_menu_page(
		'キャスト一覧ページ', 
		'キャスト一覧', 
		'manage_options', 
		'cast_list', 
		'cast_list', 
		'dashicons-businesswoman', 
		6
	);

	add_menu_page(
		'スタッフ登録ページ', 
		'スタッフ登録', 
		'manage_options', 
		'staff_regist', 
		'staff_regist', 
		'dashicons-businesswoman', 
		7
	);

	add_menu_page(
		'スタッフ一覧ページ', 
		'スタッフ一覧', 
		'manage_options', 
		'staff_list', 
		'staff_list', 
		'dashicons-businesswoman', 
		8
	);

	add_menu_page(
		'スケジュール一覧ページ', 
		'スケジュール', 
		'manage_options', 
		'sche_list', 
		'sche_list', 
		'dashicons-businesswoman', 
		9
	);

	add_menu_page(
		'キャスト設定ページ', 
		'キャスト設定', 
		'manage_options', 
		'cast_set', 
		'cast_set', 
		'dashicons-businesswoman', 
		10
	);

	add_menu_page(
		'管理設定ページ', 
		'管理設定', 
		'manage_options', 
		'admin_set', 
		'admin_set', 
		'dashicons-businesswoman', 
		11
	);
}

function cast_regist(){
    esc_html_e( include_once('cast_regist.php'), 'textdomain' );  
}
function cast_list(){
    esc_html_e( include_once('cast_list.php'), 'textdomain' );  
}
