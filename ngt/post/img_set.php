<?
/*
画像登録処理
*/

$cast_id	=$_POST["cast_id"];
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

$c_id		=$_POST["c_id"]+0;
$img_url	=$_POST["img_url"]+0;

if($task=="regist" or $task=="chg"){
	$size=300;


}else{
	$size=600;
}

$img2 		= imagecreatetruecolor($size,$size);

/*
$tmp_top	=floor( ( $img_top  - $width_s ) * ( ) * ( $img_zoom /100) );
$tmp_left	=floor( ( $img_left - $width_s ) * ( ) * ( $img_zoom /100 ) );

$tmp_width	=floor($width_l/($img_zoom/100));
$tmp_height	=floor($width_l/($img_zoom/100));
*/


$tmp_top	=floor( ( $img_top  - $width_s ) * ( -600 / $width_l) * (100 / $img_zoom ) );
$tmp_left	=floor( ( $img_left - $width_s ) * ( -600 / $width_l) * (100 / $img_zoom ) );

$tmp_width	=floor($img_width/($img_zoom/100));
$tmp_height	=floor($img_width/($img_zoom/100));


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


$tmpfname	= tempnam('tmp', 'pngtmp_');
$tmp		=imagepng($img2, $tmpfname);
$data		=@file_get_contents($tmpfname);
unlink($tmpfname);
	if ($data) $img_64 = base64_encode($data);
echo $img_64;
exit()
?>
