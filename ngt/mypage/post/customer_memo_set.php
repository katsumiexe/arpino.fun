<?
include_once('../../library/sql_post.php');
$c_id		=$_POST["c_id"];
$log		=$_POST["log"];
$memo_id	=$_POST["memo_id"];

if($memo_id){
	$sql ="UPDATE wp01_0customer_memo SET";
	$sql.=" `date`='{$now}',";
	$sql.=" `log`='{$log}'";
	$sql.=" WHERE id='{$memo_id}'";
	mysqli_query($mysqli,$sql);
	$tmp_auto=$memo_id;

}else{
	$sql ="INSERT INTO wp01_0customer_memo(`date`,`customer_id`,`log`) VALUES ";
	$sql.=" ('{$now}','{$c_id}','{$log}')";
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli);
}

$now=date("Y.m.d H:i");

$log=str_replace("\n","<br>",$log);
$dat ="<tr id=\"tr_memo_detail{$tmp_auto}\"><td class=\"customer_memo_td1\">";
$dat.="<div class=\"customer_memo_date\">{$now}</div>";
$dat.="<div id=\"m_chg{$tmp_auto}\" class=\"customer_memo_chg\"></div>";
$dat.="<div id=\"m_del{$tmp_auto}\" class=\"customer_memo_del\"></div>";
$dat.="</td></tr><tr id=\"tr_memo_log{$tmp_auto}\"><td id=\"m_log{$tmp_auto}\" class=\"customer_memo_td2\">";
$dat.="{$log}";
$dat.="</td></tr>";

echo $dat;
exit();
?>

