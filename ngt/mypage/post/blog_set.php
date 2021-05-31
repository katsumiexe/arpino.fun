<?
include_once('../../library/sql_post.php');

ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);


$blog_st[0]="<span class=\"hist_status hist_0\">公開</span>";
$blog_st[1]="<span class=\"hist_status hist_1\">非公開</span>";
$blog_st[2]="<span class=\"hist_status hist_2\">削除</span>";
$blog_st[3]="<span class=\"hist_status hist_3\">予約</span>";

$yy=$_POST["yy"];
$mm=$_POST["mm"];
$dd=$_POST["dd"];
$hh=$_POST["hh"];
$ii=$_POST["ii"];

$view_date	=$yy."-".$mm."-".$dd." ".$hh.":".$ii.":00";
$date_jst	=$yy.".".$mm.".".$dd." ".$hh.":".$ii;

$ttl		=$_POST["ttl"];
$log		=$_POST["log"];
$tag		=$_POST["tag"];
$cast_id	=$_POST["cast_id"];
$chg		=$_POST["chg"];
$status		=$_POST["status"];

$img_code	=$_POST["img_code"];
$img_id		=$_POST["img_id"];

if(!$status) $status=0;

if($status<1 && $now < $view_date){
	$view_data=3;

}else{
	$view_data=$status;
}

if($img_code){
	$img_name	 =time()+2121212121;
	$img_name	 ="p".$img_name;
	$img_link="../../img/profile/{$cast_data["id"]}/{$img_name}";

	$img	= imagecreatefromstring(base64_decode($img_code));	

	$img2	= imagecreatetruecolor(600,600);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 600, 600, 600, 600);
	imagepng($img2,$img_link.".png");

	$img2	= imagecreatetruecolor(200,200);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 200, 200, 600, 600);
	imagepng($img2,$img_link."_s.png");
	$tmp_img=substr($img_link,1).".png";

}elseif($img_id){
	$img_name	=$img_id;
	$tmp_img	="../img/profile/{$cast_data["id"]}/{$img_name}.png";

}else{
	$tmp_img="../img/blog_no_image.png";
}

$sql ="SELECT id, tag_name, tag_icon FROM wp01_0tag";
$sql.=" WHERE tag_group='blog'";
$sql.=" AND del='0'";
if($result = mysqli_query($mysqli,$sql)){
	while($raw = mysqli_fetch_assoc($result)){
		$tag_name[$raw["id"]]=$raw["tag_name"];
		$tag_icon[$raw["id"]]=$raw["tag_icon"];
	}
}

if($chg){
	$sql ="UPDATE wp01_0posts SET";
	$sql.=" `date`='{$now}',";
	$sql.=" view_date='{$view_date}',";
	$sql.=" title='{$ttl}',";
	$sql.=" log='{$log}',";
	$sql.=" cast='{$cast_data["id"]}',";
	$sql.=" tag='{$tag}',";
	$sql.=" img='{$img_name}',";
	$sql.=" `status`='{$status}'";
	$sql.=" WHERE id='{$chg}'";
	mysqli_query($mysqli,$sql);

}else{
	$sql="INSERT INTO wp01_0posts ";
	$sql.="(`date`, `view_date`, `title`, `log`, `cast`, `tag`, `img`, `status`)";
	$sql.="VALUES";
	$sql.="('{$now}','{$view_date}','{$ttl}','{$log}','{$cast_data["id"]}','{$tag}','{$img_name}','{$status}')";
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli); 
}

$log=str_replace("\n","<br>",$log);

$html=$sql;
$html.="<div id=\"blog_hist_{$auto_0}\" class=\"blog_hist\">";
$html.="<img id=\"b_img_{$img_name}\" src=\"{$tmp_img}\" class=\"hist_img\">";
$html.="<span class=\"hist_date\">{$date_jst}</span>";
$html.="<span class=\"hist_title\">{$ttl}</span>";
$html.="<span class=\"hist_tag\"><span class=\"hist_tag_i\">{$tag_icon[$tag]}</span><span class=\"hist_tag_name\">{$tag_name[$tag]}</span></span>";
$html.="<span class=\"hist_watch\"><span class=\"hist_i\"></span><span class=\"hist_watch_c\">0</span></span>";
$html.=$blog_st[$view_data];
$html.="</div>";
$html.="<div class=\"hist_log\">";



if($img_name){
$html.="<span class=\"hist_img_in\"><img src=\"../img/profile/{$cast_data["id"]}/{$img_name}.png\" class=\"hist_img_on\"></span><br>";
}
$html.="<span class=\"blog_log\">{$log}</span>";
$html.="</div>";
echo $html;
exit();
?>
