<?
function init_session_start(){
	session_start();
}
add_action('init', 'init_session_start');

$cast_id	="cast";
$cast_pass	="pass";

global $wpdb;
$rows = $wpdb->get_results("SELECT * FROM wp01_0cast WHERE cast_id='".$cast_id."' AND cast_pass='".$cast_pass."'");
//foreach($rows as $row);
if($rows):

else:

endif;

if(time()>$_SESSION["time"]+3600){
	$_SESSION="";
	session_destroy();

}else{
	$_SESSION["time"]=time();
}
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CastPage</title>
<style>
@font-face {
	font-family: at_icon;
	src: url(<?php echo get_template_directory_uri(); ?>/font/font_1/fonts/icomoon.ttf) format('truetype');
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/cast.css?t=<?=time()?>">
<script src="<?php echo get_template_directory_uri(); ?>/js/main.js?t=<?=time()?>"></script>
</head>
<body class="body">
<? if($_SESSION["time"]): ?>
	<div class="mypage_main">
	<div class="login_box">
		<span class="login_name">IDCODE</span>
		<input type="text" class="login" name="log_in_set">
		<span class="login_name">PASSWORD</span>
		<input type="password" class="login" name="log_pass_set">
		<button id="cast_login" type="button" class="login_btn" value="send">ログイン</button>
	</div>
	</div>
<? else: ?>
<div class="mymenu_head">

</div>
<div class="mymenu_slide">
<table class="cal_table">
<tr>
<td class="cal_top" colspan="2"><span class="cal_prev"></span></td>
<td class="cal_top" colspan="3">07月</td>
<td class="cal_top" colspan="2"><span class="cal_next"></span></td>
</tr>
<tr>
<td class="cal_td c1">日</td>
<td class="cal_td c2">月</td>
<td class="cal_td c2">火</td>
<td class="cal_td c2">水</td>
<td class="cal_td c2">木</td>
<td class="cal_td c2">金</td>
<td class="cal_td c3">土</td>
</tr>
<tr>
<td class="cal_td">01</td>
<td class="cal_td">02</td>
<td class="cal_td">03</td>
<td class="cal_td">04</td>
<td class="cal_td">05</td>
<td class="cal_td">06</td>
<td class="cal_td">07</td>
</tr>
<tr>
<td class="cal_td">01</td>
<td class="cal_td">02</td>
<td class="cal_td">03</td>
<td class="cal_td">04</td>
<td class="cal_td">05</td>
<td class="cal_td">06</td>
<td class="cal_td">07</td>
</tr>
</table>
<ul class="mypage_menu">
	<li id="m1" class="menu_1 menu_sel"><span class="menu_i"></span><span class="menu_s">TOP</span></li>
	<li id="m2" class="menu_1"><span class="menu_i"></span><span class="menu_s">シフト</span></li>
	<li id="m3" class="menu_1"><span class="menu_i"></span><span class="menu_s">写真</span></li>
	<li id="m4" class="menu_1"><span class="menu_i"></span><span class="menu_s">BLOG</span></li>
	<li id="m5" class="menu_1"><span class="menu_i"></span><span class="menu_s">MAIL</span></li>
	<li id="m6" class="menu_1"><span class="menu_i"></span><span class="menu_s">設定</span></li>
</ul>
</div>

	<div class="mypage_main">
	</div>
<? endif; ?>



</body>
</html>

