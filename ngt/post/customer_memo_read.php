<?
/*
顧客情報読み込み
*/
include_once('../library/sql_cast.php');
$c_id		=$_POST["c_id"];

$sql	 ="SELECT * FROM wp01_0customer_memo";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
$sql	 .=" AND `log` IS NOT NULL";
$sql	 .=" ORDER BY `date` DESC";

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);
		$row["log"]=str_replace("\n","<br>",$row["log"]);

		$dat.="<tr id=\"tr_memo_detail{$row["id"]}\"><td class=\"customer_memo_td1\">";
		$dat.="<div class=\"customer_memo_date\">{$row["date"]}</div>";
		$dat.="<div id=\"m_chg{$row["id"]}\" class=\"customer_memo_chg\"></div>";
		$dat.="<div id=\"m_del{$row["id"]}\" class=\"customer_memo_del\"></div>";
		$dat.="</td></tr><tr id=\"tr_memo_log{$row["id"]}\"><td id=\"m_log{$row["id"]}\" class=\"customer_memo_td2\">";
		$dat.="{$row["log"]}";
		$dat.="</td></tr>";
	}
}

if(!$dat){
	$dat="<tr><td class=\"customer_memo_td1\">まだ何もありません</td></tr>";
}

echo $dat;
exit();
?>
