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


if($_REQUEST["cast_edit"]){
	$post = get_post( $_REQUEST['post_ID'] );
	check_admin_referer( 'add-' . $post->post_type );
	esc_html_e( include_once('cast_edit.php'), 'textdomain' );  
}


if($_POST["staff_set"]){
	$c_s			=$_POST["c_s"];

	$staff_name		=$_POST["staff_name"];
	$staff_kana		=$_POST["staff_kana"];
	$staff_birthday	=$_POST["staff_birthday"];
	$staff_sex		=$_POST["staff_sex"];
	$staff_rank		=$_POST["staff_rank"];
	$staff_position	=$_POST["staff_position"];
	$staff_group	=$_POST["staff_group"];
	$staff_tel		=$_POST["staff_tel"];
	$staff_line		=$_POST["staff_line"];
	$staff_address	=$_POST["staff_address"];
	$staff_registday=$_POST["staff_registday"];

	$b_yy			=$_POST["b_yy"];
	$b_mm			=$_POST["b_mm"];
	$b_dd			=$_POST["b_dd"];


	$cast_id		=$_POST["cast_id"];
	$cast_pass		=$_POST["cast_pass"];
	$genji			=$_POST["genji"];
	$genji_kana		=$_POST["genji_kana"];
	$cast_mail		=$_POST["cast_mail"];
	$ctime_yy		=$_POST["ctime_yy"];
	$ctime_mm		=$_POST["ctime_mm"];
	$ctime_dd		=$_POST["ctime_dd"];

	$cast_rank		=$_POST["cast_rank"];
	$cast_sort		=$_POST["cast_sort"];

	$charm_table	=$_POST["charm_table"];
	$options		=$_POST["options"];

	$img_c		=$_POST["img_c"];
	$img_w		=$_POST["img_w"];
	$img_h		=$_POST["img_h"];
	$img_x		=$_POST["img_x"];
	$img_y		=$_POST["img_y"];
	$img_z		=$_POST["img_z"];
	$img_r		=$_POST["img_r"];

	if(!$staff_registday) $staff_registday=date("Y-m-d");
	$btime=$b_yy*10000+$b_mm*100+$b_dd;
	$btime=substr($btime,0,4)."-".substr($btime,4,2)."-".substr($btime,6,2);

	$sql="INSERT INTO wp01_0staff (`name`,`kana`,`birthday`,`sex`,`rank`,`position`,`group`,`tel`,`line`,`address`,`registday`)";
	$sql.="VALUES('{$staff_name}','{$staff_kana}','{$btime}','{$staff_sex}','{$staff_rank}','{$staff_position}','{$staff_group}','{$staff_tel}','{$staff_line}','{$staff_address}','{$staff_registday}')";
	$wpdb->query($sql);

	if($c_s == 2){

//■cast-------------------------------
		$tmp_auto=$wpdb->insert_id;
		$ctime=$ctime_yy*10000+$ctime_mm*100+$ctime_dd;
		$sql="INSERT INTO wp01_0cast (`id`,`genji`,`genji_kana`,`cast_id`,`cast_pass`,`cast_mail`,`ctime`,`rank`,`sort`)";
		$sql.="VALUES('{$tmp_auto}','{$genji}','{$genji_kana}','{$cast_id}','{$cast_pass}','{$cast_mail}','{$ctime}','{$cast_rank}','{$cast_sort}')";
		$wpdb->query($sql);	

//■encode-------------------------------
		$id_8	=substr("00000000".$tmp_auto,-8);
		$id_0	=$tmp_auto % 20;

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

		$link="../wp-content/themes/nightparty/img/page/".$tmp_auto."/";
		if(!is_dir($link)) {
			mkdir($link, 0777, TRUE);
			chmod($link, 0777);
		}

		$sql="INSERT INTO wp01_0cast_log_table(cast_id,item_name,item_icon,item_color,price,sort)VALUES";
		$sql.="('{$tmp_auto}','ドリンクA','0','48','100','0'),";
		$sql.="('{$tmp_auto}','ドリンクB','2','35','200','1'),";
		$sql.="('{$tmp_auto}','フードA','4','3','300','2'),";
		$sql.="('{$tmp_auto}','フードB','5','7','500','3'),";
		$sql.="('{$tmp_auto}','ボトル','3','36','1000','4'),";	
		$sql.="('{$tmp_auto}','本指名','8','55','1000','5'),";
		$sql.="('{$tmp_auto}','場内指名','8','12','500','6'),";
		$sql.="('{$tmp_auto}','同伴','6','59','2000','7')";
		$wpdb->query($sql);

//■options-------------------------------
		foreach($options as $a1 => $a2){
			if($a2 == "on"){
				$app.="('{$a1}','{$tmp_auto}',1),";
			}
		}
		if($app){
			$app=substr($app,0,-1);
			$sql="INSERT INTO wp01_0check_sel(list_id,cast_id,sel)VALUES";
			$sql.=$app;
			$wpdb->query($sql);
		}

//■charm_table-------------------------------
		foreach($charm_table as $a1 => $a2){
			if($a2){
				$app2.="('{$a1}','{$tmp_auto}','{$a2}'),";
			}
		}
		if($app2){
			$app2=substr($app2,0,-1);
			$sql="INSERT INTO wp01_0charm_sel(list_id,cast_id,log)VALUES";
			$sql.=$app2;
			$wpdb->query($sql);
		}

//■img-------------------------------
		if($img_c){
			$a3=0;
			foreach($img_c as $a1 => $a2){
				if($a2){

					$tmp_width	=ceil(1200*(100/$img_z[$a1]));
					$tmp_height	=ceil(1600*(100/$img_z[$a1]));


					$tmp_left	=floor((20-$img_x[$a1])*(1200/150)*100/$img_z[$a1]);
					$tmp_top	=floor((20-$img_y[$a1])*(1600/200)*100/$img_z[$a1]);

					if($img_r[$a1] ==90){
						$new_img	= imagecreatefromstring(base64_decode($img_c[$a1]));	
						$img		= imagerotate($new_img, 270, 0, 0);

					}elseif($img_r[$a1] ==180){
						$new_img	= imagecreatefromstring(base64_decode($img_c[$a1]));	
						$img		= imagerotate($new_img, 180, 0, 0);

					}elseif($img_r[$a1] ==270){
						$new_img	= imagecreatefromstring(base64_decode($img_c[$a1]));
						$img		= imagerotate($new_img, 90, 0, 0);

					}else{
						$img = imagecreatefromstring(base64_decode($img_c[$a1]));
					}

					$link="../wp-content/themes/nightparty/img/page/".$tmp_auto;

					$img2 		= imagecreatetruecolor(600,800);
					ImageCopyResampled($img2, $img, 0, 0, $tmp_left, $tmp_top, 600, 800, $tmp_width, $tmp_height);
					imagejpeg($img2,$link."/".$a3.".jpg",100);
					imagedestroy($img2);

					$img2_s 		= imagecreatetruecolor(180,240);
					ImageCopyResampled($img2_s, $img, 0, 0, $tmp_left, $tmp_top, 180, 240, $tmp_width, $tmp_height);
//					imagewebp($img2_s,$link."/".$a3."_s.webp");
					imagejpeg($img2_s,$link."/".$a3."_s.jpg");
					imagedestroy($img2_s);


					$img2_n 		= imagecreatetruecolor(30,40);
					ImageCopyResampled($img2_n, $img, 0, 0, $tmp_left, $tmp_top, 30, 40, $tmp_width, $tmp_height);
					imagejpeg($img2_n,$link."/".$a3."_n.jpg",100);
					imagedestroy($img2_n);
					$a3++;
				}
			}
		}
	}

	if($_REQUEST["news_date_yy"] && $_REQUEST["news_date_mm"] && $_REQUEST["news_date_dd"] && $_REQUEST["news_box"]){

		$news_box=str_replace("[name]","<span style=\"color:#0000d0; font-weight:600\">{$genji}</span>",$_REQUEST["news_box"]);

		$p_date=$_REQUEST["news_date_yy"]."-".$_REQUEST["news_date_mm"]."-".$_REQUEST["news_date_dd"]." 00:00:00";
		$m_date=$_REQUEST["ctime_yy"]."-".$_REQUEST["ctime_mm"]."-".$_REQUEST["ctime_dd"]." 00:00:00";

		$g_date=date("Y-m-d 00:00:00",strtotime($p_date)-32400);


		$sql_news =" INSERT INTO wp01_posts";
		$sql_news .="(post_status,post_title,post_date,post_date_gmt,post_modified,guid,post_mime_type)";
		$sql_news .=" VALUES('publish','{$news_box}','{$p_date}','{$g_date}','{$m_date}','/person','{$tmp_auto}')";
		$wpdb->query($sql_news);
		$tmp_auto_2=$wpdb->insert_id;

echo($sql_news);
		$sql_news =" INSERT INTO wp01_postmeta";
		$sql_news .="(post_id,meta_key,meta_value)";
		$sql_news .=" VALUES('{$tmp_auto_2}','_top_news','18')";
		$wpdb->query($sql_news);
	}

    esc_html_e( include_once('cast_regist.php'), 'textdomain' );  
}


add_action('admin_menu', 'custom_menu_page');
function custom_menu_page(){
	add_menu_page('スタッフ', 'スタッフ', 'manage_options', 'staff', 'staff', 'dashicons-businessman',6);
	add_submenu_page('staff', 'スタッフ一覧', 'スタッフ一覧', 'manage_options', 'staff_list', 'staff_list');
	add_submenu_page('staff','キャスト一覧', 'キャスト','manage_options','cast_list','cast_list');
	add_submenu_page('staff','スケジュール一覧', 'スケジュール','manage_options','sche_list','sche_list');

	add_menu_page('更新ページ', '更新', 'manage_options', 'write', 'write', 'dashicons-text-page', 7);
	add_submenu_page('write', 'キャストブログ', 'キャストブログ', 'manage_options', 'cast_blog', 'cast_blog' );
	add_submenu_page('write', 'TOPイベント', 'TOPイベント', 'manage_options', 'top_event', 'top_event');
	add_submenu_page('write', '新着情報', '新着', 'manage_options', 'notce', 'notce' );
	add_submenu_page('write', 'サブイベント', 'サブイベント', 'manage_options', 'sub_event', 'sub_event' );

	add_menu_page('各種設定', '各種設定', 'manage_options', 'config','config', 'dashicons-admin-tools', 8);
	add_submenu_page('config', '時計/カレンダー', '時計/カレンダー', 'manage_options', 'config_page', 'config_page');
	add_submenu_page('config', 'プロフィール', 'プロフィール', 'manage_options', 'config_prof', 'config_prof');

	add_menu_page('情報', '情報', 'manage_options', 'manage','manage', 'dashicons-admin-tools', 9);
	add_submenu_page('manage', 'EasyTalk', 'EasyTalk', 'manage_options', 'easytalk_list', 'easytalk_list');
	add_submenu_page('manage', 'キャストジョブ', 'キャストジョブ', 'manage_options', 'castjob', 'castjob');
	add_submenu_page('manage', 'お客様一覧', 'お客様一覧', 'manage_options', 'customer_list', 'customer_list');
}

function cast_list(){
	global $wpdb;
	$updir = wp_upload_dir();
	$sort_del=$_REQUEST["sort_del"];
	$n=0;
	$sql	 ="SELECT * FROM wp01_0cast";
	$sql	.=" WHERE id>0";
	$sql	.=" ORDER BY id DESC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$count_del[$res["del"]]++;
		$count_all++;

		if(mb_strlen($sort_del)==0 || $res["del"]===$sort_del){

			$member[$n]=$res;
			if (file_exists(get_template_directory()."/img/page/{$res["id"]}/0.jpg")) {
				$member[$n]["img"]=get_template_directory_uri()."/img/page/".$res["id"]."/0.jpg";
			}else{
				$member[$n]["img"]=get_template_directory_uri()."/img/page/noimage.jpg";			
			}
			$n++;
		}
	}
    esc_html_e( include_once('cast_list.php'), 'textdomain' );  
}

function config_prof(){
	global $wpdb;
	$sql	 ="SELECT * FROM wp01_0charm_table";
	$sql	.=" ORDER BY sort ASC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$charm[$res["sort"]]=$res;
	}

	$sql	 ="SELECT * FROM wp01_0check_main";
	$sql	.=" ORDER BY sort ASC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);
	foreach($tmp_list as $res){
		$check[$res["sort"]]=$res;
	}

	$sql	 ="SELECT * FROM wp01_0check_list";
	$sql	.=" ORDER BY host_id ASC, list_sort ASC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);
	foreach($tmp_list as $res){
		$list[$res["host_id"]][$res["list_sort"]]=$res;
	}
    esc_html_e(include_once('config_prof.php'),'textdomain');  
}


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

function staff(){
	global $wpdb;

	$now_code=date("Y-m-d");

	$sql	 ="SELECT * FROM wp01_0charm_table";
	$sql	.=" WHERE del=0";
	$sql	.=" ORDER BY sort ASC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$charm_table[$res["id"]]=$res;
	}

	$sql	 ="SELECT * FROM wp01_0check_main";
	$sql	.=" WHERE del=0";
	$sql	.=" ORDER BY sort ASC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$ck_main[$res["sort"]]=$res;
	}

	$sql	 ="SELECT * FROM wp01_0check_list";
	$sql	.=" WHERE del=0";
	$sql	.=" ORDER BY host_id ASC, list_sort ASC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$ck_list[$res["host_id"]][$res["id"]]=$res["list_title"];
	}

	$sql		="SELECT MAX(id) AS id_max FROM wp01_0staff";
	$tmp_list	= $wpdb->get_row($sql,ARRAY_A);
	$new_id		=$tmp_list["id_max"]+1;
    esc_html_e(include_once('staff_regist.php'),'textdomain');  
}

function config_option(){
	global $wpdb;
	$updir = wp_upload_dir();

	$n=0;
	$sql	 ="SELECT * FROM wp01_termmeta AS M";
	$sql	.=" LEFT JOIN wp01_terms AS T USING(term_id)";
	$sql	.=" WHERE meta_key='_options'";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$options[$res["meta_value"]][$res["term_id"]]=$res;
	}
    esc_html_e( include_once('config_option.php'), 'textdomain' );  
}
?>