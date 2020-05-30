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



//■■フォローしていないフォロワーがいたらフォローする------------------------
$dat_screen[0]="v_tiltowait";
$c_key[0] = "V9Vag2YGqi6kPsMGKyYBPDQzq";
$c_sec[0] = "nloqpV2FSLPvX8JHIY44hMEerWcKfCvEHNdbHrUq7JeCLMH4HW";
$s_tok[0] = "1143385250170458112-x6Ptb7NG98OWN3CIavVlWxRykuSK38";	
$s_sec[0] = "9o5tC3WAUOTMZ1tOyx1xwyFUUlNNcrSC5L4EWJzFVcm4R";

$obj[0] = new TwitterOAuth($c_key[0], $c_sec[0], $s_tok[0], $s_sec[0]); 

//■■フォローしていないフォロワーがいたらフォローする------------------------

$option = array('screen_name'=>$dat_screen[0],'stringify_ids'=>true);
$fri	= $obj[0]->get('friends/ids', $option);

foreach($fri->ids as $fri2 => $fri3){
	$friend[$fri3]=1;
print("■".$fri3."<br>\n");
}
var_dump($fri);

$option = array('screen_name'=>$dat_screen[0],'stringify_ids'=>true);
$fol = $obj[0]->get('followers/ids', $option);

foreach($fol->ids as $fol2 => $fol3){
	$follow[$fol3]=1;
	if(!$friend[$fol3]){
//		$obj[0]->post('friendships/create', array('id' => $fol3,'follow' => true));
//		$up_friend.="('{$now}','{$dat_screen[0]}','{$fol3}','1'),";
	}
print("□".$fol3."<br>\n");
}

//■■------------------------------------------------------------------------


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
