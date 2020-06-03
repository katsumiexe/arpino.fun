<?
/*
スケジュールセット処理
ini_set('display_errors',1);
*/
require_once ("../../../../wp-load.php");
global $wpdb;

$sel_in0	=$_POST['sel_in0'];
$sel_in1	=$_POST['sel_in1'];
$sel_in2	=$_POST['sel_in2'];
$sel_in3	=$_POST['sel_in3'];
$sel_in4	=$_POST['sel_in4'];
$sel_in5	=$_POST['sel_in5'];
$sel_in6	=$_POST['sel_in6'];

$sel_out0	=$_POST['sel_out0'];
$sel_out1	=$_POST['sel_out1'];
$sel_out2	=$_POST['sel_out2'];
$sel_out3	=$_POST['sel_out3'];
$sel_out4	=$_POST['sel_out4'];
$sel_out5	=$_POST['sel_out5'];
$sel_out6	=$_POST['sel_out6'];

$cast_id	=$_POST['cast_id'];
$base_day	=$_POST['base_day'];

$sql_log="INSERT INTO wp01_0schedule SET";

$sql_log.="(sche_date,cast_id,stime,etime)";
$sql_log.="VALUES";

for($n=0;$n<7;$n++){
	$day_8=date("Ymd",base_day+86400*$n);
	$sql_log.="('{$day_8}','{$cast_id}','{$sel_in[$n]}','{$sel_out[$n]}'),";
}
$sql_log=substr($sql_log,0,-1);
$wpdb->query($sql_log);
?>

