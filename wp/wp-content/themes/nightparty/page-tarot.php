<?
global $wpdb;
$jst=time()+32400;
$sql	 ="SELECT * FROM tarot_base";
$sql1 = $wpdb->get_results($sql,ARRAY_A );
foreach($sql1 as $nn){
	$tarot_base[$nn["id"]]=$nn;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>TAROT</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/tarot.css?_<?=date("YmdHi")?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/tarot.js?_<?=date("YmdHi")?>"></script>
<script>
const Dir='<?php echo get_template_directory_uri(); ?>'; 
</script>
<style>
.main{
	background-image: url("<?php echo get_template_directory_uri(); ?>/img/tarot/paper.png");
}
</style>
</head>
<body style="text-align:center;background:#888888">
<div class="main">
<div class="hand"></div>
<div id="p1" class="card_ps"></div>
<div id="p2" class="card_ps"></div>
<div id="p3" class="card_ps"></div>

<div id="c21" class="card"><span class="card_f"></span><span id="b21" class="card_b"></span></div>
<div id="c20" class="card"><span class="card_f"></span><span id="b20" class="card_b"></span></div>
<div id="c19" class="card"><span class="card_f"></span><span id="b19" class="card_b"></span></div>
<div id="c18" class="card"><span class="card_f"></span><span id="b18" class="card_b"></span></div>
<div id="c17" class="card"><span class="card_f"></span><span id="b17" class="card_b"></span></div>
<div id="c16" class="card"><span class="card_f"></span><span id="b16" class="card_b"></span></div>
<div id="c15" class="card"><span class="card_f"></span><span id="b15" class="card_b"></span></div>
<div id="c14" class="card"><span class="card_f"></span><span id="b14" class="card_b"></span></div>
<div id="c13" class="card"><span class="card_f"></span><span id="b13" class="card_b"></span></div>
<div id="c12" class="card"><span class="card_f"></span><span id="b12" class="card_b"></span></div>
<div id="c11" class="card"><span class="card_f"></span><span id="b11" class="card_b"></span></div>
<div id="c10" class="card"><span class="card_f"></span><span id="b10" class="card_b"></span></div>
<div id="c9" class="card"><span class="card_f"></span><span id="b9" class="card_b"></span></div>
<div id="c8" class="card"><span class="card_f"></span><span id="b8" class="card_b"></span></div>
<div id="c7" class="card"><span class="card_f"></span><span id="b7" class="card_b"></span></div>
<div id="c6" class="card"><span class="card_f"></span><span id="b6" class="card_b"></span></div>
<div id="c5" class="card"><span class="card_f"></span><span id="b5" class="card_b"></span></div>
<div id="c4" class="card"><span class="card_f"></span><span id="b4" class="card_b"></span></div>
<div id="c3" class="card"><span class="card_f"></span><span id="b3" class="card_b"></span></div>
<div id="c2" class="card"><span class="card_f"></span><span id="b2" class="card_b"></span></div>
<div id="c1" class="card"><span class="card_f"></span><span id="b1" class="card_b"></span></div>
<div id="c0" class="card"><span class="card_f"></span><span id="b0" class="card_b"></span></div>
</div>
<div class="guard"></div>

<div class="ans">
	<img id="img-0" src="<?php echo get_template_directory_uri(); ?>/img/tarot/tarot_0.jpg" class="ans_img">
	<div class="ans_ttl">【<span id="no-0" class="card_no">0</span>】<span id="name_j-0">愚者</span>/<span id="name_e-0">The Fool</span><span id="rev-0" class="face">正</span></div>
	<div class="ans_msg"><span id="mean-0"></span></div>
	<div id="log-0" class="ans_comm"></div>
</div>

<div class="ans">
	<img id="img-1" src="<?php echo get_template_directory_uri(); ?>/img/tarot/tarot_0.jpg" class="ans_img">
	<div class="ans_ttl">【<span id="no-1" class="card_no">0</span>】<span id="name_j-1">愚者</span>/<span id="name_e-1">The Fool</span>≪<span id="rev-1" class="face">正</span>≫</div>
	<div class="ans_msg"><span id="mean-1"></span></div>
	<div id="log-1" class="ans_comm"></div>
</div>

<div class="ans">
	<img id="img-2" src="<?php echo get_template_directory_uri(); ?>/img/tarot/tarot_0.jpg" class="ans_img">
	<div class="ans_ttl">【<span id="no-2" class="card_no">0</span>】<span id="name_j-2">愚者</span>/<span id="name_e-2">The Fool</span><span id="rev-2" class="face">正</span></div>
	<div class="ans_msg"><span id="mean-2"></span></div>
	<div id="log-2" class="ans_comm"></div>
</div>

<?foreach($tarot_base as $a1 => $a2 ){?><?foreach($a2 as $a3 => $a4){?>
<input type="hidden" id="<?=$a3?>_<?=$a1?>" value="<?=$a4?>"><?}?><?}?>
</body>
</html>
