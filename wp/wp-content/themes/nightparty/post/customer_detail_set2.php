<?
/*
誕生日変更
*/
require_once ("./post_inc.php");

$c_id	=$_POST["c_id"];
$id		=$_POST["id"];
$yy		=$_POST["yy"];
$mm		=$_POST["mm"];
$dd		=$_POST["dd"];
$ag		=$_POST["ag"];

$dt=$yy.$mm."01";

$dt2=date("t",strtotime($dt));

if($dt2<$dd+0){
	$dd=$dt2;
}

if($id == "customer_detail_ag"){
	$tmp=$mm.$dd;

	if(date("md")>$tmp){
		$yy=date("Y")-$ag-1;
	}else{
		$yy=date("Y")-$ag;
	}
}else{
	$tmp=$yy.$mm.$dd;
	$ag		= floor(($now_8-$tmp)/10000);
}

$birth	=$yy."-".$mm."-".$dd;

$sql_log ="UPDATE wp01_0customer SET";
$sql_log .=" birth_day='{$birth}'";
$sql_log .=" WHERE id={$c_id}";
$wpdb->query($sql_log);

$dat["yy"]=$yy;
$dat["mm"]=$mm;
$dat["dd"]=$dd;
$dat["ag"]=$ag;
$dat["dt"]=$dt2;



echo json_encode($dat);
exit();
?>
