<?
include_once('../library/post_sql.php');

$move_id	=$_POST["move_id"];
$get_id		=$_POST["get_id"];
$move_ll	=$_POST["move_ll"];
$move_cc	=$_POST["move_cc"];
$move_ch	=$_POST["move_ch"];
$count		=$_POST["count"];


$sql="INSERT INTO komamemo_log(`host_id`,`date`,`colum`,`line`,`style`, `position`,`koma_id`,`count`)";
$sql.=" VALUES('{$cast["id"]}','{$now}','{$move_cc}','{$move_ll}','{$move_ch}','0','{$move_id}','{$count}')";
mysqli_query($mysqli,$sql);

if($get_id){
	$sql="INSERT INTO komamemo_log(`host_id`,`date`,`colum`,`line`,`style`, `position`,`koma_id`,`count`)";
	$sql.=" VALUES('{$cast["id"]}','{$now}','0','0','0','0','{$get_id}','{$count}')";
	mysqli_query($mysqli,$sql);
}

$ps=($count+1) % 2;
$_SESSION[$ps][$move_id]["cc"]=$move_cc;
$_SESSION[$ps][$move_id]["ll"]=$move_ll;
$_SESSION[$ps][$move_id]["ch"]=$move_ch;


?>
