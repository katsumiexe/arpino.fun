<?
include_once("./library/session.php");
$nowpage=1;
$user_id=1;

$ask_name	=$_POST["ask_name"];	//■ニックネーム
$ask_mail	=$_POST["ask_mail"];	//■アドレス
$ask_log	=$_POST["ask_log"];
$send		=$_POST["send"];
$mode		=$_POST["mode"];
$back		=$_POST["back"];
$date		=date("Y-m-d H:i:s");

if($send){
	$mode++;

}elseif($back){
	$mode--;
}

if($mode==1){
	if(!$ask_name){
		$tmp_name="名無しさん";
	}else{
		$tmp_name=$ask_name;
	}

	if(!$ask_mail){
		$tmp_mail="ないしょ";
	}else{
		$tmp_mail=$ask_mail;
	}
	$tmp_log=str_replace("\n","<br>",$ask_log);
}


if($mode==2){
	$sql_up	 ="INSERT INTO post_data(`date`,`name`, `mail`, `log`,`ua`,`ip`,`width`,`height`)";
	$sql_up	.="VALUES('{$date}', '{$ask_name}', '{$ask_mail}', '{$ask_log}','{$_REQUEST["n_ua"]}','{$_REQUEST["n_ip"]}','{$_REQUEST["n_width"]}','{$_REQUEST["n_height"]}'
)";
	mysqli_query ($mysqli,$sql_up);

	mb_language("Japanese");
	mb_internal_encoding("UTF-8");
	$to      = "counterpost2016@gmail.com";
	$subject = "Aigis_POST(out)";
	$message = $ask_log;
	$headers = 'From: aigis@arpino.fun' . "\r\n";
	mb_send_mail($to, $subject, $message, $headers);

	$_POST="";
	$_REQUEST="";
}

$t_ua=$_SERVER['HTTP_USER_AGENT'];
$t_ip=$_SERVER['SERVER_ADDR'];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>「Games」:ご意見メール</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" href="./css/main.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
$(function(){ 
    var w_w = $(window).width();
    var w_h = $(window).height();
	$('#send').click(function(){
		if ($('#ask_log').val() == '') {
			$('#err').text('本文がありません。');
			return false;
		} else {
			$('#forms').submit();
		}
	});
	$('#t_width').val(w_w);
	$('#t_height').val(w_h);

});
</script>
<style>

</style>
</head>
<body style="text-align:center;background:#303030">
<div class="main">
<form id="forms" action="./outpost.php" method="post">
<div id="err" style="color:#ff0000; font-weight:600; margin:3px auto; width:90%;height:20px;">　</div>
	<?if($mode == 1){?>

		<div class="box_01">
			下記のメールを送信します。よろしいですか。<br>
			<div class="box_04">
				<span style="font-weight:700;">おなまえ：</span><?=$tmp_name?><br>
				<span style="font-weight:700;">アドレス：</span><?=$tmp_mail?><br>
				<?=$tmp_log?>
			</div>

			<input type="hidden" value="<?=$ask_name?>" name="ask_name">
			<input type="hidden" value="<?=$ask_mail?>" name="ask_mail">
			<input type="hidden" value="<?=$ask_log?>" name="ask_log">
			<input type="hidden" value="<?=$mode?>" name="mode">

			<input type="hidden" id="t_width" name="n_width" value="">
			<input type="hidden" id="t_height" name="n_height" value="">
			<input type="hidden" id="t_ua" name="n_ua" value="<?=$t_ua?>">
			<input type="hidden" id="t_ip" name="n_ip" value="<?=$t_ip?>">

 

			<div class="box_01_btn">
				<button type="submit" value="send" name="send" class="box_btn box_01_c1">送信</button>
				<button type="submit" value="back" name="back" class="box_btn box_01_c2">戻る</button>
			</div>
		</div>

	<?}elseif($mode == 2){?>
		<div class="box_01">
<br>
<br>
		ご意見ありがとうございました。<br>
<br>
<br>
		</div>
	<?}else{?>
		<div class="box_01" style="text-align:left;">
			ご意見、ご要望をお寄せ下さいませ。<br>
			システム上の不具合や機能の希望、所感などなどなんでも結構です。<br>
		</div>

		<div class="box_01">
			<div class="box_02">
				<span class="title">お名前</span><br>
				<input type="text" value="<?=$ask_name?>" name="ask_name" placeholder="匿名でもいいよ" class="post_text"><br>
			</div>

			<div class="box_02">
				<span class="title">メールアドレス</span><br>
				<input type="text" value="<?=$ask_mail?>" name="ask_mail" placeholder="なくてもいいよ" class="post_text"><br>
			</div>

			<div class="box_02">
				<textarea id="ask_log" class="post_area" name="ask_log"><?=$ask_log?></textarea>
			</div>

			<div class="box_03">
				<input type="hidden" value="<?=$mode+0?>" name="mode">
				<input type="hidden" value="send" name="send">
				<button id="send" type="submit" class="post_send">送　信</button>
			</div>
		</div>
	<?}?>
</form>
</body>
</html>
