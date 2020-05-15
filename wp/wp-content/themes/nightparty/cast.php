<?
include_once("./library/session.php");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CastPage</title>
<link rel="stylesheet" href="./css/cast.css">
<script src="../onlyme/js/jquery-3.2.1.min.js"></script>

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
