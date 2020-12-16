<?
session_start();
global $wpdb;
ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
$jst=time()+32400;
$now_8=date("Ymd",$jst-($start_time*3600));
$link=get_template_directory_uri();
?>
