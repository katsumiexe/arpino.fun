<?php
/*
Plugin Name:nightparty
Plugin URI:https://onlyme.fun
Description:prigin
Version: 0
Author: KatsumiArai
Author URI:
*/

/*
require_once ("../wp-load.php");
global $wpdb;
*/

if($_POST["staff_set"]){
	$staff_name		=$_POST["staff_name"];
	$staff_kana		=$_POST["staff_kana"];
	$staff_birthday	=$_POST["staff_birthday"];
	$staff_sex		=$_POST["staff_sex"];
	$staff_rank		=$_POST["staff_rank"];
	$staff_position	=$_POST["staff_position"];
	$staff_group	=$_POST["staff_group"];
	$staff_tel		=$_POST["staff_tel"];
	$staff_address	=$_POST["staff_address"];
	$staff_registday=$_POST["staff_registday"];

	$cast_id		=$_POST["cast_id"];
	$cast_pass		=$_POST["cast_pass"];
	$genji			=$_POST["genji"];
	$genji_kana		=$_POST["genji_kana"];
	$castmail		=$_POST["castmail"];
	$castmail_pass	=$_POST["castmail_pass"];

	if(!$staff_registday) $staff_registday=date("Y-m-d");
	$sql="INSERT INTO wp01_0staff (`name`,`kana`,`birthday`,`sex`,`rank`,`position`,`group`,`tel`,`address`,`registday`)";
	$sql.="VALUES('{$staff_name}','{$staff_kana}','{$staff_birthday}','{$staff_sex}','{$staff_rank}','{$staff_position}','{$staff_group}','{$staff_tel}','{$staff_address}','{$staff_registday}')";
	$wpdb->query($sql);

	if($genji){
		$tmp_auto=$wpdb->insert_id;
		$id_8	=substr("00000000".$tmp_auto,-8);
		$id_0	=$tmp_auto % 20;

		$sql="INSERT INTO wp01_0cast (`id`,genji`,`genji_kana`,`cast_id`,`cast_pass`,`castmail`,`castmail_pass`)";
		$sql.="VALUES('{$tmp_auto}','{$genji}','{$genji_kana}','{$cast_id}','{$cast_pass}','{$castmail}','{$castmail_pass}')";
		$wpdb->query($sql);	
	
		$sql ="SELECT * FROM wp01_0encode"; 
		$enc0 = $wpdb->get_results($sql,ARRAY_A );
		foreach($enc0 as $row){
			$enc[$row["key"]]				=$row["value"];
			$dec[$row["gp"]][$row["value"]]	=$row["key"];
		}

		for($n=0;$n<8;$n++){
			$rnd=rand(0,19);
			$tmp_id=substr($id_8,$n,1);
			$tmp_dir.=$dec[$id_0][$tmp_id];
		}

		$mk_dir="../wp-content/themes/nightparty/img/cast/".$tmp_dir;
		if(!is_dir($mk_dir)) {
			mkdir($mk_dir."/c/", 0777, TRUE);
			chmod($mk_dir."/c/", 0777);

			mkdir($mk_dir."/m/", 0777, TRUE);
			chmod($mk_dir."/m/", 0777);
		}

		$mk_dir="../wp-content/themes/nightparty/img/page/".$tmp_auto."/";
		if(!is_dir($mk_dir)) {
			mkdir($mk_dir, 0777, TRUE);
			chmod($mk_dir, 0777);
		}

		$sql="INSERT INTO wp01_0cast_log_table(cast_id,item_name,item_icon,item_color,price,sort)VALUES";
		$sql.="('{$tmp_auto}','ドリンクA','0','48','500','0'),";
		$sql.="('{$tmp_auto}','ドリンクB','2','35','1000','1'),";
		$sql.="('{$tmp_auto}','フードA','4','3','500','2'),";
		$sql.="('{$tmp_auto}','フードB','5','7','100','3'),";
		$sql.="('{$tmp_auto}','ボトル','3','36','2000','4'),";	
		$sql.="('{$tmp_auto}','本指名','8','55','2000','5'),";
		$sql.="('{$tmp_auto}','場内指名','8','12','500','6'),";
		$sql.="('{$tmp_auto}','同伴','6','59','2000','7')";
		$wpdb->query($sql);
	}
}

add_action('admin_menu', 'custom_menu_page');
function custom_menu_page(){
	add_menu_page('スタッフ', 'スタッフ', 'manage_options', 'staff', 'staff', 'dashicons-businessman',6);
	add_submenu_page('staff', 'スタッフ登録ページ', 'スタッフ登録', 'manage_options', 'staff_regist', 'staff_regist');
	add_submenu_page('staff', 'スタッフ一覧ページ', 'スタッフ一覧', 'manage_options', 'staff_list', 'staff_list');

	add_menu_page('キャスト','キャスト','manage_options','cast','cast','dashicons-businesswoman',5);
	add_submenu_page('cast','キャスト登録ページ', 'キャスト登録','manage_options', 'cast_regist', 'cast_regist');
	add_submenu_page('cast','キャスト一覧ページ', 'キャスト一覧', 'manage_options', 'cast_list', 'cast_list');
	add_submenu_page('cast','スケジュール一覧ページ', 'スケジュール','manage_options','sche_list','sche_list');

	add_menu_page('更新ページ', '更新', 'manage_options', 'write', 'write', 'dashicons-text-page', 7);
	add_submenu_page('write', 'キャストブログ', 'キャストブログ', 'manage_options', 'cast_blog', 'cast_blog' );
	add_submenu_page('write', 'スタッフブログ', 'スタッフブログ', 'manage_options', 'staff_blog', 'staff_blog');
	add_submenu_page('write', 'お知らせ', 'お知らせ', 'manage_options', 'notce', 'notce' );
	add_submenu_page('write', 'ページ変更', 'ページ変更', 'manage_options', 'set_page', 'set_page' );

	add_menu_page('各種設定', '各種設定', 'manage_options', 'config','config', 'dashicons-admin-tools', 8);
	add_submenu_page('config', 'ページ設定', 'ページ設定', 'manage_options', 'config_page', 'config_page');
	add_submenu_page('config', 'マイページ設定', 'マイページ設定', 'manage_options', 'config_mypage', 'config_mypage');
	add_submenu_page('config', 'システム設定', 'システム設定', 'manage_options', 'config_system', 'config_system' );
	add_submenu_page('config', 'アイテム設定', 'アイテム設定', 'manage_options', 'config_item', 'config_item');
}

function cast_regist(){
    esc_html_e( include_once('cast_regist.php'), 'textdomain' );  
}

function cast_list(){
	global $wpdb;
	$n=0;
	$sql	 ="SELECT * FROM wp01_0cast";
	$sql	.=" ORDER BY id DESC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$member[$n]=$res;
		$n++;
	}
    esc_html_e( include_once('cast_list.php'), 'textdomain' );  
}

//var_dump($wpdb);

function staff_list(){
	global $wpdb;
	$n=0;
	$sql	 ="SELECT * FROM wp01_0staff";
	$sql	.=" ORDER BY staff_id DESC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$member[$n]=$res;
		$n++;
	}
    esc_html_e(include_once('staff_list.php'),'textdomain');  
}

function staff_regist(){
    esc_html_e(include_once('staff_regist.php'),'textdomain');  
}
