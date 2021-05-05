<?
include_once('../../library/sql_post.php');
$blog_id	=$_POST["blog_id"];

//■Blog------------------
$n=0;

$sql ="SELECT * FROM wp01_posts";

$sql.=" WHERE status<3";
$sql.=" AND cast='{$cast_id}'";
$sql.=" AND view_date<'{$blog_id}'";
$sql.=" ORDER BY view_date DESC";
$sql.=" LIMIT 11";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$blog[$n]=$row;
	}
}

$blog_max=$n;
if($blog_max>10){
	$blog_max=10;
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
$html.="<div id=\"blog_next_{$blog[10]["date"]}\" class=\"blog_next\">続きを読む</div>";
}
echo $html;
exit();
?>
