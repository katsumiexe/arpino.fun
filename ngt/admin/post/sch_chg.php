<?
include_once('../../library/sql_post_admin.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
$chg_s		=$_POST["chg_s"];
$chg_e		=$_POST["chg_e"];
$sch_d		=$_POST["sch_d"];

$cast_id	=$_POST["cast_id"];

$sql="INSERT INTO wp01_0schedule ";
$sql.="(`date`,`sche_date`,cast_id,stime,etime,signet) VALUES";

foreach($chg_s as $a1 => $a2){
	if($chg_s[$a1]=="休み"){
		$sql.="('{$now}','{$sch_d[$a1]}','{$cast_id}','','','1'),";

	}elseif($chg_e[$a1]){
		$sql.="('{$now}','{$sch_d[$a1]}','{$cast_id}','{$chg_s[$a1]}','{$chg_e[$a1]}','1'),";
	}
}

$sql=substr($sql,0,-1);
mysqli_query($mysqli,$sql);

echo $sql;
exit();
?>
