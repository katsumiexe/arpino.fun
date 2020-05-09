<?php

$step			=$_POST["step"];
$ask_name		=$_POST["ask_name"];
$ask_kana		=$_POST["ask_kana"];
$ask_zip		=$_POST["ask_zip"];
$ask_address1	=$_POST["ask_address1"];
$ask_address2	=$_POST["ask_address2"];
$ask_comment	=$_POST["ask_comment"];

$from_mail		=$_POST["from_mail"];
$to_mail		=$_POST["to_mail"];
$staff_mail		=$_POST["staff_mail"];

$from_mail		="noreply@piyo-piyo.work";

if($step==2){
	$from_name	= $from_mail;
	$subject	= "お問合せメール";
	$ret		= "-f ".$from_mail;

	$body="以下の内容でお問合せ承りました\r\n\r\n";
	$body.="名前{$ask_name}\r\n";
	$body.="カナ{$ask_kana}\r\n";
	$body.="郵便{$ask_zip}\r\n";
	$body.="住所{$ask_address1}{$ask_address2}\r\n";
	$body.="{$ask_comment}\r\n";

	$head  = "From: " . mb_encode_mimeheader($from_name,"ISO-2022-JP") . "<{$from_mail}> \r\n";
	$head .= "Content-type: text/plane; charset=UTF-8";
	$head = "From: {$from_mail}" . "\r\n";

	mb_send_mail($staff_mail, $subject, $body, $head);

print($body."<hr>");

	$subject	= "お問合せ承りました";
	$ret		= "-f ".$from_mail;

	$body ="名前{$ask_name}様\r\n";
	$body.="お問合せありがとうございました\r\n";
	$body.="改めてスタッフよりご返信申し上げます。\r\n";
	$body.="※当メールへの返信はできません。\r\n\r\n";

	$body.="お問合せ内容\r\n";
	$body.="{$ask_comment}\r\n";

	$head  = "From: " . mb_encode_mimeheader($from_name,"ISO-2022-JP") . "<{$from_mail}> \r\n";
	$head .= "Content-type: text/plane; charset=UTF-8";
	$head = "From: {$from_mail}" . "\r\n";
	mb_send_mail($to_mail, $subject, $body, $head);

print($body."<hr>");

}

?>
<!DOCTYPE HTML>
<html lang="ja">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">

<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<script src="../js/jquery.autoKana.js"></script>
<script>
var Err=0;
$(function(){ 
	$.fn.autoKana('#name', '#kana', {
		katakana : true
	});

	$('#send').on('click',function(){
		Err=0;
		if($('#name').val()==''){
			$('#name').css('background','#d00000');
			$('#name_err').show();
			Err=1;
		}

		if($('#kana').val()==''){
			$('#kana').css('background','#d00000');
			$('#kana_err').show();
			Err=1;
		}

		if($('#zip').val()==''){
			$('#zip').css('background','#d00000');
			$('#zip_err').show();
			Err=1;
		}

		if($('#ad1').val()==''){
			$('#ad1').css('background','#d00000');
			$('#add_err').show();
			Err=1;
		}

		if($('#comm').val()==''){
			$('#comm').css('background','#d00000');
			$('#com_err').show();
			Err=1;
		}

		if(Err == 0){
			$('#send_form').submit();
		}
	});

	$('#send_ok').on('click',function(){

		if($('#staffmail').val()=='' || $('#tomail').val()==''){
			$('#err_msg').fadeIn(50).delay(800).fadeOut(150);
			return false;
		}else{
			$('#send_form').submit();
		}
	});

	$('#send_ng').on('click',function(){
		$('#step').val('');
		$('#send_form').submit();
	});

	$('#name').on('keyup',function(){
		$(this).css('background','#ffffff').next().hide();
		$('#kana').css('background','#ffffff').next().hide();
	});

	$('#zip').on('keyup',function(){
		$(this).css('background','#ffffff').next().hide();
		$('#ad1').css('background','#ffffff').next().hide();
	});

	$('#kana,#ad1,#comm').on('keyup',function(){
		$(this).css('background','#ffffff').next().hide();
	});



});
</script>
<style>
.lv{
	display:inline-block;
	width:60px;
	height:20px;
	line-height:20px;	
}

.text{
	height:20px;
	width:200px;
}

.zip{
	height:20px;
	width:80px;
}
.comment{
	height:60px;
	width:250px;
	resize:none;
	padding:5px;
}
.send{
	height:40px;
	width:255px;
}

.send1{
	height:40px;
	width:100px;
}

.err{
	display:none;
	color:#d00000;
}

.err_alert{
	display:none;
	position:fixed;
	top:0;
	bottom:0;
	left:0;
	right:0;
	margin:auto;
	width:200px;
	height:50px;
	
	background:#f0f0f0;
	border:2px solid #e0e0e0;
	padding:20px;
}

.mail_box{
	margin:10px;
	padding:10px;
	display:inline-block;
	background:#f0f0ff;
}

</style>
</head>
<body class="body">
<form id="send_form" method="post" action="test.php">

<div class="mail_box">
<div class="lv">[staff]</div><input id="tomail" name="to_mail" value="<?=$to_mail?>" type="text" class="text"><br>
<div class="lv">[to]</div><input id="staffmail" name="staff_mail" value="<?=$staff_mail?>" type="text" class="text"><br>
</div>
<hr>
<?if($step==1){?>
これでよろしいでしょうか。<br>
<input id="step" type="hidden" value="2" name="step">

<input name="ask_name" value="<?=$ask_name?>" type="hidden">
<input name="ask_kana" value="<?=$ask_kana?>" type="hidden">
<input name="ask_zip" value="<?=$ask_zip?>" type="hidden">

<input name="ask_address1" value="<?=$ask_address1?>" type="hidden">
<input name="ask_address2" value="<?=$ask_address2?>" type="hidden">
<input name="ask_comment" value="<?=$ask_comment?>" type="hidden">
	

<div class="lv">名前</div><?=$ask_name?><br>
<div class="lv">カナ</div><?=$ask_kana?><br>
<div class="lv">郵便</div><?=$ask_zip?><br>
<div class="lv">住所</div><?=$ask_address1?> <?=$ask_address2?><br>
<?=str_replace("\n","<br>",$ask_comment)?><br>
</form>
<button id="send_ok" type="button" class="send1">送信</button>
<button id="send_ng" type="button" class="send1">戻る</button>

<?}elseif($step==2){?>
送信しました。<br>


<?}else{?>
<input type="hidden" value="1" name="step">
<div class="lv">名前</div><input id="name" name="ask_name" value="<?=$ask_name?>" type="text" class="text"><span id="name_err" class="err">名前は必須です</span><br>
<div class="lv">カナ</div><input id="kana" name="ask_kana" value="<?=$ask_kana?>" type="text" class="text"><span id="kana_err" class="err">カナは必須です</span><br>
<div class="lv">郵便</div><input id="zip" type="text" name="ask_zip" value="<?=$ask_zip?>" onKeyUp="AjaxZip3.zip2addr(this,'','ask_address1','ask_address1')" class="ask_zip"><span id="zip_err" class="err">郵便番号は必須です</span><br>
<div class="lv">住所１</div><input id="ad1" name="ask_address1" value="<?=$ask_address1?>" type="text" class="text"><span id="add_err" class="err">住所は必須です</span><br>
<div class="lv">住所２</div><input id="ad2" name="ask_address2" value="<?=$ask_address2?>" type="text" class="text"><br>
<textarea id="comm" name="ask_comment" class="comment"><?=$ask_comment?></textarea><span id="com_err" class="err">問合せは必須です</span><br>
</form>
<button id="send" type="button" class="send">送信</button>
<? } ?>

<div id="err_msg" class="err_alert">確認用メールアドレスを入力してください。</div>

</body>
</html>


