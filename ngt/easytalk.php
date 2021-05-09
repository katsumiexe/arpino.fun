<?
$mysqli = mysqli_connect("localhost", "tiltowait_np", "kk1941", "tiltowait_np");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

$now		=date("Y-m-d H:i:s");
$now_8		=date("Ymd");
$now_w		=date("w");
$now_count	=date("t");
$now_month	=date("Y-m-01 00:00:00");

$day_time	=time()-($start_time*3600);

$day		=date("Y-m-d H:i:s",$day_time);
$day_8		=date("Ymd",$day_time);
$day_w		=date("w",$day_time);
$day_count	=date("t",$day_time);
$day_month	=date("Y-m-01 00:00:00",$day_time);

$ss=$_REQUEST["ss"];
if($ss){
	$sql	 ="SELECT * FROM wp01_0ssid";
	$sql	.=" WHERE ssid='{$ss}'";
	$sql	.=" AND del='0'";
	$sql	.=" ORDER BY id DESC";
	$sql	.=" LIMIT 1";

	if($res = mysqli_query($mysqli,$sql)){
		$ssid = mysqli_fetch_assoc($res);

		$sql ="SELECT * FROM wp01_0encode"; 
		if($result = mysqli_query($mysqli,$sql)){
			while($row = mysqli_fetch_assoc($result)){
				$enc[$row["key"]]				=$row["value"];
				$dec[$row["gp"]][$row["value"]]	=$row["key"];	
				$rnd[$row["id"]]				=$row["value"];
			}
		}

		$id_8=substr("00000000".$ssid["cast_id"],-8);
		$id_0	=$ssid["cast_id"] % 20;

		for($n=0;$n<8;$n++){
			$tmp_id=substr($id_8,$n,1);
			$box_no.=$dec[$id_0][$tmp_id];
		}
		$box_no.=$id_0;

		$sql	 ="UPDATE wp01_0ssid SET";
		$sql	.=" del='1'";
		$sql	.=" WHERE id <'{$ssid["id"]}'";
		$sql	.=" AND cast_id='{$ssid["cast_id"]}'";
		$sql	.=" AND customer_id='{$ssid["customer_id"]}'";
		mysqli_query($mysqli,$sql);

		if (file_exists("./img/profile/{$ssid["cast_id"]}/0_s.jpg")) {
			$face_link="./img/profile/{$ssid["cast_id"]}/0_s.jpg";			

		}else{
			$face_link="./img/cast_no_image.jpg";			
		}

		$n=0;
		$sql	 ="SELECT * FROM wp01_0easytalk";
		$sql	.=" WHERE customer_id='{$ssid["customer_id"]}' AND cast_id='{$ssid["cast_id"]}'";
		$sql	.=" ORDER BY mail_id DESC";
		$sql	.=" LIMIT 10";
		if($res = mysqli_query($mysqli,$sql)){
			while($a1 = mysqli_fetch_assoc($res)){
				$dat[$n]=$a1;
				$dat[$n]["log"]=str_replace("\n","<br>",$dat[$n]["log"]);
				$dat[$n]["send_date"]=str_replace("-",".",$dat[$n]["send_date"]);
				$dat[$n]["send_date"]=substr($dat[$n]["send_date"],0,16);

				if($dat[$n]["watch_date"] =='0000-00-00 00:00:00'){
					$dat[$n]["kidoku"]="<span class=\"midoku\">未読</span>";
				}else{
					$dat[$n]["kidoku"]="<span class=\"kidoku\">既読</span>";
					$dat[$n]["bg"]=1;
				}

				if($dat[$n+1]["watch_date"] =='0000-00-00 00:00:00' && $dat[$n]["watch_date"] !='0000-00-00 00:00:00'){
					$dat[$n]["border"]="<div class=\"mail_border\">----------ここから新着--------------</div>";
					$html=$dat[$n]["watch_date"];
				}
				if($dat[$n]["img"]){
					$dat[$n]["stamp"]="<img src=\"./img/cast/{$box_no}/m/{$dat[$n]["img"]}.png\" class=\"mail_box_stamp\">";
				}
				$n++;
			}
		}

		$sql	 ="UPDATE wp01_0easytalk SET";
		$sql	.=" watch_date='{$now}'";
		$sql	.=" WHERE customer_id='{$ssid["customer_id"]}' AND cast_id='{$ssid["cast_id"]}' AND send_flg='1' AND watch_date='0000-00-00 00:00:00'";
		mysqli_query($mysqli,$sql);


	}else{
		$err=1;
	}

}else{
	$err=2;
}
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EasyTalk</title>
<script>

const ImgSrc="./img/customer_no_img.jpg?t_<?=time()?>";
const CastId="<?=$ssid["cast_id"]?>";
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
<script src="./js/jquery.exif.js?t=<?=time()?>"></script>
<script src="./js/easytalk.js?t=<?=time()?>"></script>
<link rel="stylesheet" href="./css/easytalk.css?t=<?=time()?>">
<link rel="stylesheet" href="./css/easytalk_guest.css?t=<?=time()?>">
<style>
@font-face {
	font-family: at_icon;
	src: url("./font/font_1/fonts/icomoon.ttf") format('truetype');
}
</style>
</head>

<body class="body">
<header class="head_easytalk"></header>
<div class="main_easytalk">
	<div class="main_mail">
		<?if($err==2){?>
			<div class="err_msg">
				タイムアウトしました<br>
				再度メールからログインしてください。<br>
			</div>
		<?}elseif($err==1){?>
			<div class="err_msg">
				ログインコードが無効です。<br>
				最新のメールからログインしてください。<br>
			</div>
		<?}else{?>
			<?for($n=0;$n<count($dat);$n++){?>
				<?if($dat[$n]["send_flg"] == 1){?>
					<?=$dat[$n]["border"]?>
					<div class="mail_box_a">		
						<div class="mail_box_face">
							<img src="<?=$face_link?>" class="mail_box_img">
						</div>
						<div class="mail_box_log_1">
							<div class="mail_box_log_in">
								<?=$dat[$n]["log"]?>
							</div>
							<?=$dat[$n]["stamp"]?>
						</div>
						<span class="mail_box_date_a"><?=$dat[$n]["send_date"]?></span>
					</div>

				<?}else{?>
					<div class="mail_box_b">		
						<div class="mail_box_log_2 bg<?=$dat[$n]["bg"]?>">
							<div class="mail_box_log_in">
								<?=$dat[$n]["log"]?>
							</div>
							<?=$dat[$n]["stamp"]?>
						</div>
						<span class="mail_box_date_b"><?=$dat[$n]["kidoku"]?>　<?=$dat[$n]["send_date"]?></span>
					</div>
				<? } ?>
			<? } ?>
		<? } ?>
	</div>
	<div class="main_sub">
		<img src="./img/ad/dummy1.png" class="easytalk_img">
		<img src="./img/ad/dummy2.png" class="easytalk_img">

		<?if(!$err){?>
		<table class="send_img_table">
			<tr>
				<td class="send_img_td">
					<img id="send_img" src="./img/blog_no_image.png?t_<?=time()?>" class="mail_img_view">
				</td>
				<td>
					<textarea id="send_msg" class="mail_write_text"></textarea>
				</td>
			</tr>
		</table>

		<button id="send_mail" type="button" class="send_btn">メールを返信する</button>
		<input type="hidden" id="ssid" name="ss" value="<?=$ss?>">
		<input type="hidden" id="img_code">

		<? } ?>
	</div>
</div>

<footer class="foot_easytalk"></footer>
<div class="img_box">
	<div id="img_close" class="btn_c2">×</div>　

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

	<div class="img_box_in2">
		<label for="upd" class="upload_btn"><span class="upload_icon_p"></span><span class="upload_txt">画像選択</span></label>
		<span class="upload_icon upload_rote"></span>
		<span class="upload_icon upload_trush"></span>
		<div class="img_box_in3">
			<div class="zoom_mi">-</div>
			<div class="zoom_rg"><input id="input_zoom" type="range" name="num" min="100" max="300" step="1" value="100" class="range_bar"></div>
			<div class="zoom_pu">+</div><div class="zoom_box">100</div>
		</div>
		<div id="img_set" class="btn_c1">登録</div>　
		<div id="img_reset" class="btn_c3">リセット</div>
	</div>
	<input id="upd" type="file" accept="image/*" style="display:none;">
	<canvas id="cvs2" width="800px" height="800px;"></canvas>
</div>
</body>	
</html>
