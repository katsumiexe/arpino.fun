<?
include_once('../library/sql_post.php');
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

if($open<=1 && $now < $date_jst){
	$view_data=1;

}else{
	$view_data=$open;
}

if($img_id){
	$img_name=$img_id;

}elseif($img_code){
	$img_name	 =time()+2121212121;
	$img_name	 ="p".$img_name;
}

$sql="INSERT INTO wp01_posts ";
$sql.="(date, view_date, title, log, cast, tag, img, status)";
$sql.="VALUES";
$sql.="('{$now}','{$view_date}','{$title}','{$log}','{$_SESSION["id"]}','{$tag}','{$img_name}','{$status}')";
mysqli_query($mysqli,$sql);
$tmp_auto=mysqli_insert_id($mysqli); 

if($img_name){
	$img_link="../img/profile/{$cast_data["id"]}/{$img_name}";

	$img	= imagecreatefromstring(base64_decode($img_code));	

	$img2	= imagecreatetruecolor(600,600);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 600, 600, 600, 600);
	imagepng($img2,$img_link.".png");

	$img2	= imagecreatetruecolor(200,200);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 200, 200, 600, 600);
	imagepng($img2,$img_link."_s.png");

	$tmp_img=substr($img_link,1).".png";

}else{
	$tmp_img="./img/blog_no_image.png";

}

if($chg){
	$sql ="UPDATE wp01_posts SET";
	$sql.=" revision_id='{$tmp_auto}',";
	$sql.=" status='4'";
	$sql.=" WHERE id='{$chg}'";
	mysqli_query($mysqli,$sql);
}


$log=str_replace("\n","<br>",$log);

$html="<div id=\"blog_hist_{$auto_0}\" class=\"blog_hist\">";
$html.="<img src=\"{$tmp_img_s}\" class=\"hist_img\">";
$html.="<span class=\"hist_date\">{$date_jst}</span>";
$html.="<span class=\"hist_title\">{$ttl}</span>";
$html.="<span class=\"hist_tag\">{$tag}</span>";
$html.="<span class=\"hist_watch\"><span class=\"hist_i\"></span><span class=\"hist_watch_c\">0</span></span>";
$html.=$blog_st[$view_data];
$html.="</div>";
$html.="<div class=\"hist_log\">";

if($img_id){
$html.="<span class=\"hist_img_in\"><img src=\"{$tmp_img}\" class=\"hist_img_on\"></span>";
}
$html.="<span class=\"blog_log\">{$log}</span>";
$html.="</div>";
echo $html;
exit();
?>
