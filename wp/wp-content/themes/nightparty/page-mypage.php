<?
function init_session_start(){
	session_start();
}
add_action('init', 'init_session_start');
global $wpdb;

if($_POST["log_out"] == 1){
	$_POST="";
	$_SESSION="";
	session_destroy();
}

if($_SESSION):
	if(time()<$_SESSION["time"]+3600):
		$_SESSION["time"]=time();
		$rows = $wpdb->get_results("SELECT * FROM wp01_0cast WHERE cast_id='".$_session["cast_id"]."'");
		$_SESSION=$rows;
	else:
		$_SESSION="";
		session_destroy();
	endif;

elseif($_POST):
	$rows = $wpdb->get_results("SELECT * FROM wp01_0cast WHERE cast_id='".$_POST["log_in_set"]."' AND cast_pass='".$_POST["log_pass_set"]."'");
	if($rows):
		$_SESSION["time"]=time();
		$_SESSION=$rows;
	else:
		$err="IDもしくはパスワードが違います";
	endif;
endif;

$c_month=$_POST["c_month"];
if(!$c_month) $c_month=date("Y-m-01");

$b=strtotime("2020-05-01");
$n=date("w",$b);
$t=date("t",$b);

for($m=0; $m<$t+$n;$m++){
	$d=$m-$n+1;
	if($m%7==0){
		$cal.="</tr><tr>";
	}
	if($m-$n>=0){
		$cal.="<td class=\"cal_td\">".$d."</td>";
	}else{
		$cal.="<td class=\"cal_td\"></td>";
	}
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
<script src="<?php echo get_template_directory_uri(); ?>/js/cast.js?t=<?=time()?>"></script>
</head>
<body class="body">

<? if(!$_SESSION): ?>
	<div class="mypage_main">
	<div class="login_box">
	<form action="<?php the_permalink();?>" method="post">
		<span class="login_name">IDCODE</span>
		<input type="text" class="login" name="log_in_set">
		<span class="login_name">PASSWORD</span>
		<input type="password" class="login" name="log_pass_set">
		<button id="cast_login" type="submit" class="login_btn" value="send">ログイン</button>
	</form>
	</div>
	<?PHP if($err):?>
	<div class="err">
	<?PHP ECHO $err?>
	</div>
	<?PHP endif;?>
	</div>
<? else: ?>
<div class="mypage_head">

</div>
<div class="mypage_slide">
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
<?PHP ECHO $cal?>
</tr>
</table>

<ul class="mypage_menu">
	<li id="m1" class="menu_1 menu_sel"><span class="menu_i"></span><span class="menu_s">TOP</span></li>
	<li id="m2" class="menu_1"><span class="menu_i"></span><span class="menu_s">シフト</span></li>
	<li id="m3" class="menu_1"><span class="menu_i"></span><span class="menu_s">写真</span></li>
	<li id="m4" class="menu_1"><span class="menu_i"></span><span class="menu_s">BLOG</span></li>
	<li id="m5" class="menu_1"><span class="menu_i"></span><span class="menu_s">MAIL</span></li>
	<li id="m6" class="menu_1"><span class="menu_i"></span><span class="menu_s">設定</span></li>
	<li id="m7" class="menu_1 menu_out"><span class="menu_i"></span><span class="menu_s">LOGOUT</span></li>
</ul>
</div>

	<div class="mypage_main">
	</div>
<? endif; ?>
<form id="logout" action="<?php the_permalink();?>" method="post">
<input type="hidden" value="1" name="log_out">
</form>

</body>
</html>
