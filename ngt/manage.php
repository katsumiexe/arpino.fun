<?
include_once('./library/sql.php');
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
<script src="./js/manage.js?t=<?=time()?>"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/manage.css?t=<?=time()?>">
<style>
@font-face {
	font-family: at_icon;
	src: url("./font/font_1/fonts/icomoon.ttf") format('truetype');
}

@font-face {
	font-family: at_frame1;
	src: url("./font/font_3/fonts/icomoon.ttf") format('truetype');
}

@font-face {
	font-family: at_frame2;
	src: url("./font/border/frame2.ttf") format('truetype');
}

@font-face {
	font-family: at_font1;
	src: url("./font/Courgette-Regular.ttf") format('truetype');
}
</style>
</head>
<body class="body">
<div class="main">
	<?=include_once('./manage_regist.php');?>
</div>
<div class="left">
	<ul class="menu_ul">
		<li id="regist" class="menu">登録</li>
		<li id="staff" class="menu">スタッフ</li>
		<li id="sche" class="menu">スケジュール</li>
		<li id="blog" class="menu">ブログ</li>
		<li id="contents" class="menu">コンテンツ</li>
		<li id="easytalk" class="menu">EasyTalk</li>
		<li id="notice" class="menu">お知らせ</li>
		<li id="config" class="menu">コンフィグ</li>
	</ul>
	<div class="head_menu">
		<div class="menu_a"></div>
		<div class="menu_b"></div>
		<div class="menu_c"></div>
	</div>
</div>
</html>
