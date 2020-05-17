<?php
get_header();
$val="1";

$res = $wpdb->get_results('
	SELECT * FROM wp01_0cast WHERE id="{$val}"
');
foreach($res as $a1);

if($a1->face1 > 0):
	$a1->face=get_template_directory_uri()."/img/cast/".$a1->id."/".$a1->face1.".jpg";			
else:
	$a1->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
endif;
?>
<div class="main">
<div class="person_left">
	<img src="<?PHP ECHO $a1->face?>" class="person_img_main">
	<div class="person_img_list">
		<img id="i1" src="" class="person_img_sub">
		<img id="i2" src="" class="person_img_sub">
		<img id="i3" src="" class="person_img_sub">
		<img id="i4" src="" class="person_img_sub">
	</div>
</div>
<div class="person_right">
	<?PHP ECHO $a1->genji?>
</div>

</div>
<?php get_footer(); ?>
