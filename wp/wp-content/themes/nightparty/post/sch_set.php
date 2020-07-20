<?
/*
通常ページ　CAST読み込み
*/
require_once ("./post_inc.php");
$now=date("Y-m-d H:i:s",$jst);

$date		=$_POST['date'];


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
