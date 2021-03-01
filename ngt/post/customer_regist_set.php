<?
include_once('../library/sql_cast.php');

$group	=$_POST["group"];
$name	=$_POST["name"];
$nick	=$_POST["nick"];
$fav	=$_POST["fav"];
$cast_id=$_POST["cast_id"];
$img	=$_POST["img"];
$vw_base=$_POST["vw_base"];

$yy	=$_POST["yy"];
$mm	=$_POST["mm"];
$dd	=$_POST["dd"];
$ag	=$_POST["ag"];

$img_code	=$_POST["img_code"];
$img_zoom	=$_POST["img_zoom"];
$img_top	=$_POST["img_top"];
$img_left	=$_POST["img_left"];
$img_width	=$_POST["img_width"];
$img_height	=$_POST["img_height"];
$vw_base	=$_POST["vw_base"];
$img_rote	=$_POST["img_rote"]+0;


if($yy && $mm && $dd){
	$birth=$yy."-".$mm."-".$dd;
}else{
	$birth="0000-00-00";
}

$sql ="SELECT * FROM wp01_0customer_item"; 
$sql .=" WHERE gp=0"; 
$sql .=" AND del=0"; 
$res0 = $wpdb->get_results($sql,ARRAY_A );
foreach($res0 as $row1){
	$dat[]=$row1["id"];
}


$sql_log ="INSERT INTO wp01_0customer (`cast_id`,`nickname`,`name`,`regist_date`,`birth_day`,`face`,`fav`,`c_group`)";
$sql_log .=" VALUES('{$cast_id}','{$nick}','{$name}','{$regist_date}','{$birth}','{$clist}','{$fav}','{$group}')";
$wpdb->query($sql_log);
$tmp_auto=$wpdb->insert_id;

$sql ="INSERT INTO wp01_0customer_list (`cast_id`,`customer_id`,`item`) VALUES";
foreach($dat as $a1){
	$sql .="('{$cast_id}','{$tmp_auto}','{$a1}'),";
}
$sql=substr($sql,0,-1);
$wpdb->query($sql);

if($img_code){
	for($n=0;$n<strlen($tmp_auto);$n++){
		$cus=substr($tmp_auto,$n,1);
		$rnd=rand(0,19);
		$clist=$dec[$rnd][$cus];
	}

	$clist.=".png";
	$link="../img/cast/{$box_no}/c/".$clist;
	$img2 		= imagecreatetruecolor(300,300);

/*
	$tmp_top	=floor(((($vw_base*10-$img_top)*10)/$vw_base)*100/$img_zoom);
	$tmp_left	=floor(((($vw_base*10-$img_left)*10)/$vw_base)*100/$img_zoom);

	$tmp_width	=floor(600/($img_zoom/100));
	$tmp_height	=floor(600/($img_zoom/100));
*/

	if($img_rote ==90){
		$new_img = imagecreatefromstring(base64_decode($img_code));	
		$img = imagerotate($new_img, 270, 0, 0);

	}elseif($img_rote ==180){
		$new_img = imagecreatefromstring(base64_decode($img_code));
		$img = imagerotate($new_img, 180, 0, 0);

	}elseif($img_rote ==270){
		$new_img = imagecreatefromstring(base64_decode($img_code));
		$img = imagerotate($new_img, 90, 0, 0);

	}else{
		$img = imagecreatefromstring(base64_decode($img_code));
	}
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 300, 300, 300, 300);
	imagepng($img2,$link);

	$sql_log ="UPDATE wp01_0customer SET";
	$sql_log .=" face='{$clist}'";
	$sql_log .=" WHERE id='{$tmp_auto}'";
	$wpdb->query($sql_log);

	$html_img ="<img src=\"{$res}\" class=\"mail_img\">";
	$html_img.="<input type=\"hidden\" class=\"customer_hidden_face\" value=\"{$clist}\">";

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
