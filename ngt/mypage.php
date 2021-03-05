<?
include_once('./library/sql_cast.php');

$week[0]="日";
$week[1]="月";
$week[2]="火";
$week[3]="水";
$week[4]="木";
$week[5]="金";
$week[6]="土";

//Sche-----------------------
if($cast_data){
$c_month=$_POST["c_month"];
if(!$c_month) $c_month=date("Y-m-01");

$calendar[0]=date("Y-m-01",strtotime($c_month)-86400);
$calendar[1]=$c_month;
$calendar[2]=date("Y-m-01",strtotime($c_month)+3456000);
$calendar[3]=date("Y-m-01",strtotime($calendar[2])+3456000);

$month_ym[0]=substr(str_replace("-","",$calendar[0]),0,6);	
$month_ym[1]=substr(str_replace("-","",$calendar[1]),0,6);	
$month_ym[2]=substr(str_replace("-","",$calendar[2]),0,6);	

$base_w=$day_w-$config["start_week"];
if($base_w<0) $base_w+=7;

$base_day		=$day_time-($base_w+7)*86400;
$week_st		=date("Ymd",$base_day);
$week_ed		=date("Ymd",$base_day+604800);
$month_st		=date("Ymd",strtotime($calendar[0]));
$month_ed		=date("Ymd",strtotime($calendar[3]));

$ana_ym=$_POST["ana_ym"];
if(!$ana_ym) $ana_ym=date("Ym");


//analytics-----------------------
$week_01		=date("w",strtotime($c_month));

$ana_line[$config["start_week"]]=" ana_line";

$cast_page=$_POST["cast_page"]+0;

if($cast_page == 1){
	$page_title="スケジュール";

}elseif($cast_page == 2){
	$page_title="顧客リスト";

}elseif($cast_page == 3){
	$page_title="Easy Talk";

}elseif($cast_page == 4){
	$page_title="ブログ";

}elseif($cast_page == 5){
	$page_title="アナリティクス";

}elseif($cast_page == 6){
	$page_title="各種設定";

}else{
	$page_title="トップページ";
}

$sql ="SELECT * FROM wp01_0cast_config";
$sql.=" WHERE cast_id='{$cast_data["id"]}'";
$sql.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);

	if($row["c_sort_group"]>0){
		$app1	=" AND c_group='{$c_sort["c_sort_group"]}'";
	}

	if($c_sort["c_sort_main"]==1){
		$app2	=" `date`";
		$app4	=" LEFT JOIN wp01_0cast_log ON id=customer_id";
		$app5	=" ,MAX(`date`) AS log_date"; 

		if($c_sort["c_sort_asc"]==1){
			$app3	.=" DESC";
		}else{
			$app3	.=" ASC";
		}

	}elseif($c_sort["c_sort_main"]==2){
		$app2	=" `fav`";

		if($c_sort["c_sort_asc"]==1){
			$app3	.=" DESC";
		}else{
			$app3	.=" ASC";
		}

	}elseif($c_sort["c_sort_main"]==3){
		$app2	=" `birth_day`";

		if($c_sort["c_sort_asc"]==1){
			$app3	.=" ASC";
		}else{
			$app3	.=" DESC";
		}

	}else{
		$app2	=" `id`";

		if($c_sort["c_sort_asc"]==1){
			$app3	.=" ASC";
		}else{
			$app3	.=" DESC";
		}
	}
}


/*--■スケジュール--*/
$tmp_today[$day_8]="cc8";
$sql ="SELECT * FROM wp01_0sch_table";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sche_table_name[$row["in_out"]][$row["sort"]]	=$row["name"];
		$sche_table_time[$row["in_out"]][$row["sort"]]	=$row["time"];
		$sche_table_calc[$row["in_out"]][$row["name"]]	=$row["time"];
	}
}


//■カレンダー　スケジュール
$sql	 ="SELECT * FROM wp01_0schedule";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND sche_date>='{$month_st}'";
$sql	.=" AND sche_date<'{$month_ed}'";
$sql   	.=" ORDER BY id ASC";


if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["stime"] && $row["etime"]){
			$days_sche[$row["sche_date"]]="{$row["stime"]}-{$row["etime"]}";
			$sche_dat[$row["sche_date"]]="n2";

		}else{
			$days_sche[$row["sche_date"]]="休み";
			$sche_dat[$row["sche_date"]]="";

		}

		if($ana_ym==substr($row["sche_date"],0,6) ){
			$ana_sche[$row["sche_date"]]	="<span class=\"sche_s\">".$row["stime"]."</span>-<span class=\"sche_e\">".$row["etime"]."</span>";

			if(substr($sche_table_calc["in"][$row["stime"]],2,1) == 3){
				$tmp_s=$sche_table_calc["in"][$row["stime"]]+20;

			}else{
				$tmp_s=$sche_table_calc["in"][$row["stime"]];
			}		

			if(substr($sche_table_calc["out"][$row["etime"]],2,1) == 3){
				$tmp_e=$sche_table_calc["out"][$row["etime"]]+20;

			}else{
				$tmp_e=$sche_table_calc["out"][$row["etime"]];
			}		

			$ana_time[$row["sche_date"]]=($tmp_e-$tmp_s)/100;
		}
	}
}

//■カレンダー　メモ
$sql	 ="SELECT * FROM wp01_0schedule_memo";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND date_8>='{$month_st}'";
$sql	.=" AND date_8<'{$month_ed}'";
$sql	.=" AND `log` IS NOT NULL";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if(trim($row["log"])){
			$memo_dat[$row["date_8"]]="n3";
			$cal_app[substr($row["date_8"],0,6)].="<input class=\"cal_m_{$row["date_8"]}\" type=\"hidden\" value=\"{$row["log"]}\">";
/*
			if($day_8 == $row["date_8"]){
				$days_memo.=$row["log"];
			}
*/

		}
	}
}


//■カレンダー　ブログカウント
$sql	 ="SELECT * FROM wp01_posts";
$sql	.=" WHERE cast='{$cast_data["id"]}'";
$sql	.=" AND status<2";
$sql	.=" AND view_date>='{$calendar[0]}'";
$sql	.=" AND view_date<'{$calendar[3]}'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tmp_date=substr($tmp["post_date"],0,4).substr($tmp["post_date"],5,2).substr($tmp["post_date"],8,2);
		$blog_dat[$tmp_date]="n4";
	}
}


//■カスタマーソート

$sql	 ="SELECT *{$app5} FROM wp01_0customer";
$sql	.=$app4;
$sql	.=" WHERE wp01_0customer.cast_id='{$cast_data["id"]}'";
$sql	.=$app1;
$sql	.=" GROUP BY wp01_0customer.id";
$sql	.=" ORDER BY";
$sql	.=$app2;
$sql	.=$app3;

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if(!$row["birth_day"] || $row["birth_day"]=="0000-00-00"){
			$row["yy"]="----";
			$row["mm"]="--";
			$row["dd"]="--";
			$row="--";

		}else{
			$row["yy"]=substr($row["birth_day"],0,4);
			$row["mm"]=substr($row["birth_day"],5,2);
			$row["dd"]=substr($row["birth_day"],8,2);
			$row["ag"]= floor(($day_8-str_replace("-", "", $row["birth_day"]))/10000);
		}

		$birth=str_replace("-","",$row["birth_day"]);
		$birth_y	=substr($birth,0,4);
		$birth_m	=substr($birth,4,2);
		$birth_d	=substr($birth,6,2);

		$birth_dat[$birth_m.$birth_d]="n1";

		$birth_hidden[$birth_m][$birth_d].="<span class='days_birth'><span class='days_icon'></span><span class='days_text'>{$row["nickname"]}</span></span><br>";
		$days_birth[$birth_m.$birth_d].="<span class='days_birth'><span class='days_icon'></span><span class='days_text'>{$row["nickname"]}</span></span><br>";

	}

	if($birth_hidden){
		foreach($birth_hidden as $a1 => $a2){
			foreach($birth_hidden[$a1] as $a3 => $a4){
				$birth_app[$a1].="<input class=\"cal_b_{$a1}{$a3}\" type=\"hidden\" value=\"{$a4}\">";
			}
		}
		$customer[]=$row;
	}
	if(is_array($customer)){
		$cnt_coustomer=connt($customer);
	}
}


for($n=0;$n<3;$n++){

	$now_month=date("m",strtotime($calendar[$n]));
	$now_ym=date("ym",strtotime($calendar[$n]));
	$t=date("t",strtotime($calendar[$n]));

	$wk=$config["start_week"]-date("w",strtotime($calendar[$n]));
	if($wk>0) $wk-=7;

	$st=strtotime($calendar[$n])+($wk*86400);//初日
	

	$v_year[$n]	=substr($calendar[$n],0,4)."年";
	$v_month[$n]=substr($calendar[$n],5,2)."月";

	for($m=0; $m<42;$m++){
		$tmp_ymd	=date("Ymd",$st+($m*86400));
		$tmp_ym		=date("ym",$st+($m*86400));
		$tmp_month	=date("m",$st+($m*86400));
		$tmp_day	=date("d",$st+($m*86400));
		$tmp_week	=date("w",$st+($m*86400));

		$app_n1="";
		$app_n2="";
		$app_n3="";
		$app_n4="";

		$tmp_w	=$m % 7;
		if($tmp_w==0){
			if($now_ym<$tmp_ym){
				break 1;
			}else{
				$cal[$n].="</tr><tr>";
			}
		}
		if($ob_holiday[$tmp_ymd]){
			$tmp_week=0;

		}elseif($tmp_ymd ==$day_8){
			$tmp_week=7;
		}

		if($now_month!=$tmp_month){
				$day_tag=" outof";

		}else{
			$day_tag=" nowmonth";

			$app_n1=$birth_dat[substr($tmp_ymd,4,4)];
			$app_n2=$sche_dat[$tmp_ymd];
			$app_n3=$memo_dat[$tmp_ymd];
			$app_n4=$blog_dat[$tmp_ymd];

			$cal_app[substr($tmp_ymd,0,6)].="<input class=\"cal_s_{$tmp_ymd}\" type=\"hidden\" value=\"{$days_sche[$tmp_ymd]}\">";

		}

		$cal[$n].="<td id=\"c{$tmp_ymd}\" week=\"{$week[$tmp_w]}\" class=\"cal_td cc{$tmp_week} {$tmp_today[$tmp_ymd]} \">";
		$cal[$n].="<span class=\"dy{$tmp_week}{$day_tag}\">{$tmp_day}</span>";

		$cal[$n].="<span class=\"cal_i1 {$app_n1}\"></span>";
		$cal[$n].="<span class=\"cal_i2 {$app_n2}\"></span>";
		$cal[$n].="<span class=\"cal_i3 {$app_n3}\"></span>";
		$cal[$n].="<span class=\"cal_i4 {$app_n4}\"></span>";
		$cal[$n].="</td>";
	}
}

$sql	 ="SELECT * FROM wp01_0notice";
$sql	.=" LEFT JOIN wp01_0notice_ck ON wp01_0notice.id=wp01_0notice_ck.notice_id";
$sql	.=" WHERE del='0'";
$sql	.=" AND cast_id='{$cast_data["id"]}'";
$sql	.=" AND status>0";
$sql	.=" ORDER BY date DESC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$row["log"]=str_replace("\n","<br>",$row["log"]);
		$notice[$row["id"]]=$row;
	}
}


$sql	 ="SELECT * FROM wp01_0customer_item";
$sql	.=" WHERE del='0'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$c_list_name[$row["gp"]][$row["id"]]=$row["item_name"];
		$c_list_style[$row["id"]]=$row["style"];
	}
}

$sql	 ="SELECT * FROM wp01_0customer_group";
$sql	.=" WHERE `del`='0'";
$sql	.=" AND group_id='1'";
$sql	.=" AND cast_id='{$cast_data["id"]}'";
$sql	.=" ORDER BY `sort` ASC";


if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cus_group_sel[$row["sort"]]=$row["tag"];
	}
	if(is_array($cus_group_sel)){
		$cnt_cus_group_sel=count($cus_group_sel);
	}
}

//■Blog------------------
$sql ="SELECT * FROM wp01_posts";
$sql.=" WHERE cast='{$cast_data["id"]}'";
$sql.=" ORDER BY view_date DESC";
$sql.=" LIMIT 11";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$blog[]=$row;
	}
	if(is_array($dat)){
		$blog_max=count($dat);
	}

	if($blog_max>10){
		$blog_max=10;
		$blog_next=1;
	}
}

$sql ="SELECT * FROM wp01_0tag";
$sql.=" WHERE tag_group='blog'";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["id"]]=$row;
	}
}

$sql	 ="SELECT nickname, M.customer_id, C.mail, M.log, MAX(M.send_date) AS last_date,COUNT((M.send_flg = 2 and M.watch_date='0000-00-00 00:00:00') or null) AS r_count,face,M.send_flg";
$sql	.=" FROM wp01_0castmail AS M";
$sql	.=" LEFT JOIN wp01_0customer AS C ON M.customer_id=C.id";
$sql	.=" LEFT JOIN wp01_0castmail AS M2 ON (M.customer_id = M2.customer_id AND M.send_date < M2.send_date)";
$sql	.=" WHERE M.cast_id='{$cast_data["id"]}'";
$sql	.=" AND M2.send_date IS NULL";
$sql	.=" AND M.del='0'";
$sql	.=" GROUP BY M.customer_id";
$sql	.=" ORDER BY last_date DESC";
$n=0;
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$row["log_p"]=mb_substr($row["log"],0,39);
		if(mb_strlen($row["log"])>39){
			$row["log_p"].="...";
		}
		$row["last_date"]=date("m.d H:i",strtotime($row["last_date"]));
		$mail_data[]=$row;
	}
	if(is_array($mail_data)){
		$cnt_mail_data=count($mail_data);
	}
}

//■------------------
$sql ="SELECT * FROM wp01_0cast_log_table";
$sql.=" WHERE cast_id='{$cast_data["id"]}'";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$log_item[$row["sort"]]=$row;
		$log_list_cnt.='"i'.$row["sort"].'",';
	}
	$log_list_cnt=substr($log_list_cnt,0,-1);
}

$sql ="SELECT log_icon,log_comm,nickname,log_price,date,B.cast_id,customer_id FROM wp01_0cast_log_list AS A ";
$sql.=" LEFT JOIN wp01_0cast_log AS B ON A.master_id=B.log_id";
$sql.=" LEFT JOIN wp01_0customer AS C ON B.customer_id=C.id";

$sql.=" WHERE B.cast_id='{$cast_data["id"]}'";
$sql.=" AND A.date>='{$calendar[1]}'";
$sql.=" AND A.date<'{$calendar[2]}'";
$sql.=" AND A.del=0";
$sql.=" AND B.del=0";
$sql.=" ORDER BY log_id ASC";

if($dat){
	foreach($dat as $aa1){
		$tmp_d=substr($aa1["date"],8,2)+0;

		$dat_ana[$tmp_d][]	 =$aa1;
		$pay_all[$tmp_d]	+=$aa1["log_price"];
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
	src: url("./font/font_0/fonts/icomoon.ttf") format('truetype');
}
</style>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/cast.css?t=<?=time()?>">
<link rel="stylesheet" href="./css/easytalk.css?t=<?=time()?>">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

<script src="./js/jquery.exif.js?t=<?=time()?>"></script>
<script src="./js/cast.js?t=<?=time()?>"></script>
<script src="./js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>

<script>
const CastId='<?=$cast_data["id"] ?>'; 
const CastName='<?=$cast_data["genji"] ?>'; 

const Now_md=<?=date("md")+0?>;
const Now_Y	=<?=date("Y")+0?>;
var C_Id=0;
var C_Id_tmp=0;
var ChgList=[<?=$log_list_cnt?>];

const SNS_LINK={
	customer_line:"https://line_me/",
	customer_twitter:"https://twitter.com/",
	customer_insta:"https://instagram.com/",
	customer_facebook:"https://facebook.com/",
	customer_tel:"tel",
};

$(function(){ 
<?if($c_sort["c_sort_group"] >0){?> 
	$('.sort_alert').show();
<?}?>


<?if($easy_cas["id"]){?>
	$('.mail_detail').css({'right':'0'});
	Customer_id='<?=$easy_cas["id"]?>';
	
	Customer_Name='<?=$easy_cas["name"]?>';
	Customer_mail='<?=$easy_cas["mail"]?>';

	$.post({
		url:Dir + "/post/easytalk_hist.php",
		data:{
			'cast_id'	:CastId,
			'c_id'		:Customer_id
		},

	}).done(function(data, textStatus, jqXHR){
		$.when(
			$('.mail_detail_in').html(data),

		).done(function(){
			TMP_H=$('.mail_write').offset().top;
			$('.mail_detail').scrollTop(TMP_H);
			$('.head_mymenu_ttl').text(Customer_Name),
			$('.head_mymenu_comm').addClass('arrow_mail')
		});
	});
<?}?>
<?if($c_sort["c_sort_asc"] ==1){?> 
	$('.sort_circle').css({'left':'10vw','border-radius':'0 10px 10px 0'});
	$('.sort_btn_on1').css({'color':'#0000d0'});
	$('.sort_btn_on0').css({'color':'#b0b0a0'});
<?}?>
});
</script>
</head>
<body class="body">

<? if(!$cast_data["cast_time"]){ ?>
	<div class="login_box">
		<form action="./mypage.php" method="post">
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

<?}else{?>
	<div class="head">
		<div class="head_mymenu">
			<div class="mymenu_a"></div>
			<div class="mymenu_b"></div>
			<div class="mymenu_c"></div>
		</div>	
		<div class="head_mymenu_comm">
			<div class="head_mymenu_arrow"></div>
			<span class="head_mymenu_ttl"><?=$page_title?></span>
		</div>

	<?if($cast_page==1){?>
		<div id="regist_schedule" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">登録</span>
		</div>

	<?}elseif($cast_page==2){?>
		<div id="regist_customer_set" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">登録</span>
		</div>
		<div id="regist_customer" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">新規</span>
		</div>

	<?}elseif($cast_page==3){?>
		<div id="regist_mail_set" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">作成</span>
		</div>

	<?}elseif($cast_page==4){?>
		<div id="regist_blog_fix" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">修正</span>
		</div>
		<div id="regist_blog" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">投稿</span>
		</div>

	<?}elseif($cast_page==5){?>
		<div id="regist_blog" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">変更</span>
		</div>
	<?}?>
	</div>
	<div class="slide">
		<?if(file_exists("./img/profile/{$cast_data["id"]}/0_s.jpg")){?>
		<img src="./img/profile/<?=$cast_data["id"]?>/0_s.jpg?t_<?=time()?>" class="slide_img">
		<?}else{?>
		<img src="./img/profile/noimage.jpg?t_<?=time()?>" class="slide_img">
		<?}?>
		<div class="slide_name"><?=$cast_data["genji"]?></div>
		<ul class="menu">
			<li id="m0" class="menu_1<?if($cast_page+0==0){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">トップページ</span></li>
			<li id="m1" class="menu_1<?if($cast_page+0==1){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">スケジュール</span></li>
			<li id="m2" class="menu_1<?if($cast_page+0==2){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">顧客リスト</span></li>
			<li id="m3" class="menu_1<?if($cast_page+0==3){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">メール</span></li>
			<li id="m4" class="menu_1<?if($cast_page+0==4){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">ブログ</span></li>
			<li id="m5" class="menu_1<?if($cast_page+0==5){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">アナリティクス</span></li>
			<li id="m6" class="menu_1<?if($cast_page+0==6){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">各種設定</span></li>
			<li id="m99" class="menu_1 menu_out"><span class="menu_i"></span><span class="menu_s">ログアウト</span></li>
		</ul>
	</div>

	<?if($cast_page==1){?>
	<div class="main_sch">
		<input id="c_month" type="hidden" value="<?=$c_month?>" name="c_month">
		<input id="week_start" type="hidden" value="<?=$config["start_week"]?>">
		<div class="cal">
			<?for($c=0;$c<3;$c++){?>
				<table class="cal_table">
					<tr>
						<td class="cal_top" colspan="7">
							<div class="cal_title">
							<span class="cal_prev"></span>
							<span class="cal_table_ym"><span class="v_year"><?=$v_year[$c]?></span><span class="v_month"><?=$v_month[$c]?></span></span>
							<span class="cal_next"></span>
							<span id="para<?=$month_ym[$c]?>">
							<?=$cal_app[$month_ym[$c]]?>
							<?=$birth_app[substr($month_ym[$c],-2)]?>
							<?=$memo_app[$month_ym[$c]]?>
							</span>
							</div>
							<div class="cal_btn">
								<div class="cal_btn_on1"></div>
								<div class="cal_btn_on2"></div>
								<div class="cal_circle"></div>
							</div>
						</td>
					</tr>
					<tr>
						<?
						for($s=0;$s<7;$s++){
						$w=($s+$config["start_week"]) % 7;
						?>
						<td class="cal_th <?=$week_tag[$w]?>"><?=$week[$w]?></td>
						<? } ?>
						<?=$cal[$c]?>
					</tr>
				</table>
			<?}?>
		</div>

		<div class="cal_days">
			<span class="cal_days_date"><?=date("m月d日",$day_time)?>[<?=$week[$day_w]?>]</span>
			<span class="cal_days_sche"><span class="days_icon"></span><span class="days_day"><?=$days_sche[$now_8]?></span></span>
			<span class="cal_days_birth"><?=$days_birth?></span>
			<textarea class="cal_days_memo"><?=$days_memo?></textarea>
			<input id="set_date" type="hidden" value="<?=$day_8?>">
		</div>
	</div>
	<?}elseif($cast_page==2){?>

	<div class="customer_sort_box">
		<select id="customer_sort_sel" class="customer_sort_sel">
			<option value="0">登録順</option>
			<option value="1" <?if($c_sort["c_sort_main"] == 1){?> selected="selected"<?}?>>履歴順</option>
			<option value="2" <?if($c_sort["c_sort_main"] == 2){?> selected="selected"<?}?>>好感順</option>
			<!--option value="3" <?if($c_sort["c_sort_main"] == 4){?> selected="selected"<?}?>>名前順</option-->
			<!--option value="4" <?if($c_sort["c_sort_main"] == 5){?> selected="selected"<?}?>>呼名順</option-->
			<option value="3" <?if($c_sort["c_sort_main"] == 3){?> selected="selected"<?}?>>年齢順</option>
		</select>
		<div class="sort_btn">
			<div class="sort_btn_on0"></div>
			<div class="sort_btn_on1"></div>
			<div class="sort_circle"></div>
			<input id="customer_sort_asc" type="hidden" value="<?=$c_sort["c_sort_asc"]?>">
		</div>
		<select id="customer_sort_fil" class="customer_sort_sel">
		<option value="0">全て</option>
		<?if($cnt_cus_group_sel>0){?>
			<?foreach($cus_group_sel as $a1=>$a2){?>
				<option value="<?=$a1?>" <?if($c_sort["c_sort_group"] == $a1){?> selected="selected"<?}?>><?=$a2?></option>
			<?}?>
		<?}?>
		</select>
		<span class="customer_sort_tag"></span>
		<input id="customer_sort_ext" type="hidden" value="<?=$c_sort["cast_id"]?>">
	</div>

	<div class="main pg2">
		<div class="sort_alert">非表示になっている顧客がいます</div>
		<div class="customer_all_in">
			<?if (is_array($customer)) {?>
				<?for($n=0;$n<count($customer);$n++){?>
					<div id="clist<?=$customer[$n]["id"]?>" class="customer_list">
						<?if($customer[$n]["face"]){?>
							<img src="./img/cast/<?=$box_no?>/c/<?=$customer[$n]["face"]?>?t_<?=time()?>" class="mail_img">
							<input type="hidden" class="customer_hidden_face" value="<?=$customer[$n]["face"]?>">
						<?}else{?>
							<img src="./img/customer_no_image.png?t_<?=time()?>" class="mail_img">
						<? } ?>
						<div class="customer_list_fav">
							<?for($s=1;$s<6;$s++){?>
								<span id="fav_<?=$customer[$n]["id"]?>_<?=$s?>" class="customer_list_fav_icon<?if($customer[$n]["fav"]>=$s){?> fav_in<?}?>"></span>
							<?}?>
						</div>
						<div class="customer_list_name"><?=$customer[$n]["name"]?> 様</div>
						<div class="customer_list_nickname"><?=$customer[$n]["nickname"]?></div>
						<span class="mail_al"></span>
						<input type="hidden" class="customer_hidden_fav" value="<?=$customer[$n]["fav"]?>">
						<input type="hidden" class="customer_hidden_yy" value="<?=$customer[$n]["yy"]?>">
						<input type="hidden" class="customer_hidden_mm" value="<?=$customer[$n]["mm"]?>">
						<input type="hidden" class="customer_hidden_dd" value="<?=$customer[$n]["dd"]?>">
						<input type="hidden" class="customer_hidden_ag" value="<?=$customer[$n]["ag"]?>">
						<input type="hidden" class="customer_hidden_group" value="<?=$customer[$n]["c_group"]?>">

						<input type="hidden" class="customer_hidden_mail" value="<?=$customer[$n]["mail"]?>">
						<input type="hidden" class="customer_hidden_tel" value="<?=$customer[$n]["tel"]?>">
						<input type="hidden" class="customer_hidden_twitter" value="<?=$customer[$n]["twitter"]?>">
						<input type="hidden" class="customer_hidden_facebook" value="<?=$customer[$n]["facebook"]?>">
						<input type="hidden" class="customer_hidden_insta" value="<?=$customer[$n]["insta"]?>">
						<input type="hidden" class="customer_hidden_line" value="<?=$customer[$n]["line"]?>">
						<input type="hidden" class="customer_hidden_web" value="<?=$customer[$n]["web"]?>">
					</div>
				<?}?>
			<?}?>	
		</div>


		<div class="tmpl_send_box">
			<div class="tmpl_send_box_in">
				<button id="ins_name" type="button" class="tmpl_btn" value="[本名]">本名</button>
				<button id="ins_nick" type="button" class="tmpl_btn" value="[呼び名]">呼び名</button>
				<select class="tmpl_sel">
				<option value="0" >テンプレート選択</option>
				<?for($n=1;$n<6;$n++){?>
				<option value="<?=$n?>" ><?=$mail_tmpl[$n]["title"]?></option>
				<?}?>
				</select>
			</div>
			<textarea id="tmpl_send" class="tmpl_send"></textarea>

			<div class="tmpl_list" style="display:none;">
				<?for($n=1;$n<6;$n++){?>
					<div class="tmpl_box">
						<input id="tmpl_title<?=$n?>" type="text" value="<?=$mail_tmpl[$n]["title"]?>" class="tmpl_title"><button type="button" class="tmpl_set">選択</button>
						<input id="tmpl_hidden<?=$n?>" type="hidden" value="<?=$mail_tmpl[$n]["log"]?>">
					</div>
				<?}?>
			</div>
		</div>

		<div class="filter_main">
			<div class="filter_flex">
				<input type="checkbox" id="filter_1" class="filter_check" value="1"><label for="filter_1" class="mail_filter"><span class="filter_icon"></span>本日未送信</label>
				<input type="checkbox" id="filter_2" class="filter_check" value="1"><label for="filter_2" class="mail_filter"><span class="filter_icon"></span>本日登録</label>
				<input type="checkbox" id="filter_3" class="filter_check" value="1"><label for="filter_3" class="mail_filter"><span class="filter_icon"></span>本日誕生日</label>
				<input type="checkbox" id="filter_4" class="filter_check" value="1"><label for="filter_4" class="mail_filter"><span class="filter_icon"></span>本日メモ登録</label>
			</div>

			<div class="filter_flex">
				<div class="filter_box">
					<div class="filter_fav_label"></div>
					<div class="filter_fav">
						<span id="filter_fav_6" class="filter_fav_in"></span>
						<span id="filter_fav_5" class="filter_fav_in"></span>
						<span id="filter_fav_4" class="filter_fav_in"></span>
						<span id="filter_fav_3" class="filter_fav_in"></span>
						<span id="filter_fav_2" class="filter_fav_in"></span>
						<span id="filter_fav_1" class="filter_fav_in"></span>
						<span id="filter_fav_0" class="filter_fav_in"></span>
					</div>
				</div>
				<div class="filter_box">
					<div class="filter_tag_label">タグ</div>
					<div class="filter_tag">
						<span id="filter_tag_99" class="filter_tag_in">全て</span>
						<?if($cnt_cus_group_sel > 0){?>
							<?foreach($cus_group_sel as $a1=>$a2){?><span id="filter_tag_<?=$a1?>" class="filter_tag_in"><?=$a2?></span>
						<?}?>
						<?}?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="main pg3">
		<table id="tag_1_tbl" class="customer_memo"><tr><td></td></tr></table>
		<table id="tag_2_tbl" class="customer_memo"><tr><td></td></tr></table>
		<table id="tag_3_tbl" class="customer_memo"><tr><td></td></tr></table>
	</div>

	<div class="customer_detail">
		<table class="customer_base">
			<tr>
				<td class="customer_base_img" rowspan="3">
				<img id="customer_img" src="" class="customer_detail_img">
				<span class="customer_camera"></span>
				</td>
				<td class="customer_base_tag">タグ</td>
				<td id="" class="customer_base_item">
				<select id="customer_group" name="cus_group" value="" class="item_group cas_set">
				<option value="0">通常</option>
				<?if($cnt_cus_group_sel > 0){?>
				<?foreach($cus_group_sel as $a1=>$a2){?>
				<option value="<?=$a1?>"><?=$a2?></option>
				<?}?>
				<?}?>
				</select>
				</td>
			</tr>
			<tr>
				<td class="customer_base_tag">名前</td>
				<td id="c_name" class="customer_base_item"><input type="text" id="customer_detail_name" name="cus_name" value="" class="item_basebox cas_set"></td>
			</tr>
			<tr>
				<td class="customer_base_tag">呼び名</td>
				<td id="c_nick" class="customer_base_item"><input type="text" id="customer_detail_nick" name="cus_nick" value="" class="item_basebox cas_set"></td>
			</tr>
			<tr>
				<td class="customer_base_fav">
					<span id="fav_1" class="customer_fav"></span>
					<span id="fav_2" class="customer_fav"></span>
					<span id="fav_3" class="customer_fav"></span>
					<span id="fav_4" class="customer_fav"></span>
					<span id="fav_5" class="customer_fav"></span>
				</td>
				<td class="customer_base_tag">誕生日</td>
				<td id="c_birth" class="customer_base_item">
				<select id="customer_detail_yy" name="cus_b_y" value="1977" class="item_basebox_yy cas_set2">
					<?for($n=1930;$n<date("Y");$n++){?>
					<option value="<?=$n?>"><?=$n?></option>
					<?}?>
				</select>/<select id="customer_detail_mm" name="cus_b_m" value="" class="item_basebox_mm cas_set2">
					<?for($n=1;$n<13;$n++){?>
					<option value="<?=substr("0".$n,-2,2)?>"><?=substr("0".$n,-2,2)?></option>
					<?}?>
				</select>/<select id="customer_detail_dd" name="cus_b_d" value="" class="item_basebox_mm cas_set2">
					<?for($n=1;$n<32;$n++){?>
					<option value="<?=substr("0".$n,-2,2)?>"><?=substr("0".$n,-2,2)?></option>
					<?}?>
				</select><span class="detail_age">
					<select id="customer_detail_ag" name="cus_b_a" value="20" class="item_basebox_ag cas_set2">
						<?for($n=0;$n<date("Y")-1930;$n++){?>
						<option value="<?=$n?>"><?=$n?></option>
						<?}?>
					</select>
				歳</span>
				</td>
			</tr>
		</table>
		<table class="customer_sns">
			<tr>
				<td class="customer_sns_1"><span id="customer_line" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_twitter" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_insta" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_facebook" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_web" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_mail" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_tel" class="customer_sns_btn"></span></td>
			</tr>
			<tr class="customer_sns_tr">
				<td class="customer_sns_2"><span id="a_customer_line" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_twitter" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_insta" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_facebook" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_web" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_mail" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_tel" class="sns_arrow_a"></span></td>
			</tr>
		</table>
		<div class="customer_sns_box">
			<div class="sns_jump"></div><input type="text" class="sns_text"><div class="sns_btn"></div>
			<div class="customer_sns_ttl"></div>
		</div>
		<div class="customer_tag"><div id="tag_1" class="tag_set tag_set_ck" style="height:8vw;">項目</div><div id="tag_2" class="tag_set">メモ</div><div id="tag_3" class="tag_set">履歴</div></div>
		<input id="h_customer_id" type="hidden" name="cus_id" value="0">
		<input id="h_customer_set" type="hidden" name="cus_set" value="1">
		<input id="h_customer_page" type="hidden" name="cus_page" value="1">
		<input id="h_customer_fav" type="hidden" name="cus_fav" value="0">

		<input id="h_customer_tel" type="hidden" value="">
		<input id="h_customer_mail" type="hidden" value="">
		<input id="h_customer_twitter" type="hidden" value="">
		<input id="h_customer_facebook" type="hidden" value="">
		<input id="h_customer_insta" type="hidden" value="">
		<input id="h_customer_line" type="hidden" value="">
		<input id="h_customer_web" type="hidden" value="">

		<input id="n_customer_tel" type="hidden" value="">
		<input id="n_customer_mail" type="hidden" value="">
		<input id="n_customer_twitter" type="hidden" value="">
		<input id="n_customer_facebook" type="hidden" value="">
		<input id="n_customer_insta" type="hidden" value="">
		<input id="n_customer_line" type="hidden" value="">
		<input id="n_customer_web" type="hidden" value="">
	</div>

	<?}elseif($cast_page==3){?>
	<script src="./js/easytalk_cast.js?t=<?=time()?>"></script>

	<div class="main">

		<?for($n=0;$n<$cnt_mail_data;$n++){?>
			<div id="mail_hist<?=$mail_data[$n]["customer_id"]?>" class="mail_hist <?if($mail_data[$n]["watch_date"] =="0000-00-00 00:00:00"){?> mail_yet<?}?>">
				<?if($mail_data[$n]["face"]){?>
					<img src="./img/cast/<?=$box_no?>/c/<?=$mail_data[$n]["face"]?>?t_<?=time()?>" class="mail_img">
				<?}else{?>
					<img id="mail_img<?=$s?>" src="./img/customer_no_image.png?t_<?=time()?>" class="mail_img">
				<? } ?>
				<span class="mail_date"><?=$mail_data[$n]["last_date"]?></span>
				<span class="mail_log"><?=$mail_data[$n]["log_p"]?></span>
				<span class="mail_gp"></span><span id="mail_name<?=$s?>" class="mail_name"><?=$mail_data[$n]["nickname"]?></span>
				<?if($mail_data[$n]["r_count"]>0 || $mail_data[$n]["r_count"]=="9+"){?>
					<span class="mail_count"><?=$mail_data[$n]["r_count"]?></span>
				<?}?>

				<input type="hidden" class="mail_address" value="<?=$mail_data[$n]["mail"]?>">

				<?if($a1["img_1"]){?><input id="img_a<?=$s?>" type="hidden" value='./img/cast/mail/<?=$cast_data["id"]?>/<?=$a1["img_1"]?>'><? } ?>
				<?if($a1["img_2"]){?><input id="img_b<?=$s?>" type="hidden" value='./img/cast/mail/<?=$cast_data["id"]?>/<?=$a1["img_2"]?>'><? } ?>
				<?if($a1["img_3"]){?><input id="img_c<?=$s?>" type="hidden" value='./img/cast/mail/<?=$cast_data["id"]?>/<?=$a1["img_3"]?>'><? } ?>
			</div>
		<?}?>
		<div class="mail_detail">
			<div class="mail_detail_in"></div>

			<div class="mail_write">
				<div class="mail_img_in"><img src="" class="mail_img_view">	</div>
				<textarea class="mail_write_text"></textarea><br>
				<div class="mail_write_in">
					<div class="mail_detail_btn_img"></div>
					<div class="mail_detail_btn_send">送信</div>
					<div class="mail_detail_btn_del"></div>
				</div>
			</div>
		</div>
	</div>

	<?}elseif($cast_page==4){?>
		<div class="main">
			<div class="blog_write">
				<div class="blog_pack">
					<span class="blog_title_tag">投稿日</span><br>
					<div class="blog_box">	
						<select id="blog_yy" name="blog_yy" class="blog_4">
							<?for($n=2018;$n<date("Y")+3;$n++){?>
								<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n?>"<?if($n == date("Y",$jst)){?> selected="selected"<?}?>><?=$n?></option>
							<?}?>
						</select>年
						<select id="blog_mm" name="blog_mm" class="blog_2">
							<?for($n=1;$n<13;$n++){?>
								<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n1?>"<?if($n1 == date("m",$jst)){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>月
						<select id="blog_dd" name="blog_dd" class="blog_2">
							<?for($n=1;$n<32;$n++){?>
								<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n1?>"<?if($n1 == date("d",$jst)){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>日　
						<select id="blog_hh" name="blog_hh" class="blog_2">
							<?for($n=0;$n<24;$n++){?>
								<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n1?>"<?if($n1 == date("H",$jst)){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>
						：
						<select id="blog_ii" name="blog_ii" class="blog_2">
							<?for($n=0;$n<60;$n++){?>
							<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n1?>"<?if($n1 == date("i",$jst)){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>
						<br>
					</div>
					<span class="blog_title_tag">タイトル</span><br>
					<input id="blog_title" type="text" name="blog_title" class="blog_title_box"><br>

					<span class="blog_title_tag">本文</span><br>
					<textarea id="blog_log" type="text" name="blog_log" class="blog_log_box"></textarea><br>
					<div class="blog_open">
						<div class="blog_open_yes yes_on">公開</div>
						<div class="blog_open_no">非公開</div>
						<input type="hidden" id="blog_open" value="0">
					</div>

					<table class="blog_table_set">
						<tr>
							<td  class="blog_td_img" rowspan="2">
							<span class="blog_img_pack">
							<img src="./img/customer_no_image.png?t_<?=time()?>" class="blog_img">
							</span>					
							<span class="customer_camera"></span>
							</td>
							<td class="blog_tag_td">
								<span class="tag_icon"></span>
								<select id="blog_tag" name="blog_tag" class="blog_tag_sel">
								<?foreach($tag_list as $a1=> $a2){?>
									<option value="<?=$a1?>"><?=$a2?></option>
								<?}?>
								</select>
								<span class=" tag_ttl">タグ</span>
							</td>
						</tr>
						<tr>
							<td class="blog_tag_td">
								<div id="blog_set" class="btn btn_l1">登録</div>　
							</td>
						</tr>
					</table>
				</div>
				<input id="blog_chg" type="hidden" value="" >
			</div>

			<div class="blog_list">
				<?for($n=0;$n<$blog_max;$n++){?>
				<div id="blog_hist_<?=$blog[$n]["id"]?>" class="blog_hist">
					<img src="<?=$blog[$n]["img"]?>" class="hist_img">
					<span class="hist_date"><?=$blog[$n]["date"]?></span>
					<span class="hist_title"><?=$blog[$n]["title"]?></span>
					<span class="hist_tag"><?=$tag_name[$n]["name"]?></span>
					<span class="hist_watch"><span class="hist_i"></span><span class="hist_watch_c">0</span></span>
					<span class="hist_status hist_<?=$blog[$n]["status"]?>"><?=$blog_status[$blog[$n]["status"]]?></span>
				</div>
				<div class="hist_log">
					<?if($blog[$n]["img_on"]){?>
					<span class="hist_img_in"><img src="<?=$blog[$n]["img"]?>" class="hist_img_on"></span>
					<?}?>
					<span class="blog_log"><?=$blog[$n]["content"]?></span>
				</div>
				<? } ?>

				<?if($blog_max>10){?>
				<div class="blog_ad"><img src="./img/page/ad/bn.jpg?t=<?=time()?>" style="width:100%;"></div>
				<div id="blog_next_<?=$blog[10]["date"]?>" class="blog_next">続きを読む</div>
				<? } ?>
			</div>
		</div>

	<?}elseif($cast_page==5){?>
<div class="main">
	<div class="config_box">
		<table class="ana">
		<tr>
			<td class="ana_top">日時</td>
			<td class="ana_top">シフト</td>
			<td class="ana_top">時間</td>
			<td class="ana_top" colspan="2">給与・歩合</td>
		</tr>

	<?for($n=1;$n<$now_count+1;$n++){?>
		<?$ana_week=($week_01+$n-1)%7?>
		<? $ana_salary = $ana_time[$n] * $cast_data["cast_salary"]?>
		<? $ana_all = number_format($ana_salary +$pay_all[$n])?>

		<tr>
			<td rowspan="2" class="ana_month <?=$ana_line[$ana_week]?>"><?=$n?>(<?=$week[$ana_week]?>)</td>
			<td class="ana_sche <?=$ana_line[$ana_week]?>"><?=$ana_sche[$n]?></td>
			<td class="ana_time <?=$ana_line[$ana_week]?>"><?=$ana_time[$n]?></td>
			<td class="ana_pay <?=$ana_line[$ana_week]?>">	
				<span class="ana_icon"></span><span class="ana_pay_all"><?=$ana_all?></span>
			</td>
			<td id="ana_<?=$n?>" class="ana_detail<?if($ana_all ==0){?>_n<?}?> <?=$ana_line[$ana_week]?>"><span class="ana_arrow"></span></td>
		</tr>

		<tr>
			<td id="lana_<?=$n?>" class="ana_list" colspan="4">
				<div id="dana_<?=$n?>" class="ana_list_div">
					<span class="ana_list_c lc1">
						<span class="ana_list_name">店舗</span>
						<span class="ana_list_item">時給</span>
						<span class="ana_list_pts"><?=$ana_salary?></span>
					</span>

				<?$tmp_line=0;?>

				<?foreach((array)$dat_ana[$n] as $a1){?>
					<?$tmp_lc=$tmp_line % 2;?>
					<span class="ana_list_c lc<?=$tmp_lc?>">
						<span class="ana_list_name"><?=$a1["nickname"]?>様</span>
						<span class="ana_list_item"><?=$a1["log_comm"]?></span>
						<span class="ana_list_pts"><?=$a1["log_price"]?></span>
					</span>
					<?$tmp_line++;?>
				<? } ?>
				</div>
			</td>
		</tr>
	<?}?>
		<tr><td colspan="4" style="padding: 0;"></td></tr>
	</table>
</div>
</div>
	<?}elseif($cast_page==6){?>
<div class="main">
<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">基本情報</span></div></h2>

<!--
<table class="config_img">
	<tr>
		<td class="config_img_a" rowspan="3"><img src="<?=$user_face?>?t=<?=time()?>" class="config_img_a1"></td>

//		<td id="line_face1" class="config_img_b">
//			<img id="sumb1" src="<?=$prof_img[1]?>?t=<?=time()?>" class="config_img_b1">
//			<div id="s1" class="img_btn1<?if(strpos($prof_img[1],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 1){?> img_sel<?}?>">
//				<span class="icon_img icon_5s img_btn_icon"></span>
//				<span class="img_btn_txt">選択</span>
//			</div>
//			<a href="line://nv/profile" class="config_img_line"><span class="icon_img icon_line"></span><span class="text_line">LINE</span></a>
//		</td>

		<td id="line_face2" class="config_img_b">
			<img id="sumb1" src="<?=$prof_img[1]?>?t=<?=time()?>" class="config_img_b1">
			<div id="s1" class="img_btn1<?if(strpos($prof_img[1],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 1){?> img_sel<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">選択</span>
			</div>
			<div id="t1" class="img_btn1 btn_set">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">登録</span>
			</div>
			<div id="d1" class="img_btn1<?if(strpos($prof_img[1],"noimage") === FALSE){?> btn_del<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">削除</span>
			</div>
		</td>
	</tr>
	<tr>
		<td class="config_img_b">
			<img id="sumb2" src="<?=$prof_img[2]?>?t=<?=time()?>" class="config_img_b1">
			<div id="s2" class="img_btn1<?if(strpos($prof_img[2],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 2){?> img_sel<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">選択</span>
			</div>
			<div id="t2" class="img_btn1 btn_set">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">登録</span>
			</div>
			<div id="d2" class="img_btn1<?if(strpos($prof_img[2],"noimage") === FALSE){?> btn_del<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">削除</span>
			</div>
		</td>
	</tr>
	<tr>
		<td class="config_img_b">
			<img id="sumb3" src="<?=$prof_img[3]?>?t=<?=time()?>" class="config_img_b1">
			<div id="s3" class="img_btn1<?if(strpos($prof_img[3],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 3){?> img_sel<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">選択</span>
			</div>
			<div id="t3" class="img_btn1 btn_set">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">登録</span>
			</div>
			<div id="d3" class="img_btn1<?if(strpos($prof_img[3],"noimage") === FALSE){?> btn_del<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">削除</span>
			</div>
		</td>
	</tr>
</table>
-->

<div class="config_box">
	<span class="config_tag1">USER_ID</span><span class="config_text2"><?=$cast_data["cast_id"]?></span><br>
	<span class="config_tag1">PASSWORD</span><input type="password" value="<?=$cast_data["cast_pass"]?>" class="config_text1" autocomplete="new-password"><br>
	<span class="config_tag1">名前</span><input type="text" value="<?=$cast_data["genji"]?>" class="config_text1"><br>
	<span class="config_tag1">メール</span><input type="text" value="<?=$cast_data["cast_mail"]?>" class="config_text1"><br>
	<span class="config_tag1">時給</span><input id="hourly" type="text" value="<?=$cast_data["cast_salary"]?>" class="config_text1"><br>
	<span class="config_tag2">LINE連携</span>
	<span class="config_tag2">Twitter連携</span>
</div>
<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">切替時間設定</span></div></h2>
<div class="config_box">
<div class="config_tag3">
<select id="config_day_start" class="config_tag3_sel">
<option value="0"<?if($cast_data["times_st"]==0){?> selected="selected"<?}?>>00:00</option>
<option value="1"<?if($cast_data["times_st"]==1){?> selected="selected"<?}?>>01:00</option>
<option value="2"<?if($cast_data["times_st"]==2){?> selected="selected"<?}?>>02:00</option>
<option value="3"<?if($cast_data["times_st"]==3){?> selected="selected"<?}?>>03:00</option>
<option value="4"<?if($cast_data["times_st"]==4){?> selected="selected"<?}?>>04:00</option>
<option value="5"<?if($cast_data["times_st"]==5){?> selected="selected"<?}?>>05:00</option>
<option value="6"<?if($cast_data["times_st"]==6){?> selected="selected"<?}?>>06:00</option>
<option value="7"<?if($cast_data["times_st"]==7){?> selected="selected"<?}?>>07:00</option>
<option value="8"<?if($cast_data["times_st"]==8){?> selected="selected"<?}?>>08:00</option>
<option value="9"<?if($cast_data["times_st"]==9){?> selected="selected"<?}?>>09:00</option>
<option value="10"<?if($cast_data["times_st"]==10){?> selected="selected"<?}?>>10:00</option>
<option value="11"<?if($cast_data["times_st"]==11){?> selected="selected"<?}?>>11:00</option>
<option value="12"<?if($cast_data["times_st"]==12){?> selected="selected"<?}?>>12:00</option>
<option value="13"<?if($cast_data["times_st"]==13){?> selected="selected"<?}?>>13:00</option>
<option value="14"<?if($cast_data["times_st"]==14){?> selected="selected"<?}?>>14:00</option>
<option value="15"<?if($cast_data["times_st"]==15){?> selected="selected"<?}?>>15:00</option>
<option value="16"<?if($cast_data["times_st"]==16){?> selected="selected"<?}?>>16:00</option>
<option value="17"<?if($cast_data["times_st"]==17){?> selected="selected"<?}?>>17:00</option>
<option value="18"<?if($cast_data["times_st"]==18){?> selected="selected"<?}?>>18:00</option>
<option value="19"<?if($cast_data["times_st"]==19){?> selected="selected"<?}?>>19:00</option>
<option value="20"<?if($cast_data["times_st"]==20){?> selected="selected"<?}?>>20:00</option>
<option value="21"<?if($cast_data["times_st"]==21){?> selected="selected"<?}?>>21:00</option>
<option value="22"<?if($cast_data["times_st"]==22){?> selected="selected"<?}?>>22:00</option>
<option value="23"<?if($cast_data["times_st"]==23){?> selected="selected"<?}?>>23:00</option>
</select>
<span class="config_tag3_in">一日の開始時間</span>
</div>

<div class="config_tag3">
<select id="config_week_start" class="config_tag3_sel">
<option value="0"<?if($cast_data["week_st"]==0){?> selected="selected"<?}?>>日曜日</option>
<option value="1"<?if($cast_data["week_st"]==1){?> selected="selected"<?}?>>月曜日</option>
<option value="2"<?if($cast_data["week_st"]==2){?> selected="selected"<?}?>>火曜日</option>
<option value="3"<?if($cast_data["week_st"]==3){?> selected="selected"<?}?>>水曜日</option>
<option value="4"<?if($cast_data["week_st"]==4){?> selected="selected"<?}?>>木曜日</option>
<option value="5"<?if($cast_data["week_st"]==5){?> selected="selected"<?}?>>金曜日</option>
<option value="6"<?if($cast_data["week_st"]==6){?> selected="selected"<?}?>>土曜日</option>
</select>
<span class="config_tag3_in">週の開始曜日</span>
</div>
</div>
<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">顧客グループ設定</span></div></h2>
<div class="config_box">

<table class="log_item_set">
<thead>
	<tr>
		<td></td>
		<td class="log_td_top">順</td>
		<td class="log_td_top">名前</td>
		<td class="log_td_top">替</td>
	</tr>
</thead>

<tbody id="gp_sort">
	<?if($cnt_cus_group_sel > 0){?>
	<?foreach($cus_group_sel as $a1 => $a2){?>
		<tr id="gp<?=$a1?>">
			<td class="log_td_del"><span class="gp_del_in"></span></td>
			<td class="log_td_order"><?=$a1?></td>

			<td class="log_td_name">
				<input id="gp_name_<?=$a1?>" type="text" value="<?=$a2?>" class="gp_name">
			</td>
			<td class="gp_handle"></td>
		</tr>
	<?}?>
	<?}?>
</tbody>

	<tr>
		<td colspan="4" style="height:5px;"></td>
	</tr><tr>
		<td class="log_td_order_new" colspan="2">追加</td>
		<td class="log_td_name">
			<input id="gp_new" type="text" value="" class="gp_name_new">
		</td>
		<td class="log_td_handle"><span id="gp_set"></span></td>
	</tr>
</table>
<input id="count_gp" type="hidden" value="<?=$cnt_cus_group_sel?>">
</div>
<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">履歴アイテム設定</span></div></h2>
<div class="config_box">
<table class="log_item_set">
<thead>
	<tr>
		<td></td>
		<td class="log_td_top">順</td>
		<td class="log_td_top">色</td>
		<td class="log_td_top">絵</td>
		<td class="log_td_top">名前(8文字)</td>
		<td class="log_td_top">金額(6桁)</td>
		<td class="log_td_top">替</td>
	</tr>
</thead>

<tbody id="item_sort">
	<?foreach($log_item as $a1){?>
		<tr id="i<?=$a1["sort"]?>">
			<td class="log_td_del"><span class="log_td_del_in"></span></td>
			<td class="log_td_order"><?=$a1["sort"]?></td>

			<td class="log_td_color">
				<div class="item_color" style="background:<?=$c_code[$a1["item_color"]]?>"></div>
				<div id="c_div<?=$a1["sort"]?>" class="color_picker">
					<?foreach($c_code as $b1 => $b2){?>
						<span cd="<?=$b1?>" class="color_picker_list" style="background:<?=$b2?>;"></span>
					<?}?>
				</div>
				<input id="item_color_hidden_<?=$a1["sort"]?>" class="color_hidden" type="hidden" value="<?=$a1["item_color"]?>">
			</td>

			<td class="log_td_icon" style="color:<?=$c_code[$a1["item_color"]]?>">
				<div class="item_icon"><?=$i_code[$a1["item_icon"]]?></div>
				<div id="i_div<?=$a1["sort"]?>" class="icon_picker">
					<?foreach($i_code as $b1 => $b2){?>
						<span cd="<?=$b1?>" class="icon_picker_list"><?=$b2?></span>
					<?}?>
				</div>

				<input id="item_icon_hidden_<?=$a1["sort"]?>" type="hidden" value="<?=$a1["item_icon"]?>">
			</td>
			<td class="log_td_name">
				<input id="item_name_<?=$a1["sort"]?>" type="text" value="<?=$a1["item_name"]?>" class="item_name">
			</td>
			<td class="log_td_price">
				<input id="item_price_<?=$a1["sort"]?>" type="text" value="<?=$a1["price"]?>" class="item_price">
			</td>
			<td class="log_td_handle"></td>
		</tr>
	<?}?>
</tbody>
	<tr>
		<td colspan="7" style="height:5px;"></td>
	</tr><tr>
		<td class="log_td_order_new" colspan="2">追加</td>
		<td class="log_td_color">
			<div id="new_color" class="item_color" style="background:<?=$c_code[10]?>"></div>
			<div class="color_picker">
				<?foreach($c_code as $b1 => $b2){?>
					<span cd="<?=$b1?>" class="color_picker_list" style="background:<?=$b2?>;"></span>
				<?}?>
			</div>
			<input id="color_new" type="hidden" value="10">
		</td>

		<td class="log_td_icon" style="color:<?=$c_code[0]?>">
			<div id="new_icon" class="item_icon"><?=$i_code[0]?></div>
			<div class="icon_picker">
				<?foreach($i_code as $b1 => $b2){?>
					<span cd="<?=$b1?>" class="icon_picker_list"><?=$b2?></span>
				<?}?>
			</div>
			<input id="icon_new" type="hidden" value="0">
		</td>

		<td class="log_td_name">
			<input id="name_new" type="text" value=" " class="item_name_new">
		</td>
		<td class="log_td_price">
			<input id="price_new" type="text" value="0" class="item_price_new">
		</td>
		<td class="log_td_handle"><span id="new_set"></span></td>
	</tr>
</table>
</div>

<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">お問合せ</span></div></h2>
<div class="config_menu">お問合せ</div>
<div class="config_menu">退会</div>
<div class="config_menu">プライバシーポリシー</div>
<div class="config_menu">ご利用規約</div>


</div>
	<?}else{?>
	<div class="main">
		<div class="notice_ttl">
			<div class="notice_ttl_day"><span id="notice_day"><?=date("m月d日",$jst)?>[<?=$week[date("w",$jst)]?>]</span></div>
			<div id="notice_ttl_1" class="notice_ttl_in notice_sel">本日</div>
			<div id="notice_ttl_2" class="notice_ttl_in">明日</div>
			<div id="notice_ttl_3" class="notice_ttl_in">明後日</div>
			<input id="h_notice_ttl_1" type="hidden" value="<?=date("m月d日",$jst)?>[<?=$week[date("w",$jst)]?>]">
			<input id="h_notice_ttl_2" type="hidden" value="<?=date("m月d日",$jst+86400)?>[<?=$week[date("w",$jst+86400)]?>]">
			<input id="h_notice_ttl_3" type="hidden" value="<?=date("m月d日",$jst+172800)?>[<?=$week[date("w",$jst+172800)]?>]">
		</div>
		<div id="notice_box_1" class="notice_box">
			<span class="notice_box_sche"><span class="notice_icon"></span><?=$days_sche?></span><br>
			<span class="notice_box_birth"><?=$days_birth?></span>
		</div>
		<div id="notice_box_2" class="notice_box">
			<span class="notice_box_sche"><span class="notice_icon"></span><?=$days_sche_2?></span><br>
			<span class="notice_box_birth"><?=$days_birth_2?></span>
		</div>
		<div id="notice_box_3" class="notice_box">
			<span class="notice_box_sche"><span class="notice_icon"></span><?=$days_sche_3?></span><br>
			<span class="notice_box_birth"><?=$days_birth_3?></span>
		</div>
		<div class="notice_ttl"><div class="notice_list_in">連絡事項</div></div>

		<div class="notice_list">
			<?foreach((array)$notice as $n =>$a2){?>
				<div id="notice_box_title<?=$notice[$n]["id"]?>" class="notice_box_item<?=$notice[$n]["status"]?>">
					<span class="notice_d"><?=substr($notice[$n]["date"],5,2)?>月<?=substr($notice[$n]["date"],8,2)?>日</span>
					<span class="notice_t"><?=$notice[$n]["title"]?></span>
					<span class="notice_yet<?=$notice[$n]["status"]?>"></span>
				</div>
				<input id="notice_box_hidden<?=$notice[$n]["id"]?>" type="hidden" value="<?=$notice[$n]["log"]?>">
			<? } ?>
		</div>
		<div id="notice_box_log<?=$notice[$n]["id"]?>" class="notice_box_log"></div>
	<? } ?>
</div>



<div class="customer_memo_set"></div>
<div class="customer_log_set"></div>
<div class="sch_set_done">スケジュールが登録されました</div>
<div class="set_back">
	<div class="cal_weeks">
		<div class="cal_weeks_prev">前週</div>
		<div class="cal_weeks_box">
			<div class="cal_weeks_box_2">
				<?for($n=0;$n<21;$n++){
					$tmp_wk=($n+$config["start_week"])%7;
					$sche_8=date("Ymd",$base_day+86400*$n);
				?>
					<div class="cal_list">
						<div class="cal_day <?=$week_tag2[$tmp_wk]?>"><?substr($sche_8,4,2)?>月<?substr($sche_8,6,2)?>月(<?=$week[$tmp_wk]?>)</div>

						<?if($day_8>$sche_8){?>
							<div class="d_sch_time_in <?=$sche_8?>"><?=$stime[$sche_8]?></div>
							<div class="d_sch_time_out <?=$sche_8?>"><?=$etime[$sche_8]?></div>
							<input id="sel_in<?=$n?>" type="hidden" value="<?=$stime[$sche_8]?>" class="sch_time_in">
							<input id="sel_out<?=$n?>" type="hidden" value="<?=$etime[$sche_8]?>" class="sch_time_in">

						<?}else{?>
							<select id="sel_in<?=$n?>" value="" name="sel_in<?=$n?>" class="sch_time_in">
							<option value=""></option>
							<?for($s=0;$s<count($sche_table_name["in"]);$s++){?><option value="<?=$sche_table_name["in"][$s]?>" <?if($stime[$sche_8]===$sche_table_name["in"][$s]){?> selected="selected"<?}?>><?=$sche_table_name["in"][$s]?></option>
							<?}?>
							</select>

							<select id="sel_out<?=$n?>" name="sel_out<?=$n?>" class="sch_time_out">
							<option class="sel_txt" value=""></option>
							<?for($s=0;$s<count($sche_table_name["out"]);$s++){?><option class="sel_txt" value="<?=$sche_table_name["out"][$s]?>" <?if($etime[$sche_8]===$sche_table_name["out"][$s]){?> selected="selected"<?}?>><?=$sche_table_name["out"][$s]?></option>
							<?}?>
							</select>
						<? } ?>
					</div>
				<? } ?>
			</div>
		</div>

		<div class="cal_weeks_next">翌週</div>
		<div id="sch_set_arrow" class="sch_set_btn">
			<div class="sch_set_arrow"></div>
		</div>
		<div class="sch_set">登録</div>
		<div id="sch_set_trush" class="sch_set_btn"></div>
		<!--div id="sch_set_copy" class="sch_set_btn"></div-->
	</div>

	<div class="customer_memo_del_back_in">
			削除します。よろしいですか
		<div class="customer_memo_del_back_in_btn">
			<div id="memo_del_set" class="btn btn_c2">削除</div>　
			<div id="memo_del_back" class="btn btn_c1">戻る</div>
		</div>
		<input id="del_id" type="hidden">
	</div>

	<div class="customer_log_del_back_in">
			削除します。よろしいですか
		<div class="customer_memo_del_back_in_btn">
			<div id="log_del_set" class="btn btn_c2">削除</div>　
			<div id="log_del_back" class="btn btn_c1">戻る</div>
		</div>
	</div>

	<div class="log_list_del">
		<div class="log_list_del_item">
			<span class="log_list_del_icon"></span>
			<span class="log_list_del_name">恐ろしい安酒</span>
			<span class="log_list_del_price">999999</span>
		</div>
		<div class="log_list_del_comm">
			削除します。よろしいですか<br> 
			※既に登録された履歴は削除されません。
		</div>

		<div class="log_list_del_btn">
			<div id="log_list_del_set" class="btn btn_c2">削除</div>　
			<div id="log_list_del_back" class="btn btn_c1">戻る</div>
		</div>
	</div>

	<div class="customer_memo_in">
		<div class="customer_memo_new_date"><?=date("Y-m-d H:i:s",$jst)?></div>
		<textarea class="customer_memo_new_txt"></textarea>

		<div class="customer_log_bottom">
		<div id="memo_set" class="btn btn_c2">登録</div>
		　<div id="memo_reset" class="btn btn_c1">戻る</div>
		　<div id="memo_del" class="btn btn_c3">削除</div>
		</div>
	</div>

	<div class="customer_regist">
		<div class="customer_regist_ttl">新規顧客登録</div>
		<span class="customer_regist_no">×</span>
		<table class="customer_regist_base">
			<tr>
				<td id="set_new_img" class="customer_base_img" rowspan="3">
					<span class="regist_img_pack"><img src="./img/customer_no_image.png?t_<?=time()?>" class="regist_img"></span>					
					<span class="customer_camera"></span>
				</td>
				<td class="customer_base_tag">タグ</td>
					<td id="" class="customer_base_item">
				<select id="regist_group" name="cus_group" value="0" class="item_group">
				<option value="0">通常</option>
				<?if($cnt_cus_group_sel > 0){?>
				<?foreach($cus_group_sel as $a1=>$a2){?>
				<option value="<?=$a1?>"><?=$a2?></option>
				<?}?>
				<?}?>
				</select>
				</td>
			</tr>

			<tr>
				<td class="customer_base_tag">名前</td>
				<td class="customer_base_item"><input type="text" id="regist_name" name="cus_name" value="" class="item_basebox"></td>
			</tr>

			<tr>
				<td class="customer_base_tag">呼び名</td>
				<td class="customer_base_item"><input type="text" id="regist_nick" name="cus_nick" value="" class="item_basebox"></td>
			</tr>

			<tr>
				<td class="regist_fav">
					<span id="reg_fav_1" class="reg_fav"></span>
					<span id="reg_fav_2" class="reg_fav"></span>
					<span id="reg_fav_3" class="reg_fav"></span>
					<span id="reg_fav_4" class="reg_fav"></span>
					<span id="reg_fav_5" class="reg_fav"></span>
				</td>
				<td class="customer_base_tag">誕生日</td>
				<td class="customer_base_item">
				<select id="reg_yy" name="cus_b_y" value="1977" class="item_basebox_yy">
					<?for($n=1930;$n<date("Y");$n++){?>
					<option value="<?=$n?>" <?if($n==$reg_base_yy){?> selected="selected"<?}?>><?=$n?></option>
					<?}?>
				</select>/<select id="reg_mm" name="cus_b_m" value="" class="item_basebox_mm">
					<?for($n=1;$n<13;$n++){?>
					<option value="<?=substr("0".$n,-2,2)?>"><?=substr("0".$n,-2,2)?></option>
					<?}?>
				</select>/<select id="reg_dd" name="cus_b_d" value="" class="item_basebox_mm">
					<?for($n=1;$n<32;$n++){?>
					<option value="<?=substr("0".$n,-2,2)?>"><?=substr("0".$n,-2,2)?></option>
					<?}?>
				</select><span class="detail_age">
					<select id="reg_ag" name="cus_b_a" value="20" class="item_basebox_ag">
						<?for($n=0;$n<date("Y")-1930;$n++){?>
						<option value="<?=$n?>" <?if($n==$reg_base_ag){?> selected="selected"<?}?>><?=$n?></option>
						<?}?>
					</select>
				歳</span>
				</td>
			</tr>
		</table>
		<div id="customer_regist_set" class="btn btn_l2">登録</div>
		<input id="regist_fav" type="hidden" value="0">
	</div>

	<div class="img_box">
		<div class="img_box_in">
			<canvas id="cvs1" width="800px" height="800px;"></canvas>
			<div class="img_box_out1"></div>
			<div class="img_box_out2"></div>
			<div class="img_box_out3"></div>
			<div class="img_box_out4"></div>
			<div class="img_box_out5"></div>
			<div class="img_box_out6"></div>
			<div class="img_box_out7"></div>
			<div class="img_box_out8"></div>
		</div>
<!--
		<div class="img_box_in2">
			<label for="upd" class="upload_icon"></label>
			<span id="img_set_line" class="upload_icon"></span>
			<span id="img_set_twitter" class="upload_icon"></span>
			<span id="img_set_insta" class="upload_icon"></span>
			<span id="img_set_facebook" class="upload_icon"></span>　
			<span class="upload_icon upload_rote"></span>
			<span class="upload_icon upload_trush"></span>
		</div>
-->
		<div class="img_box_in2">
			<label for="upd" class="upload_btn"><span class="upload_icon_p"></span><span class="upload_txt">画像選択</span></label>
			<span class="upload_icon upload_rote"></span>
			<span class="upload_icon upload_trush"></span>
		</div>
		<div class="img_box_in3">
			<div class="zoom_mi">-</div>
			<div class="zoom_rg"><input id="input_zoom" type="range" name="num" min="100" max="300" step="1" value="100" class="range_bar"></div>
			<div class="zoom_pu">+</div><div class="zoom_box">100</div>
		</div>

		<div class="img_box_in4">
			<div id="img_set" class="btn btn_c2">登録</div>　
			<div id="img_close" class="btn btn_c1">戻る</div>　
			<div id="img_reset" class="btn btn_c3">リセット</div>
		</div>
	</div>

	<div class="customer_log_in">
		<div class="customer_log_top">
			<select id="logset_yy" class="blog_4">
				<?for($n=2018;$n<date("Y")+3;$n++){?>
					<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n?>"<?if($n == date("Y",$jst)){?> selected="selected"<?}?>><?=$n?></option>
				<?}?>
			</select><span class="customer_log_ymd">年</span>
			<select id="logset_mm" class="blog_2">
				<?for($n=1;$n<13;$n++){?>
					<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n1?>"<?if($n == date("m",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select><span class="customer_log_ymd">月</span>
			<select id="logset_dd" class="blog_2">
				<?for($n=1;$n<32;$n++){?>
					<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n1?>"<?if($n == date("d",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select><span class="customer_log_ymd">日</span>　
			<span class="customer_log_st">開始</span><select id="logset_hh_s" class="blog_2">
				<?for($n=0;$n<24;$n++){?>
					<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n1?>"<?if($n == date("H",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select><span class="customer_log_h">：</span><select id="logset_ii_s" class="blog_2">
				<?for($n=0;$n<60;$n++){?>
				<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n1?>"<?if($n == date("i",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select><br>
　			<span class="customer_log_ed">終了</span><select id="logset_hh_e" class="blog_2">
				<?for($n=0;$n<24;$n++){?>
					<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n1?>"<?if($n == date("H",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select><span class="customer_log_h">：</span><select id="logset_ii_e" class="blog_2">
				<?for($n=0;$n<60;$n++){?>
				<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n1?>"<?if($n == date("i",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select>
		</div>
		<div class="customer_log_left">
			<div id="sel_log_main" class="sel_log_option" class="sel_log_option" style="color:<?=$c_code[$log_item[0]["item_color"]]?>;border:1px solid <?=$c_code[$log_item[0]["item_color"]]?>">
				<span class="sel_log_icon"><?=$i_code[$log_item[0]["item_icon"]]?></span>
				<span class="sel_log_comm"><?=$log_item[0]["item_name"]?></span>
				<span class="sel_log_price">￥<?=$log_item[0]["price"]?></span>
			</div>
			<div id="sel_log_box" class="sel_log_box">
				<?foreach($log_item as $a1){?>
				<div id="ls<?=$a1["sort"]?>" class="sel_log_option" style="color:<?=$c_code[$a1["item_color"]]?>;border:1px solid <?=$c_code[$a1["item_color"]]?>">
					<span class="sel_log_icon"><?=$i_code[$a1["item_icon"]]?></span>
					<span class="sel_log_comm"><?=$a1["item_name"]?></span>
					<span class="sel_log_price"><?=$a1["price"]?></span>
				</div>
				<?}?>
			</div>
			<textarea id="sel_log_area" class="sel_log_area" placeholder="メモ："></textarea>
		</div>
		<div class="customer_log_right"></div>
		<div class="customer_log_bottom">
		<div id="sel_log_set" class="btn btn_c2">登録</div>
		　<div id="sel_log_reset" class="btn btn_c1">戻る</div>
		　<div id="sel_log_del" class="btn btn_c3">削除</div>
		</div>
	</div>
</div>
<input id="page" type="hidden" val="<?=$cast_page?>">
<input id="img_top" type="hidden" name="img_top" value="10">
<input id="img_left" type="hidden" name="img_left" value="10">
<input id="img_width" type="hidden" name="img_width" value="10">
<input id="img_height" type="hidden" name="img_height" value="10">
<input id="img_zoom" type="hidden" name="img_zoom" value="100">
<input id="img_url" type="hidden" name="img_url" value="">
<input id="img_code" type="hidden" name="img_code" value="">

<input id="h_blog_yy" type="hidden" value="">
<input id="h_blog_mm" type="hidden" value="">
<input id="h_blog_dd" type="hidden" value="">
<input id="h_blog_hh" type="hidden" value="">
<input id="h_blog_ii" type="hidden" value="">
<input id="h_blog_title" type="hidden" value="">
<input id="h_blog_log" type="hidden" value="">
<input id="h_blog_tag" type="hidden" value="">
<input id="h_blog_img" type="hidden" value="">
<input id="memo_chg_id" type="hidden">

<input id="easytalk_page" type="hidden" value="1">
<input id="upd" type="file" accept="image/*" style="display:none;">
<input id="base_day" type="hidden" value="<?=$base_day?>" dd="<?=date("Ymd",$base_day)?>">
<input id="cast_id" type="hidden" value="<?=$cast_data["id"]?>">

<form id="logout" action="./mypage.php" method="post">
	<input type="hidden" value="1" name="log_out">
</form>

<form id="menu_sel" action="mypage.php" method="post">
	<input id="cast_page" type="hidden" value="" name="cast_page">
	<input type="hidden" value="<?=$c_month?>" name="c_month">
</form>

<form id="sns_form" action="" method="post">
	<input id="sns_form_hidden" type="hidden" name="cast_page" value="">
	<input id="sns_form_customer" type="hidden" name="c_id" value="">
</form>
<? }?>
</body>
</html>
