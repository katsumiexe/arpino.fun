<?
include_once("./library/session.php");



?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CastPage</title>
<script src="../onlyme/js/jquery-3.2.1.min.js"></script>
<script>
$(function(){ 
var AllCnt=<?=count($list)-1?>;
var NowCnt=<?=count($list)-1?>;
	$('.tag_a').on('click', function() {
		if($(this).hasClass("tag_b")){
			$(this).removeClass("tag_b");
			NowCnt--;
		}else{
			$(this).addClass("tag_b");
			NowCnt++;
		}		

		$('.box').hide();
		Tmp = $(this).attr('id');
		$('.'+Tmp).fadeIn();

		$('#max_cnt').text(AllCnt);
		$('#now_cnt').text(NowCnt);
	});
});
</script>
<style>
.body{
	background:#f0f0f0;
	text-align:center;
}
.main{
	background		:#fafafa;
	width			:100vw;
	height			:100vh;
	max-width		:650px;
	margin			:0 auto;	
}

.login_box{
	display			:inline-block;
	width			:80%;
	border			:1vw solid #ffd0d0;
	text-shadow		:1vw 1vw 1vw rgba()30,30,30,0.6);
	border-radius	:2vw;
	margin			:10vh auto;
	background		:#fff0f5
}

.login_name{
	display			:inline-block;
	width			:80%;
	font-size		:3.5vw;
	font-weight		:600;
	margin			:1vw auto 0.5vw 2vw;
	text-align		:left;
}

.login{
	width			:80%;
	font-size		:4.5vw;
	font-weight		:600;
	margin			:0 auto 0.5vw 1.5vw;
	height			:6vw;
}

.login_btn{
	width			:80%;
	font-size		:4vw;
	font-weight		:600;
	margin			:5vw auto;
	height			:8vw;
}

</style>
<body class="body">
<?if(!$_SESSION["id"]){?>
	<div class="menu"></div>
	<div class="main">
	<div class="login_box">
		<span class="login_name">IDCODE</span>
		<input type="text" class="login" name="log_in_set">
		<span class="login_name">PASSWORD</span>
		<input type="password" class="login" name="log_pass_set">
		<button type="submit" class="login_btn" value="send">ログイン</button>
	</div>
	</div>
<?}else{?>
	<div class="menu"></div>
	<div class="main"></div>
<?}?>
</div>
</body>
</html>
