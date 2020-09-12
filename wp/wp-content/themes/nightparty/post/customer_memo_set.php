<?
/*
顧客情報読み込み
*/
ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;
$now=date("Y-m-d H:i:s",time()+32400);

$c_id		=$_POST["c_id"];
$log		=$_POST["log"];
$cast_id	=$_POST["cast_id"];
$memo_id	=$_POST["memo_id"];

if($memo_id){
	$sql_log ="UPDATE wp01_0customer_memo SET";
	$sql_log.=" `date`='{$now}',";
	$sql_log.=" `log`='{$log}'";
	$sql_log.=" WHERE id='{$memo_id}'";

}else{
	$sql_log ="INSERT INTO wp01_0customer_memo(`date`,`cast_id`,`customer_id`,`log`) VALUES ";
	$sql_log.=" ('{$now}','{$cast_id}','{$c_id}','{$log}')";
}
$wpdb->query($sql_log);


$tmp_auto=$wpdb->insert_id;
	$log=str_replace("\n","<br>",$log);

	$dat ="<tr><td class=\"customer_memo_td1\">";
	$dat.="<div class=\"customer_memo_date\">{$now}</div>";
	$dat.="<div id=\"m_chg{$tmp_auto}\" class=\"customer_memo_chg\"></div>";
	$dat.="<div id=\"m_del{$tmp_auto}\" class=\"customer_memo_del\"></div>";
	$dat.="</td></tr><tr><td class=\"customer_memo_td2\">";
	$dat.="{$log}";
	$dat.="</td></tr>";

echo $dat;
exit();
?>

