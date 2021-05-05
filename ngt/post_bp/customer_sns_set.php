<?
/*
SNSセット
*/
include_once('../library/sql_post.php');
$n_id	=$_POST["n_id"];

$c_id		=$_POST['c_id'];
$text		=$_POST['text'];
$kind		=$_POST['kind'];

$sql	="UPDATE wp01_0customer";
$sql	.=" SET {$kind}='{$text}'";
$sql	.=" WHERE id='{$c_id}'";
mysqli_query($mysqli,$sql);


echo $kind;
exit();
?>
