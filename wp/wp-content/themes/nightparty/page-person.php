<?php
get_header();
$week[0]="(日)";
$week[1]="(月)";
$week[2]="(火)";
$week[3]="(水)";
$week[4]="(木)";
$week[5]="(金)";
$week[6]="(土)";
$t_day=date("Ymd",time()-21600);
$n_day=date("Ymd",time()+86400*7-21600);

$tmp=explode("/",$_SERVER["REQUEST_URI"]);
$val=$tmp[count($tmp)-2];

$sql="SELECT * FROM wp01_0cast WHERE id='".$val."'";
$res = $wpdb->get_results($sql);
foreach($res as $a1):
	$charm[1]=$a1->charm01;
	$charm[2]=$a1->charm02;
	$charm[3]=$a1->charm03;
	$charm[4]=$a1->charm04;
	$charm[5]=$a1->charm05;
	$charm[6]=$a1->charm06;
	$charm[7]=$a1->charm07;
	$charm[8]=$a1->charm08;
	$charm[9]=$a1->charm09;

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
endforeach;

$sql="SELECT * FROM wp01_0schedule WHERE sche_date>='".$t_day."' AND sche_date<'".$n_day."' AND cast_id='".$val."'";
$res2 = $wpdb->get_results($sql);
foreach($res2 as $a2):
	$sch[$a2->sche_date]=$a2;
endforeach;

for($n=0;$n<7;$n++){
	$t_sch=date("Ymd",time()+(86400*$n)-21600);

	if(substr_count($sch[$t_sch]->stime,"0")>0):
		$tmp_s=substr($sch[$t_sch]->stime,0,2).":".substr($sch[$t_sch]->stime,2,2);
	else:
		$tmp_s=$sch[$t_sch]->stime;
	endif;

	if(substr_count($sch[$t_sch]->etime,"0")>0):
		$tmp_e=substr($sch[$t_sch]->etime,0,2).":".substr($sch[$t_sch]->etime,2,2);
	else:
		$tmp_e=$sch[$t_sch]->etime;
	endif;

	$list_day=substr($t_sch,4,2)."/".substr($t_sch,6,2);
	$list_week=date("w",strtotime($t_sch));

	if($tmp_s && $tmp_e):
		$tmp_date=$tmp_s."～".$tmp_e;
	else:
		$tmp_date="";
	endif;

	if($tmp_s && $tmp_e):
		$list.="<tr><td class=\"sche_l_".$list_week."\">".$list_day." ".$week[$list_week]."</td><td class=\"sche_r_".$list_week."\">".$tmp_s."～".$tmp_e."</td>";
	else:
		$list.="<tr><td class=\"sche_l_".$list_week."\">".$list_day." ".$week[$list_week]."</td><td class=\"sche_r_".$list_week."\">休み</td>";
	endif;
}

$sql="SELECT * FROM wp01_0charm_table WHERE del=0 ORDER BY sort ASC";
$res3 = $wpdb->get_results($sql);
foreach($res3 as $a3):
	$charm_list.="<tr><td class=\"prof_l\">".$a3->charm."</td><td class=\"prof_r\">".$charm[$a3->id]."</td></tr>";
endforeach;
?>
<div class="person_main">
<div class="person_left">
		<?PHP ECHO $face_a?>
	<div class="person_img_list">
		<?PHP ECHO $face_b?>
	</div>
</div>
<div class="person_middle">
<table class="prof">
<tr>
<td class="prof_l">名前</td>
<td class="prof_r"><?PHP ECHO $a1->genji?></td>
</tr>
<?PHP ECHO $charm_list?>
</table>
<table class="sche">
<?PHP ECHO $list?>
</table>
</div>

<div class="person_right">
</div>
</div>

<?php get_footer(); ?>