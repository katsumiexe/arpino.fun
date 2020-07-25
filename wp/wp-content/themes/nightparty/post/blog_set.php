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

$sql="INSERT INTO wp01_posts ";
$sql.="(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_modified, post_modified_gmt, comment_status, ping_status, post_name, guid, post_type, post_parent)";
$sql.="VALUES";
$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','{$log}','{$ttl}','publish','{$date_jst}','{$date_gmt}'";

if($chg){
	$sql.=",'close','close','{$chg}-revision-v1','blog/{$cast_id}/{$chg}-revision-v1/','revision','{$chg}')";
}else{
	$sql.=",'open','open','post','blog/{$cast_id}/{$chg}-revision-v1/','post','0')";
}

$wpdb->query($sql);
$tmp_auto=$wpdb->insert_id;

$sql	 ="INSERT INTO wp01_postmeta(post_id,meta_key,meta_value)";
$sql	.="VALUES('{$tmp_auto}','cast_name','{$cast_id}')";
if($tag){
$sql	.=",('{$tmp_auto}','blog_tag','{$tag}')";
}
$wpdb->query($sql);

if($img_code){
	$link	="{$wp_upload_dir['baseurl']}/np{$cast_id}/{$tmp_auto}.png";
	$link2	="../../../../wp-content/uploads/np{$cast_id}/{$tmp_auto}.png";

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
	$sql.="(post_author,post_date,post_date_gmt,post_title,post_status,post_modified,post_modified_gmt, comment_status,ping_status,post_name,guid,post_type,post_parent)";
	$sql.="VALUES";
	$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','img_{$tmp_auto}','inherit','{$date_jst}','{$date_gmt}'";
	$sql.=",'close','close','img_{$tmp_auto}','{$link}','image/png','{$tmp_auto}')";
	$wpdb->query($sql);
	echo $sql;

}

exit();
?>
