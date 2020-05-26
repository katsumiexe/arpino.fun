<?
session_start();
global $wpdb;
if($_POST["log_out"] == 1){
	$_POST="";
	$_SESSION="";
	session_destroy();
}

if($_SESSION){
	if(time()<$_SESSION["time"]+3600){
		$rows = $wpdb->get_row("SELECT * FROM wp01_0cast WHERE cast_id='".$_SESSION["cast_id"]."'",ARRAY_A );

		$_SESSION=$rows;
		$_SESSION["time"]=time();

	}else{
		$_SESSION="";
		session_destroy();
	}

}elseif($_POST["log_in_set"] && $_POST["log_pass_set"]){
	$rows = $wpdb->get_row("SELECT * FROM wp01_0cast WHERE cast_id='".$_POST["log_in_set"]."' AND cast_pass='".$_POST["log_pass_set"]."'",ARRAY_A );
	if($rows){
		$_SESSION=$rows;
		$_SESSION["time"]=time();

	}else{
		$err="IDもしくはパスワードが違います";
	}
}
if($_SESSION){
	$cast_page=$_POST["cast_page"]+0;
	/*--■祝日カレンダー--*/
	$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
	$ob_holiday = json_decode($holiday,true);

	//$ob_holiday["20200101"];
	/*--■メールチェック--*/
	/*
	$s_url	=get_option('mailserver_url');
	$s_port	=get_option('mailserver_port');

	$sv="{".$s_url.":".$s_port."/pop3}INBOX";
	$sv="{".$s_url.":".$s_port."}INBOX";	
	$sv="{".$s_url."}INBOX";
	$m_list=imap_open ($sv,$_SESSION["castmail"],$_SESSION["castmail_pass"]);
	$num = imap_num_msg($m_list);
	*/

	$sql	 ="SELECT * FROM wp01_0castmail_recive ";
	$sql	.=" LEFT JOIN wp01_0castomer_list ON wp01_0castmail_recive.from_address=wp01_0castomer_list.address";
	$sql	.=" WHERE to_id='".$_SESSION["id"]."'";
	$sql	.=" ORDER BY send_date DESC";
	$n=0;
	$mail_data0 = $wpdb->get_results($sql,ARRAY_A );
	foreach($mail_data0 AS $tmp){
		$mail_data[$n]=$tmp;
		$n++;
	}

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

		$v_ymd=date("Ymd",strtotime($c_month)+($d-1)*86400);

		if($tmp_w==0){
			$cal.="</tr><tr>";
		}

		if($ob_holiday[$v_ymd]){
			$tmp_w=0;
		}

		if($m-$n>=0){
			$cal.="<td class=\"cal_td cc".$tmp_w."\">";
			$cal.="<span class=\"dy".$tmp_w."\">".$d."</span>";
			$cal.="<span class=\"cal_i1 n1\"></span>";
			$cal.="<span class=\"cal_i2\"></span>";
			$cal.="<span class=\"cal_i3\"></span>";
			$cal.="</td>";

		}else{
			$cal.="<td class=\"cal_td cc".$tmp_w."\"></td>";
		}
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

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.exif.js?t=<?=time()?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/cast.js?t=<?=time()?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
</head>
<body class="body">
<? if(!$_SESSION){ ?>
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
	<?if($err){?>
	<div class="err">
	<?=$err?>
	</div>
	<? }?>
	</div>
<?}else{?>
<div class="mypage_main">
<?if($cast_page==1){?>
よてい



<?}elseif($cast_page==2){?>
<div class="mypage_mail">
	<?for($s=0;$s<count($mail_data);$s++){?>
	<div class="mypage_mail_hist <?if($mail_data[$s]["watch_date"] =="0000-00-00 00:00:00"){?> mail_yet<?}?>">
		<img src="<?php echo get_template_directory_uri(); ?>/img/costomer_no_img.jpg" class="mail_img">
		<span id="mail_date<?=$s?>" class="mail_date"><?=$mail_data[$s]["send_date"]?></span>
		<span class="mail_tmp<?if($mail_data[$s]["img_1"]){?> mail_ck<?}?>"></span>
		<span class="mail_res<?if($mail_data[$s]["res"]){?> mail_ck<?}?>"></span>
		<span class="mail_star<?if($mail_data[$s]["star"] =="1"){?> mail_ck<?}?>"></span>
		<span id="mail_title<?=$s?>" class="mail_title"><?=$mail_data[$s]["title"]?></span>
		<span id="mail<?=$s?>" class="mail_al"></span>
		<span class="mail_gp"></span><span id="mail_name<?=$s?>" class="mail_name"><?=$mail_data[$s]["from_name"]?></span>

		<input id="mail_log<?=$s?>" type="hidden" value="<?=$mail_data[$s]["log"]?>">
		<?if($mail_data[$s]["img_1"]){?><input id="img_a<?=$s?>" type="hidden" value="<?=$mail_data[$s]["img_1"]?>"><? } ?>
		<?if($mail_data[$s]["img_2"]){?><input id="img_b<?=$s?>" type="hidden" value="<?=$mail_data[$s]["img_2"]?>"><? } ?>
		<?if($mail_data[$s]["img_3"]){?><input id="img_c<?=$s?>" type="hidden" value="<?=$mail_data[$s]["img_3"]?>"><? } ?>

	</div>
	<?}?>
</div>


<div class="mypage_mail_detail">
	<span class="mail_detail_top"></span>
	<span class="mail_detail_head"></span>
	<span class="mail_detail_title"></span>
	<span class="mail_detail_log"></span>
	<span class="mail_detail_img_box">
		<img class="mail_detail_img">
		<img class="mail_detail_img">
		<img class="mail_detail_img">
	</span>
</div>

<?}elseif($cast_page==3){?>
<div>
<button type="button" class="mypage_blog_set">新規投稿</button>
<div class="mypage_blog_write">
	<div class="mypage_blog_pack">
		<span class="mypage_blog_title_tag">投稿日</span><br>
		<div style="text-align:left;margin-bottom:3vw;">	
		<input id="mypage_blog_date" type="text" name="mypage_blog_date" class="mypage_blog_date_box" value="<?=$blog_date?>">
		<input id="mypage_blog_hour" type="text" name="mypage_blog_hour" class="mypage_blog_hour_box">
		<input id="mypage_blog_minute" type="text" name="mypage_blog_minute" class="mypage_blog_hour_box"><br>
		</div>
		<span class="mypage_blog_title_tag">タイトル</span><br>
		<input id="mypage_blog_title" type="text" name="mypage_blog_title" class="mypage_blog_title_box"><br>

		<span class="mypage_blog_title_tag">本文</span><br>
		<textarea id="mypage_blog_log" type="text" name="mypage_blog_log" class="mypage_blog_log_box"></textarea><br>
	</div>
	<div class="upload_icon tag_open"></div>
	<div class="upload_icon img_open"></div>
	<div class="back">
	<div class="mypage_blog_img">
		<div class="img_box_in">
			<div class="img_box_in111"><canvas id="cvs1" width="800px" height="800px;"></canvas></div>
			<div class="img_box_out1"></div>
			<div class="img_box_out2"></div>
			<div class="img_box_out3"></div>
			<div class="img_box_out4"></div>
			<div class="img_box_out5"></div>
			<div class="img_box_out6"></div>
			<div class="img_box_out7"></div>
			<div class="img_box_out8"></div>
		</div>

		<div class="img_box_in2">
			<label for="upd" class="upload_btn"><span class="upload_icon"></span><span class="upload_txt">画像選択</span></label>
			<span class="upload_icon upload_rote"></span>
			<span class="upload_icon upload_reset"></span>
		</div>

		<div class="img_box_in3">
			<div class="zoom_mi">-</div>
			<div class="zoom_rg"><input id="input_zoom" type="range" name="num" min="100" max="300" step="1" value="100" class="range_bar"></div>
			<div class="zoom_pu">+</div><div class="zoom_box">100</div>
		</div>

		<div class="img_box_in4">
			<div id="yes_5" class="btn c2">登録</div>　
			<div class="btn c1">戻る</div>
		</div>
	</div>
	</div>
</div>
<div class="mypage_blog_hist">
<img src="" class="hist_img">
<span class="hist_date">2020/05/08 06:00</span>
<span class="hist_title">にゃんにゃかにゃー</span>
<span class="hist_watch"><span class="hist_i"></span><span class="hist_watch_c">0</span></span>
<span class="hist_comm"><span class="hist_i"></span><span class="hist_comm_c">0</span></span>
</div>
<div class="mypage_blog_hist">
<img src="" class="hist_img">
<span class="hist_date">2020/05/08 06:00</span>
<span class="hist_title">にゃんにゃかにゃー</span>
<span class="hist_watch"><span class="hist_i"></span><span class="hist_watch_c">0</span></span>
<span class="hist_comm"><span class="hist_i"></span><span class="hist_comm_c">0</span></span>
</div>

<input id="img_top" type="hidden" name="img_top" value="10">
<input id="img_left" type="hidden" name="img_left" value="10">
<input id="img_width" type="hidden" name="img_width" value="10">
<input id="img_height" type="hidden" name="img_height" value="10">
<input id="img_zoom" type="hidden" name="img_zoom" value="100">
<input id="img_url" type="hidden" name="img_url" value="<?php echo get_template_directory_uri(); ?>/img/cast/<?=$_SESSION["id"]?>/<?=date("Ymd")?>.jpg">
<input id="upd" type="file" accept="image/*" style="display:none;">
</div>
<?}elseif($cast_page==3){?>
こんふぃぐ
<?}else{?>
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
<? } ?>
<ul class="mypage_menu">
<li id="m0" class="menu_1<?if($cast_page+0==0){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">トップ</span></li>
<li id="m1" class="menu_1<?if($cast_page+0==1){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">予定</span></li>
<li id="m2" class="menu_1<?if($cast_page+0==2){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">メール</span></li>
<li id="m3" class="menu_1<?if($cast_page+0==3){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">ブログ</span></li>
<li id="m4" class="menu_1<?if($cast_page+0==4){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">設定</span></li>
</ul>
<form id="logout" action="<?php the_permalink();?>" method="post">
<input type="hidden" value="1" name="log_out">
</form>
<form id="chg_month" action="<?php the_permalink();?>" method="post">
<input type="hidden" value="<?PHP ECHO $c_month?>" name="c_month">
<input id="chg" type="hidden" name="b_month">
</form>
<form id="menu_sel" action="<?php the_permalink();?>" method="post">
<input id="cast_page" type="hidden" value="" name="cast_page">
<input type="hidden" value="<?PHP ECHO $c_month?>" name="c_month">
</form>
<? }?>
</body>
</html>
