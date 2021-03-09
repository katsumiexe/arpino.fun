<?
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
include_once('../library/sql_post.php');
$group	=$_POST["group"];
$name	=$_POST["name"];
$nick	=$_POST["nick"];
$fav	=$_POST["fav"];
$img	=$_POST["img"];

$yy	=$_POST["yy"];
$mm	=$_POST["mm"];
$dd	=$_POST["dd"];
$ag	=$_POST["ag"];

if($yy && $mm && $dd){
	$birth=$yy.$mm.$dd;
}else{
	$birth="00000000";
}

$sql ="SELECT * FROM wp01_0customer_item"; 
$sql .=" WHERE gp=0"; 
$sql .=" AND del=0"; 
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$dat[]=$row;
	}
}

$sql ="INSERT INTO wp01_0customer (`cast_id`,`nickname`,`name`,`regist_date`,`birth_day`,`face`,`fav`,`c_group`)";
$sql .=" VALUES('{$cast_data["id"]}','{$nick}','{$name}','{$now}','{$birth}','{$clist}','{$fav}','{$group}')";
mysqli_query($mysqli,$sql);
$tmp_auto=mysqli_insert_id($mysqli);

if($dat){
	$sql ="INSERT INTO wp01_0customer_list (`cast_id`,`customer_id`,`item`) VALUES";
	foreach($dat as $a1){
		$sql .="('{$cast_data["id"]}','{$tmp_auto}','{$a1}'),";
	}
	$sql=substr($sql,0,-1);
	mysqli_query($mysqli,$sql);
}


if($img_code){

	$img_link="../img/cast/{$box_no}/c/{$dec[$id_0][$tmp_auto]}.png";
	$img	= imagecreatefromstring(base64_decode($img_code));	
	$img2	= imagecreatetruecolor(160,160);
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 160, 160, 300, 300);
	imagepng($img2,$img_link.".png");
	$tmp_img="<img src=\"{$img_link}.png\" class=\"mail_img\">";
}else{
	$html_img="<img src=\"./img/customer_no_img.jpg\" class=\"mail_img\">";
}


for($s=1;$s<6;$s++){
	$html_fav.="<span id=\"fav_{$tmp_auto}_{$s}\" class=\"customer_list_fav_icon";

	if($fav>=$s){
		$html_fav.=" fav_in";
	}
	$html_fav.="\"></span>\"";
}

$html="<div id=\"clist{$tmp_auto}\" class=\"customer_list\">";
$html.=$html_img;
$html.="<div class=\"customer_list_fav\">";
$html.=$html_fav;
$html.="</div>";

$html.="<div class=\"customer_list_name\">{$name} 様</div>";
$html.="<div class=\"customer_list_nickname\">{$nick}</div>";
$html.="<span class=\"mail_al\"></span>";
$html.="<input type=\"hidden\" class=\"customer_hidden_fav\" value=\"{$fav}\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_yy\" value=\"{$yy}\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_mm\" value=\"{$mm}\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_dd\" value=\"{$dd}\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_ag\" value=\"{$ag}\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_group\" value=\"{$group}\">";

$html.="<input type=\"hidden\" class=\"customer_hidden_mail\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_tel\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_twitter\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_facebook\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_insta\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_line\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_web\" value=\"\">";
$html.="</div>";
echo $html;
exit();
?>
