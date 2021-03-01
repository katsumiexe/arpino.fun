<?
include_once('../library/sql_cast.php');
$base_day	=$_POST['base_day']+86400*7-($config["start_time"]*3600);
$sel_in		=$_POST['sel_in'];
$sel_out	=$_POST['sel_out'];

$sql_log="INSERT INTO wp01_0schedule ";
$sql_log.="(sche_date,date,cast_id,stime,etime)";
$sql_log.="VALUES";

for($n=0;$n<7;$n++){
	if(!$sel_in[$n] || !$sel_out[$n]){
		$sel_in[$n]="";
		$sel_out[$n]="";
	}

	$day_8=date("Ymd",$base_day+86400*$n);
	if($day_8 >=$now_8){
		$sql_log_app.="('{$day_8}','{$now}','{$cast_id}','{$sel_in[$n]}','{$sel_out[$n]}'),";
		$day_date[$day_8]=$sel_in[$n];
	}
}

if($sql_log_app){
	$sql_log.=substr($sql_log_app,0,-1);
	mysqli_query($mysqli,$sql_log);
}

echo json_encode($day_date);
exit();
?>
