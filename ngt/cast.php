<?php 
include_once('./library/sql.php');


$sql=" SELECT C.id, genji, in_out, `name`, `sort` FROM wp01_0cast AS C";
$sql.=" LEFT JOIN wp01_0schedule AS S ON C.id=S.cast_id";
$sql.=" LEFT JOIN wp01_0sch_table AS T ON in_out='in' AND stime=T.name";
$sql.=" WHERE C.cast_status=0";
$sql.=" AND S.sche_date='{$day_8}'";
$sql.=" ORDER BY S.id DESC";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){

		if($a1["stime"] && $a1["etime"]){
			$a1["sch"]="{$a1["stime"]} － {$a1["etime"]}";
			$sort[$a1["id"]]=$$a1["stime"];
		}else{
			$a1["sch"]="休み";
			$sort[$a1["id"]]=999999;
		}



			if (."./img/page/{$a1["id"]}/0.jpg")) {
				$a1["id"]="{$link}/img/page/{$a1["id"]}/0.jpg";		

			}else{
				$dat[$a1["id"]]["face"]="{$link}/img/page/noimage.jpg";			
			}

			if($sch_8 < $a1["ctime"]){
				$dat[$a1["id"]]["new"]=1;

			}elseif($sch_8 == $a1["ctime"]){
				$dat[$a1["id"]]["new"]=2;

			}elseif(strtotime($sch_8) - strtotime($a1["ctime"])<=2592000){
				$dat[$a1["id"]]["new"]=3;
			}





		$dat[$a1["id"]]=$a1;

	}
}





$sql=" SELECT genji,ctime,id FROM wp01_0cast";
$sql.=" WHERE del=0";
$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $a1){
	$dat[$a1["id"]]=$a1;

	$sql =" SELECT * FROM wp01_0schedule";
	$sql.=" WHERE sche_date='{$sch_8}'";
	$sql.=" AND cast_id='{$a1["id"]}'";
	$sql.=" ORDER BY schedule_id DESC";
	$sql.=" LIMIT 1";
	$res2 = $wpdb->get_results($sql,ARRAY_A);

	foreach($res2 as $a2){
		if($a2["stime"] && $a2["etime"]){
			$dat[$a1["id"]]["sch"]="{$a2["stime"]} － {$a2["etime"]}";
			$sort[$a1["id"]]=$sch_table["in"][$a2["stime"]];

			if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/0.jpg")) {
				$dat[$a1["id"]]["face"]="{$link}/img/page/{$a1["id"]}/0.jpg";		

			}else{
				$dat[$a1["id"]]["face"]="{$link}/img/page/noimage.jpg";			
			}

			if($sch_8 < $a1["ctime"]){
				$dat[$a1["id"]]["new"]=1;

			}elseif($sch_8 == $a1["ctime"]){
				$dat[$a1["id"]]["new"]=2;



			}elseif(strtotime($sch_8) - strtotime($a1["ctime"])<=2592000){
				$dat[$a1["id"]]["new"]=3;
			}



			if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/0.jpg")) {
				$dat[$a1["id"]]["face"]="{$link}/img/page/{$a1["id"]}/0.jpg";		

			}else{
				$dat[$a1["id"]]["face"]="{$link}/img/page/noimage.jpg";			
			}

			if($sch_8 < $a1["ctime"]){
				$dat[$a1["id"]]["new"]=1;

			}elseif($sch_8 == $a1["ctime"]){
				$dat[$a1["id"]]["new"]=2;

			}elseif(strtotime($sch_8) - strtotime($a1["ctime"])<=2592000){
				$dat[$a1["id"]]["new"]=3;
			}

				}else{
					$dat[$a1["id"]]["sch"]="休み";
					$sort[$a1["id"]]=999999;
				}
			}

			if(!$res2){
				$dat[$a1["id"]]["sch"]="休み";
				$sort[$a1["id"]]=999999;
			}


	if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/0.jpg")) {
		$dat[$a1["id"]]["face"]="{$link}/img/page/{$a1["id"]}/0.jpg";		

	}else{
		$dat[$a1["id"]]["face"]="{$link}/img/page/noimage.jpg";			
	}

	if($sch_8 < $a1["ctime"]){
		$dat[$a1["id"]]["new"]=1;

	}elseif($sch_8 == $a1["ctime"]){
		$dat[$a1["id"]]["new"]=2;

	}elseif(strtotime($sch_8) - strtotime($a1["ctime"])<=2592000){
		$dat[$a1["id"]]["new"]=3;
	}


}
asort($sort);

$week[0]="(日)";
$week[1]="(月)";
$week[2]="(火)";
$week[3]="(水)";
$week[4]="(木)";
$week[5]="(金)";
$week[6]="(土)";

$cl[0]="tag_sun";
$cl[6]="tag_sat";

for($e=0;$e<7;$e++){
	$cast_tag[$e]="<span class=\"tag_pc\">".date("m月d日",$now+86400*$e).$week[date("w",$now+86400*$e)]."</span><span class=\"tag_sp\">".date("m/d",$now+86400*$e)."<br>".$week[date("w",$now+86400*$e)]."</span>";
	$cast_id[$e]=date("Ymd",$now+86400*$e);
}

get_header();
?>
<div class="footmark">
	<a href="<?=home_url()?>" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">CAST</span>
	</div>
</div>
<div class="cast_tag">
<!--div id="d0" class="cast_tag_box cast_tag_box_sel">ALL</div-->
<? for($e=0;$e<7;$e++){?><div id="d<?=$cast_id[$e]?>" class="cast_tag_box <?=$cl[$e]?><?if($e == 0){?> cast_tag_box_sel<?}?>"><?=$cast_tag[$e]?></div><?}?>
</div>
<div class="main_d">
<? foreach($sort as $b1=> $b2){?>
	<a href="<?=home_url('/person')?>/?cast=<?=$b1?>" id="i<?=$b1?>" class="main_d_1">
		<img src="<?=$dat[$b1]["face"]?>" class="main_d_1_1">
		<span class="main_d_1_2">
			<span class="main_b_1_2_h"></span>
			<span class="main_b_1_2_f f_tr"></span>
			<span class="main_b_1_2_f f_tl"></span>
			<span class="main_b_1_2_f f_br"></span>
			<span class="main_b_1_2_f f_bl"></span>

			<span class="main_d_1_2_name"><?=$dat[$b1]["genji"]?></span>
			<span class="main_d_1_2_sch"><?=$dat[$b1]["sch"]?></span>
		</span>

		<?if($dat[$b1]["new"] == 1){?>
			<span class="main_b_1_ribbon ribbon1">近日入店</span>
		<?}elseif($dat[$b1]["new"] == 2){?>
			<span class="main_b_1_ribbon ribbon2">本日入店</span>
		<?}elseif($dat[$b1]["new"] == 3){?>
			<span class="main_b_1_ribbon ribbon3">新人</span>
		<?}?>
	</a>
<? } ?>
</div>
<?php get_footer(); ?>
