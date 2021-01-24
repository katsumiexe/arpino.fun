<?
require_once ("wp-load.php");
global $wpdb;
$now=date("Y-m-d H:i:s");
$now_gmt=date("Y-m-d H:i:s",time()+32400);

$title=array(
"access",
"article",
"cast",
"castblog",
"easytalk",
"event",
"info",
"mypage",
"news_all",
"person",
"requruit",
"system"
);

$sql="INSERT INTO wp01_posts(post_date,post_date_gmt,post_title,post_status,post_name,guid,post_type)VALUES";
for($n=0;$n<12;$n++){
	$app.="('{$now}','{$now_gmt}','{$title[$n]}','publish','{$title[$n]}','./{$title[$n]}/','page'),";
}

$app=substr($app,0,-1);
$sql.=$app;
$wpdb->query($sql);
$app="";

$sql="INSERT INTO wp01_postmeta(post_id,meta_key,meta_value)VALUES";
for($n=1;$n<13;$n++){
	$app.="('{$n}','_wp_page_template','default'),";
}
$app=substr($app,0,-1);
$sql.=$app;
$wpdb->query($sql);
?>
SETUP OK
