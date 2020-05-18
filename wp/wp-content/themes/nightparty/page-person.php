<?php
get_header();
$val="1";
$sql="SELECT * FROM wp01_0cast WHERE id='".$val."'";

$res = $wpdb->get_results($sql);
foreach($res as $a1);

if($a1->face1 > 0):
	$face_a="<img src=\"".get_template_directory_uri()."/img/cast/".$a1->id."/".$a1->face1.".jpg\" class=\"person_img_main\">";
	$face_b="<img id=\"i1\" src=\"".get_template_directory_uri()."/img/cast/".$a1->id."/".$a1->face1.".jpg\" class=\"person_img_sub\">";
else:
	$a1->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
	$face_a="<img src=\"".get_template_directory_uri()."/img/cast/noimage.jpg\" class=\"person_img_main\">";

endif;

if($a1->face2 > 0):
	$face_b.="<img id=\"i2\" src=\"".get_template_directory_uri()."/img/cast/".$a1->id."/".$a1->face2.".jpg\" class=\"person_img_sub\">";
endif;

if($a1->face3 > 0):
	$face_b.="<img id=\"i3\" src=\"".get_template_directory_uri()."/img/cast/".$a1->id."/".$a1->face3.".jpg\" class=\"person_img_sub\">";
endif;

if($a1->face4 > 0):
	$face_b.="<img id=\"i4\" src=\"".get_template_directory_uri()."/img/cast/".$a1->id."/".$a1->face4.".jpg\" class=\"person_img_sub\">";
endif;
?>

<div class="person_left">
		<?PHP ECHO $face_a?>
	<div class="person_img_list">
		<?PHP ECHO $face_b?>
	</div>
</div>
<div class="person_middle">

</div>
<div class="person_right">
	<?PHP ECHO $a1->genji?>
</div>

<?php get_footer(); ?>
