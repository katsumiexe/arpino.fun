<?
/*
顧客情報読み込み
*/
ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;
$now=date("Y-m-d H:i:s");

$c_id		=$_POST["c_id"];
$log		=$_POST["log"];
$cast_id	=$_POST["cast_id"];

$sql_log ="INSERT INTO wp01_0customer_memo(`date`,`cast_id`,`customer_id`,`log`) VALUES ";
$sql_log.=" ('{$now}','{$cast_id}','{$c_id}','{$log}')";
$wpdb->query($sql_log);

$tmp_auto=$wpdb->insert_id;

	$dat ="<tr><td class=\"customer_memo_td\">";
	$dat.="<div class=\"customer_memo_date\">{$now}</div>";
	$dat.="<div id=\"m_chg{$tmp_auto}\" class=\"customer_memo_chg\">修正</div>";
	$dat.="<div id=\"m_del{$tmp_auto}\" class=\"customer_memo_del\">削除</div>";
	$dat.="<textarea id=\"m_txt{$tmp_auto}\" class=\"customer_memo_txt\">{$log}</textarea>";
	$dat.="</td></tr>";
echo $sql_log;
exit();
?>
