<?php
require_once("./twitteroauth/autoload.php");
use Abraham\TwitterOAuth\TwitterOAuth;

/*
status:1 ok
status:2 add_follow
status:3 Remove_follow
status:91 ERROR
*/

$month["Jan"]="01";
$month["Feb"]="02";
$month["Mar"]="03";
$month["Apr"]="04";
$month["May"]="05";
$month["Jun"]="06";
$month["Jul"]="07";
$month["Aug"]="08";
$month["Sep"]="09";
$month["Oct"]="10";
$month["Nov"]="11";
$month["Dec"]="12";

$ts=date("Y-m-d H:i:s",time()-1800);
$te=date("Y-m-d H:i:s",time());	
$now=date("Y-m-d H:i:s");

$hour=(date("H") %4);

//■■SQL------------------------
$mysqli = mysqli_connect("localhost", "tiltowait_db", "kk1941", "tiltowait_db");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 
//■■SQL------------------------



$dat_screen[0]="v_tiltowait";
$c_key[0] = "V9Vag2YGqi6kPsMGKyYBPDQzq";
$c_sec[0] = "nloqpV2FSLPvX8JHIY44hMEerWcKfCvEHNdbHrUq7JeCLMH4HW";
$s_tok[0] = "1143385250170458112-x6Ptb7NG98OWN3CIavVlWxRykuSK38";	
$s_sec[0] = "9o5tC3WAUOTMZ1tOyx1xwyFUUlNNcrSC5L4EWJzFVcm4R";
$obj[0] = new TwitterOAuth($c_key[0], $c_sec[0], $s_tok[0], $s_sec[0]); 

$dat_screen[1]="v_katino";
$keyword[1][1]="#AKB";
$keyword[1][2]="#コスプレ";
$keyword[1][3]="#絵描き";
$keyword[1][4]="#同人";
$keyword[1][5]="";



if(date(Hi)>1000 && date(Hi)<=1400){
	$ap_date=date("Y-m-d",time()-86400);
	$ap_day=date("m月d日",time()-86400);

	$talk="おはようございます。\n";
	$talk.="{$ap_day}のitunes セールスランキングです。\n";

	$sql ="SELECT * FROM vitter_rank ";
	$sql.=" WHERE `date`='{$ap_date}'";
	$sql.=" ORDER BY `rank` ASC";
	$sql.=" LIMIT 5";

	$res2 = mysqli_query($mysqli,$sql);
	while($res = mysqli_fetch_assoc($res2)){
		mysqli_query($mysqli,$sql);
		$talk.="{$res["rank"]}位 #{$res["name"]} [{$res["cate"]}]\n";
	}
	if($res["rank"]>0){
		$obj[0]->post("statuses/update", array('status' => $talk));
	}
}
print($sql."<hr>");
print($talk."<hr>");
print($res["rank"]."<hr>");



?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>System;BOT</title>
</head>
<body style="font-size:12px;">
<div>System;BOT:<?=date("Y/m/d H:i:s")?></div>
<hr>
<div>
<?=$sql_log?>
</div>


</body>
</html>
