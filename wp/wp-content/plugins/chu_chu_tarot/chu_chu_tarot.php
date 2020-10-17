<?php
/*
Plugin Name:chu_chu_tarot
Plugin URI:https://arpino.fun
Description:prigin
Version: 1.1
Author: KatsumiArai
Author URI:
*/

/*
require_once ("../wp-load.php");
global $wpdb;
*/

add_action('admin_menu', 'custom_menu_tarot');
function custom_menu_tarot(){
	add_menu_page('タロット設定', 'タロット設定', 'manage_options', 'set_tarot','set_tarot', 'dashicons-images-alt2', 9);
	add_submenu_page('set_tarot', 'タロット：ベース設定', 'ベース設定', 'manage_options', 'set_tarot_base', 'set_tarot_base');
	add_submenu_page('set_tarot', 'タロット：詳細設定', '詳細設定', 'manage_options', 'set_tarot_detail', 'set_tarot_detail');
	add_submenu_page('set_tarot', 'タロット：カード設定', 'カード設定', 'manage_options', 'set_tarot_card', 'set_tarot_card');
}
	
function set_tarot(){
global $wpdb;
/*
	$n=0;
	$sql	 ="SELECT * FROM tarot_group";
	$sql	.=" ORDER BY id ASC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$group[$n]=$res;
		$n++;
	}
  */
    esc_html_e(include_once('chu_chu_tarot_group.php'),'textdomain');  
}

function set_tarot_base(){
	global $wpdb;
	$n=0;
	$sql	 ="SELECT * FROM tarot_base";
	$sql	.=" ORDER BY id ASC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$card[$n]=$res;
		$n++;
	}
    esc_html_e(include_once('chu_chu_tarot_base.php'),'textdomain');  
}

function set_tarot_detail(){
	esc_html_e(include_once('chu_chu_tarot_detail.php'),'textdomain');  
}

function set_tarot_card(){
	global $wpdb;
	$n=0;
	$sql	 ="SELECT * FROM tarot_base";
	$sql	.=" ORDER BY id ASC";
	$tmp_list = $wpdb->get_results($sql,ARRAY_A);

	foreach($tmp_list as $res){
		$card[$n]=$res;
		$n++;
	}
	esc_html_e(include_once('chu_chu_tarot_card.php'),'textdomain');  
}


//------------------------------------------------------
function chu_chu_fanc($num) {

	$gp=$num[0];
	if($gp+0==0) $gp=1;

	global $wpdb;
	$jst	=time()+32400;

	$sql	="SELECT * FROM tarot_group";
	$sql	.=" WHERE group_id='{$gp}'";
	$sql	.=" LIMIT 1";
	$group	= $wpdb->get_row($sql);

	for($p=1;$p<$group["oracle"]+1;$p++){
		$ps.="<div id=\"p{$p}\" class=\"chu_card_ps\"></div>";
	}

	$sql	="SELECT * FROM tarot_base";
	$sql1	= $wpdb->get_results($sql,ARRAY_A );

	foreach($sql1 as $nn){
		$tarot_base[$nn["id"]]=$nn;
	}

$str=<<<EOF
<link rel="stylesheet" href="../../../../wp/wp-content/plugins/chu_chu_tarot/css/tarot.css?_{$jst}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="../../../../wp/wp-content/plugins/chu_chu_tarot/js/jquery.easing.1.3.js"></script>
<script src="../../../../wp/wp-content/plugins/chu_chu_tarot/js/tarot.js?_{$jst}"></script>
<script src="../../../../wp/wp-content/plugins/chu_chu_tarot/js/jquery.ui.touch-punch.min.js?_{$jst}"></script>
<script>
const Oc={$group["oracle"]};
const Gp={$gp};
</script>
<style>
.chu_main{
	background-image: url("../../../../wp/wp-content/plugins/chu_chu_tarot/img/paper.png");
}
</style>
<div class="chu_box">
<div class="chu_main">
<div class="chu_hand"></div>
{$ps}
<div id="c21" class="chu_card"><span class="chu_card_f"></span><span id="b21" class="chu_card_b"></span></div>
<div id="c20" class="chu_card"><span class="chu_card_f"></span><span id="b20" class="chu_card_b"></span></div>
<div id="c19" class="chu_card"><span class="chu_card_f"></span><span id="b19" class="chu_card_b"></span></div>
<div id="c18" class="chu_card"><span class="chu_card_f"></span><span id="b18" class="chu_card_b"></span></div>
<div id="c17" class="chu_card"><span class="chu_card_f"></span><span id="b17" class="chu_card_b"></span></div>
<div id="c16" class="chu_card"><span class="chu_card_f"></span><span id="b16" class="chu_card_b"></span></div>
<div id="c15" class="chu_card"><span class="chu_card_f"></span><span id="b15" class="chu_card_b"></span></div>
<div id="c14" class="chu_card"><span class="chu_card_f"></span><span id="b14" class="chu_card_b"></span></div>
<div id="c13" class="chu_card"><span class="chu_card_f"></span><span id="b13" class="chu_card_b"></span></div>
<div id="c12" class="chu_card"><span class="chu_card_f"></span><span id="b12" class="chu_card_b"></span></div>
<div id="c11" class="chu_card"><span class="chu_card_f"></span><span id="b11" class="chu_card_b"></span></div>
<div id="c10" class="chu_card"><span class="chu_card_f"></span><span id="b10" class="chu_card_b"></span></div>
<div id="c9" class="chu_card"><span class="chu_card_f"></span><span id="b9" class="chu_card_b"></span></div>
<div id="c8" class="chu_card"><span class="chu_card_f"></span><span id="b8" class="chu_card_b"></span></div>
<div id="c7" class="chu_card"><span class="chu_card_f"></span><span id="b7" class="chu_card_b"></span></div>
<div id="c6" class="chu_card"><span class="chu_card_f"></span><span id="b6" class="chu_card_b"></span></div>
<div id="c5" class="chu_card"><span class="chu_card_f"></span><span id="b5" class="chu_card_b"></span></div>
<div id="c4" class="chu_card"><span class="chu_card_f"></span><span id="b4" class="chu_card_b"></span></div>
<div id="c3" class="chu_card"><span class="chu_card_f"></span><span id="b3" class="chu_card_b"></span></div>
<div id="c2" class="chu_card"><span class="chu_card_f"></span><span id="b2" class="chu_card_b"></span></div>
<div id="c1" class="chu_card"><span class="chu_card_f"></span><span id="b1" class="chu_card_b"></span></div>
<div id="c0" class="chu_card"><span class="chu_card_f"></span><span id="b0" class="chu_card_b"></span></div>
</div>
<div class="chu_guard"></div>
<div class="chu_ans_box"></div>
</div>
EOF;
return $str;
}
add_shortcode('chu_chu_tarot','chu_chu_fanc');
