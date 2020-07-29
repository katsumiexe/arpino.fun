<?
/*
スケジュールセット処理
*/
require_once ("./post_inc.php");

$cast_id	=$_POST['cast_id'];
$base_day	=$_POST['base_day']+32400+86400*7;
$sel_in		=$_POST['sel_in'];
$sel_out	=$_POST['sel_out'];

$now=date("Y-m-d H:i:s",$jst);

$sql_log="INSERT INTO wp01_0schedule ";
$sql_log.="(sche_date,date,cast_id,stime,etime)";
$sql_log.="VALUES";

for($n=0;$n<7;$n++){
	$day_8=date("Ymd",$base_day+86400*$n);
	if($day_8 >=$now_8){
		$sql_log_app.="('{$day_8}','{$now}','{$cast_id}','{$sel_in[$n]}','{$sel_out[$n]}'),";
	}
}
if($sql_log_app){
	$sql_log.=substr($sql_log_app,0,-1);
	$wpdb->query($sql_log);
	echo $sql_log;
}
echo "[".date("Ymd",$base_day)."][".$base_day."][".$day_8."][".$now_8."]";
exit();
?>
