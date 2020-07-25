<?php
//-----------------------------------------------------
// スケジュール変更
//-----------------------------------------------------
include_once("../common/conf.php");
include_once("../common/common.php");
include_once("../common/session.php");
include_once("../common/profile_com.php");
include_once("../common/page_com2.php");
include_once("../common/mail_send.php");
include_once("../common/schedule_com.php");
include_once("../common/reserve_com.php");

//ini_set('display_errors',1);

$ext=$_REQUEST["ext"];

if($ext =="2400") $ext="0000";
if($ext =="2430") $ext="0030";

$ext2="0000".$ext;
$ext3 = substr($ext2,-2,2);

if ($ext3 != "00" && $ext3 != "30"){
	$ext_err = 1;
	$msg_err = "入力された数字が不正です。30分単位で入力してください。";
}

$now=date("Hi");
$ext_n=$ext;

if($now+0<800){
	$now_24+=2400;
}else{
	$now_24+=0;
}

if($ext+0<800){
	$ext_24+=2400;
}else{
	$ext_24+=0;
}

$sche_date=date("Y-m-d");
$idcode=get_session("idcode");

if($ext_24>29){
	$ext_err = 1;
	$msg_err="5時以降のセットは出来ません";
}

$prm="";
$sql="SELECT * FROM Schedule";
$sql.=" WHERE idcode='{$idcode}'";
$sql.=" AND sche_date='{$sche_date}'";
$res = mdb2_sql_all($sql,$prm,$max_cnt);
$n=0;
for($e=0;$e<count($res);$e++){

	if($res[$e]["stime"]<800){
		$st_24=$res["stime"]+2400;
		$st_86400=86400;
	}else{
		$st_24=$res["stime"]+0;
		$st_86400=0;
	}

	if($res[$e]["etime"]<800){
		$ed_24=$res[$e]["etime"]+2400;
		$ed_86400=86400;

	}else{
		$ed_24[$e]=$res[$e]["etime"]+0;
		$ed_86400=0;
	}

	if($st_24 < $now_24 && $now_24 < $ed_24){
		$st_time	=date("Ymd",strtotime($res[$e]["sche_date"])+$st_86400).$res[$e]["stime"];
		$ed_time	=date("Ymd",strtotime($res[$e]["sche_date"])+$st_86400).$ext;

		$ss=$res[$e]["stime"];
		$ee=$ext;

		if($ee=="2400"){
			$ee="0000";
		}

		if($ext_24<$ed_24){
			$ext_err = 1;
			$msg_err="延長セットが待機終了時間以前の為、変更できません。";
		}

	}else{
		$st_ck[$n]=$st_24;
		$ed_ck[$n]=$ed_24;
		$n++;
	}
}

for($s=0;$s<$n;$s++){
	if($ext_24 <= $st_ck[$s] && $now_24<=$st_ck[$s] && $now_24<=$ed_ck[$s] && $ext){
		$ext_err = 1;
		$msg_err="延長セットがスケジュールにかぶっています。<br>サポートセンターまでご連絡下さい";
	}
}


if(!$ext_err){
	$pass		= get_session("pass");
	$mail_from	= sql_dec_get(get_session("mail"));
	$mail		="kwsk_ggrks@i.softbank.jp";
	$mail		="info@vernis.co.jp";

	$mail_sub	= "待機延長_".get_session("idcode").":".get_session("nickname");
	$mail_body	= get_session("idcode").":".get_session("nickname")."待機延長\n".$ext2."まで\n";

	if(!rtrim($mail_from)){
		$mail_from	= "dummy@vernis.co.jp";
	}
	cmd_send_info_ope( $idcode, $pass, $mail, $mail_from, $mail_sub, $mail_body );

	$trnset_tel_trn		= get_session("tel_trn");
	cmd_tran_set($idcode, $trnset_tel_trn, $st_time, $ed_time);
	$sql="UPDATE Schedule SET";
	$sql.=" etime='{$ee}'";
	$sql.=" WHERE idcode='{$idcode}'";
	$sql.=" AND sche_date='{$sche_date}'";
	$sql.=" AND stime='{$ss}'";
	mdb2_sql_upd($sql,$prm_upd);

/*
	print($sql."<br>\n");
	print($idcode."<br>\n");	
	print($trnset_tel_trn."<br>\n");	
	print($st_time."<br>\n");	
	print($ed_time."<br>\n");	
*/
}


$data=array();
$data["ses"]		="?".$ses;
$data["hidden_ses"]	=$hidden_ses;
$data["idcode"]		=get_session("idcode");
$data["idcode2_e"]	= get_encode($char_id);

$data["talk_flg"]	= $p_info["talk_flg"];
$data["ext"]		= $ext;
$data["msg_err"]	=$msg_err;

$mes=get_template("ext.html",$data);
show_html($mes,$title);
exit();
?>