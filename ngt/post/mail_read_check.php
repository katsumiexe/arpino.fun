<?
/*
メール既読処理
*/
include_once('../library/sql.php');
$res_mail_id	=$_POST["res_mail_id"];
$dat=date("Y-m-d H:i:s",time()+32400);
$sql ="UPDATE wp01_0castmail_receive SET watch_date='{$dat}'";
$sql.=" WHERE res_mail_id='1'";
mysqli_query($mysqli,$sql);
?>
