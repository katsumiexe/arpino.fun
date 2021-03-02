<?
/*
メモ削除
*/

include_once('../library/sql_cast.php');
$memo_id	=$_POST["memo_id"];
$c_id		=$_POST["c_id"];

$sql ="UPDATE wp01_0customer_memo SET";
$sql.=" `del`='1'";
$sql.=" WHERE id='{$memo_id}'";
mysqli_query($mysqli,$sql);

$sql	 ="SELECT * FROM wp01_0customer_memo";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
$sql	 .=" AND `log` IS NOT NULL";
$sql	 .=" ORDER BY id DESC";



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
