<?
session_start();
global $wpdb;
if($_POST["log_out"] == 1){
	$_POST="";
	$_SESSION="";
	session_destroy();
}

$week[0]="日";
$week[1]="月";
$week[2]="火";
$week[3]="水";
$week[4]="木";
$week[5]="金";
$week[6]="土";

$week_tag[0]="c1";
$week_tag[1]="c2";
$week_tag[2]="c2";
$week_tag[3]="c2";
$week_tag[4]="c2";
$week_tag[5]="c2";
$week_tag[6]="c3";

$week_tag2[0]="ca1";
$week_tag2[1]="ca2";
$week_tag2[2]="ca2";
$week_tag2[3]="ca2";
$week_tag2[4]="ca2";
$week_tag2[5]="ca2";
$week_tag2[6]="ca3";

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
/*
	$id_8	=substr("00000000".$_SESSION["id_8"],-8);
	$id_20	=$_SESSION["id_8"]%20;
	
	$sql ="SELECT * FROM wp01_0encode"; 
	$enc0 = $wpdb->get_results($sql,ARRAY_A );
	foreach($enc0 as $enc1){
		$enc[$row["key"]]			=$row["value"];
		$dec[$gp][$row["value"]]	=$row["key"];
	}

	for($n=0;$n<8;$N++){
		$tmp_dir.=$dec[$id_20][$n];
	}

	$dir=get_template_directory_uri()."img/cast/".$tmp_dir;
	
	if(!file_exists($dir)){
		mkdir($dir."/c/", 0777, TRUE);
		chmod($dir."/c/", 0777);
		mkdir($dir."/m/", 0777, TRUE);
		chmod($dir."/m/", 0777);
	}
*/



	/*--■祝日カレンダー--*/
	$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
	$ob_holiday = json_decode($holiday,true);
	//$ob_holiday["20200101"];

	/*--■イニシャライズ--*/
	$cast_page=$_POST["cast_page"]+0;
	$c_month=$_POST["c_month"];
	if(!$c_month) $c_month=date("Y-m-01");

	$calendar[0]=date("Y-m-01",strtotime($c_month)-86400);
	$calendar[1]=$c_month;
	$calendar[2]=date("Y-m-01",strtotime($c_month)+3456000);

	$week_start=get_option("start_of_week")+0;
	$now_w=date("w");

	$base_now=strtotime(date("Y-m-d 00:00:00"));
	$base_w=$now_w-$week_start;
	if($base_w<0) $base_w+=7;

	$base_day=$base_now-($base_w+7)*86400;

	$week_st=date("Ymd",$base_day);
	$week_ed=date("Ymd",$base_day+604800);

	$month_st=date("Ymd",strtotime($calendar[1]));
	$month_ed=date("Ymd",strtotime($calendar[2]));

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

	/*--■スケジュール--*/
	$sql	 ="SELECT * FROM wp01_0castmail_receive ";
	$sql	.=" LEFT JOIN wp01_0castomer_list ON wp01_0castmail_receive.from_address=wp01_0castomer_list.address";
	$sql	.=" WHERE to_id='".$_SESSION["id"]."'";
	$sql	.=" ORDER BY send_date DESC";
	$n=0;
	$mail_data0 = $wpdb->get_results($sql,ARRAY_A );
	foreach($mail_data0 AS $tmp){
		$mail_data[$n]=$tmp;
		$n++;
	}

	$sql ="SELECT * FROM wp01_0sch_table";
	$sql.=" ORDER BY sort ASC";
	$dat = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat as $tmp){
		$sche_table_name[$tmp["in_out"]][$tmp["sort"]]	=$tmp["name"];
		$sche_table_time[$tmp["in_out"]][$tmp["sort"]]	=$tmp["time"];
	}

	$sql	 ="SELECT * FROM wp01_0schedule";
	$sql	.=" WHERE cast_id='{$_SESSION["id"]}'";
	$sql	.=" AND sche_date>='{$month_st}'";
	$sql	.=" AND sche_date<'{$month_ed}'";

	$dat = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat as $tmp2){
		$stime[$tmp2["sche_date"]]		=$tmp2["stime"];
		$etime[$tmp2["sche_date"]]		=$tmp2["etime"];
	}

	for($n=0;$n<3;$n++){
		$now_month=date("m",strtotime($calendar[$n]));
		$t=date("t",strtotime($calendar[$n]));

		$wk=$week_start-date("w",strtotime($calendar[$n]));
		if($wk>0) $wk-=7;

		$st=strtotime($calendar[$n])+($wk*86400);
		$v_year[$n]	=substr($calendar[$n],0,4)."年";
		$v_month[$n]=substr($calendar[$n],5,2)."月";

		for($m=0; $m<42;$m++){
			$tmp_ymd	=date("Ymd",$st+($m*86400));
			$tmp_month	=date("m",$st+($m*86400));
			$tmp_day	=date("d",$st+($m*86400));
			$tmp_week	=date("w",$st+($m*86400));

			$tmp_w		=$m % 7;
			if($tmp_w==0){

				if($now_month<$tmp_month){
					break 1;
				}else{
					$cal[$n].="</tr><tr>";
				}
			}

			if($ob_holiday[$tmp_ymd]){
				$tmp_week=0;
			}

			if($now_month!=$tmp_month){
				$day_tag=" outof";

			}else{
				$day_tag=" nowmonth";
			}

			if($stime[$tmp_ymd] && $etime[$tmp_ymd]){
				$jb=" n2";
			}else{
				$jb="";
			}
			$cal[$n].="<td id=\"{$tmp_ymd}\" class=\"cal_td cc{$tmp_week}\">";
			$cal[$n].="<span class=\"dy{$tmp_week}{$day_tag} cc{$tmp_week}\">{$tmp_day}</span>";
			$cal[$n].="<span class=\"cal_i1 n1\"></span>";
			$cal[$n].="<span class=\"cal_i2{$jb}\"></span>";
			$cal[$n].="<span class=\"cal_i3\"></span>";
			$cal[$n].="</td>";
		}
	}

	$n=0;

	$sql	 ="SELECT * FROM wp01_0customer";
	$sql	.=" WHERE cast_id='{$_SESSION["id"]}'";
	$sql	.=" AND `del`='0'";
	$dat2 = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat2 as $cus2){
		$customer[$n]=$cus2;
		$n++;
	}

	$sql	 ="SELECT * FROM wp01_0customer_item";
	$sql	.=" WHERE del='0'";
	$dat2 = $wpdb->get_results($sql,ARRAY_A );

	foreach($dat2 as $cus2){
		$c_list_name[$cus2["gp"]][$cus2["id"]]=$cus2["item_name"];
		$c_list_style[$cus2["id"]]=$cus2["style"];
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

<script>
const Dir='<?php echo get_template_directory_uri(); ?>'; 
const CastId='<?=$_SESSION["id"] ?>'; 
</script>
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
<div class="mypage_head">
	<div class="head_mymenu">
		<div class="mymenu_a"></div>
		<div class="mymenu_b"></div>
		<div class="mymenu_c"></div>
	</div>	
</div>
<div class="mypage_slide">
	<ul class="mypage_menu">
		<li id="m0" class="menu_1<?if($cast_page+0==0){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">トップ</span></li>
		<li id="m1" class="menu_1<?if($cast_page+0==1){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">スケジュール</span></li>
		<li id="m2" class="menu_1<?if($cast_page+0==2){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">顧客管理</span></li>
		<li id="m3" class="menu_1<?if($cast_page+0==3){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">メール</span></li>
		<li id="m4" class="menu_1<?if($cast_page+0==4){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">ブログ</span></li>
		<li id="m5" class="menu_1<?if($cast_page+0==5){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">設定</span></li>
		<li id="m99" class="menu_1 menu_out"><span class="menu_i"></span><span class="menu_s">ログアウト</span></li>
	</ul>
</div>

<div class="mypage_main">
<?if($cast_page==1){?>

<?}elseif($cast_page==2){?>

<div class="mypage_customer">
<?for($n=0;$n<count($customer);$n++){?>
	<div id="clist<?=$customer[$n]["id"]?>" class="customer_list">
		<?if($customer[$n]["face"]){?>
			<img src="<?php echo get_template_directory_uri(); ?>/img/customer_no_img.jpg" class="mail_img">
		<?}else{?>
			<img src="<?php echo get_template_directory_uri(); ?>/img/customer_no_img.jpg" class="mail_img">
		<? } ?>
		<div class="customer_list_fav">
			<?for($s=1;$s<6;$s++){?>
				<span class="customer_list_fav_icon<?if($customer[$n]["fav"]>=$s){?> fav_in<?}?>"></span>
			<?}?>
		</div>

		<div class="customer_list_name"><?=$customer[$n]["name"]?> 様</div>
		<div class="customer_list_nickname"><?=$customer[$n]["nickname"]?></div>
		<span class="mail_al"></span>
		<input type="hidden" class="customer_hidden_fav" value="<?=$customer[$n]["fav"]?>">
	</div>
<?}?>



	<div class="customer_detail">
		<table class="customer_base">
		<tr>
			<td class="customer_base_img" rowspan="4"></td>
			<td class="customer_base_tag">最終</td>
			<td id="" class="customer_base_item">16日前</td>
		</tr>
		<tr>
			<td class="customer_base_tag">名前</td>
			<td id="c_name" class="customer_base_item"><input type="text" id="customer_detail_name" value="" class="item_basebox"></td>
		</tr>
		<tr>
			<td class="customer_base_tag">呼び名</td>
			<td id="c_nick" class="customer_base_item"><input type="text" id="customer_detail_nick" value="" class="item_basebox"></td>
		</tr>
		<tr>
			<td class="customer_base_tag">誕生日</td>
			<td id="c_birth" class="customer_base_item">1977/06/10（43歳）</td>
		</tr>
		<tr>
			<td class="customer_base_fav">
				<span id="fav_1" class="customer_fav"></span>
				<span id="fav_2" class="customer_fav"></span>
				<span id="fav_3" class="customer_fav"></span>
				<span id="fav_4" class="customer_fav"></span>
				<span id="fav_5" class="customer_fav"></span>
			</td>
			<td class="customer_base_tag">出身</td>
			<td class="customer_base_item">ばぶー</td>
		</tr>
		</table>

		<div class="customer_tag">
		<div id="tag_0" class="tag_set tag_set_ck" style="top:0.5vw;">基本情報</div>
		<div id="tag_1" class="tag_set">詳細情報</div>
		<div id="tag_2" class="tag_set">連絡先</div>
		<div id="tag_3" class="tag_set">メモ</div>
		<button class="tag_btn">更新</button>
		</div>

		<div class="customer_body">
			<?for($n=0;$n<3;$n++){?>
				<table id="tag_<?=$n?>_tbl" class="customer_memo">
					<?foreach($c_list_name[$n] as $a1=> $a2){?>
						<?if($c_list_style[$a1] == 2){?>
							<tr>
								<td class="customer_memo_tag"><?=$a2?></td>
								<td class="customer_memo_item">
									<lavel><input type="radio" name="cas[<?=$a1?>]" value="1">Yes</label>
									<lavel><input type="radio" name="cas[<?=$a1?>]" value="2">No</label>
								</td>
							</tr>

						<?}elseif($c_list_style[$a1] == 3){?>
							<tr>
								<td class="customer_memo_tag"><?=$a2?></td>
								<td class="customer_memo_item">
									<lavel><input type="radio" name="cas[<?=$a1?>]" value="1">Ａ</label>
									<lavel><input type="radio" name="cas[<?=$a1?>]" value="2">Ｂ</label>
									<lavel><input type="radio" name="cas[<?=$a1?>]" value="3">Ｏ</label>
									<lavel><input type="radio" name="cas[<?=$a1?>]" value="4">AB</label>
								</td>
							</tr>
						<?}else{?>
							<tr>
								<td class="customer_memo_tag"><?=$a2?></td>
								<td class="customer_memo_item"><input type="text" name="cas[<?=$a1?>]"class="item_textbox"></td>
							</tr>
						<? } ?>
					<? } ?>
				</table>
			<? } ?>
		</div>
	</div>
</div>

<?}elseif($cast_page==3){?>
<div class="mypage_mail">
	<?for($s=0;$s<count($mail_data);$s++){?>
	<div class="mypage_mail_hist <?if($mail_data[$s]["watch_date"] =="0000-00-00 00:00:00"){?> mail_yet<?}?>">
		<img id="mail_img<?=$s?>" src="<?php echo get_template_directory_uri(); ?>/img/customer_no_img.jpg" class="mail_img">
		<span id="mail_date<?=$s?>" class="mail_date"><?=$mail_data[$s]["send_date"]?></span>
		<span id="mail_icon<?=$s?>" class="mail_icon">
			<span class="mail_tmp<?if($mail_data[$s]["img_1"]){?> mail_ck<?}?>"></span>
			<span class="mail_res<?if($mail_data[$s]["res"]){?> mail_ck<?}?>"></span>
			<span class="mail_star<?if($mail_data[$s]["star"] =="1"){?> mail_ck<?}?>"></span>
		</span>

		<span id="mail_title<?=$s?>" class="mail_title"><?=$mail_data[$s]["title"]?></span>
		<span id="mail<?=$s?>" class="mail_al"></span>
		<span class="mail_gp"></span><span id="mail_name<?=$s?>" class="mail_name"><?=$mail_data[$s]["from_name"]?></span>

		<input id="mail_address<?=$s?>" type="hidden" value="<?=$mail_data[$s]["from_address"]?>">
		<input id="mail_log<?=$s?>" type="hidden" value="<?=$mail_data[$s]["log"]?>">
		<?if($mail_data[$s]["img_1"]){?><input id="img_a<?=$s?>" type="hidden" value='<?php echo get_template_directory_uri(); ?>/img/cast/mail/<?=$_SESSION["id"]?>/<?=$mail_data[$s]["img_1"]?>'><? } ?>
		<?if($mail_data[$s]["img_2"]){?><input id="img_b<?=$s?>" type="hidden" value='<?php echo get_template_directory_uri(); ?>/img/cast/mail/<?=$_SESSION["id"]?>/<?=$mail_data[$s]["img_2"]?>'><? } ?>
		<?if($mail_data[$s]["img_3"]){?><input id="img_c<?=$s?>" type="hidden" value='<?php echo get_template_directory_uri(); ?>/img/cast/mail/<?=$_SESSION["id"]?>/<?=$mail_data[$s]["img_3"]?>'><? } ?>
	</div>
	<?}?>
</div>
<div class="mypage_mail_detail">
	<span class="mail_detail_from">
		<span class="mail_detail_back"></span>
		<span class="mail_detail_name"></span>
		<span class="mail_detail_address"></span>
		<img class="mail_detail_img">
	</span>
	<span class="mail_detail_body">
		<span class="mail_detail_head">
			<span class="mail_detail_date"></span>
			<span class="mail_detail_icon"></span>
			<span class="mail_detail_title"></span>
		</span>
		<span class="mail_detail_log"></span>

		<span class="mail_detail_img_box">
			<span id="sum_img_a" class="mail_detail_tmp"></span>
			<span id="sum_img_b" class="mail_detail_tmp"></span>
			<span id="sum_img_c" class="mail_detail_tmp"></span>
		</span>
	</span>
</div>
<input id="dir" type="hidden" value="<?php echo get_template_directory_uri(); ?>">
<div class="detail_modal">
	<div class="detail_modal_box">
		<span class="detail_modal_out">×</span>
		<img src="" class="detail_modal_img">
		<div class="detail_modal_link">
		</div>
	</div>
</div>

<?}elseif($cast_page==4){?>
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
<?}elseif($cast_page==5){?>
<div class="mypage_config">
<div class="config_menu">
名前：
CAST_ID：
PASSWORD：
お知らせADDRESS
</div>

</div>
<?}else{?>
<input id="c_month" type="hidden" value="<?=$c_month?>" name="c_month">
<input id="week_start" type="hidden" value="<?=$week_start?>">
<div>
<div class="mypage_cal">
<?for($c=0;$c<3;$c++){?>
<table class="cal_table">
<tr>
<td class="cal_top" colspan="1"></td>
<td class="cal_top" colspan="1"><span class="cal_prev"></span></td>
<td class="cal_top" colspan="3"><span class="v_year"><?PHP ECHO $v_year[$c]?></span><span class="v_month"><?PHP ECHO $v_month[$c]?></span></td>
<td class="cal_top" colspan="1"><span class="cal_next"></span></td>
<td class="cal_top" colspan="1"></td>
</tr>
<tr>
<?
for($s=0;$s<7;$s++){
$w=($s+$week_start) % 7;
?>
<td class="cal_td <?PHP ECHO $week_tag[$w]?>"><?PHP ECHO $week[$w]?></td>
<? } ?>
<?PHP ECHO $cal[$c]?>
</tr>
</table>
<?}?>
</div>
</div>
<div class="cal_days">
</div>

<div class="cal_set_btn">スケジュール入力</div>
<div class="cal_weeks">
	<div class="cal_weeks_prev">前週</div>
	<div class="cal_weeks_box">
		<div class="cal_weeks_box_2">
			<?for($n=0;$n<21;$n++){
				$tmp_wk=($n+$week_start)%7;
			?>
				<div class="cal_list">
					<div class="cal_day <?=$week_tag2[$tmp_wk]?>"><?=date("m月d日",$base_day+86400*$n)?>(<?=$week[$tmp_wk]?>)</div>
<?if($base_now>$base_day+86400*$n){?>
						<div class="d_sch_time_in"><?=$stime[date("Ymd",$base_day+86400*$n)]?></div>
						<div class="d_sch_time_out"><?=$etime[date("Ymd",$base_day+86400*$n)]?></div>
<?}else{?>
					<select id="sel_in<?=$n?>" class="sch_time_in">
						<option class="sel_txt"></option>
						<?for($s=0;$s<count($sche_table_name["in"]);$s++){?>
							<option class="sel_txt" value="<?=$sche_table_name["in"][$s]?>" <?if($stime[date("Ymd",$base_day+86400*$n)]===$sche_table_name["in"][$s]){?> selected="selected"<?}?>><?=$sche_table_name["in"][$s]?></option>
						<?}?>
					</select>
					<select id="sel_out<?=$n?>" class="sch_time_out">
						<option class="sel_txt"></option>
						<?for($s=0;$s<count($sche_table_name["out"]);$s++){?>
							<option class="sel_txt" value="<?=$sche_table_name["out"][$s]?>" <?if($etime[date("Ymd",$base_day+86400*$n)]===$sche_table_name["out"][$s]){?> selected="selected"<?}?>><?=$sche_table_name["out"][$s]?></option>
						<?}?>
					</select>
<? } ?>
				</div>
			<? } ?>
		</div>
	</div>
	<div class="cal_weeks_next">翌週</div>
	<div class="sch_set">SCHE_SET</div>
	<span class="sch_set_done">スケジュールが登録されました</span>
</div>
<? } ?>

<input id="base_day" type="hidden" value="<?=$base_day?>">
<input id="cast_id" type="hidden" value="<?=$_SESSION["id"]?>">
<form id="logout" action="<?php the_permalink();?>" method="post">
<input type="hidden" value="1" name="log_out">
</form>

<form id="menu_sel" action="<?php the_permalink();?>" method="post">
<input id="cast_page" type="hidden" value="" name="cast_page">
<input type="hidden" value="<?PHP ECHO $c_month?>" name="c_month">
</form>
<? }?>
</body>
</html>
