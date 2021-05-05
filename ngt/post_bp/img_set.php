<?
/*
画像登録処理
*/

include_once('../library/sql_post.php');
$img_code	=$_POST["img_code"];
$img_top	=$_POST["img_top"];
$img_left	=$_POST["img_left"];
$img_width	=$_POST["img_width"];
$img_height	=$_POST["img_height"];
$img_zoom	=$_POST["img_zoom"];
$img_rote	=$_POST["img_rote"]+0;

$width_s	=$_POST["width_s"];
$width_l	=$_POST["width_l"];

$task		=$_POST["task"];
$post_id	=$_POST["post_id"];


if($task=="regist" or $task=="chg"){
	$size=300;

}else{
	$size=600;
}

$img2 		= imagecreatetruecolor($size,$size);

$tmp_top	=floor( ( $img_top  - $width_s ) * ( -600 / $width_l) * (100 / $img_zoom ) );
$tmp_left	=floor( ( $img_left - $width_s ) * ( -600 / $width_l) * (100 / $img_zoom ) );

if($img_width>$img_height){
	$tmp_width	=floor($img_height/($img_zoom/100));
	$tmp_height	=floor($img_height/($img_zoom/100));

}else{
	$tmp_width	=floor($img_width/($img_zoom/100));
	$tmp_height	=floor($img_width/($img_zoom/100));
}

if($img_rote ==90){
	$new_img = imagecreatefromstring(base64_decode($img_code));	
	$img = imagerotate($new_img, 270, 0, 0);

}elseif($img_rote ==270){
	$new_img = imagecreatefromstring(base64_decode($img_code));
	$img = imagerotate($new_img, 90, 0, 0);

}elseif($img_rote ==180){
	$new_img = imagecreatefromstring(base64_decode($img_code));
	$img = imagerotate($new_img, 180, 0, 0);

}else{
	$img = imagecreatefromstring(base64_decode($img_code));
}
ImageCopyResampled($img2, $img, 0, 0, $tmp_left, $tmp_top, $size, $size, $tmp_width, $tmp_height);

$tmpfname = tempnam('tmp', 'pngtmp_');
$tmp=imagepng($img2, $tmpfname);
$data = @file_get_contents($tmpfname);
unlink($tmpfname);

if($data) $img_64 = base64_encode($data);

if($task=="chg"){
	$sql ="UPDATE wp01_0customer SET";
	$sql .=" `face`='{$img_64}'";
	$sql .=" WHERE `id`='{$post_id}'";
	mysqli_query($mysqli,$sql);
}

echo $img_64;
exit()
?>
