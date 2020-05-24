<?

$img_code	=$_POST["img_code"];
$img_zoom	=$_POST["img_zoom"];
$img_top	=$_POST["img_top"];
$img_left	=$_POST["img_left"];
$img_width	=$_POST["img_width"];
$img_height	=$_POST["img_height"];
$vw_base	=$_POST["vw_base"];
$img_rote	=$_POST["img_rote"]+0;

$tmp		=substr("0".$tmp_key+$img_id,-2,2);
$prof_x		=$enc[$tmp].".jpg";
$link		="./".$dir3.$prof_x;

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

$sql_log="UPDATE reg SET";
$sql_log.=" `reg_pic`='{$img_id}'";
$sql_log.=" WHERE id='{$user["id"]}'";
mysqli_query($mysqli,$sql_log);

ImageCopyResampled($img2, $img, 0, 0, $tmp_left, $tmp_top, 480, 800, $tmp_width, $tmp_height);
imagejpeg($img2,$link);
?>
<?=$link?>
