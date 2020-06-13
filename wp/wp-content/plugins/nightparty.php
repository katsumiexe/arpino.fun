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
	add_menu_page('スタッフ', 'スタッフ', 'manage_options', 'staff', 'staff', 'dashicons-businessman',6);
	add_submenu_page('staff', 'スタッフ登録ページ', 'スタッフ登録', 'manage_options', 'staff_regist', 'staff_regist');
	add_submenu_page('staff', 'スタッフ一覧ページ', 'スタッフ一覧', 'manage_options', 'staff_list', 'staff_list');

	add_menu_page('キャスト','キャスト','manage_options','cast','cast','dashicons-businesswoman',5);
	add_submenu_page('cast','キャスト登録ページ', 'キャスト登録','manage_options', 'cast_regist', 'cast_regist');
	add_submenu_page('cast','キャスト一覧ページ', 'キャスト一覧', 'manage_options', 'cast_list', 'cast_list');
	add_submenu_page('cast','スケジュール一覧ページ', 'スケジュール','manage_options','sche_list','sche_list');


	add_menu_page(
	'更新ページ', 
		'更新', 
		'manage_options', 
		'write', 
		'write', 
		'dashicons-text-page', 
		7
	);


	add_submenu_page(
		'write', 
		'キャストブログ', 
		'キャストブログ', 
		'manage_options', 
		'cast_blog', 
		'cast_blog' 
	);

	add_submenu_page(
		'write', 
		'スタッフブログ', 
		'スタッフブログ', 
		'manage_options', 
		'staff_blog', 
		'staff_blog'
	);

	add_submenu_page(
		'write', 
		'お知らせ', 
		'お知らせ', 
		'manage_options', 
		'notce', 
		'notce' 
	);

	add_submenu_page(
		'write', 
		'ページ変更', 
		'ページ変更', 
		'manage_options', 
		'set_page', 
		'set_page' 
	);

	add_menu_page(
		'各種設定', 
		'各種設定', 
		'manage_options', 
		'config',
		'config', 
		'dashicons-admin-tools', 
		8
	);

	add_submenu_page(
		'config', 
		'ページ設定', 
		'ページ設定', 
		'manage_options', 
		'config_page', 
		'config_page'
	);

	add_submenu_page(
		'config', 
		'マイページ設定', 
		'マイページ設定', 
		'manage_options', 
		'config_mypage', 
		'config_mypage'
	);
	add_submenu_page(
		'config', 
		'システム設定', 
		'システム設定', 
		'manage_options', 
		'config_system', 
		'config_system' 
	);

	add_submenu_page(
		'config', 
		'アイテム設定', 
		'アイテム設定', 
		'manage_options', 
		'config_item', 
		'config_item'
	);
}




function cast_regist(){
    esc_html_e( include_once('cast_regist.php'), 'textdomain' );  
}
function cast_list(){
    esc_html_e( include_once('cast_list.php'), 'textdomain' );  
}
