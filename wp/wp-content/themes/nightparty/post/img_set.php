<?
/*
画像登録処理
*/
ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;

$cast_id	=$_POST["cast_id"];
$img_code	=$_POST["img_code"];
$img_zoom	=$_POST["img_zoom"];
$img_top	=$_POST["img_top"];
$img_left	=$_POST["img_left"];
$img_width	=$_POST["img_width"];
$img_height	=$_POST["img_height"];
$vw_base	=$_POST["vw_base"];
$img_rote	=$_POST["img_rote"]+0;
$c_id		=$_POST["c_id"]+0;

$tmp		=substr("0".$tmp_key+$img_id,-2,2);
$prof_x		=$enc[$tmp].".jpg";
$link		="./".$dir3.$prof_x;

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

$clist.=".jpg";


$link=get_template_directory_uri()."/".$tmp_dir."/c/".$clist;

$img2 		= imagecreatetruecolor(800,800);
$tmp_top	=floor(((($vw_base*10-$img_top)*10)/$vw_base)*100/$img_zoom);
$tmp_left	=floor(((($vw_base*10-$img_left)*10)/$vw_base)*100/$img_zoom);

$tmp_width	=floor(400/($img_zoom/100));
$tmp_height	=floor(400/($img_zoom/100));

if($img_rote ==90){
	$new_img = imagecreatefromstring(base64_decode($img_code));	
	$img = imagerotate($new_img, 270, 0, 0);

}elseif($img_rote ==270){
	$new_img = imagecreatefromstring(base64_decode($img_code));
	$img = imagerotate($new_img, 90, 0, 0);

}else{
	$img = imagecreatefromstring(base64_decode($img_code));
}

$sql_log ="UPDATE wp01_0customer SET";
$sql_log.=" `face`='{$clist}'";
$sql_log.=" WHERE id='{$c_id}'";
$wpdb->query($sql);

ImageCopyResampled($img2, $img, 0, 0, $tmp_left, $tmp_top, 480, 800, $tmp_width, $tmp_height);

imagejpeg($img2,$link);

?>
<?=$link?>
