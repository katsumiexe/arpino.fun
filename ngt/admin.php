<?
//ini_set( 'display_errors', 1 );
include_once('./library/sql.php');
include_once('./library/inc_code.php');

$staff_set=$_POST["staff_set"];//１新規　２変更　３キャスト追加変更　４削除
$staff_id=$_POST["staff_id"];

//■スタッフ削除
if($staff_set == 4){
	$sql  =" UPDATE wp01_0staff SET";
	$sql .=" `del`=1";
	$sql .=" WHERE staff_id='{$_POST["staff_id"]}'";
	mysqli_query($mysqli,$sql);
	$_POST["menu_post"]="staff";

//■スタッフ登録or変更
}elseif($staff_set){
	$c_s			=$_POST["c_s"];
	$staff_name		=$_POST["staff_name"];
	$staff_kana		=$_POST["staff_kana"];
	$staff_birthday	=$_POST["staff_birthday"];
	$staff_sex		=$_POST["staff_sex"];
	$staff_rank		=$_POST["staff_rank"];
	$staff_position	=$_POST["staff_position"];
	$staff_group	=$_POST["staff_group"];
	$staff_tel		=$_POST["staff_tel"];
	$staff_line		=$_POST["staff_line"];
	$staff_address	=$_POST["staff_address"];
	$staff_registday=$_POST["staff_registday"];

	$b_yy			=$_POST["b_yy"];
	$b_mm			=$_POST["b_mm"];
	$b_dd			=$_POST["b_dd"];

	$cast_id		=$_POST["cast_id"];
	$cast_pass		=$_POST["cast_pass"];
	$genji			=$_POST["genji"];
	$genji_kana		=$_POST["genji_kana"];
	$cast_mail		=$_POST["cast_mail"];
	$ctime_yy		=$_POST["ctime_yy"];
	$ctime_mm		=$_POST["ctime_mm"];
	$ctime_dd		=$_POST["ctime_dd"];

	$cast_rank		=$_POST["cast_rank"];
	$cast_sort		=$_POST["cast_sort"];

	$charm_table	=$_POST["charm_table"];
	$options		=$_POST["options"];

	$img_c		=$_POST["img_c"];
	$img_w		=$_POST["img_w"];
	$img_h		=$_POST["img_h"];
	$img_x		=$_POST["img_x"];
	$img_y		=$_POST["img_y"];
	$img_z		=$_POST["img_z"];
	$img_r		=$_POST["img_r"];

	if(!$staff_registday) $staff_registday=date("Y-m-d");
	$btime=$b_yy*10000+$b_mm*100+$b_dd;

	if($staff_set == 2 || $staff_set == 3){
		$sql="UPDATE wp01_0staff SET";
		$sql.=" `name`='{$staff_name}',";
		$sql.=" `kana`='{$staff_kana}',";
		$sql.=" `birthday`='{$btime}',";
		$sql.=" `sex`='{$staff_sex}',";
		$sql.=" `rank`='{$staff_rank}',";
		$sql.=" `position`='{$staff_position}',";
		$sql.=" `group`='{$staff_group}',";
		$sql.=" `tel`='{$staff_tel}',";
		$sql.=" `line`='{$staff_line}',";
		$sql.=" `mail`='{$staff_mail}',";
		$sql.=" `address`='{$staff_address}',";
		$sql.=" `registday`='{$staff_registday}'";
		$sql.=" WHERE staff_id='{$staff_id}'";
		mysqli_query($mysqli,$sql);

	//新規STAFF
	}else{
		$sql="INSERT INTO wp01_0staff (`name`,`kana`,`birthday`,`sex`,`rank`,`position`,`group`,`tel`,`line`,`mail`,`address`,`registday`)";
		$sql.="VALUES('{$staff_name}','{$staff_kana}','{$btime}','{$staff_sex}','{$staff_rank}','{$staff_position}','{$staff_group}','{$staff_tel}','{$staff_line}','{$staff_mail}','{$staff_address}','{$staff_registday}')";
		mysqli_query($mysqli,$sql);
		$staff_id=mysqli_insert_id($mysqli);
	}

//■cast-------------------------------
	if($c_s == 2){
		$ctime=$ctime_yy*10000+$ctime_mm*100+$ctime_dd;

		if($staff_set == 2){//変更
			$sql="UPDATE wp01_0cast SET";
			$sql.=" `genji`='{$genji}',";
			$sql.=" `genji_kana`='{$genji_kana}',";

			$sql.=" `cast_id`='{$cast_id}',";
			$sql.=" `cast_pass`='{$cast_pass}',";
			$sql.=" `cast_mail`='{$cast_mail}',";

			$sql.=" `ctime`='{$ctime}',";
			$sql.=" `cast_rank`='{$cast_rank}',";
			$sql.=" `cast_sort`='{$cast_sort}'";
			$sql.=" WHERE id='{$staff_id}'";
			mysqli_query($mysqli,$sql);

			$sql="DELETE FROM wp01_0charm_sel WHERE cast_id='{$staff_id}'";
			mysqli_query($mysqli,$sql);

			$sql="DELETE FROM wp01_0check_sel WHERE cast_id='{$staff_id}'";
			mysqli_query($mysqli,$sql);

		}else{//新規１　かCAST追加3
			$sql="INSERT INTO wp01_0cast (`id`,`genji`,`genji_kana`,`cast_id`,`cast_pass`,`cast_mail`,`ctime`,`cast_rank`,`cast_sort`)";
			$sql.="VALUES('{$staff_id}','{$genji}','{$genji_kana}','{$cast_id}','{$cast_pass}','{$cast_mail}','{$ctime}','{$cast_rank}','{$cast_sort}')";
			mysqli_query($mysqli,$sql);
//■encode-------------------------------
			$id_8	=substr("00000000".$staff_id,-8);
			$id_0	=$staff_id % 20;
			for($n=0;$n<8;$n++){
				$rnd=rand(0,19);
				$tmp_id=substr($id_8,$n,1);
				$tmp_dir.=$dec[$id_0][$tmp_id];
			}
			$tmp_dir.=$tmp_id;

			$mk_dir="./img/cast/".$tmp_dir;
			if(!is_dir($mk_dir)) {
				mkdir($mk_dir."/c/", 0777, TRUE);
				chmod($mk_dir."/c/", 0777);

				mkdir($mk_dir."/m/", 0777, TRUE);
				chmod($mk_dir."/m/", 0777);
			}

			$link="./img/profile/".$staff_id;
			if(!is_dir($link)) {
				mkdir($link, 0777, TRUE);
				chmod($link, 0777);
			}

			$sql="INSERT INTO wp01_0cast_log_table(cast_id,item_name,item_icon,item_color,price,sort)VALUES";
			$sql.="('{$staff_id}','ドリンクA','0','48','100','0'),";
			$sql.="('{$staff_id}','ドリンクB','2','35','200','1'),";
			$sql.="('{$staff_id}','フードA','4','3','300','2'),";
			$sql.="('{$staff_id}','フードB','5','7','500','3'),";
			$sql.="('{$staff_id}','ボトル','3','36','1000','4'),";	
			$sql.="('{$staff_id}','本指名','8','55','1000','5'),";
			$sql.="('{$staff_id}','場内指名','8','12','500','6'),";
			$sql.="('{$staff_id}','同伴','6','59','2000','7')";
			mysqli_query($mysqli,$sql);

			if($_REQUEST["news_date_yy"] && $_REQUEST["news_date_mm"] && $_REQUEST["news_date_dd"] && $_REQUEST["news_box"]){
				$title=str_replace("[name]","<span style=\"color:#ffffff; font-weight:600\">{$genji}</span>",$_REQUEST["news_box"]);

				$p_date=$_REQUEST["news_date_yy"]."-".$_REQUEST["news_date_mm"]."-".$_REQUEST["news_date_dd"]." 00:00:00";
				$m_date=$_REQUEST["ctime_yy"]."-".$_REQUEST["ctime_mm"]."-".$_REQUEST["ctime_dd"]." 00:00:00";
				$g_date=date("Y-m-d 00:00:00",strtotime($p_date)-32400);

				$sql =" INSERT INTO wp01_0contents";
				$sql .="(`date`, display_date, page, category, contents_key, title, contents,tag)";
				$sql .=" VALUES('{$now}','{$p_date}','news','person','{$staff_id}','{$title}','{$news_box}','2')";
				mysqli_query($mysqli,$sql);
			}
		}
			
//■options-------------------------------
		foreach($options as $a1 => $a2){
			if($a2 == "on"){
				$app.="('{$a1}','{$staff_id}',1),";
			}
		}
		if($app){
			$app=substr($app,0,-1);
			$sql="INSERT INTO wp01_0check_sel(list_id,cast_id,sel)VALUES";
			$sql.=$app;
			mysqli_query($mysqli,$sql);
		}

//■charm_table-------------------------------
		foreach($charm_table as $a1 => $a2){
			if($a2){
				$app2.="('{$a1}','{$staff_id}','{$a2}'),";
			}
		}
		if($app2){
			$app2=substr($app2,0,-1);
			$sql="INSERT INTO wp01_0charm_sel(list_id,cast_id,log)VALUES";
			$sql.=$app2;
			mysqli_query($mysqli,$sql);
		}

//■img-------------------------------
		if($img_c){
			$a3=0;

			foreach($img_c as $a1 => $a2){

				if($a2 || $chg_check[$a3]==1){

					$tmp_width	=ceil(1200*(100/$img_z[$a1]));
					$tmp_height	=ceil(1600*(100/$img_z[$a1]));

					$tmp_left	=floor((20-$img_x[$a1])*(1200/150)*100/$img_z[$a1]);
					$tmp_top	=floor((20-$img_y[$a1])*(1600/200)*100/$img_z[$a1]);

					if($img_r[$a1] ==90){
						$new_img	= imagecreatefromstring(base64_decode($img_c[$a1]));	
						$img		= imagerotate($new_img, 270, 0, 0);

					}elseif($img_r[$a1] ==180){
						$new_img	= imagecreatefromstring(base64_decode($img_c[$a1]));	
						$img		= imagerotate($new_img, 180, 0, 0);

					}elseif($img_r[$a1] ==270){
						$new_img	= imagecreatefromstring(base64_decode($img_c[$a1]));
						$img		= imagerotate($new_img, 90, 0, 0);

					}else{
						$img = imagecreatefromstring(base64_decode($img_c[$a1]));
					}

					$link="./img/profile/".$staff_id;

					$img2 		= imagecreatetruecolor(600,800);
					ImageCopyResampled($img2, $img, 0, 0, $tmp_left, $tmp_top, 600, 800, $tmp_width, $tmp_height);
					imagejpeg($img2,$link."/".$a3.".jpg",100);
					imagedestroy($img2);

					$img2_s 		= imagecreatetruecolor(180,240);
					ImageCopyResampled($img2_s, $img, 0, 0, $tmp_left, $tmp_top, 180, 240, $tmp_width, $tmp_height);
//					imagewebp($img2_s,$link."/".$a3."_s.webp");
					imagejpeg($img2_s,$link."/".$a3."_s.jpg");
					imagedestroy($img2_s);

					$img2_n 		= imagecreatetruecolor(30,40);
					ImageCopyResampled($img2_n, $img, 0, 0, $tmp_left, $tmp_top, 30, 40, $tmp_width, $tmp_height);
					imagejpeg($img2_n,$link."/".$a3."_n.jpg",100);
					imagedestroy($img2_n);
					$a3++;
				}
			}
		}
	}
}
$sel[$_POST["menu_post"]]="menu_sel";
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
<script src="./js/admin.js?t=<?=time()?>"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/admin.css?t=<?=time()?>">
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

.menu_sel{
	background:linear-gradient(#ff0000,#e00000);
	color:#fafafa;
}
</style>
</head>
<body class="body">
<div class="main">
	<?if($_POST["menu_post"]){?>
		<?=include_once("./admin_{$_POST["menu_post"]}.php");?>
	<?}?>
</div>
<div class="left">
	<ul class="menu_ul">
		<li id="regist" class="menu <?=$sel["regist"]?>"><span class="menu_icon"></span><span class="menu_comm">登録</span></li>
		<li id="staff" class="menu <?=$sel["staff"]?>"><span class="menu_icon"></span><span class="menu_comm">スタッフ</span></li>
		<li id="sche" class="menu <?=$sel["sche"]?>"><span class="menu_icon"></span><span class="menu_comm">スケジュール</span></li>
		<li id="contents" class="menu <?=$sel["contents"]?>"><span class="menu_icon"></span><span class="menu_comm">コンテンツ</span></li>
		<li id="notice" class="menu <?=$sel["notice"]?>"><span class="menu_icon"></span><span class="menu_comm">お知らせ</span></li>
		<li id="config" class="menu <?=$sel["config"]?>"><span class="menu_icon"></span><span class="menu_comm">設定</span></li>
		<li id="blog" class="menu <?=$sel["blog"]?>"><span class="menu_icon"></span><span class="menu_comm">ブログ</span></li>
		<li id="easytalk" class="menu <?=$sel["easytalk"]?>"><span class="menu_icon"></span><span class="menu_comm">EasyTalk</span></li>
	</ul>
	<div class="head_menu">
		<div class="menu_a"></div>
		<div class="menu_b"></div>
		<div class="menu_c"></div>
	</div>
</div>
<form id="form_menu" method="post" action="./admin.php">
<input id="menu_post" type="hidden" name="menu_post">
<?$_POST="";?>
</form>
</html>
