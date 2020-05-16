<?php
get_header();
$val="";

$res = $wpdb->get_results('
	SELECT * FROM wp01_0cast WHERE id="{$val}"
');

if($res->face1 > 0):
	$res->face=get_template_directory_uri()."/img/cast/".$res->id."/".$res->face1.".jpg";			
else:
	$res->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
endif;
?>
<div class="main">
<div class="person_left">
	<img src="<?PHP ECHO $res->face?>" class="person_img_main">
	<div class="person_img_list">
		<img id="i1" src="" class="person_img_sub">
		<img id="i2" src="" class="person_img_sub">
		<img id="i3" src="" class="person_img_sub">
		<img id="i4" src="" class="person_img_sub">
		<img id="i5" src="" class="person_img_sub">
	</div>
</div>
<div class="person_right">
	<?PHP ECHO $res->genji?>
</div>
</div>
<?php get_footer(); ?>
