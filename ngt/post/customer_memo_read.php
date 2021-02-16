<?
/*
顧客情報読み込み
*/
ini_set('display_errors',1);

require_once ("../../../../wp-load.php");
global $wpdb;

$c_id		=$_POST["c_id"];
$cast_id	=$_POST["cast_id"];

$sql	 ="SELECT * FROM wp01_0customer_memo";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
$sql	 .=" AND `log` IS NOT NULL";
$sql	 .=" ORDER BY `date` DESC";

$now=date("Y-m-d H:i");
$dat0 = $wpdb->get_results($sql,ARRAY_A );

if($dat0){
	foreach($dat0 AS $dat1){
		$dat1["log"]=str_replace("\n","<br>",$dat1["log"]);

		$dat.="<tr id=\"tr_memo_detail{$dat1["id"]}\"><td class=\"customer_memo_td1\">";
		$dat.="<div class=\"customer_memo_date\">{$dat1["date"]}</div>";
		$dat.="<div id=\"m_chg{$dat1["id"]}\" class=\"customer_memo_chg\"></div>";
		$dat.="<div id=\"m_del{$dat1["id"]}\" class=\"customer_memo_del\"></div>";
		$dat.="</td></tr><tr id=\"tr_memo_log{$dat1["id"]}\"><td id=\"m_log{$dat1["id"]}\" class=\"customer_memo_td2\">";
		$dat.="{$dat1["log"]}";
		$dat.="</td></tr>";
	}
}else{
		$dat.="<tr><td class=\"customer_memo_td1\">まだ何もありません</td></tr>";


}

echo $dat;
exit();
?>

