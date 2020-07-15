<?
/*
顧客情報読み込み
*/
require_once ("./post_inc.php");

$regist_date=date("Y-m-d H:i:s",$jst);

$group	=$_POST["group"];
$name	=$_POST["name"];
$nick	=$_POST["nick"];
$fav	=$_POST["fav"];
$cast_id=$_POST["cast_id"];
$img	=$_POST["img"];

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


if($img_code){
	$sql ="SELECT * FROM wp01_0encode"; 
	$enc0 = $wpdb->get_results($sql,ARRAY_A );
	foreach($enc0 as $row){
		$enc[$row["key"]]				=$row["value"];
		$dec[$row["gp"]][$row["value"]]	=$row["key"];
	}

	$id_8=substr("00000000".$cast_id,-8);
	$id_0	=$cast_id % 20;

	for($n=0;$n<8;$n++){
		$tmp_id=substr($id_8,$n,1);
		$tmp_dir.=$dec[$id_0][$tmp_id];
	}

	for($n=0;$n<strlen($c_id);$n++){
		$cus=substr($c_id,$n,1);
		$rnd=rand(0,19);
		$clist=$dec[$rnd][$cus];
	}

	$clist.=".png";
	$res=get_template_directory_uri()."/img/cast/".$tmp_dir."/c/".$clist;
	$link="../img/cast/".$tmp_dir."/c/".$clist;

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
	imagepng($img2,$link);
}

if($yy && $mm && $dd){
	$birth=$yy."-".$mm."-".$dd;
}else{
	$birth="0000-00-00";
}

$sql_log ="INSERT INTO wp01_0customer (`cast_id`,`nickname`,`name`,`regist_date`,`birth_day`,`face`,`fav`,`c_group`)";
$sql_log .=" VALUES('{$cast_id}','{$nick}','{$name}','{$regist_date}','{$birth}','{$clist}','{$fav}','{$group}')";
$wpdb->query($sql_log);

echo($sql_log);
exit();
?>
