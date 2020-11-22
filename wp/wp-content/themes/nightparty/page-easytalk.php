<?
/*
Template Name: easytalk
*/
global $wpdb;
if($_POST["log_out"] == 1){
	$_POST="";
	$_SESSION="";
	session_destroy();
}
$jst=time();
$now=date("Y-m-d H:i:s",time()+21600);

if($_REQUEST["ss"]){
//	session_destroy();
	$sql	 ="SELECT * FROM wp01_0ssid";
	$sql	.=" WHERE ssid='{$_REQUEST["ss"]}'";
	$ssid = $wpdb->get_row($sql,ARRAY_A);
	$_SESSION=$ssid;

	if(!$ssid){
		$err=1;

	}else{
		$_SESSION["time"]=$jst;
		$sql	 ="UPDATE wp01_0ssid";
		$sql	.=" cast_id='',";
		$sql	.=" customer_id=''";
		$sql	.=" WHERE ssid !='{$_REQUEST["ss"]}'";
		$sql	.=" AND cast_id='{$session["cast_id"]}'";
		$sql	.=" AND customer_id='{$session["customer_id"]}'";
		$wpdb->query($sql);
	}

}elseif($_SESSION["ssid"]){
	if($jst<$_SESSION["time"]+18000){
		$_SESSION["time"]=$jst;
	}else{
		$_SESSION="";
		session_destroy();
		$err=2;
	}
}

if($_SESSION){
	if (file_exists(get_template_directory()."/img/page/{$_SESSION["cast_id"]}/1.jpg")) {
		$face_link=get_template_directory_uri()."/img/page/".$_SESSION["cast_id"]."/1.jpg";			
	}else{
		$face_link=get_template_directory_uri()."/img/page/noimage.jpg";			
	}

	$sql	 ="SELECT * FROM wp01_0castmail";
	$sql	.=" WHERE customer_id='{$_SESSION["customer_id"]}' AND cast_id='{$_SESSION["cast_id"]}'";
	$sql	.=" ORDER BY mail_id DESC";
	$sql	.=" LIMIT 10";

	$res = $wpdb->get_results($sql,ARRAY_A);
	$n=0;

	foreach($res as $a1){
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
		$n++;
	}

	$sql	 ="UPDATE wp01_0castmail SET";
	$sql	.=" watch_date='{$now}'";
	$sql	.=" WHERE customer_id='{$_SESSION["customer_id"]}' AND cast_id='{$_SESSION["cast_id"]}' AND send_flg='1' AND watch_date='0000-00-00 00:00:00'";
	$wpdb->query($sql);
}

?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Easy-Talk</title>
<script>
const Dir='<?php echo get_template_directory_uri(); ?>'; 
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/easytalk.js?t=<?=time()?>"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/easytalk.css?t=<?=time()?>">
</head>
<body class="body">
<div class="head_easytalk"></div>

<div class="main_easytalk">
	<div class="main_mail">
		<?if($err==1){?>
			<div class="err_msg">
				タイムアウトしました<br>
				再度メールからログインしてください。<br>
			</div>
		<?}elseif($err==2){?>
			<div class="err_msg">
				ログインコードが無効です。<br>
				最新のメールからログインしてください。<br>
			</div>

		<?}elseif($err==3){?>
			<div class="err_msg">
				SESSIONが拾えません。<br>
			</div>

		<?}else{?>
			<?for($n=0;$n<count($dat);$n++){?>
				<?if($dat[$n]["send_flg"] == 1){?>
					<div class="mail_box_a">		
						<div class="mail_box_face">
							<img src="<?=$face_link?>" class="mail_box_img">
						</div>
						<div class="mail_box_log_1">
							<?=$dat[$n]["log"]?>
						</div>
						<span class="mail_box_date_a"><?=$dat[$n]["send_date"]?></span>
					</div>

				<?}else{?>
					<div class="mail_box_b">		
						<div class="mail_box_log_2 bg<?=$dat[$n]["bg"]?>">
							<?=$dat[$n]["log"]?>
						</div>
						<span class="mail_box_date_b"><?=$dat[$n]["kidoku"]?>　<?=$dat[$n]["send_date"]?></span>
					</div>
				<? } ?>
			<? } ?>
		<? } ?>
	</div>
	<div class="main_sub">
		<img src="<?php echo get_template_directory_uri(); ?>/img/ad/dummy1.png" class="easytalk_img"></img>
		<img src="<?php echo get_template_directory_uri(); ?>/img/ad/dummy2.png" class="easytalk_img"></img>
		<?if(!$er){?>
		<input type="hidden" id="ssid" value="<?=$_SESSION["ssid"]?>">
		<textarea id="send_msg" class="easytalk_text"></textarea>
		<button id="send_mail" type="button">送</button>
		<button id="send_img" type="button">画</button>
		<? } ?>
	</div>
</div>
<div class="foot_easytalk">
</div>
</body>	
</html>
