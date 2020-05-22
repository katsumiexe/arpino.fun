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

$blog_date=$_POST["blog_date"];
if(!$blog_date) $blog_date=date("Y/m/d");


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

$pg=$_POST["pg"]+0;
$c_month=$_POST["c_month"];
if(!$c_month) $c_month=date("Y-m-01");

if($_POST["b_month"] == 'next'){
	$c_month=date("Y-m-01",strtotime($c_month)+3456000);
}

if($_POST["b_month"] == 'prev'){
	$c_month=date("Y-m-01",strtotime($c_month)-86400);
}

$n=date("w",strtotime($c_month));
$t=date("t",strtotime($c_month));
$v_year	=substr($c_month,0,4)."年";
$v_month=substr($c_month,5,2)."月";

for($m=0; $m<$t+$n;$m++){
	$d=$m-$n+1;
	$tmp_w=$m%7;
	if($tmp_w==0){
		$cal.="</tr><tr>";
	}
	if($m-$n>=0){
		$cal.="<td class=\"cal_td cc".$tmp_w."\"><span class=\"dy".$tmp_w."\">".$d."</span></td>";
	}else{
		$cal.="<td class=\"cal_td cc".$tmp_w."\"></td>";
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
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/cast.css?t=<?=time()?>">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
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
<div class="mypage_main">
<table class="cal_table">
<tr>
<td class="cal_top" colspan="1"></td>
<td class="cal_top" colspan="1"><span id="prev" class="cal_prev"></span></td>
<td class="cal_top" colspan="3"><span class="v_year"><?PHP ECHO $v_year?></span><span class="v_month"><?PHP ECHO $v_month?></span></td>
<td class="cal_top" colspan="1"><span id="next" class="cal_next"></span></td>
<td class="cal_top" colspan="1"></td>
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
<? endif; ?>

<form id="logout" action="<?php the_permalink();?>" method="post">
<input type="hidden" value="1" name="log_out">
</form>

<form id="chg_month" action="<?php the_permalink();?>" method="post">
<input type="hidden" value="<?PHP ECHO $c_month?>" name="c_month">
<input id="chg" type="hidden" name="b_month">
</form>

<form id="menu_sel" action="<?php the_permalink();?>" method="post">
<input id="pg" type="hidden" value="" name="pg">
<input type="hidden" value="<?PHP ECHO $c_month?>" name="c_month">
</form>

<ul class="mypage_menu">
<li id="m0" class="menu_1<?if($pg+0==0){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">トップ</span></li>
<li id="m1" class="menu_1<?if($pg+0==1){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">予定</span></li>
<li id="m2" class="menu_1<?if($pg+0==2){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">メール</span></li>
<li id="m3" class="menu_1<?if($pg+0==3){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">ブログ</span></li>
<li id="m4" class="menu_1<?if($pg+0==4){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">設定</span></li>
</ul>
</body>
</html>
