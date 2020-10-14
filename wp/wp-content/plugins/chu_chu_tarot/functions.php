<?
function chu_chu_fanc($tarot_code) {
	$atts = shortcode_atts(
		array(
'word' => '値が入力されていません',
), $atts, 'userword' );
return $atts['word'];
}
add_shortcode( 'chu_chu_tarot', 'chu_chu_fanc' );
?>


