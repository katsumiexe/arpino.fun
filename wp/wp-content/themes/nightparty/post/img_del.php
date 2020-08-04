<?
/*
画像登録処理
*/
ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;

$c_id		=$_POST["c_id"];
$cast_id	=$_POST["cast_id"];
$imgurl		=$_POST["imgurl"];

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


if($imgurl){
	$sql_log ="UPDATE wp01_0customer SET";
	$sql_log.=" `face`=''";
	$sql_log.=" WHERE id='{$c_id}'";
	$wpdb->query($sql_log);

//$link=get_template_directory_uri()."/img/cast/".$tmp_dir."/c/".$imgurl.".png";

$link="../img/cast/".$tmp_dir."/c/".$imgurl;

unlink($link);

echo get_template_directory_uri()."/img/customer_no_img.jpg?t=".time();

}
exit()
?>
