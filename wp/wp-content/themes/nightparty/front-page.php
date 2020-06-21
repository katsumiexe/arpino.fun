<?php
get_header();
$dat[0]->face=get_template_directory_uri()."/img/cast/noimage.jpg";
$dat[1]->face=get_template_directory_uri()."/img/cast/noimage.jpg";
$dat[2]->face=get_template_directory_uri()."/img/cast/noimage.jpg";
$dat[3]->face=get_template_directory_uri()."/img/cast/noimage.jpg";
$dat[4]->face=get_template_directory_uri()."/img/cast/noimage.jpg";
$dat[5]->face=get_template_directory_uri()."/img/cast/noimage.jpg";
$dat[6]->face=get_template_directory_uri()."/img/cast/noimage.jpg";
$dat[7]->face=get_template_directory_uri()."/img/cast/noimage.jpg";
$dat[8]->face=get_template_directory_uri()."/img/cast/noimage.jpg";
$dat[9]->face=get_template_directory_uri()."/img/cast/noimage.jpg";

$now=date("Ymd",time()+32400);

print($now);
$res = $wpdb->get_results('SELECT * FROM wp01_0cast',ARRAY_A);

$n=0;
foreach($res as $a1){
	$dat[$n]	=$a1;
	if($a1["face1"] > 0){
		$dat[$n]["face"]=get_template_directory_uri()."/img/page/".$a1["id"]."/".$a1["face1"].".jpg";			
	}else{
		$dat[$n]["face"]=get_template_directory_uri()."/img/page/noimage.jpg";			
	}
	$sch[$a1["id"]]="本日休み";
	$n++;
}


$sql="SELECT * FROM wp01_0schedule WHERE sche_date='{$now}' ORDER BY schedule_id ASC";

$res2 = $wpdb->get_results($sql,ARRAY_A);
foreach($res2 as $a2){

	if($a2["stime"] && $a2["etime"]):
		$sch[$a2["cast_id"]]	="{$a2["stime"]} - {$a2["etime"]}";

	else:
		$sch[$a2["cast_id"]]	="本日休み";
	endif;
}
?>
<div class="slide">
	<div class="slide_img"></div>
	<div class="slide_point">
		<div class="slide_dot"></div>
		<div class="slide_dot"></div>
		<div class="slide_dot"></div>
		<div class="slide_dot"></div>
		<div class="slide_dot"></div>
		<div class="slide_dot"></div>
	</div>
</div>

<div class="main_b">
	<h1 class="main_b_title">本日の出勤キャスト</h1>
<?for($s=0;$s<10;$s++){?>
	<a href="<?php echo get_template_directory_uri(); ?>/person/<?=$dat[$s]["id"]?>" id="c<?=$dat[$s]["id"]?>" class="main_b_1">
		<img src="<?=$dat[$s]["face"]?>" class="main_b_1_1">
		<div class="main_b_1_2"><?=$dat[$s]["genji"]?><br><?=$sch[$dat[$s]["id"]]?></div>
		<div class="main_b_1_3"></div>
	</a>
<?}?>
</div>

<div class="main_c">
	<div class="main_c_1">
<?php echo $cast[1]["genji"]?><bR>
	にゃんにゃか<br>
	にゃんにゃか<br>
	にゃんにゃか<br>
	にゃんにゃか<br>
	にゃんにゃか<br>
	</div>

	<div class="main_c_1">
	にゃんにゃか<br>
	にゃんにゃか<br>
	にゃんにゃか<br>
	にゃんにゃか<br>
	</div>
	<div class="main_c_1">
	</div>
</div>
<?php get_footer(); ?>
