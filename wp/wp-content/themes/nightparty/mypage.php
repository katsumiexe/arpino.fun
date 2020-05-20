<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CastPage</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/cast.css?t=<?=time()?>">
<script src="<?php echo get_template_directory_uri(); ?>/js/main.js?t=<?=time()?>"></script>
</head>
<body class="body">

<? if(!$_SESSION["time"]): ?>
	<div class="main">
	<div class="login_box">
		<span class="login_name">IDCODE</span>
		<input type="text" class="login" name="log_in_set">
		<span class="login_name">PASSWORD</span>
		<input type="password" class="login" name="log_pass_set">
		<button id="cast_login" type="button" class="login_btn" value="send">ログイン</button>
	</div>
	</div>
<? else: ?>
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
<? endif; ?>
</div>
</body>
</html>
