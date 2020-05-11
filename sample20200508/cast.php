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
});
</script>
<style>
.body{
	background:#f0f0f0;
	text-align:center;
}

.menu{
	display			:inline-block;
	background		:#ffd0d0;
	width			:300px;
	height			:400px;
	padding			:20px;
	border-radius	:20px;
}

.main{
	display			:inline-block;
	background		:#fafafa;
	width			:100vw;
	height			:100vh;
	max-width		:650px;
	margin			:0 auto;	
}

.login_box{
	display			:inline-block;
	width			:70%;
	border			:1vw solid #ffd0d0;
	box-shadow		:1vw 1vw 1vw rgba(30,30,30,0.6);
	border-radius	:2vw;
	margin			:10vh auto;
	padding			:1vw;
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

.menu_1{
	display		:block;
	margin		:0 auto;
	width		:260px;
	height		:50px;
	line-height	:50px;
	text-align	:left;
	font-size	:16px;
	border		:2px solid #fafafa;
	background	:#f1c0d0;
	padding-left:10px;
	color		:#fafafa;
	font-weight	:700;
}
</style>
<?$_SESSION["id"]=1;?>
<body class="body">
<?if(!$_SESSION["id"]){?>
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
	<div class="menu">
	<span id="m1" class="menu_1">TOP</span>
	<span id="m2" class="menu_1">シフト</span>
	<span id="m3" class="menu_1">写真</span>
	<span id="m4" class="menu_1">日記</span>
	<span id="m5" class="menu_1">BBS</span>
	<span id="m6" class="menu_1">TL</span>
	<span id="m7" class="menu_1">MAIL</span>
	</div>
	<div class="main"></div>
<?}?>
</div>
</body>
</html>
