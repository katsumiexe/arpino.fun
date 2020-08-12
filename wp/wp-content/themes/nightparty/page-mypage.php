<?
session_start();
global $wpdb;
if($_POST["log_out"] == 1){
	$_POST="";
	$_SESSION="";
	session_destroy();
}
$jst=time()+32400;
require_once ("post/inc_code.php");

$now		=date("Y-m-d H:i:s",$jst);
$now_ymd	=date("Ymd",$jst);
$now_ymd_2	=date("Ymd",$jst+86400);
$now_ymd_3	=date("Ymd",$jst+172800);

if($_SESSION){
	if($jst<$_SESSION["time"]+32400){
		$rows = $wpdb->get_row("SELECT * FROM wp01_0cast WHERE cast_id='".$_SESSION["cast_id"]."'",ARRAY_A );
		$_SESSION=$rows;
		$_SESSION["time"]=$jst;

	}else{
		$_SESSION="";
		session_destroy();
	}

}elseif($_POST["log_in_set"] && $_POST["log_pass_set"]){
	$rows = $wpdb->get_row("SELECT * FROM wp01_0cast WHERE cast_id='".$_POST["log_in_set"]."' AND cast_pass='".$_POST["log_pass_set"]."'",ARRAY_A );
	if($rows){
		$_SESSION=$rows;
		$_SESSION["time"]=$jst;

	}else{
		$err="IDもしくはパスワードが違います";
	}
}

if($_SESSION){

$sql ="SELECT term_id FROM wp01_terms"; 
$sql .=" WHERE slug='{$_SESSION["id"]}'"; 
$cate_id = $wpdb->get_var($sql);



$sql ="SELECT * FROM wp01_0encode"; 
$enc0 = $wpdb->get_results($sql,ARRAY_A );
foreach($enc0 as $row){
	$enc[$row["key"]]				=$row["value"];
	$dec[$row["gp"]][$row["value"]]	=$row["key"];
}

$id_8=substr("00000000".$_SESSION["id"],-8);
$id_0	=$_SESSION["id"] % 20;

for($n=0;$n<8;$n++){
	$tmp_id=substr($id_8,$n,1);
	$box_no.=$dec[$id_0][$tmp_id];
}

$reg_base_yy=1980;
$reg_base_ag=date("Y")-1980;


	$page_title="スケジュール";
	/*--■祝日カレンダー--*/
	$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
	$ob_holiday = json_decode($holiday,true);
	//$ob_holiday["20200101"];

	/*--■イニシャライズ--*/
	$cast_page=$_POST["cast_page"]+0;

	if($cast_page == 1){
		$page_title="スケジュール";

	}elseif($cast_page == 2){
		$page_title="顧客リスト";

	}elseif($cast_page == 3){
		$page_title="メール";

	}elseif($cast_page == 4){
		$page_title="ブログ";

	}elseif($cast_page == 5){
		$page_title="アナリティクス";

	}elseif($cast_page == 5){
		$page_title="各種設定";

	}else{
		$page_title="トップページ";
	}


	$c_month=$_POST["c_month"];
	if(!$c_month) $c_month=date("Y-m-01");

	$calendar[0]=date("Y-m-01",strtotime($c_month)-86400);
	$calendar[1]=$c_month;
	$calendar[2]=date("Y-m-01",strtotime($c_month)+3456000);
	$calendar[3]=date("Y-m-01",strtotime($calendar[2])+3456000);

	$month_ym[0]=substr(str_replace("-","",$calendar[0]),0,6);	
	$month_ym[1]=substr(str_replace("-","",$calendar[1]),0,6);	
	$month_ym[2]=substr(str_replace("-","",$calendar[2]),0,6);	

	$week_start=get_option("start_of_week")+0;
	$now_w=date("w");

	$base_now=strtotime(date("Y-m-d 00:00:00"));
	$base_w=$now_w-$week_start;
	if($base_w<0) $base_w+=7;

	$base_day=$base_now-($base_w+7)*86400;

	$week_st=date("Ymd",$base_day);
	$week_ed=date("Ymd",$base_day+604800);

	$month_st=date("Ymd",strtotime($calendar[0]));
	$month_ed=date("Ymd",strtotime($calendar[3]));

	/*--■メールチェック--*/
	/*
	$s_url	=get_option('mailserver_url');
	$s_port	=get_option('mailserver_port');
	$sv="{".$s_url.":".$s_port."/pop3}INBOX";
	$sv="{".$s_url.":".$s_port."}INBOX";	
	$sv="{".$s_url."}INBOX";
	$m_list=imap_open ($sv,$_SESSION["castmail"],$_SESSION["castmail_pass"]);
	$num = imap_num_msg($m_list);
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
	*/
	/*--■スケジュール--*/

	$tmp_today[$now_ymd]="cc8";

	$sql ="SELECT * FROM wp01_0sch_table";
	$sql.=" ORDER BY sort ASC";
	$dat = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat as $tmp){
		$sche_table_name[$tmp["in_out"]][$tmp["sort"]]	=$tmp["name"];
		$sche_table_time[$tmp["in_out"]][$tmp["sort"]]	=$tmp["time"];
	}

	$days_sche="休み";
	$sql	 ="SELECT * FROM wp01_0schedule";
	$sql	.=" WHERE cast_id='{$_SESSION["id"]}'";
	$sql	.=" AND sche_date>='{$month_st}'";
	$sql	.=" AND sche_date<'{$month_ed}'";
	$sq	   	.=" ORDER BY id ASC";

	$dat = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat as $tmp2){
		$stime[$tmp2["sche_date"]]		=$tmp2["stime"];
		$etime[$tmp2["sche_date"]]		=$tmp2["etime"];
	}

	if($stime[$now_ymd] && $etime[$now_ymd]){
		$days_sche="{$stime[$now_ymd]}-{$etime[$now_ymd]}";
	}else{
		$days_sche="休み";
	}

	if($stime[$now_ymd_2] && $etime[$now_ymd_2]){
		$days_sche_2="{$stime[$now_ymd_2]}-{$etime[$now_ymd_2]}";
	}else{
		$days_sche_2="休み";
	}

	if($stime[$now_ymd_3] && $etime[$now_ymd_3]){
		$days_sche_3="{$stime[$now_ymd_3]}-{$etime[$now_ymd_3]}";
	}else{
		$days_sche_3="休み";
	}

	$sql	 ="SELECT * FROM wp01_0schedule_memo";
	$sql	.=" WHERE cast_id='{$_SESSION["id"]}'";
	$sql	.=" AND date_8>='{$month_st}'";
	$sql	.=" AND date_8<'{$month_ed}'";
	$sql	.=" AND `log` IS NOT NULL";
	$dat = $wpdb->get_results($sql,ARRAY_A );

	foreach($dat as $tmp){
		if(trim($tmp["log"])){
			$memo_dat[$tmp["date_8"]]="n3";
			$cal_app[substr($tmp["date_8"],0,6)].="<input class=\"cal_m_{$tmp["date_8"]}\" type=\"hidden\" value=\"{$tmp["log"]}\">";

			if($now_ymd == $tmp["date_8"]){
				$days_memo.=$tmp["log"];
			}
		}
	}

	$sql	 ="SELECT * FROM wp01_posts";
	$sql	.=" WHERE post_password='{$_SESSION["id"]}'";
	$sql	.=" AND post_name='post'";
	$sql	.=" AND post_date>='{$calendar[0]}'";
	$sql	.=" AND post_date<'$calendar[3]}'";
	$dat = $wpdb->get_results($sql,ARRAY_A );

	foreach($dat as $tmp){
		if(trim($tmp["post_content"])){
			$tmp_date=substr($tmp["post_date"],0,4).substr($tmp["post_date"],5,2).substr($tmp["post_date"],8,2);
			$blog_dat[$tmp_date]="n4";
		}
	}

	$n=0;
	$b_month=substr($c_month,4,4);
	$sql	 ="SELECT * FROM wp01_0customer";
	$sql	.=" WHERE cast_id='{$_SESSION["id"]}'";
	$sql	.=" AND del='0'";
	$sql	.=" ORDER BY id DESC";

	$dat = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat as $tmp){
		$customer[$n]=$tmp;

		if(!$tmp["birth_day"] || $tmp["birth_day"]=="0000-00-00"){
			$customer[$n]["yy"]="----";
			$customer[$n]["mm"]="--";
			$customer[$n]["dd"]="--";
			$customer[$n]["ag"]="--";

		}else{
			$customer[$n]["yy"]=substr($tmp["birth_day"],0,4);
			$customer[$n]["mm"]=substr($tmp["birth_day"],5,2);
			$customer[$n]["dd"]=substr($tmp["birth_day"],8,2);
			$customer[$n]["ag"]= floor(($now_ymd-str_replace("-", "", $tmp["birth_day"]))/10000);
		}
		$n++;

		$birth=str_replace("-","",$tmp["birth_day"]);
		$birth_y	=substr($birth,0,4);
		$birth_m	=substr($birth,4,2);
		$birth_d	=substr($birth,6,2);

		$birth_dat[$birth_m.$birth_d]="n1";
		$birth_hidden[$birth_m][$birth_d].="<span class='days_birth'><span class='days_icon'></span>{$tmp["nickname"]}</span><br>";

		if(substr($birth,4,4) == substr($now_ymd,4,4)){
			$days_birth.="<span class='days_birth'><span class='days_icon'></span>{$tmp["nickname"]}</span><br>";

		}elseif(substr($birth,4,4) == substr($now_ymd_2,4,4)){
			$days_birth_2.="<span class='days_birth'><span class='days_icon'></span>{$tmp["nickname"]}</span><br>";

		}elseif(substr($birth,4,4) == substr($now_ymd_3,4,4)){
			$days_birth_3.="<span class='days_birth'><span class='days_icon'></span>{$tmp["nickname"]}</span><br>";

		}

	}

	foreach($birth_hidden as $a1 => $a2){
		foreach($birth_hidden[$a1] as $a3 => $a4){
			$birth_app[$a1].="<input class=\"cal_b_{$a1}{$a3}\" type=\"hidden\" value=\"{$a4}\">";
		}
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

			$tmp_w	=$m % 7;
			if($tmp_w==0){
				if($now_month<$tmp_month){
					break 1;
				}else{
					$cal[$n].="</tr><tr>";
				}
			}

			if($ob_holiday[$tmp_ymd]){
				$tmp_week=0;

			}elseif($tmp_ymd ==$now_ymd){
				$tmp_week=7;
			}

			if($now_month!=$tmp_month){
					$day_tag=" outof";

			}else{
				$day_tag=" nowmonth";
			}

			$app_n1=$birth_dat[substr($tmp_ymd,4,4)];

			if($stime[$tmp_ymd] && $etime[$tmp_ymd]){
				$app_n2=" n2";
				$cal_app[substr($tmp_ymd,0,6)].="<input class=\"cal_s_{$tmp_ymd}\" type=\"hidden\" value=\"{$stime[$tmp_ymd]}-{$etime[$tmp_ymd]}\">";
			}else{
				$app_n2="";
			}

			$app_n3=$memo_dat[$tmp_ymd];
			$app_n4=$blog_dat[$tmp_ymd];

			$cal[$n].="<td id=\"c{$tmp_ymd}\" week=\"{$week[$tmp_w]}\" class=\"cal_td cc{$tmp_week} {$tmp_today[$tmp_ymd]} \">";
			$cal[$n].="<span class=\"dy{$tmp_week}{$day_tag}\">{$tmp_day}</span>";
			$cal[$n].="<span class=\"cal_i1 {$app_n1}\"></span>";
			$cal[$n].="<span class=\"cal_i2 {$app_n2}\"></span>";
			$cal[$n].="<span class=\"cal_i3 {$app_n3}\"></span>";
			$cal[$n].="<span class=\"cal_i4 {$app_n4}\"></span>";

			$cal[$n].="</td>";
		}
	}

	if($_POST["cus_set"]){
		$cast_page=2;


		$cus_id		=$_POST["cus_id"];
		$cus_set	=$_POST["cus_set"];
		$cus_page	=$_POST["cus_page"];
		$cus_fav	=$_POST["cus_fav"];
		$cus_group	=$_POST["cus_group"];
		$cus_name	=$_POST["cus_name"];
		$cus_nick	=$_POST["cus_nick"];
		$cus_b_y	=$_POST["cus_b_y"];
		$cus_b_m	=$_POST["cus_b_m"];
		$cus_b_d	=$_POST["cus_b_d"];
		$cus		=$_POST["cus"];

		if($cus_set == 1){
			if($cus_page == 1){
				$sql_log ="UPDATE wp01_0customer SET";
				$sql_log.=" `name`='{$cus_name}',";
				$sql_log.=" `nickname`='{$cus_nick}',";
				$sql_log.=" `fav`='{$cus_fav}',";
				$sql_log.=" `c_group`='{$cus_group}'";
				$sql_log.=" WHERE id='{$cus_id}'";
				$wpdb->query($sql_log);

				$sql_log ="DELETE FROM wp01_0customer_list";
				$sql_log.=" WHERE customer_id='{$cus_id}'";
				$wpdb->query($sql_log);

				$sql_log ="INSERT INTO wp01_0customer_list(`cast_id`,`customer_id`,`item`,`comm`) VALUES ";
				foreach($cus as $a1 => $a2){
					$sql_log.=" ('{$_SESSION["id"]}','{$cus_id}','{$a1}','{$a2}'),";
				}
				$sql_log=substr($sql_log,0,-1);
				$wpdb->query($sql_log);

			}elseif($cus_page == 2){		

			}	

		}elseif($cus_set == 2){		
			$to_day=date("Y-m-d");
			$birth=$cus_b_y."-".$cus_b_m."-".$cus_b_d;	
			$sql_log ="INSERT INTO wp01_0customer(`cast_id`,`nickname`,`name`,`regist_date`,`birth_day`,`fav`,`c_group`) VALUES ";
			$sql_log.=" ('{$_SESSION["id"]}','{$cus_nick}','{$cus_name}','{$to_day}','{$birth}','{$cus_fav}','{$cus_group}')";
			$tmp_auto=$wpdb->insert_id;

			$sql_log ="INSERT INTO wp01_0customer_list(`cast_id`,`customer_id`,`item`,`comm`) VALUES ";
			foreach($cus as $a1 => $a2){
				$sql_log.=" ('{$_SESSION["id"]}','{$tmp_auto}','{$a1}','{$a2}'),";
			}
			$sql_log=substr($sql_log,0,-1);
			$wpdb->query($sql_log);
		}
	}

	$sql	 ="SELECT * FROM wp01_0notice";
	$sql	.=" LEFT JOIN  wp01_0notice_ck ON wp01_0notice.id=wp01_0notice_ck.notice_id";
	$sql	.=" WHERE del='0'";
	$sql	.=" AND cast_id='{$_SESSION["id"]}'";
	$sql	.=" AND status>0";
	$sql	.=" ORDER BY date DESC";

	$dat2 = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat2 as $cus2){
		$notice[]=$cus2;
	}

	$sql	 ="SELECT * FROM wp01_0customer_item";
	$sql	.=" WHERE del='0'";
	$dat2 = $wpdb->get_results($sql,ARRAY_A );

	foreach($dat2 as $cus2){
		$c_list_name[$cus2["gp"]][$cus2["id"]]=$cus2["item_name"];
		$c_list_style[$cus2["id"]]=$cus2["style"];
	}

	$sql	 ="SELECT * FROM wp01_0customer_group";
	$sql	.=" WHERE `del`='0'";
	$sql	.=" AND group_id='1'";
	$sql	.=" AND cast_id='{$_SESSION["id"]}'";
	$sql	.=" ORDER BY `sort` ASC";
	$dat2 = $wpdb->get_results($sql,ARRAY_A );

	foreach($dat2 as $cus2){
		$cus_group_sel[$cus2["sort"]]=$cus2["tag"];
	}

//■Blog------------------
	$sql ="SELECT * FROM wp01_posts";
	$sql.=" WHERE post_password='{$_SESSION["id"]}'";
	$sql.=" AND post_name='post'";
	$sql.=" ORDER BY post_date DESC";
	$sql.=" LIMIT 20";

	$dat = $wpdb->get_results($sql,ARRAY_A );
	$n=0;
	foreach($dat as $tmp){
		$img_tmp=$tmp["ID"]+2;
		$updir = wp_upload_dir();

		$sql ="SELECT * FROM wp01_postmeta";
		$sql.=" WHERE post_id='{$tmp["ID"]}'";
		$sql.=" AND meta_key='_thumbnail_id'";
		$thumb = $wpdb->get_var($sql);
		if($thumb){
			$blog[$n]["img"]="{$updir['baseurl']}/np{$_SESSION["id"]}/img_{$img_tmp}.png?t=".time();
			$blog[$n]["img_on"]="{$updir['baseurl']}/np{$_SESSION["id"]}/img_{$img_tmp}.png?t=".time();

		}else{
			$blog[$n]["img"]=get_template_directory_uri()."/img/customer_no_img.jpg?t=".time();
		}

		$blog[$n]["date"]	=$tmp["post_date"];
		$blog[$n]["title"]	=$tmp["post_title"];
		$blog[$n]["content"]=str_replace("\n","<br>",$tmp["post_content"]);
		$blog[$n]["count"]	=$tmp["comment_count"];

		if($tmp["post_date"] > $now){
			$blog[$n]["status"]=1;

		}elseif($tmp["post_status"] == "draft"){
			$blog[$n]["status"]=2;

		}elseif($tmp["post_status"] == "pending"){
			$blog[$n]["status"]=3;

		}elseif($tmp["post_status"] == "publish"){
			$blog[$n]["status"]=0;
	
		}else{
			$blog[$n]["status"]=3;
		}	
		$n++;
	}
	$blog_status[0]="公開";
	$blog_status[1]="予約";
	$blog_status[2]="削除";
	$blog_status[3]="非公開";

	$sql ="SELECT * FROM wp01_terms";
	$sql.=" LEFT JOIN wp01_term_taxonomy ON wp01_terms.term_id=wp01_term_taxonomy.term_id";
	$sql.=" WHERE taxonomy='post_tag'";
	$dat = $wpdb->get_results($sql,ARRAY_A );

	foreach($dat as $a1){
		$tag_list[$a1["slug"]]=$a1["name"];
	}

	$sql ="SELECT * FROM wp01_0cast_log_table";
	$sql.=" WHERE cast_id='{$_SESSION["id"]}'";
	$dat = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat as $a1){
		$log_item[$a1["sort"]]=$a1;
	}
	ksort($log_item);

	foreach($log_item as $a1 => $a2){
		$log_list_cnt.='"i'.$a1.'",';
	}
	$log_list_cnt=substr($log_list_cnt,0,-1);
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
	src: url(<?php echo get_template_directory_uri(); ?>/font/font_0/fonts/icomoon.ttf) format('truetype');
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
const Now_md=<?=date("md",$jst)+0?>;
const Now_Y	=<?=date("Y",$jst)+0?>;
var C_Id=0;
var C_Id_tmp=0;
var ChgList=[<?=$log_list_cnt?>];
</script>
</head>

<body class="body">
<? if(!$_SESSION){ ?>
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
			<span class="regist_icon"></span>
			<span class="regist_txt">送信</span>
		</div>
		<div id="regist_customer" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">作成</span>
		</div>

	<?}elseif($cast_page==4){?>
		<div id="regist_brog_set" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">登録</span>
		</div>
		<div id="regist_brog" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">投稿</span>
		</div>

	<?}elseif($cast_page==5){?>
		<div id="regist_brog" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">変更</span>
		</div>
	<?}?>
	</div>
	<div class="slide">
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
		<input id="week_start" type="hidden" value="<?=$week_start?>">
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
						$w=($s+$week_start) % 7;
						?>
						<td class="cal_th <?=$week_tag[$w]?>"><?=$week[$w]?></td>
						<? } ?>
						<?=$cal[$c]?>
					</tr>
				</table>
			<?}?>
		</div>
		<div class="cal_days">
			<span class="cal_days_date"><?=date("m月d日",$jst)?>[<?=$week[date("w",$jst)]?>]</span>
			<span class="cal_days_sche"><span class="days_icon"></span><span class="days_day"><?=$days_sche?></span></span>
			<span class="cal_days_birth"><?=$days_birth?></span>
			<textarea class="cal_days_memo"><?=$days_memo?></textarea>
			<input id="set_date" type="hidden" value="<?=$now_ymd?>">
		</div>
	</div>
	<?}elseif($cast_page==2){?>
	<div class="main">
		<?for($n=0;$n<count($customer);$n++){?>
			<div id="clist<?=$customer[$n]["id"]?>" class="customer_list">
				<?if($customer[$n]["face"]){?>
					<img src="<?php echo get_template_directory_uri(); ?>/img/cast/<?=$box_no?>/c/<?=$customer[$n]["face"]?>?t_<?=time()?>" class="mail_img">
					<input type="hidden" class="customer_hidden_face" value="<?=$customer[$n]["face"]?>">
				<?}else{?>
					<img src="<?php echo get_template_directory_uri(); ?>/img/customer_no_img.jpg?t_<?=time()?>" class="mail_img">
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
				<?foreach($cus_group_sel as $a1=>$a2){?>
				<option value="<?=$a1?>"><?=$a2?></option>
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
		<div class="sns_jump"></div><input type="text" class="sns_text"><div class="sns_btn"></div>
		</div>

		<div class="customer_tag">
			<div id="tag_1" class="tag_set tag_set_ck" style="top:0.5vw;">項目</div>
			<div id="tag_2" class="tag_set">メモ</div>
			<div id="tag_3" class="tag_set">履歴</div>
			<div class="customer_body">
				<table id="tag_1_tbl" class="customer_memo"><tr><td></td></tr></table>
				<table id="tag_2_tbl" class="customer_memo"><tr><td></td></tr></table>
				<table id="tag_3_tbl" class="customer_memo"><tr><td></td></tr></table>
			</div>
		</div>
		<input id="h_customer_id" type="hidden" name="cus_id" value="">
		<input id="h_customer_set" type="hidden" name="cus_set" value="1">
		<input id="h_customer_page" type="hidden" name="cus_page" value="1">
		<input id="h_customer_fav" type="hidden" name="cus_fav" value="0">

		<input id="h_customer_tel" type="hidden" value="">
		<input id="h_customer_mail" type="hidden" value="">
		<input id="h_customer_twitter" type="hidden" value="">
		<input id="h_customer_facebook" type="hidden" value="">
		<input id="h_customer_insta" type="hidden" value="">
		<input id="h_customer_blog" type="hidden" value="">
		<input id="h_customer_web" type="hidden" value="">
	</div>
	<?}elseif($cast_page==3){?>
	<div class="main">
		<?for($s=0;$s<count($mail_data);$s++){?>
			<div class="mail_hist <?if($mail_data[$s]["watch_date"] =="0000-00-00 00:00:00"){?> mail_yet<?}?>">
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

		<div class="mail_detail">
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
								<option value="<?=$n?>"<?if($n == date("m",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>月
						<select id="blog_dd" name="blog_dd" class="blog_2">
							<?for($n=1;$n<32;$n++){?>
								<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n?>"<?if($n == date("d",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>日　
						<select id="blog_hh" name="blog_hh" class="blog_2">
							<?for($n=0;$n<24;$n++){?>
								<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n?>"<?if($n == date("H",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>
						：
						<select id="blog_ii" name="blog_ii" class="blog_2">
							<?for($n=0;$n<60;$n++){?>
							<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n?>"<?if($n == date("i",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>
						<br>
					</div>
					<span class="blog_title_tag">タイトル</span><br>
					<input id="blog_title" type="text" name="blog_title" class="blog_title_box"><br>

					<span class="blog_title_tag">本文</span><br>
					<textarea id="blog_log" type="text" name="blog_log" class="blog_log_box"></textarea><br>

					<table class="blog_table_set">
						<tr>
							<td  class="blog_td_img" rowspan="2">
							<span class="blog_img_pack">
							<img src="<?php echo get_template_directory_uri(); ?>/img/customer_no_img.jpg?t_<?=time()?>" class="blog_img">
							</span>					
							<span class="customer_camera"></span>
							</td>
							<td class="blog_tag_td">
								<span class="tag_icon"></span>
								<select id="blog_tag_sel" name="blog_tag" class="blog_tag_sel">
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
			</div>
			<?for($n=0;$n<count($blog);$n++){?>
			<div class="blog_hist">
			<div class="blog_hist_in">
				<img src="<?=$blog[$n]["img"]?>" class="hist_img">
				<span class="hist_date"><?=$blog[$n]["date"]?></span>
				<span class="hist_title"><?=$blog[$n]["title"]?></span>
				<span class="hist_watch"><span class="hist_i"></span><span class="hist_watch_c">0</span></span>
				<span class="hist_comm"><span class="hist_i"></span><span class="hist_comm_c"><?=$blog[$n]["count"]?></span></span>
				<span class="hist_status hist_<?=$blog[$n]["status"]?>"><?=$blog_status[$blog[$n]["status"]]?></span>

			</div>
				<div class="hist_log">
				<?if($blog[$n]["img_on"]){?>
				<span class="hist_img_in"><img src="<?=$blog[$n]["img"]?>" class="hist_img_on"></span>
				<?}?>
				<?=$blog[$n]["content"]?>
				</div>

			</div>
			<? } ?>
		</div>
	<?}elseif($cast_page==5){?>
	<?}elseif($cast_page==6){?>
	<div class="main">
		<div class="config_menu">

名前：
CAST_ID：
LOGIN ID
PASSWORD
アドレス

顧客グループ設定
履歴アイテム設定
画面ロック時間
LINE連携
Twitter連携
<br>
<hr>
</select>

<table class="log_item_set">
<thead>
	<tr>
		<td class="log_td_top">順</td>
		<td class="log_td_top">色</td>
		<td class="log_td_top">絵</td>
		<td class="log_td_top">名前</td>
		<td class="log_td_top">金額</td>
		<td class="log_td_top">削</td>
		<td class="log_td_top">替</td>
	</tr>
</thead>
<tbody id="item_sort">
	<?foreach($log_item as $a1){?>
		<tr id="i<?=$a1["sort"]?>">
			<td class="log_td_order">
				<?=$a1["sort"]?>
			</td>
			<td class="log_td_color">
				<div class="item_color" style="background:<?=$c_code[$a1["item_color"]]?>"></div>
				<div class="color_picker">
					<?foreach($c_code as $b1 => $b2){?>
						<span cd="<?=$b1?>" class="color_picker_list" style="background:<?=$b2?>;"></span>
					<?}?>
				</div>
				<input id="item_color_hidden_<?=$a1["sort"]?>" class="color_hidden" type="hidden" value="<?=$a1["item_color"]?>">
			</td>

			<td class="log_td_icon" style="color:<?=$c_code[$a1["item_color"]]?>">
				<div class="item_icon"><?=$i_code[$a1["item_icon"]]?></div>
				<div class="icon_picker">
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
			<td class="log_td_del"></td>
			<td class="log_td_handle"></td>
		</tr>
	<?}?>
</tbody>
	<tr style="border-top:2px solid #202020;">
		<td class="log_td_order_new">追</td>
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
			<input id="name_new" type="text" value=" " class="item_name">
		</td>
		<td class="log_td_price">
			<input id="price_new" type="text" value="0" class="item_price">
		</td>
		<td class="log_td_handle" colspan="2"><span id="new_set"></span></td>
	</tr>
</table>

<div class="box">
<div id="item_set" class="btn btn_c2">変更</div>
　　
<div id="item_reset" class="btn btn_c1">戻す</div>
</div>

		</div>
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
			<?for($n=0;$n<count($notice);$n++){?>
				<div id="notice_box_title<?=$notice[$n]["id"]?>" class="notice_box_item<?=$notice[$n]["status"]?>"><?=substr($notice[$n]["date"],5,2)?>月<?=substr($notice[$n]["date"],8,2)?>日　<?=$notice[$n]["title"]?>
				<div class="notice_yet<?=$notice[$n]["status"]?>"></div></div>
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
					$tmp_wk=($n+$week_start)%7;
				?>
					<div class="cal_list">
						<div class="cal_day <?=$week_tag2[$tmp_wk]?>"><?=date("m月d日",$base_day+86400*$n)?>(<?=$week[$tmp_wk]?>)</div>
						<?if($base_now>$base_day+86400*$n){?>
							<div class="d_sch_time_in"><?=$stime[date("Ymd",$base_day+86400*$n)]?></div>
							<div class="d_sch_time_out"><?=$etime[date("Ymd",$base_day+86400*$n)]?></div>
							<input id="sel_in<?=$n?>" type="hidden" value="<?=$stime[date("Ymd",$base_day+86400*$n)]?>">
							<input id="sel_out<?=$n?>" type="hidden" value="<?=$etime[date("Ymd",$base_day+86400*$n)]?>">

						<?}else{?>
<select id="sel_in<?=$n?>" value="" name="sel_in<?=$n?>" class="sch_time_in">
<option value=""></option>
<?for($s=0;$s<count($sche_table_name["in"]);$s++){?><option value="<?=$sche_table_name["in"][$s]?>" <?if($stime[date("Ymd",$base_day+86400*$n)]===$sche_table_name["in"][$s]){?> selected="selected"<?}?>><?=$sche_table_name["in"][$s]?></option>
<?}?>
</select>
						<select id="sel_out<?=$n?>" name="sel_out<?=$n?>" class="sch_time_out">
							<option class="sel_txt" value=""></option>
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
		<div id="sch_set_arrow" class="sch_set_btn">
			<div class="sch_set_arrow"></div>
		</div>
		<div class="sch_set">登録</div>
		<div id="sch_set_trush" class="sch_set_btn"></div>
		<div id="sch_set_copy" class="sch_set_btn"></div>
	</div>

	<div class="customer_memo_del_back_in">
			削除します。よろしいですか
		<div class="customer_memo_del_back_in_btn">
			<div id="memo_del_set" class="btn btn_c2">削除</div>　
			<div id="memo_del_back" class="btn btn_c1">戻る</div>
		</div>
		<input id="del_id" type="hidden">
	</div>

	<div class="customer_memo_in">
		<div class="customer_memo_new_date"><?=date("Y-m-d H:i:s",$jst)?></div>
		<div class="customer_memo_new_set"></div>
		<div class="customer_memo_new_del"></div>
		<textarea class="customer_memo_new_txt"></textarea>
	</div>

	<div class="customer_regist">
		<div class="customer_regist_ttl">新規顧客登録</div>
		<span class="customer_regist_no">×</span>
		<table class="customer_regist_base">
			<tr>
				<td id="set_new_img" class="customer_base_img" rowspan="3">
				<span class="regist_img_pack"><img src="<?php echo get_template_directory_uri(); ?>/img/customer_no_img.jpg?t_<?=time()?>" class="regist_img"></span>					
				<span class="customer_camera"></span>
				</td>
				<td class="customer_base_tag">タグ</td>
				<td id="" class="customer_base_item">
				<select id="regist_group" name="cus_group" value="0" class="item_group">
				<option value="0">通常</option>
				<?foreach($cus_group_sel as $a1=>$a2){?>
				<option value="<?=$a1?>"><?=$a2?></option>
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
					<option value="<?=$n?>"<?if($n == date("m",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select><span class="customer_log_ymd">月</span>
			<select id="logset_dd" class="blog_2">
				<?for($n=1;$n<32;$n++){?>
					<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n?>"<?if($n == date("d",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select><span class="customer_log_ymd">日</span>　
			<span class="customer_log_st">開始</span><select id="logset_hh_s" class="blog_2">
				<?for($n=0;$n<24;$n++){?>
					<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n?>"<?if($n == date("H",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select><span class="customer_log_h">：</span><select id="logset_ii_s" class="blog_2">
				<?for($n=0;$n<60;$n++){?>
				<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n?>"<?if($n == date("i",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select><br>
　			<span class="customer_log_ed">終了</span><select id="logset_hh_e" class="blog_2">
				<?for($n=0;$n<24;$n++){?>
					<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n?>"<?if($n == date("H",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
				<?}?>
			</select><span class="customer_log_h">：</span><select id="logset_ii_e" class="blog_2">
				<?for($n=0;$n<60;$n++){?>
				<?$n1=substr("00".$n,-2,2)?>
					<option value="<?=$n?>"<?if($n == date("i",$jst)+0){?> selected="selected"<?}?>><?=$n1?></option>
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
		<div class="customer_log_right">
		</div>
	<div id="sel_log_set" class="btn btn_c2">セット</div>
	</div>
</div>

<input id="img_top" type="hidden" name="img_top" value="10">
<input id="img_left" type="hidden" name="img_left" value="10">
<input id="img_width" type="hidden" name="img_width" value="10">
<input id="img_height" type="hidden" name="img_height" value="10">
<input id="img_zoom" type="hidden" name="img_zoom" value="100">
<input id="img_url" type="hidden" name="img_url" value="">
<input id="img_code" type="hidden" name="img_code" value="">

<input id="upd" type="file" accept="image/*" style="display:none;">
<input id="base_day" type="hidden" value="<?=$base_day?>" dd="<?=date("Ymd",$base_day)?>">
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