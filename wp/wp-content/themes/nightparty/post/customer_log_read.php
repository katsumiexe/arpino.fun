<?
/*
顧客情報読み込み
*/
require_once ("./post_inc.php");
$date_gmt=date("Y-m-d H:i:s");

$c_id		=$_POST["c_id"];
$cast_id	=$_POST["cast_id"];

$sql	 ="SELECT * FROM wp01_0cust_log";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND customer_id='{$c_id}'";
$sql	.=" ORDER BY id DESC";
$sql	.=" LIMIT 20";

$dat0 = $wpdb->get_results($sql,ARRAY_A );
foreach($dat0 AS $dat1){
	$sdate=substr($dat1["sdate"],0,4)."/".substr($dat1["sdate"],4,2)."/".substr($dat1["sdate"],6,2)." ".substr($dat1["stime"],0,2).":".substr($dat1["stime"],2,2);
	$edate=substr($dat1["edate"],0,4)."/".substr($dat1["edate"],4,2)."/".substr($dat1["edate"],6,2)." ".substr($dat1["etime"],0,2).":".substr($dat1["etime"],2,2);
	$dat1["log"]=str_replace("\n","<br>",$dat1["log"]);

	$dat.="<tr><td class=\"customer_log_td\">";
	$dat.="<div class=\"customer_log_date\">{$sdate} - {$edate}</div>";

	$sql	 ="SELECT * FROM wp01_0cust_log_list";
	$sql	.=" LEFT JOIN wp01_0cust_log_table ON wp01_0cust_log_list.action_id=wp01_0cust_log_table.id";
	$sql	.=" WHERE master_id='{$dt1["id"]}'";
	$sql	.=" ORDER BY id DESC";

	$dat2 = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat3 AS $dat2){
		$dat.="<div class=\"customer_log_item\">";
		$dat.="<span class=\"log_item_icon\">{$icon[$dat3["item_name"]]}</span>";
		$dat.="<span class=\"log_item_name\">{$dat3["item_name"]}</span>";
		$dat.="<span class=\"log_item_prize\">{$dat3["price"]}</span>";
		$dat.="</div>";
	}

	$dat.="<div class=\"customer_log_memo\">";
	$dat.="{$dat1["log"]}";
	$dat.="</div>";
	$dat.="</td></tr>";
}

echo $dat;
exit();
?>
