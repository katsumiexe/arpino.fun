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

$ts	=date("Y-m-d H:i:s",time()-1800);
$te	=date("Y-m-d H:i:s",time());	
$now=date("Y-m-d H:i:s");

$hour=(date("H") %4);

$ck[1143385250170458112]=1;
$ck[1145915557620768768]=1;


//■■SQL------------------------
$mysqli = mysqli_connect("localhost", "tiltowait_db", "kk1941", "tiltowait_db");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 
//■■---------------------------------

/*
//■■Oauth設定------------------------
$dat_screen[0]="v_tiltowait";
$c_key[0] = "V9Vag2YGqi6kPsMGKyYBPDQzq";
$c_sec[0] = "nloqpV2FSLPvX8JHIY44hMEerWcKfCvEHNdbHrUq7JeCLMH4HW";
$s_tok[0] = "1143385250170458112-x6Ptb7NG98OWN3CIavVlWxRykuSK38";	
$s_sec[0] = "9o5tC3WAUOTMZ1tOyx1xwyFUUlNNcrSC5L4EWJzFVcm4R";

$obj[0] = new TwitterOAuth($c_key[0], $c_sec[0], $s_tok[0], $s_sec[0]); 
//■■------------------------------------------------------------------------

//■■フォローしていないフォロワーがいたらフォローする------------------------
$option = array('screen_name'=>$dat_screen[0],'stringify_ids'=>true);
$fri	= $obj[0]->get('friends/ids', $option);

foreach($fri->ids as $fri2 => $fri3){
	$friend[$fri3]=1;
}

$option = array('screen_name'=>$dat_screen[0],'stringify_ids'=>true);
$fol = $obj[0]->get('followers/ids', $option);

foreach($fol->ids as $fol2 => $fol3){
	$follow[$fol3]=1;
	if(!$friend[$fol3]){
		$obj[0]->post('friendships/create', array('id' => $fol3,'follow' => true));
		$up_friend.="('{$now}','{$dat_screen[0]}','{$fol3}','11'),";
		sleep(5);
	}
}
//■■------------------------------------------------------------------------

//■■フォロワーのツイートをリツイート------------------------
$option = array('count'=>80, 'screen_name'=>$dat_screen[0],'include_rts'=>false,'exclude_replies'=>true,'result_type' => 'recent');
$res = $obj[0]->get('statuses/home_timeline', $option);

$ct=0;
foreach( $res as $res2 ){
	if(
		$res2->quoted_status_id_str =="" && 
		$res2->in_reply_to_status_id =="" && 
		!$ck[$res2->user->id_str] && 
		strpos($res2->text,"フォロバ")===FALSE){

		$ck[$res2->user->id_str]=1;
		$tm2=substr($res2->created_at,-4,4)."-".$month[substr($res2->created_at,4,3)]."-".substr($res2->created_at,8,11);
		$tm=date("Y-m-d H:i:s",strtotime($tm2)+32400);

		if($te>$tm && $tm>$ts && $ct+0<40){
			$obj[0]->post("statuses/retweet", array('id' => $res2->id_str,'trim_user'=>'true'));
			sleep(5);
			$obj[0]->post("favorites/create", array('id' => $res2->id_str));
			sleep(5);
			$ct++;
			$up_log.="('{$now}','{$dat_screen[0]}','{$res2->id_str}','{$res2->user->id_str}','{$res2->user->name}','{$res2->user->screen_name}','{$tm}','{$res2->text}','11',''),";
		}
	}
}
//■■------------------------------------------------------------------------


if($ct<35){
	//■■日本のトレンド------------------------
	$option = array('id'=>'23424856','count'=>10);
	$tor = $obj[0]->get('trends/place', $option);
	$tor =json_decode(json_encode($tor), true);	
	$trends=str_replace("#","",$tor[0]["trends"][$hour]["name"]);

	//■30件リツイートでないツイートを取得
	$option = array('count'=>30, 'q'=>$trends." -RT", 'lang'=>ja, 'result_type'=>'recent');
	$tdl = $obj[0]->get('search/tweets', $option);
	$tdl =json_decode(json_encode($tdl), true);
	//■■------------------------------------

	for($n1=0;$n1<30;$n1++){
		if(
		$tdl["statuses"][$n1]["retweeted_status"]["id"] =="" && 
		$tdl["statuses"][$n1]["in_reply_to_status_id"] =="" &&
		$tdl["statuses"][$n1]["user"]["screen_name"] !=$dat_screen[0] &&
		!$ck[$tdl["statuses"][$n1]["user"]["id_str"]])
		{

			$ck[$tdl["statuses"][$n1]["user"]["id_str"]]=1;

			$tm2=substr($tdl["statuses"][$n1]["created_at"],-4,4)."-".$month[substr($tdl["statuses"][$n1]["created_at"],4,3)]."-".substr($tdl["statuses"][$n1]["created_at"],8,11);
			$tm=date("Y-m-d H:i:s",strtotime($tm2)+32400);
			
			if($te>$tm && $tm>$ts){
				$obj[0]->post("statuses/retweet", array('id' => $tdl["statuses"][$n1]["id_str"]));
				sleep(5);
				$obj[0]->post("favorites/create", array('id' => $tdl["statuses"][$n1]["id_str"]));
				sleep(5);
				$up_log.="('{$now}','{$dat_screen[0]}','{$tdl["statuses"][$n1]["id_str"]}','{$tdl["statuses"][$n1]["user"]["id_str"]}','{$tdl["statuses"][$n1]["user"]["name"]}','{$tdl["statuses"][$n1]["user"]["screen_name"]}','{$tm}','{$tdl["statuses"][$n1]["text"]}','12','{$trends}'),";
				$write++;
				if($write >= 5){//5個で終わり
					break;
				}
			}else{
				$up_log.="('{$now}','{$dat_screen[0]}','{$tdl["statuses"][$n1]["id_str"]}','{$tdl["statuses"][$n1]["user"]["id_str"]}','{$tdl["statuses"][$n1]["user"]["name"]}','{$tdl["statuses"][$n1]["user"]["screen_name"]}','{$tm}','{$tdl["statuses"][$n1]["text"]}','14','{$trends}'),";
			}

		}else{
			$up_log.="('{$now}','{$dat_screen[0]}','{$tdl["statuses"][$n1]["id_str"]}','{$tdl["statuses"][$n1]["user"]["id_str"]}','{$tdl["statuses"][$n1]["user"]["name"]}','{$tdl["statuses"][$n1]["user"]["screen_name"]}','{$tm}','{$tdl["statuses"][$n1]["text"]}','13','{$trends}'),";
		}
	}
}
*/
//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■

$c_key[1] = "GzrPhtQWHEIppfuMd2ncdluDb";
$c_sec[1] = "WY4P1sGmPauStgfuIgWWrCKqDa5bw3vcyxjRNc1uHPmHuOPhdZ";
$s_tok[1] = "1145915557620768768-MVV335sWkO88NVed1dBuUBw2veDm7v";	
$s_sec[1] = "DrgnDGj7JN1MdzBPNxepqwq97ECpELdWfDB1QsGVs6Xq5";
$obj[1] = new TwitterOAuth($c_key[1], $c_sec[1], $s_tok[1], $s_sec[1]); 

$dat_screen[1]="v_katino";
$keyword[1][1]="#猫";
$keyword[1][2]="#コスプレイヤー";
$keyword[1][3]="#絵描き";
$keyword[1][4]="#同人作家";
$keyword[1][5]="";
$ct=0;

//■■フォローしていないフォロワーがいたらフォローする------------------------
$option = array('screen_name'=>$dat_screen[1],'stringify_ids'=>true);
$fri	= $obj[1]->get('friends/ids', $option);

foreach($fri->ids as $fri2 => $fri3){
	$friend[$fri3]=1;
}

$option = array('screen_name'=>$dat_screen[1],'stringify_ids'=>true);
$fol = $obj[1]->get('followers/ids', $option);

foreach($fol->ids as $fol2 => $fol3){
	$follow[$fol3]=1;
	if(!$friend[$fol3]){
		$obj[1]->post('friendships/create', array('id' => $fol3,'follow' => false));
		$up_friend.="('{$now}','{$dat_screen[1]}','{$fol3}','21'),";
		sleep(5);
	}
}
//■■------------------------------------------------------------------------

$option = array('count'=>80, 'screen_name'=>$dat_screen[1],'include_rts'=>false, 'q'=>"-フォロバ", 'lang'=>ja, 'exclude_replies'=>true,'result_type' => 'recent');
$res = $obj[1]->get('statuses/home_timeline', $option);

foreach( $res as $res2 ){
	if( $res2->quoted_status_id_str =="" && $res2->in_reply_to_status_id =="" && !$ck[$res2->user->id_str] && strpos($res2->text,"フォロバ")===FALSE){

		$ck[$res2->user->id_str]=1;

		$tm2=substr($res2->created_at,-4,4)."-".$month[substr($res2->created_at,4,3)]."-".substr($res2->created_at,8,11);
		$tm=date("Y-m-d H:i:s",strtotime($tm2)+32400);

		if($te>$tm && $tm>$ts && $ct+0<40){
			$res = $obj[1]->post("statuses/retweet", array('id' => $res2->id_str));
			sleep(5);
			$res = $obj[1]->post("favorites/create", array('id' => $res2->id_str));
			sleep(5);
			$ct++;
			$up_log.="('{$now}','{$dat_screen[1]}','{$res2->id_str}','{$res2->user->id_str}','{$res2->user->name}','{$res2->user->screen_name}','{$tm}','{$res2->text}','21',''),";
		}
	}
}

if($ct<35){
	//■■日本のトレンド------------------------
	$trends=$keyword[1][1]." OR ".$keyword[1][2]." OR ".$keyword[1][3]." OR ".$keyword[1][4];
	$option = array('count'=>1, 'q'=>"-RT", 'lang'=>ja, 'result_type'=>'recent');
	$tdl = $obj[1]->get('search/tweets', $option);
	$tdl =json_decode(json_encode($tdl), true);
	$since=$tdl["statuses"][0]["id_str"]-250000000000000;

	$option = array('count'=>10, 'q'=>$trends." -RT", 'lang'=>ja, 'max_id'=>$since, 'max_retweets'=>1, 'result_type'=>'recent');
	$tdl = $obj[1]->get('search/tweets', $option);
	$tdl =json_decode(json_encode($tdl), true);

	//■■日本のトレンド------------------------
	for($n1=0;$n1<10;$n1++){
		if( $tdl["statuses"][$n1]["retweeted_status"]["id"] =="" && $tdl["statuses"][$n1]["in_reply_to_status_id"] =="" && !$ck[$tdl["statuses"][$n1]["user"]["id_str"]]){
			$ck[$tdl["statuses"][$n1]["user"]["id_str"]]=1;

			$tm2=substr($tdl["statuses"][$n1]["created_at"],-4,4)."-".$month[substr($tdl["statuses"][$n1]["created_at"],4,3)]."-".substr($tdl["statuses"][$n1]["created_at"],8,11);
			$tm=date("Y-m-d H:i:s",strtotime($tm2)+32400);

			$res = $obj[1]->post("statuses/retweet", array('id' => $tdl["statuses"][$n1]["id_str"]));
			sleep(5);
			$res = $obj[1]->post("favorites/create", array('id' => $tdl["statuses"][$n1]["id_str"]));
			sleep(5);
			$up_log.="('{$now}','{$dat_screen[1]}','{$tdl["statuses"][$n1]["id_str"]}','{$tdl["statuses"][$n1]["user"]["id_str"]}','{$tdl["statuses"][$n1]["user"]["name"]}','{$tdl["statuses"][$n1]["user"]["screen_name"]}','{$tm}','{$tdl["statuses"][$n1]["text"]}','22','{$trends}'),";

			$write2++;
			if($write2>= 5){//5個で終わり
				break;
			}

		}else{
			$up_log.="('{$now}','{$dat_screen[1]}','{$tdl["statuses"][$n1]["id_str"]}','{$tdl["statuses"][$n1]["user"]["id_str"]}','{$tdl["statuses"][$n1]["user"]["name"]}','{$tdl["statuses"][$n1]["user"]["screen_name"]}','{$tm}','{$tdl["statuses"][$n1]["text"]}','23','{$trends}'),";
		}
	}
}


if(date(Hi)>1000 && date(Hi)<=1030){
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
		sleep(5);
	}
	$obj[0]->post("statuses/update", array('status' => $talk));
}



//■■まとめてログの書き込み--------------------------------------------------
if($up_log){
	$up_log=substr($up_log,0,-1);
	$sql_log="INSERT INTO vitter(`date`,`host_screen`,`tweet_id`,`user_id`,`user_name`,`user_screen_name`,`t_date`,`t_log`,`t_status`,`trends`) VALUES";
	$sql_log.=$up_log;
	mysqli_query($mysqli,$sql_log);
}

if($up_friend){
	$up_friend=substr($up_friend,0,-1);
	$sql_log="INSERT INTO vitter_friend(`date`,`target_screen`,`friend_id`,`status`) VALUES";
	$sql_log.=$up_friend;
	mysqli_query($mysqli,$sql_log);
}

if(date(Hi)>=2330){
	$ap_date=date("Y-m-d");
	$list=file_get_contents('https://rss.itunes.apple.com/api/v1/jp/ios-apps/top-grossing/all/200/explicit.json');
	$res=json_decode($list,true);
	//print_r($res);
	for($n=0;$n<5;$n++){
//		print($res["feed"]["results"][$n]["name"]);
//		print("[".$res["feed"]["results"][$n]["genres"][0]["name"]."]<br>\n");
		$ranking=$n+1;
		$ap.="('{$ap_date}','{$res["feed"]["results"][$n]["name"]}','{$res["feed"]["results"][$n]["genres"][0]["name"]}','{$ranking}'),";
	}
	$ap=substr($ap,0,-1);
	$sql_ap="INSERT INTO vitter_rank(`date`,`name`,`cate`,`rank`)VALUES";
	$sql_ap.=$ap;
	mysqli_query($mysqli,$sql_ap);
}

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
</body>
</html>
