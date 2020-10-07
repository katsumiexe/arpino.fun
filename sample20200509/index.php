<?php
$mysqli = mysqli_connect("localhost", "tiltowait_tmpl", "kk1941", "tiltowait_tmpl");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

$step			=$_POST["step"];
$ask_name		=$_POST["ask_name"];
$ask_kana		=$_POST["ask_kana"];
$ask_mail		=$_POST["ask_mail"];
$ask_id			=$_POST["ask_id"];

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


	$subject	= "メールアドレス登録";
	$ret		= "-f ".$from_mail;

	$body ="{$ask_name}様\r\n";
	$body.="メールアドレスの登録を承りました\r\n";
	$body.="※当メールへの返信はできません。\r\n\r\n";

	$head  = "From: " . mb_encode_mimeheader($from_name,"ISO-2022-JP") . "<{$from_mail}> \r\n";
	$head .= "Content-type: text/plane; charset=UTF-8";
	$head = "From: {$from_mail}" . "\r\n";
	mb_send_mail($ask_mail, $subject, $body, $head);

	$now=date("Y-m-d H:i:s");
	$sql="INSERT INTO zlog_20200509 (regist_time,user_id,user_name,user_kana,user_mail)";
	$sql.=" VALUES ('{$now}','{$ask_id}','{$ask_name}','{$ask_kana}','{$ask_mail}')";
	mysqli_query($mysqli,$sql);

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

		if($('#id').val()==''){
			$('#id').css('background','#d00000');
			$('#id_err').show();
			Err=1;
		}

		if($('#kana').val()==''){
			$('#kana').css('background','#d00000');
			$('#kana_err').show();
			Err=1;
		}

		if($('#mail').val()==''){
			$('#mail').css('background','#d00000');
			$('#mail_err').show();
			Err=1;
		}

		if(Err == 0){
			$('#send_form').submit();
		}
	});

	$('#send_ok').on('click',function(){
		$('#send_form').submit();
	});

	$('#send_ng').on('click',function(){
		$('#step').val('');
		$('#send_form').submit();
	});

	$('#name').on('keyup',function(){
		$('#kana').css('background','#ffffff');
		$('#kana_err').hide();
	});

	$('.text').on('keyup',function(){
		Err=$(this).attr("id")+"_err";
		$(this).css('background','#ffffff');
		$("#"+Err).hide();
	});
});
</script>
<style>

.body{
	width:100%;
	max-width:600px;
	text-align:center;
	background:#fafafa;
}

.box_1{
	width:600px;
	text-align:left;
}


.lv{
	width			:120px;
	height			:24px;
	line-height		:24px;	
	font-size		:16px;
	border			:1px solid #c0c0c0;
	text-align		:left;
	padding-left	:5px;
}

.lv_2{
	width			:300px;
	height			:24px;
	line-height		:24px;	
	font-size		:16px;
	border			:1px solid #c0c0c0;
	text-align		:left;
}


.lv_3{
	border-left		:none;
	border-right	:none;
	border-bottom	:none;
	padding			:5px;
	text-align		:center;
}


.text{
	height			:24px;
	width			:300px;
	border			:none;
	font-size		:16px;
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
	border-top:none;
	border-right:none;
	border-bottom:none;
	font-size:13px;
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
<?if($step==1){?>

<form id="send_form" method="post" action="index.php">

これでよろしいでしょうか。<br>
<input id="step" type="hidden" value="2" name="step">
<input name="ask_name" value="<?=$ask_name?>" type="hidden">
<input name="ask_kana" value="<?=$ask_kana?>" type="hidden">
<input name="ask_id" value="<?=$ask_id?>" type="hidden">
<input name="ask_mail" value="<?=$ask_mail?>" type="hidden">
<div class="box_1">
<table>
<tr>
<td class="lv">会員ID</td><td class="lv_2"><?=$ask_id?></td>
</tr><tr>
<td class="lv">名前</td><td class="lv_2"><?=$ask_name?></td>
</tr><tr>
<td class="lv">カナ</td><td class="lv_2"><?=$ask_kana?></td>
</tr><tr>
<td class="lv">メールアドレス</td><td class="lv_2"><?=$ask_mail?></td>
</tr>
</form>
<tr>
<td class="lv_3" colspan="2">
<button id="send_ok" type="button" class="send1">送信</button>
<button id="send_ng" type="button" class="send1">戻る</button>
</td>
<td></td>
</tr>
</table>

</div>
<?}elseif($step==2){?>

送信しました。<br>

<?}else{?>
<form id="send_form" method="post" action="index.php">
<div class="box_1">
<input type="hidden" value="1" name="step">
<table class="table">
<tr>
	<td class="lv">会員ID</td>
	<td class="lv_2"><input id="id" name="ask_id" value="<?=$ask_id?>" type="text" class="text"></td>
	<td id="id_err" class="err">会員IDは必須です</td>
</tr><tr>	

<tr>
	<td class="lv">名前</td>
	<td class="lv_2"><input id="name" name="ask_name" value="<?=$ask_name?>" type="text" class="text"></td>
	<td id="name_err" class="err">名前は必須です</td>
</tr><tr>	

<tr>
	<td class="lv">カナ</td>
	<td class="lv_2"><input id="kana" name="ask_kana" value="<?=$ask_kana?>" type="text" class="text"></td>
	<td id="kana_err" class="err">カナは必須です</td>
</tr><tr>	

<tr>
	<td class="lv">メールアドレス</td>
	<td class="lv_2"><input id="mail" name="ask_mail" value="<?=$ask_mail?>" type="text" class="text"></td>
	<td id="mail_err" class="err">メールアドレスは必須です</td>
</tr>
</form>
<tr>
<td class="lv_3" colspan="2">
<button id="send" type="button" class="send">送信</button>
</td>
<td></td>
</tr>
</table>
<? } ?>


</body>
</html>


