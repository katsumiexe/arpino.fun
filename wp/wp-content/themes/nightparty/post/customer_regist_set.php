<?
/*
顧客情報読み込み
*/
require_once ("./post_inc.php");

$regist_date=date("Y-m-d H:i:s",$jst);

$group	=$_POST["group"];
$name	=$_POST["name"];
$nick	=$_POST["nick"];
$fav	=$_POST["fav"];
$cast_id=$_POST["cast_id"];

$yy	=$_POST["yy"];
$mm	=$_POST["mm"];
$dd	=$_POST["dd"];
$ag	=$_POST["ag"];

if($yy && $mm && $dd){
	$birth=$yy."-".$mm."-".$dd;
}else{
	$birth="0000-00-00";
}


$sql_log ="INSERT INTO wp01_0customer (`cast_id`,`nickname`,`name`,`regist_date`,`birth_day`,`fav`,`c_group`)";
$sql_log .=" VALUES('{$cast_id}','{$nick}','{$name}','{$regist_date}','{$birth}','{$fav}','{$group}')";
$wpdb->query($sql_log);
echo($sql_log);
exit();
?>
