<?php
get_header();
$week[0]="(日)";
$week[1]="(月)";
$week[2]="(火)";
$week[3]="(水)";
$week[4]="(木)";
$week[5]="(金)";
$week[6]="(土)";

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
<div class="person_main">

<div class="person_left">
		<?PHP ECHO $face_a?>
	<div class="person_img_list">
		<?PHP ECHO $face_b?>
	</div>
</div>

<div class="person_middle">
<table>
<tr>
<td class="parson_td_1">名前</td>
<td class="parson_td_2"><?PHP ECHO $a1->genji?></td>
</tr>
</table>

<table>
<?PHP for($n=0;$n<7;$n++){?>
<tr>
<td class="parson_sch_1"><?PHP ECHO date("m/d",time()+(86400*$n))?><?PHP ECHO $week[date("w",time()+(86400*$n))]?></td>
<td class="parson_sch_2"></td>
</tr>
<?}?>
</table>

</div>
<div class="person_right">
</div>
</div>
<?php get_footer(); ?>
