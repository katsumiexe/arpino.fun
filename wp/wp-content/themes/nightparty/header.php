<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CastPage</title>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?t=<?=time()?>">
<script src="<?php echo get_template_directory_uri(); ?>/js/main.js?t=<?=time()?>"></script>
<?php wp_enqueue_script('jquery'); ?>
<?php wp_head(); ?>
</head>
<body class="body">
<div class="head">
	<div id="rank1" class="menu_select">TOP PAGE</div>
	<div id="rank2" class="menu_select">CAST</div>
	<div id="rank3" class="menu_select">SCHEDULE</div>
	<div id="rank4" class="menu_select">BLOG</div>
	<div id="rank5" class="menu_select">SYSTEM</div>
	<div id="rank6" class="menu_select">ACCESS</div>
</div>