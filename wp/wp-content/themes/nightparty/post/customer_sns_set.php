<?
/*
SNSセット処理
*/
ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;

$c_id		=$_POST['c_id'];
$text		=$_POST['text'];
$kind		=$_POST['kind'];

$sql	="UPLOAD wp01_0customer";
$sql	.=" SET {$kind}='{$text}'";
$sql	.=" WHERE id='{$c_id}'";
$wpdb->query($sql_log);
echo $kind;
exit();
?>
