<?
/*
Template Name: easytalk
*/
session_start();
global $wpdb;
if($_POST["log_out"] == 1){
	$_POST="";
	$_SESSION="";
	session_destroy();
}
$jst=time();

if($_SESSION){
	if($jst<$_SESSION["time"]+18000){
		$_SESSION["time"]=$jst;
	}else{
		$_SESSION="";
		session_destroy();
		$err=2;
	}

}elseif($_REQUEST["ss"]){
	$sql	 ="SELECT * FROM wp01_0ssid";
	$sql	.=" WHERE ssid='{$ss}'";
	$session = $wpdb->get_row($sql,ARRAY_A);

	if(!$ssid){
		$err=1;
	}else{
		$_SESSION=$ssid;
		$_SESSION["time"]=$jst;
		$sql	 ="UPDATE wp01_0ssid";
		$sql	.=" cast_id='',";
		$sql	.=" customer_id=''";
		$sql	.=" WHERE ssid !='{$ss}'";
		$sql	.=" AND cast_id='{$ssid["cast_id"]}'";
		$sql	.=" AND customer_id='{$ssid["customer_id"]}'";
	}

}else{
	$err="2";
}

if($_SESSION){
	if (file_exists(get_template_directory()."/img/page/{$cast}/1.jpg")) {
		$face_link=get_template_directory_uri()."/img/page/".$cast."/1.jpg";			
	}else{
		$face_link=get_template_directory_uri()."/img/page/noimage.jpg";			
	}

	$sql	 ="SELECT * FROM wp01_0castmail";
	$sql	.=" WHERE customer_id='{$customer}' AND cast_id='{$cast}'";
	$sql	.=" ORDER BY mail_id DESC";
	$sql	.=" LIMIT 10";

	$res = $wpdb->get_results($sql,ARRAY_A);
	foreach($res as $a1){
		$dat[]=$a1;
	}
	$sql	 ="UPDATE wp01_castmail SET";
	$sql	.=" watch_date='{$now}'";
	$sql	.=" WHERE customer_id='{$customer}' AND cast_id='{$cast}' AND send_flg='1' AND watch_date='0000-00-00 00:00:00'";
}

$err="";
?>

<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/main.js?t=<?=time()?>"></script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/easytalk.css?t=<?=time()?>">
</head>
<body class="body">
<div class="main">
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

<?}else{?>
<div class="main_mail">
<?for($n=0;$n<count($dat);$n++){?>
	<?if($dat[$n]["send_flg"] == 1){?>
		<div class="mail_box_a">		
			<div class="mail_box_face">
				<img src="<?=$face_link?>" class="mail_box_img">
			</div>
			<div class="mail_box_log_1">
				<?=$dat[$n]["log"]?>
				<span class="mail_box_date"><?=$dat[$n]["send_date"]?></span>
			</div>
		</div>

	<?}else{?>
		<div class="mail_box_b">		
			<div class="mail_box_log_2">
				<?=$dat[$n]["log"]?>
				<span class="mail_box_date"><?=$dat[$n]["send_date"]?></span>
			</div>
		</div>
	<? } ?>
<? } ?>
</div>
<div class="main_sub">
</div>
<? } ?>
</div>
</body>
</html>
