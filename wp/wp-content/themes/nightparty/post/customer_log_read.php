<?

$c_code[0]="#000000";
$c_code[1]="#000040";
$c_code[2]="#000080";
$c_code[3]="#0000c0";
$c_code[4]="#004000";
$c_code[5]="#004040";
$c_code[6]="#004080";
$c_code[7]="#0040c0";
$c_code[8]="#008000";
$c_code[9]="#008040";
$c_code[10]="#008080";
$c_code[11]="#0080c0";
$c_code[12]="#00c000";
$c_code[13]="#00c040";
$c_code[14]="#00c080";
$c_code[15]="#00c0c0";
$c_code[16]="#400000";
$c_code[17]="#400040";
$c_code[18]="#400080";
$c_code[19]="#4000c0";
$c_code[20]="#404000";
$c_code[21]="#404040";
$c_code[22]="#404080";
$c_code[23]="#4040c0";
$c_code[24]="#408000";
$c_code[25]="#408040";
$c_code[26]="#408080";
$c_code[27]="#4080c0";
$c_code[28]="#40c000";
$c_code[29]="#40c040";
$c_code[30]="#40c080";
$c_code[31]="#40c0c0";
$c_code[32]="#800000";
$c_code[33]="#800040";
$c_code[34]="#800080";
$c_code[35]="#8000c0";
$c_code[36]="#804000";
$c_code[37]="#804040";
$c_code[38]="#804080";
$c_code[39]="#8040c0";
$c_code[40]="#808000";
$c_code[41]="#808040";
$c_code[42]="#808080";
$c_code[43]="#8080c0";
$c_code[44]="#80c000";
$c_code[45]="#80c040";
$c_code[46]="#80c080";
$c_code[47]="#80c0c0";
$c_code[48]="#c00000";
$c_code[49]="#c00040";
$c_code[50]="#c00080";
$c_code[51]="#c000c0";
$c_code[52]="#c04000";
$c_code[53]="#c04040";
$c_code[54]="#c04080";
$c_code[55]="#c040c0";
$c_code[56]="#c08000";
$c_code[57]="#c08040";
$c_code[58]="#c08080";
$c_code[59]="#c080c0";
$c_code[60]="#c0c000";
$c_code[61]="#c0c040";
$c_code[62]="#c0c080";
$c_code[63]="#c0c0c0";

/*
顧客情報読み込み
*/
require_once ("./post_inc.php");
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
	$sdate=substr($dat1["sdate"],0,4)."/".substr($dat1["sdate"],4,2)."/".substr($dat1["sdate"],6,2)." ".substr($dat1["stime"],0,2).":".substr($dat1["stime"],2,2);
	$edate=substr($dat1["edate"],0,4)."/".substr($dat1["edate"],4,2)."/".substr($dat1["edate"],6,2)." ".substr($dat1["etime"],0,2).":".substr($dat1["etime"],2,2);
	$dat1["log"]=str_replace("\n","<br>",$dat1["log"]);

	$dat.="<tr><td class=\"customer_log_td\">";
	$dat.="<div class=\"customer_log_date\">{$sdate} - {$edate}</div>";

	$sql	 ="SELECT * FROM wp01_0cast_log_list";
	$sql	.=" LEFT JOIN wp01_0cast_log_table ON wp01_0cast_log_list.action_id=wp01_0cast_log_table.id";
	$sql	.=" WHERE master_id='{$dat1["id"]}'";
	$sql	.=" ORDER BY wp01_0cast_log_list.id DESC";

	$dat2 = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat2 AS $dat3){
		$dat.="<div class=\"customer_log_item\" style=\"border:2px solid {$c_code[$dat3["item_color"]]}; color:{$c_code[$dat3["item_color"]]};\">";
		$dat.="<span class=\"log_item_icon\">{$icon[$dat3["item_name"]]}</span>";
		$dat.="<span class=\"log_item_name\">{$dat3["item_name"]}</span>";
		$dat.="<span class=\"log_item_price\">{$dat3["price"]}</span>";
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
