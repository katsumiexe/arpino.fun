<?
/*
顧客情報読み込み
*/
require_once ("./post_inc.php");
require_once ("./inc_code.php");
$date_gmt=date("Y-m-d H:i:s");

$c_id		=$_POST["c_id"];
$cast_id	=$_POST["cast_id"];

$sql	 ="SELECT * FROM wp01_0cast_log";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND customer_id='{$c_id}'";
$sql	.=" ORDER BY id DESC";
$sql	.=" LIMIT 20";

$dat0 = $wpdb->get_results($sql,ARRAY_A );
foreach($dat0 AS $dat1){
	$t_date=substr($dat1["sdate"],0,4)."/".substr($dat1["sdate"],4,2)."/".substr($dat1["sdate"],6,2);
	$s_time=substr($dat1["etime"],0,2).":".substr($dat1["etime"],2,2);
	$e_time=substr($dat1["etime"],0,2).":".substr($dat1["etime"],2,2);

	$dat1["log"]=str_replace("\n","<br>",$dat1["log"]);

	$dat.="<tr><td class=\"customer_log_td\">";
	$dat.="<div class=\"customer_log_date\"> <span class=\"customer_log_icon\"></span><span class=\"customer_log_date_detail\">{$t_date} {$s_time}-{$e_time}</span>";
	$dat.="<div id=\"m_chg{$dat1["id"]}\" class=\"customer_log_chg\"></div>";
	$dat.="</div>";


	$sql	 ="SELECT * FROM wp01_0cast_log_list";
	$sql	.=" LEFT JOIN wp01_0cast_log_table ON wp01_0cast_log_list.action_id=wp01_0cast_log_table.id";
	$sql	.=" WHERE master_id='{$dat1["id"]}'";
	$sql	.=" ORDER BY wp01_0cast_log_list.id DESC";

	$dat2 = $wpdb->get_results($sql,ARRAY_A );
	$dat.="<div class=\"customer_log_memo\">";
	$dat.="{$dat1["log"]}";
	$dat.="</div>";
	$dat.="<div class=\"customer_log_list\">";
	foreach($dat2 as $dat3){
		$dat.="<div class=\"customer_log_item\" style=\"border:2px solid {$dat3["log_color"]}; color:{$dat3["log_color"]};\">";
		$dat.="<span class=\"log_item_icon\">{$dat3["log_icon"]}</span>";
		$dat.="<span class=\"log_item_name\">{$dat3["log_comm"]}</span>";
		$dat.="<span class=\"log_item_price\">{$dat3["log_price"]}</span>";
		$dat.="</div>";
	}
	$dat.="</div>";
	$dat.="</td></tr>";
}
echo $dat;
exit();
?>
