<?
/*
logSet
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$c_id		=$_POST["c_id"];


$item_name	=$_POST["item_name"];
$item_icon	=$_POST["item_icon"];
$item_color	=$_POST["item_color"];
$item_price	=$_POST["item_price"];

$now=date("Y-m-d H:i:s",$jst);

$yy			=substr('0000'.$_POST["yy"],-4,4);
$mm			=substr('00'.$_POST["mm"],-2,2);
$dd			=substr('00'.$_POST["dd"],-2,2);

$hh_s		=substr('00'.$_POST["hh_s"],-2,2);
$ii_s		=substr('00'.$_POST["ii_s"],-2,2);

$hh_e		=substr('00'.$_POST["hh_e"],-2,2);
$ii_e		=substr('00'.$_POST["ii_e"],-2,2);

$log		=$_POST["log"];
$chg		=$_POST["chg"];
$del		=$_POST["del"];

$sdate	=$yy.$mm.$dd;
$stime	=$hh_s.$ii_s;
$etime	=$hh_e.$ii_e;

if($del > 0){//■削除
	$sql="DELETE FROM wp01_0cast_log WHERE log_id='{$del}'";
	$wpdb->query($sql);

	$sql="DELETE FROM wp01_0cast_log_list WHERE master_id='{$del}'";
	$wpdb->query($sql);
	exit();
}

if($chg){//■変更
	$sql=" UPDATE wp01_0cast_log SET";
	$sql.=" sdate='{$sdate}',";
	$sql.=" stime='{$stime}',";
	$sql.=" etime='{$etime}',";
	$sql.=" log='{$log}'";
	$sql.=" WHERE log_id='{$chg}'";
	$wpdb->query($sql);

	$sql="DELETE FROM wp01_0cast_log_list WHERE master_id='{$chg}'";
	$wpdb->query($sql);
	$tmp_auto=$chg;


}else{//新規
	$sql_log ="INSERT INTO wp01_0cast_log(`date`,`sdate`,`stime`,`etime`,`cast_id`,`customer_id`,`log`) VALUES ";
	$sql_log.=" ('{$now}','{$sdate}','{$stime}','{$etime}','{$cast_id}','{$c_id}','{$log}')";
	$wpdb->query($sql_log);
	$tmp_auto=$wpdb->insert_id;
}

$log=str_replace("\n","<br>",$log);

$sdate=substr($sdate,0,4)."/".substr($sdate,4,2)."/".substr($sdate,6,2);
$stime=substr($stime,0,2).":".substr($stime,2,2);
$etime=substr($etime,0,2).":".substr($etime,2,2);

$dat.="<tr id=\"customer_log_td_{$dat1["id"]}\"><td class=\"customer_log_td\">";

$dat.="<div class=\"customer_log_date\"> <span class=\"customer_log_icon\"></span><span class=\"customer_log_date_detail\">{$sdate} {$stime}-{$etime}</span>";
$dat.="<div id=\"m_chg{$dat1["id"]}\" class=\"customer_log_chg\"></div>";
$dat.="<div id=\"l_del{$dat1["id"]}\" class=\"customer_log_del\"></div>";
$dat.="</div>";
$dat.="<div class=\"customer_log_memo\">";
$dat.="{$log}";
$dat.="</div>";
$dat.="<div class=\"customer_log_list\">";

if($item_name){
	$sql_log ="INSERT INTO wp01_0cast_log_list(`master_id`,`log_color`,`log_icon`,`log_comm`,`log_price`) VALUES ";
	foreach($item_name as $a1 => $a2){
		$item_color[$a1]=str_replace("rgb(","",$item_color[$a1]);
		$item_color[$a1]=str_replace(")","",$item_color[$a1]);
		$tmp_color=explode(",",$item_color[$a1]);

		$tmp_1=substr('00'.dechex($tmp_color[0]),-2,2);
		$tmp_2=substr('00'.dechex($tmp_color[1]),-2,2);
		$tmp_3=substr('00'.dechex($tmp_color[2]),-2,2);
		$tmp="#".$tmp_1.$tmp_2.$tmp_3;

		$sql_log.=" ('{$tmp_auto}','{$tmp}','{$item_icon[$a1]}','{$item_name[$a1]}','{$item_price[$a1]}'),";
		$app.="<div class=\"customer_log_item\" style=\"border:1px solid {$tmp}; color:{$tmp};\">";
		$app.="<span class=\"sel_log_icon_s\">{$item_icon[$a1]}</span>";
		$app.="<span class=\"sel_log_comm_s\">{$item_name[$a1]}</span>";
		$app.="<span class=\"sel_log_price_s\">{$item_price[$a1]}</span>";
		$app.="</div>";
	}
	$sql_log=substr($sql_log,0,-1);
	$wpdb->query($sql_log);
	$dat.=$app."</span></td></tr>";
}

echo $dat;
exit();
?>
