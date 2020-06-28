<?
/*
メモ削除
*/
ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;
$now=date("Y-m-d H:i:s",time()+32400);

$memo_id		=$_POST["memo_id"];
$c_id		=$_POST["c_id"];

$sql_log ="UPDATE wp01_0customer_memo SET";
$sql_log.=" `del`='1'";
$sql_log.=" WHERE id='{$memo_id}'";
$wpdb->query($sql_log);

$sql	 ="SELECT * FROM wp01_0customer_memo";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
$sql	 .=" AND `log` IS NOT NULL";
$sql	 .=" ORDER BY id DESC";

$now=date("Y-m-d H:i");
$dat0 = $wpdb->get_results($sql,ARRAY_A );

foreach($dat0 AS $dat1){
	$dat1["log"]=str_replace("\n","<br>",$dat1["log"]);

	$dat.="<tr><td class=\"customer_memo_td1\">";
	$dat.="<div class=\"customer_memo_date\">{$dat1["date"]}</div>";
	$dat.="<div id=\"m_chg{$dat1["id"]}\" class=\"customer_memo_chg\"></div>";
	$dat.="<div id=\"m_del{$dat1["id"]}\" class=\"customer_memo_del\"></div>";
	$dat.="</td></tr><tr><td class=\"customer_memo_td2\">";
	$dat.="{$dat1["log"]}";
	$dat.="</td></tr>";
}

echo $dat;
exit();
?>
