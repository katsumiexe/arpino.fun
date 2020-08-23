<?
/*
BlogSet
*/
require_once ("./post_inc.php");
$date_gmt=date("Y-m-d H:i:s");
$now=date("Y-m-d H:i:s",$jst);
$cast_id	=$_POST["cast_id"];
$blog_id	=$_POST["blog_id"];

$url=get_template_directory_uri();

//■Blog------------------
$sql ="SELECT * FROM wp01_posts";
$sql.=" LEFT JOIN wp01_term_relationships ON wp01_posts.ID=wp01_term_relationships.object_id";
$sql.=" LEFT JOIN wp01_term_taxonomy ON wp01_term_relationships.term_taxonomy_id=wp01_term_taxonomy.term_id";
$sql.=" LEFT JOIN wp01_terms ON wp01_term_relationships.term_taxonomy_id=wp01_terms.term_id";

$sql.=" WHERE post_type='post'";
$sql.=" AND wp01_term_taxonomy.taxonomy='category'";
$sql.=" AND wp01_terms.slug='{$cast_id}'";
$sql.=" AND wp01_posts.post_date<'{$blog_id}'";
$sql.=" ORDER BY post_date DESC";
$sql.=" LIMIT 11";

$dat = $wpdb->get_results($sql,ARRAY_A );

$blog_max=count($dat);
if($blog_max>10){
	$blog_max=10;
}
$n=0;

foreach($dat as $tmp){
	$img_tmp=$tmp["ID"]+2;
	$updir = wp_upload_dir();

	$sql ="SELECT * FROM wp01_term_relationships";
	$sql.=" LEFT JOIN wp01_terms ON wp01_term_relationships.term_taxonomy_id=wp01_terms.term_id";
	$sql.=" WHERE object_id='{$tmp["ID"]}'";
	$sql.=" AND slug LIKE 'tag%'";

	$dat2 = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat2 as $tmp2){
		$tag_name[$n][]		=$tmp2["name"];
	}

	$sql ="SELECT * FROM wp01_postmeta";
	$sql.=" WHERE post_id='{$tmp["ID"]}'";
	$sql.=" AND meta_key='_thumbnail_id'";
	$thumb = $wpdb->get_var($sql);
	if($thumb){
		$blog[$n]["img"]="{$updir['baseurl']}/np{$cast_id}/img_{$img_tmp}.png?t=".time();
		$blog[$n]["img_on"]="{$updir['baseurl']}/np{$cast_id}/img_{$img_tmp}.png?t=".time();

	}else{
		$blog[$n]["img"]=get_template_directory_uri()."/img/customer_no_img.jpg?t=".time();
	}

	$blog[$n]["id"]		=$tmp["ID"];
	$blog[$n]["date"]	=$tmp["post_date"];
	$blog[$n]["title"]	=$tmp["post_title"];
	$blog[$n]["content"]=str_replace("\n","<br>",$tmp["post_content"]);
	$blog[$n]["count"]	=$tmp["comment_count"];

	if($tmp["post_status"] == "draft"){
		$blog[$n]["status"]=3;

	}elseif($tmp["post_status"] == "pending"){
		$blog[$n]["status"]=2;

	}elseif($tmp["post_date"] > $now){
		$blog[$n]["status"]=1;

	}elseif($tmp["post_status"] == "publish"){
		$blog[$n]["status"]=0;
	}	
	$n++;
}

$sql ="SELECT * FROM wp01_terms";
$sql.=" LEFT JOIN wp01_term_taxonomy ON wp01_terms.term_id=wp01_term_taxonomy.term_id";
$sql.=" WHERE taxonomy='post_tag'";
$dat = $wpdb->get_results($sql,ARRAY_A );

foreach($dat as $a1){
	$tag_list[$a1["slug"]]=$a1["name"];
}

$sql ="SELECT * FROM wp01_0cast_log_table";
$sql.=" WHERE cast_id='{$cast_id}'";
$dat = $wpdb->get_results($sql,ARRAY_A );

foreach($dat as $a1){
	$log_item[$a1["sort"]]=$a1;
}
ksort($log_item);

foreach($log_item as $a1 => $a2){
	$log_list_cnt.='"i'.$a1.'",';
}
$log_list_cnt=substr($log_list_cnt,0,-1);

$blog_st[0]="<span class=\"hist_status hist_0\">公開</span>";
$blog_st[1]="<span class=\"hist_status hist_1\">予約</span>";
$blog_st[2]="<span class=\"hist_status hist_2\">削除</span>";
$blog_st[3]="<span class=\"hist_status hist_3\">非公開</span>";

if($status<=1 && $now < $date_jst){
	$status=1;
}

if($img_code){
	$tmp_img="{$updir['baseurl']}/np{$cast_id}/img_{$tmp_auto2}.png";

}else{
	$tmp_img="{$url}/img/customer_no_img.jpg";
}

for($n=0;$n<$blog_max;$n++){
	$html.="<div id=\"blog_hist_{$blog[$n]["id"]}\" class=\"blog_hist\">";
	$html.="<div class=\"blog_hist_in\">";
	$html.="<img src=\"{$blog[$n]["img"]}\" class=\"hist_img\">";
	$html.="<span class=\"hist_date\">{$blog[$n]["date"]}</span>";
	$html.="<span class=\"hist_title\">{$blog[$n]["title"]}</span>";
	$html.="<span class=\"hist_tag\">";
	if($tag_name[$n]){
		foreach($tag_name[$n] as $a2){
			$html.="{$a2}/";
		}
	}
	$html.="</span>";
	$html.="</div>";
	$html.="<div class=\"hist_log\">";

	if($blog[$n]["img_on"]){
		$html.="<span class=\"hist_img_in\"><img src=\"{$blog[$n]["img"]}\" class=\"hist_img_on\"></span>";
	}

	$html.="<span class=\"blog_log\">{$blog[$n]["content"]}</span>";
	$html.="</div>";
	$html.="<span class=\"hist_watch\"><span class=\"hist_i\"></span><span class=\"hist_watch_c\">0</span></span>";
	$html.="<span class=\"hist_comm\"><span class=\"hist_i\"></span><span class=\"hist_comm_c\">{$blog[$n]["count"]}</span></span>";
	$html.=$blog_st[$blog[$n]["status"]];
	$html.="</div>";
}

if($blog[10]["date"]){
$html.="<div class=\"blog_ad\"><img src=\"{$url}/img/ad/bn.jpg\" style=\"width:100%;\"></div>";
$html.="<div id=\"blog_next_{$blog[10]["date"]}\" class=\"blog_next\">続きを読む</div>";
}
echo $html;
exit();
?>