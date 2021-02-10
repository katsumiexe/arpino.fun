<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/main.js?t=<?=time()?>"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?t=<?=time()?>">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/person.css?t=<?=time()?>">
<script>
const Dir='<?php echo get_template_directory_uri(); ?>'; 
</script>
<style>
@font-face {
	font-family: at_icon;
	src: url(<?php echo get_template_directory_uri(); ?>/font/font_1/fonts/icomoon.ttf) format('truetype');
}

@font-face {
	font-family: at_frame1;
	src: url(<?php echo get_template_directory_uri(); ?>/font/font_3/fonts/icomoon.ttf) format('truetype');
}

@font-face {
	font-family: at_frame2;
	src: url(<?php echo get_template_directory_uri(); ?>/font/border/frame2.ttf) format('truetype');
}


@font-face {
	font-family: at_font1;
	src: url(<?php echo get_template_directory_uri(); ?>/font/Courgette-Regular.ttf) format('truetype');
}
</style>
<?php wp_head(); ?>
</head>
<body class="body">
<header class="head">
<div class="head_top">
<img src="<?=get_template_directory_uri()?>/img/ad/nightparty_logo.png?t=<?=time()?>" class="head_logo">

<div class="head_b">
<table class="head_b_table">
<tr>
<td colspan="2" class="head_b_1">
	西武新宿駅徒歩5分<br>誰もが落ち着ける新スタイルのNew Club</span>
</td>
</tr>
<tr>
<td class="head_b_2">営業時間</td>
<td class="head_b_3">19：00～LAST</td>
</tr>
<tr>
<td class="head_b_2">電話番号</td>
<td class="head_b_3">03<span>-</span>1234<span>-</span>5678</span></td>
</tr>
</table>
</div>

<div class="head_in">
<?php
	$args = array(
		'theme_location'	=>'global', 
		'menu_id'			=>'',
		'menu_class'		=>'menu',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
	 );
wp_nav_menu($args);
?>
<div class="head_menu">
	<div class="menu_a"></div>
	<div class="menu_b"></div>
	<div class="menu_c"></div>
</div>
<div class="head_tel"></div>
</div>
</header>
<div class="main">
