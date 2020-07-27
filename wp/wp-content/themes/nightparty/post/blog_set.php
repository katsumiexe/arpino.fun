<?
/*
BlogSet

*/

require_once ("./post_inc.php");
$date_gmt=date("Y-m-d H:i:s");

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

$img_code	=$_POST["img_code"];
$img_zoom	=$_POST["img_zoom"];
$img_top	=$_POST["img_top"];
$img_left	=$_POST["img_left"];
$img_width	=$_POST["img_width"];
$img_height	=$_POST["img_height"];
$vw_base	=$_POST["vw_base"];
$img_rote	=$_POST["img_rote"]+0;

$sql ="SELECT term_id FROM wp01_terms";
$sql.=" WHERE slug='{$cast_id}' OR slug='{$tag}'";
$dat = $wpdb->get_results($sql,ARRAY_A );
foreach($dat as $a1){
	$term[]=$a1["term_id"];
}

$updir = wp_upload_dir();
$blog[$n]["img"]="{$updir['baseurl']}/np{$_SESSION["id"]}/img_{$tmp["ID"]}.png";

if($chg){
	$sql="INSERT INTO wp01_posts ";
	$sql.="(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_modified, post_modified_gmt, comment_status, ping_status, post_name, guid, post_type, post_parent)";
	$sql.="VALUES";
	$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','{$log}','{$ttl}','publish','{$date_jst}','{$date_gmt}'";
	$sql.=",'closed','closed','{$chg}-revision-v1','blog/{$cast_id}/{$chg}-revision-v1/','revision','{$chg}')";
	$wpdb->query($sql);
	$tmp_auto=$wpdb->insert_id;

}else{
	$sql="INSERT INTO wp01_posts ";
	$sql.="(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_modified, post_modified_gmt, comment_status, ping_status, post_name, guid, post_type, post_parent)";
	$sql.="VALUES";
	$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','{$log}','{$ttl}','publish','{$date_jst}','{$date_gmt}'";
	$sql.=",'open','open','post','{$updir['baseurl']}/{$cast_id}/{$chg}-revision-v1/','post','0')";
	$wpdb->query($sql);
	$tmp_auto=$wpdb->insert_id;

	$sql="INSERT INTO wp01_posts ";
	$sql.="(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_modified, post_modified_gmt, comment_status, ping_status, post_name, guid, post_type, post_parent)";
	$sql.="VALUES";
	$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','{$log}','{$ttl}','publish','{$date_jst}','{$date_gmt}'";
	$sql.=",'closed','closed','{$tmp_auto}-revision-v1','{$updir['baseurl']}/{$cast_id}/{$tmp_auto}-revision-v1/','revision','{$tmp_auto}')";
	$wpdb->query($sql);

	$sql="INSERT INTO wp01_term_relationships";
	$sql.="(object_id,term_taxonomy_id)";
	$sql.="VALUES";
	$sql.="('{$tmp_auto}','{$term[0]}'),";
	$sql.="('{$tmp_auto}','{$term[1]}')";
	$wpdb->query($sql);

	if($img_code){
		$tmp_auto2=$tmp_auto+2;
		$link2	="../../../../wp-content/uploads/np{$cast_id}/img_{$tmp_auto}-600x600.png";

		$img2 		= imagecreatetruecolor(600,600);
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
		imagepng($img2,$link2);

		$sql="INSERT INTO wp01_posts ";
		$sql.="(post_author,post_date,post_date_gmt,post_title,post_status,post_modified,post_modified_gmt, comment_status,ping_status,post_name,guid,post_type,post_mime_type,post_parent)";
		$sql.="VALUES";
		$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','img_{$tmp_auto}','inherit','{$date_jst}','{$date_gmt}'";
		$sql.=",'open','closed','img_{$tmp_auto}','{$updir['baseurl']}/np{$cast_id}/img_{$tmp_auto}.png','attachment','image/png','{$tmp_auto}')";
		$wpdb->query($sql);
		echo $sql;

		$tmp_in="a:5:{s:5:\"width\";i:1568;s:6:\"height\";i:1044;s:4:\"file\";s:44:\"np{$cast_id}/img_{$tmp_auto}.png\";s:5:\"sizes\";a:5:{s:6:\"medium\";a:4:{s:4:\"file\";s:44:\"img_{$tmp_auto}-300x200.png\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:45:\"img_{$tmp_auto}-1024x682.png\";s:5:\"width\";i:1024;s:6:\"height\";i:682;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:44:\"img_{$tmp_auto}-150x50.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:45:\"img_{$tmp_auto}-768x511.png\";s:5:\"width\";i:768;s:6:\"height\";i:511;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"1536x1536\";a:4:{s:4:\"file\";s:45:\"img_{$tmp_auto}-1536x1023.png\";s:5:\"width\";i:1536;s:6:\"height\";i:1023;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"1\";s:8:\"keywords\";a:0:{}}}";

		$sql	 ="INSERT INTO wp01_postmeta(post_id,meta_key,meta_value)";
		$sql	.="VALUES('{$tmp_auto}','_thumbnail_id','{$tmp_auto2}'),";
		$sql	.="('{$tmp_auto}','_wp_attached_file','np{$cast_id}/img_{$tmp_auto}.png'),";
		$sql	.="('{$tmp_auto}','_wp_attachment_metadata','{$tmp_in}'),";
		$sql	.="('{$tmp_auto}','_wp_attachment_image_alt','{$date_jst}')";
		$wpdb->query($sql);
	}
}
exit();
?>