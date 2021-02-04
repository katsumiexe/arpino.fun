<?
/*
BlogSet
*/
require_once ("./post_inc.php");
$date_gmt=date("Y-m-d H:i:s");
$now=date("Y-m-d H:i:s",$jst);
$updir = wp_upload_dir();

$blog_st[0]="<span class=\"hist_status hist_0\">公開</span>";
$blog_st[1]="<span class=\"hist_status hist_1\">予約</span>";
$blog_st[2]="<span class=\"hist_status hist_2\">非公開</span>";
$blog_st[3]="<span class=\"hist_status hist_3\">削除</span>";

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
$img_id		=$_POST["img_id"];

$sql ="SELECT term_id FROM wp01_terms";
$sql.=" WHERE slug='{$cast_id}'";
$dat = $wpdb->get_row($sql,ARRAY_A );

if(!$dat){
	$sql	 ="INSERT INTO wp01_terms(`name`,`slug`)";
	$sql	.=" VALUES('{$_SESSION["genji"]}','{$cast_id}')";
	$wpdb->query($sql);

	$terms_id=$wpdb->insert_id;

	$sql	 ="INSERT INTO wp01_term_taxonomy(`term_id`,`taxonomy`)";
	$sql	.=" VALUES('{$terms_id}','category')";
	$wpdb->query($sql);

}else{
	$terms_id=$dat["term_id"];
}

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

	$auto_0=$chg;
	$auto_2=$chg+2;

	if($img_del){
		$sql="UPDATE wp01_postmeta SET";
		$sql.=" meta_key='_thumbnail_id_out'";
		$sql.=" WHERE meta_key='_thumbnail_id'";
		$sql.=" AND post_id='{$chg}'";
		$wpdb->query($sql);

	}elseif($img_code){
		$mk_dir="../../../../wp-content/uploads/np{$cast_id}/";
		if(!is_dir($mk_dir)) {
			mkdir($mk_dir, 0777, TRUE);
			chmod($mk_dir, 0777);
		}
		$img	= imagecreatefromstring(base64_decode($img_code));	

		$link	="../../../../wp-content/uploads/np{$cast_id}/img_{$auto_2}_s.png";
		$img2	= imagecreatetruecolor(150,150);
		ImageCopyResampled($img2, $img, 0, 0, 0, 0, 150, 150, 600, 600);
		imagepng($img2,$link);

		$link	="../../../../wp-content/uploads/np{$cast_id}/img_{$auto_2}.png";
		$img2	= imagecreatetruecolor(600,600);
		ImageCopyResampled($img2, $img, 0, 0, 0, 0, 600, 600, 600, 600);
		imagepng($img2,$link);

		$img_id=$auto_2;

		$sql.=",('{$cast_id}','{$date_jst}','{$date_gmt}','','img_{$auto_2}','inherit','{$date_jst}','{$date_gmt}'";
		$sql.=",'open','closed','img_{$auto_2}','{$updir['baseurl']}/np{$cast_id}/img_{$auto_2}.png','attachment','image/png','')";
		$img_origin			="img_{$auto_2}.png";
		$img_origin_cnt		=mb_strlen($img_origin);

		$tmp_in="a:5:{s:5:\"width\";i:600;s:6:\"height\";i:600;s:4:\"file\";s:{$img_origin_cnt}:\"{$img_origin}\";s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}";
		$sql_app	.="('{$auto_2}','_wp_attached_file','np{$cast_id}/img_{$auto_2}.png'),";
		$sql_app	.="('{$auto_2}','_wp_attachment_metadata','{$tmp_in}'),";
		$sql_app	.="('{$auto_2}','_wp_attachment_image_alt','{$date_jst}'),";
		$sql_app	.="('{$auto_0}','_thumbnail_id','{$auto_2}')";

	}elseif($img_id){
		$sql_app	.="('{$auto_0}','_thumbnail_id','{$img_id}')";
	}

}else{
	$sql="SELECT max(ID) AS m_id FROM wp01_posts";
	$tmp = $wpdb->get_row($sql,ARRAY_A);
	$auto_0=$tmp["m_id"]+1;
	$auto_1=$tmp["m_id"]+2;
	$auto_2=$tmp["m_id"]+3;

	$sql="INSERT INTO wp01_posts ";
	$sql.="(post_author, post_date, post_date_gmt, post_content, post_title, post_status, post_modified, post_modified_gmt, comment_status, ping_status, post_name, guid, post_type, post_mime_type, post_parent)";
	$sql.="VALUES";

//■main
	$sql.="('{$cast_id}','{$date_jst}','{$date_gmt}','{$log}','{$ttl}','publish','{$date_jst}','{$date_gmt}'";
	$sql.=",'open','open','post','{$updir['baseurl']}/{$cast_id}/','post','','0')";

//■revision
	$sql.=",('{$cast_id}','{$date_jst}','{$date_gmt}','{$log}','{$ttl}','inherit','{$date_jst}','{$date_gmt}'";
	$sql.=",'closed','closed','{$auto_0}-revision-v1','blog/{$cast_id}/{$auto_0}-revision-v1/','revision','','{$auto_0}')";

	if($img_code){
		$mk_dir="../../../../wp-content/uploads/np{$cast_id}/";
		if(!is_dir($mk_dir)) {
			mkdir($mk_dir, 0777, TRUE);
			chmod($mk_dir, 0777);
		}

		$link	="../../../../wp-content/uploads/np{$cast_id}/img_{$auto_2}.png";

		$img	= imagecreatefromstring(base64_decode($img_code));	
		$img2	= imagecreatetruecolor(600,600);
		ImageCopyResampled($img2, $img, 0, 0, 0, 0, 600, 600, 600, 600);
		imagepng($img2,$link);

		$img_id=$auto_2;

		$sql.=",('{$cast_id}','{$date_jst}','{$date_gmt}','','img_{$auto_2}','inherit','{$date_jst}','{$date_gmt}'";
		$sql.=",'open','closed','img_{$auto_2}','{$updir['baseurl']}/np{$cast_id}/img_{$auto_2}.png','attachment','image/png','')";

		$img_origin			="img_{$auto_2}.png";
		$img_origin_cnt		=mb_strlen($img_origin);

		$tmp_in="a:5:{s:5:\"width\";i:600;s:6:\"height\";i:600;s:4:\"file\";s:{$img_origin_cnt}:\"{$img_origin}\";s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}";
		$sql_app	.="('{$auto_2}','_wp_attached_file','np{$cast_id}/img_{$auto_2}.png'),";
		$sql_app	.="('{$auto_2}','_wp_attachment_metadata','{$tmp_in}'),";
		$sql_app	.="('{$auto_2}','_wp_attachment_image_alt','{$date_jst}'),";
		$sql_app	.="('{$auto_0}','_thumbnail_id','{$auto_2}')";
	}elseif($img_id){
		$sql_app	.="('{$auto_0}','_thumbnail_id','{$img_id}')";
	}

	$wpdb->query($sql);

//	$sql.="(post_author,post_date,post_date_gmt,post_content, post_title, post_status, post_modified, post_modified_gmt, comment_status, ping_status, post_name, guid, post_type, post_mime_type,post_parent)";

	$sql_meta="INSERT INTO wp01_postmeta";
	$sql_meta.="(post_id, meta_key, meta_value)";
	$sql_meta.="VALUES";
	$sql_meta.=$sql_app;
	$wpdb->query($sql_meta);

	$sql="INSERT INTO wp01_term_relationships";
	$sql.="(object_id,term_taxonomy_id)";
	$sql.="VALUES";
	$sql.="('{$auto_0}','{$tag}'),";
	$sql.="('{$auto_0}','{$terms_id}')";
	$wpdb->query($sql);
}

if($img_id){
	$tmp_img_s="{$updir['baseurl']}/np{$cast_id}/img_{$img_id}_s.png";
	$tmp_img="{$updir['baseurl']}/np{$cast_id}/img_{$img_id}.png";

}else{
	$tmp_img_s="{get_template_directory_uri()}/img/customer_no_img.jpg";
	$tmp_img="{get_template_directory_uri()}/img/customer_no_img.jpg";
}

$log=str_replace("\n","<br>",$log);

$html="<div id=\"blog_hist_{$auto_0}\" class=\"blog_hist\">";
$html.="<img src=\"{$tmp_img_s}\" class=\"hist_img\">";
$html.="<span class=\"hist_date\">{$date_jst}</span>";
$html.="<span class=\"hist_title\">{$ttl}</span>";

$html.="<span class=\"hist_tag\"></span>";
$html.="<span class=\"hist_watch\"><span class=\"hist_i\"></span><span class=\"hist_watch_c\">0</span></span>";
$html.="<span class=\"hist_status hist_{$open} \">{$blog_st[$open]}</span>";

$html.="<div class=\"hist_log\">";
if($img_id){
$html.="<span class=\"hist_img_in\"><img src=\"{$tmp_img}\" class=\"hist_img_on\"></span>";
}
$html.="<span class=\"blog_log\">{$log}</span>";
$html.="</div>";
$html.="</div>";
echo $html;
exit();
?>

