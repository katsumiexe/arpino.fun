<?
global $wpdb;

$res_mail_id	=$_POST["res_mail_id"];
$dat=date("Y-m-d H:i:s");

//$wpdb->update('wp01_0castmail_receve', array('watch_date'=> $dat), array('res_mail_id'=>$res_mail_id));
//$wpdb->update('wp01_0castmail_receve', array('watch_date'=> $dat), array('res_mail_id'=>$res_mail_id));


$sql ="UPDATE wp01_0castmail_receve SET watch_date='{$dat}'";
$sql.=" WHERE res_mail_id='{$res_mail_id}'";

$wpdb->update($sql);
//$rows = $wpdb->get_row("SELECT * FROM wp01_0cast WHERE cast_id='".$_SESSION["cast_id"]."'",ARRAY_A );
?>
