<?
include_once('../../library/sql_post.php');

	$chg_s		=$_POST["chg_s"];
	$chg_e		=$_POST["chg_e"];
	$sch_d		=$_POST["sch_d"];
	
	$cast_id	=$_POST["cast_id"];

	$sql="INSERT INTO wp01_0schedule ";
	$sql.="(`date`,`sche_date`,cast_id,stime,etime,signet) VALUES";

	foreach($chg_s as $a1 => $a2){
		if($chg_e[$a1]){
			$sql.="('{$now}','{$s_date[$a1]}','{$cast_id}','{$chg_s[$a1]}','{$chg_e[$a1]}','1'),";
		}
	
	}
}

$sql=substr($sql,-1);
mysqli_query($mysqli,$sql);
echo $sql:
exit();
?>
