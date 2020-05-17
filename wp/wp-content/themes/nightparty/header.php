<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CastPage</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/main.js?t=<?=time()?>"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?t=<?=time()?>">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/person.css?t=<?=time()?>">

<?php wp_head(); ?>
<?php include(get_template_directory_uri()."/libraly/inc_cast.php"); ?>
</head>
<body class="body">
<?php
	$args = array(
		'theme_location'	=>'global', 
		'menu_id'			=>'',
		'menu_class'		=>'head',
	 );
wp_nav_menu($args);
?>

<!--
<div class="head">
	<div id="rank1" class="menu_select">TOP PAGE</div>
	<div id="rank2" class="menu_select">CAST</div>
	<div id="rank3" class="menu_select">SCHEDULE</div>
	<div id="rank4" class="menu_select">BLOG</div>
	<div id="rank5" class="menu_select">SYSTEM</div>
	<div id="rank6" class="menu_select">ACCESS</div>
</div>
-->
