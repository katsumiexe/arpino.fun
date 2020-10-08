
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


<?if($step==1){?>
<form id="send_form" method="post" action="test.php">
これでよろしいでしょうか。<br>

<input id="step" type="hidden" value="2" name="step">
<input name="ask_name" value="<?=$ask_name?>" type="hidden">
<input name="ask_kana" value="<?=$ask_kana?>" type="hidden">
<input name="ask_id" value="<?=$ask_id?>" type="hidden">
<input name="ask_address" value="<?=$ask_mail?>" type="hidden">

<div class="lv">会員ID</div><?=$ask_id?><br>
<div class="lv">名前</div><?=$ask_name?><br>
<div class="lv">カナ</div><?=$ask_kana?><br>
<div class="lv">メールアドレス</div><?=$ask_mail?><br>
</form>
<button id="send_ok" type="button" class="send1">送信</button>
<button id="send_ng" type="button" class="send1">戻る</button>

<?}elseif($step==2){?>
送信しました。<br>


<?}else{?>
<form id="send_form" method="post" action="test.php">
<input type="hidden" value="1" name="step">
<div class="lv">会員ID</div><input id="id" name="ask_id" value="<?=$ask_id?>" type="text" class="text"><span id="id_err" class="err">会員IDは必須です</span><br>
<div class="lv">名前</div><input id="name" name="ask_name" value="<?=$ask_name?>" type="text" class="text"><span id="name_err" class="err">名前は必須です</span><br>
<div class="lv">カナ</div><input id="kana" name="ask_kana" value="<?=$ask_kana?>" type="text" class="text"><span id="kana_err" class="err">カナは必須です</span><br>
<div class="lv">メールアドレス</div><input id="mail" name="ask_mail" value="<?=$ask_mail?>" type="text" class="text"><span id="mail_err" class="err">メールアドレスは必須です</span><br>
</form>
<button id="send" type="button" class="send">送信</button>
<? } ?>


</body>
</html>


