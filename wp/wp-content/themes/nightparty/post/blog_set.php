<?
/*
BlogSet
*/
require_once ("./post_inc.php");
$date_gmt=date("Y-m-d H:i:s");
$now=date("Y-m-d H:i:s",$jst);
$updir = wp_upload_dir();

$yy=$_POST["yy"];
$mm=$_POST["mm"];
$dd=$_POST["dd"];
$hh=$_POST["hh"];
$ii=$_POST["ii"];
$date_jst=$yy."-".$mm."-".$dd." ".$hh.":".$ii.":00";

$ttl		=$_POST["ttl"];
$log		=$_POST["log"];
$tag		=$_POST["tag"];
$cast_id	=$_POST["cast_id"];
$chg		=$_POST["chg"];
$open		=$_POST["open"];

$img_code	=$_POST["img_code"];

/*
$img_zoom	=$_POST["img_zoom"];
$img_top	=$_POST["img_top"];
$img_left	=$_POST["img_left"];
$img_width	=$_POST["img_width"];
$img_height	=$_POST["img_height"];
$vw_base	=$_POST["vw_base"];
$img_rote	=$_POST["img_rote"]+0;
*/

$sql ="SELECT term_id FROM wp01_terms";
$sql.=" WHERE slug='{$cast_id}'";
$dat = $wpdb->get_row($sql,ARRAY_A );

if(!$dat){
	$sql	 ="INSERT INTO wp01_terms(`name`,`slug`)";
	$sql	.=" VALUES('{$_SESSION["genji"]}','{$cast_id}')";
	$wpdb->query($sql);
	$terms_id=$wpdb->insert_id;

	$sql	 ="INSERT INTO wp01_term_taxonomy(`term_id`,`taxonomy`)";
	$sql	.=" VALUES('{$terms_id}','cast')";
	$wpdb->query($sql);

}else{
	$terms_id=$dat["term_id"];
}


$blog_st[0]="<span class=\"hist_status hist_0\">公開</span>";
$blog_st[1]="<span class=\"hist_status hist_1\">予約</span>";
$blog_st[2]="<span class=\"hist_status hist_2\">非公開</span>";
$blog_st[3]="<span class=\"hist_status hist_3\">削除</span>";

if($open<=1 && $now < $date_jst){
	$open=1;
}

if($open == 2){
	$status="draft";
}else{
	$status="publish";
}

$blog[$n]["img"]="{$updir['baseurl']}/np{$_SESSION["id"]}/img_{$tmp["ID"]}.png";

if($chg){
	$sql="UPDATE wp01_posts SET";
	$sql.=" post_author='{$cast_id}',";
	$sql.=" post_date='{$date_jst}',";
	$sql.=" post_date_gmt='{$date_gmt}',";
	$sql.=" post_content='{$log}',";
	$sql.=" post_title='{$ttl}',";
	$sql.=" post_status='{$status}',";
	$sql.=" post_modified='{$date_jst}',";
	$sql.=" post_modified_gmt='{$date_gmt}'";
	$sql.=" WHERE ID='{$chg}'";
	$wpdb->query($sql);

	$sql="INSERT INTO wp01_posts ";
	$sql.="(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_modified, post_modified_gmt, comment_status, ping_status, post_name, guid, post_type, post_parent)";
	$sql.="VALUES";
	$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','{$log}','{$ttl}','inherit','{$date_jst}','{$date_gmt}'";
	$sql.=",'closed','closed','{$chg}-revision-v1','blog/{$cast_id}/{$chg}-revision-v1/','revision','{$chg}')";
	$wpdb->query($sql);


	$sql ="UPDATE `wp01_term_relationships` SET";
	$sql.=" term_taxonomy_id='{$tag}'";

	$sql.=" WHERE object_id='{$chg}'";
//	$sql.=" AND term_taxonomy_id='{$tag}'";
	$wpdb->query($sql);

}else{
	$sql="INSERT INTO wp01_posts ";
	$sql.="(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_modified, post_modified_gmt, comment_status, ping_status, post_name, guid, post_type, post_parent)";
	$sql.="VALUES";
	$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','{$log}','{$ttl}','publish','{$date_jst}','{$date_gmt}'";
	$sql.=",'open','open','post','{$updir['baseurl']}/{$cast_id}/','post','0')";

	$wpdb->query($sql);
	$tmp_auto=$wpdb->insert_id;
	$tmp_auto2=$tmp_auto++;
/*
	$sql="INSERT INTO wp01_posts ";
	$sql.="(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_modified, post_modified_gmt, comment_status, ping_status, post_name, guid, post_type, post_parent)";
	$sql.="VALUES";
	$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','{$log}','{$ttl}','inherit','{$date_jst}','{$date_gmt}'";
	$sql.=",'closed','closed','{$tmp_auto}-revision-v1','{$updir['baseurl']}/{$cast_id}/{$tmp_auto}-revision-v1/','revision','{$tmp_auto}')";
	$wpdb->query($sql);
*/
	if($img_code){
		$tmp_img=$tmp_auto2;

		$sql="INSERT INTO wp01_posts ";
		$sql.="(post_author,post_date,post_date_gmt,post_title,post_status,post_modified,post_modified_gmt, comment_status,ping_status,post_name,guid,post_type,post_mime_type";
		$sql.="VALUES";
		$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','img_{$tmp_auto2}','inherit','{$date_jst}','{$date_gmt}'";
		$sql.=",'open','closed','img_{$tmp_auto2}','{$updir['baseurl']}/np{$cast_id}/img_{$tmp_auto2}.png','attachment','image/png')";
		$wpdb->query($sql);

		$img_origin			="img_{$tmp_auto2}.png";
		$img_origin_cnt		=mb_strlen($img_origin);
		$tmp_in="a:5:{s:5:\"width\";i:600;s:6:\"height\";i:600;s:4:\"file\";s:{$img_origin_cnt}:\"{$img_origin}\";s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}";

		$app	.="('{$tmp_auto2}','_wp_attached_file','np{$cast_id}/img_{$tmp_auto2}.png'),";
		$app	.="('{$tmp_auto2}','_wp_attachment_metadata','{$tmp_in}'),";
		$app	.="('{$tmp_auto2}','_wp_attachment_image_alt','{$date_jst}')";

		$mk_dir="../../../../wp-content/uploads/np{$cast_id}/";
		if(!is_dir($mk_dir)) {
			mkdir($mk_dir, 0777, TRUE);
			chmod($mk_dir, 0777);
		}

		$link	="../../../../wp-content/uploads/np{$cast_id}/img_{$tmp_auto2}.png";
		$img_64	= imagecreatefromstring(base64_decode($img_code));	
/*
		$img2 		= imagecreatetruecolor(600,600);
		$new_img	= imagecreatefromstring(base64_decode($img_code));	

		$tmp_top	=floor(((($vw_base*10-$img_top)*10)/$vw_base)*100/$img_zoom);
		$tmp_left	=floor(((($vw_base*10-$img_left)*10)/$vw_base)*100/$img_zoom);

		$tmp_width	=floor(600/($img_zoom/100));
		$tmp_height	=floor(600/($img_zoom/100));

		if($img_rote ==90){
			$new_img = imagecreatefromstring(base64_decode($img_code));	
			$img = imagerotate($new_img, 270, 0, 0);

		}elseif($img_rote ==270){
			$new_img = imagecreatefromstring(base64_decode($img_code));
			$img = imagerotate($new_img, 90, 0, 0);

		}else{
			$img = imagecreatefromstring(base64_decode($img_code));
		}

		ImageCopyResampled($img2, $img, 0, 0, $tmp_left, $tmp_top, 600, 600, $tmp_width, $tmp_height);
*/
		imagepng($img_64,$link);
	}elseif($album){
		$tmp_img=$album;
	}

	$app.="('{$tmp_auto}','_thumbnail_id','{$tmp_img}')";

	$sql="INSERT INTO wp01_postmeta";
	$sql.="(post_id, meta_key, meta_value)";
	$sql.="VALUES";
	$sql.=$app;
	$wpdb->query($sql);

	$sql="INSERT INTO wp01_term_relationships";
	$sql.="(object_id,term_taxonomy_id)";
	$sql.="VALUES";
	$sql.="('{$tmp_auto}','{$tag}'),";
	$sql.="('{$tmp_auto}','{$terms_id}')";
	$wpdb->query($sql);

	$sql="INSERT INTO wp01_posts ";
	$sql.="(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_modified, post_modified_gmt, comment_status, ping_status, post_name, guid, post_type, post_parent)";
	$sql.="VALUES";
	$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','{$log}','{$ttl}','inherit','{$date_jst}','{$date_gmt}'";
	$sql.=",'closed','closed','{$tmp_auto}-revision-v1','{$updir['baseurl']}/{$cast_id}/{$tmp_auto}-revision-v1/','revision','{$tmp_auto}')";
	$wpdb->query($sql);
}

if($img_code){
	$tmp_img="{$updir['baseurl']}/np{$cast_id}/img_{$tmp_auto2}.png";

}else{
	$tmp_img="{get_template_directory_uri()}/img/customer_no_img.jpg";
}


$log=str_replace("\n","<br>",$log);

$html="<div id=\"blog_hist_{$tmp_auto}\" class=\"blog_hist\">";
$html.="<div class=\"blog_hist_in\">";
$html.="<img src=\"{$tmp_img}\" class=\"hist_img\">";
$html.="<span class=\"hist_date\">{$date_jst}</span>";
$html.="<span class=\"hist_title\">{$ttl}</span>";
$html.="<span class=\"hist_tag\">";
foreach((array)$tag_name as $a2){
$html.="{$a2}/";
}
$html.="</span>";
$html.="</div>";
$html.="<div class=\"hist_log\">";
if($img_code){
$html.="<span class=\"hist_img_in\"><img src=\"{$tmp_img}\" class=\"hist_img_on\"></span>";
}
$html.="<span class=\"blog_log\">{$log}</span>";
$html.="</div>";
$html.="<span class=\"hist_watch\"><span class=\"hist_i\"></span><span class=\"hist_watch_c\">{$view_cnt}</span></span>";
$html.="<span class=\"hist_comm\"><span class=\"hist_i\"></span><span class=\"hist_comm_c\">{$comm_cnt}</span></span>";
$html.=$blog_st[$open];
$html.="</div>";
echo $html;
exit();
?>