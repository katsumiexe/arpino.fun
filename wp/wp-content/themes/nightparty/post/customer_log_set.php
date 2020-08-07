<?
/*
BlogSet
*/

require_once ("./post_inc.php");
$date_gmt=date("Y-m-d H:i:s");

c_id		=$_POST["c_id"];
$log		=$_POST["log"];
$cast_id	=$_POST["cast_id"];

$sdate		=$_POST["sdate"];
$edate		=$_POST["edate"];
$stime		=$_POST["stime"];
$etime		=$_POST["etime"];




$sql_log ="INSERT INTO wp01_0cast_log(`date`,`sdate`,`stime`,`edate`,`etime`,`cast_id`,`customer_id`) VALUES ";
$sql_log.=" ('{$now}','{$sdate}','{$edate}','{$stime}','{$edate}','{$c_id}','{$cast_id}')";
$wpdb->query($sql_log);
$tmp_auto=$wpdb->insert_id;


$sql_log ="INSERT INTO wp01_0cast_log_list(`master_id`,`action_id`) VALUES ";
for($n=0;$n<count($dat);$n++){
	$sql_log.=" ('{$tmp_auto}','{$dat[$n]}),";
}

$sql_log=substr($sql_log,0,-1);
$wpdb->query($sql_log);

echo $dat;
exit();
?>
