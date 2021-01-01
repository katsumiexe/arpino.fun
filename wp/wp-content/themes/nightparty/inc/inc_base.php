<?
require_once ("../../../../wp-load.php");
global $wpdb;

$sql=" SELECT meta_value, meta_key FROM wp01_usermeta";
$sql.=" WHERE meta_key IN('start_time','start_week')";
$admin	= $wpdb->get_results($sql,ARRAY_A);

$jst=time()+32400;
$sch_8=date("Ymd",$jst-($admin["start_time"]*3600));

$link=get_template_directory_uri();

?>
