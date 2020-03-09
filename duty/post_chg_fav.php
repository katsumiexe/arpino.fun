<?
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 


$chg	=$_POST["chg"];
$uid	=$_POST["uid"];
$log_id	=$_POST["log_id"];



$sql2 ="UPDATE me_fav SET"; 
$sql2.=" WHERE user_id='{$host_id}'";
$sql2.=" GROUP BY day,action";
$sql2.=" ORDER BY log_id DESC";



echo json_encode($dat_p);
exit;
?>




