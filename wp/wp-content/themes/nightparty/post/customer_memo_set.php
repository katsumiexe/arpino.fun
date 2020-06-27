<?
/*
顧客情報読み込み
*/
ini_set('display_errors',1);

require_once ("../../../../wp-load.php");
global $wpdb;

$now=date("Y-m-d H:i");

$c_id		=$_POST["c_id"];
$log		=$_POST["log"];
$cast_id	=$_POST["cast_id"];

$sql_log ="INSERT INTO wp01_0customer_memo(`date`,`cast_id`,`customer_id`,`log`,`birth_day`,`fav`,`group`) VALUES ";
$sql_log.=" ('{$now}','{$_SESSION["id"]}','{$cus_nick}','{$cus_name}','{$to_day}','{$birth}','{$cus_fav}','{$cus_group}')";
$tmp_auto=$wpdb->insert_id;

$sql	 ="SELECT * FROM wp01_0customer_memo";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
$sql	 .=" ORDER BY id DESC";

$now=date("Y-m-d H:i");
$dat0 = $wpdb->get_results($sql,ARRAY_A );

	$dat ="<tr><td class=\"customer_memo_td\">";
	$dat.="<div class=\"customer_memo_date\">{$now}</div>";
	$dat.="<div id=\"m_chg{$dat1["id"]}\" class=\"customer_memo_set\">登録</div>";
	$dat.="<div id=\"m_del{$dat1["id"]}\" class=\"customer_memo_del\">削除</div>";
	$dat.="<textarea id=\"m_txt{$dat1["id"]}\" class=\"customer_memo_txt_set\"></textarea>";
	$dat.="</td></tr>";

foreach($dat0 AS $dat1){
	$dat.="<tr><td class=\"customer_memo_td\">";
	$dat.="<div class=\"customer_memo_date\">{$dat1["date"]}</div>";
	$dat.="<div id=\"m_chg{$dat1["id"]}\" class=\"customer_memo_chg\">修正</div>";
	$dat.="<div id=\"m_del{$dat1["id"]}\" class=\"customer_memo_del\">削除</div>";
	$dat.="<textarea id=\"m_txt{$dat1["id"]}\" class=\"customer_memo_txt\">{$dat1["log"]}</textarea>";
	$dat.="</td></tr>";
}

echo $dat;
exit();
?>

