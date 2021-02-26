<?php 
include_once('./library/sql.php');
$sort=array();

$sql=" SELECT C.id, genji, in_out, `name`, T.sort,C.ctime FROM wp01_0cast AS C";
$sql.=" LEFT JOIN wp01_0schedule AS S ON C.id=S.cast_id";
$sql.=" LEFT JOIN wp01_0sch_table AS T ON in_out='in' AND stime=T.name";
$sql.=" WHERE C.cast_status=0";
//$sql.=" AND S.sche_date='{$day_8}'";
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

		if (file_exists("./img/profile/{$a1["id"]}/0.jpg")) {
			$a1["face"]="./img/profile/{$a1["id"]}/0.jpg";		

		}else{
			$a1["face"]="./img/profile/noimage.jpg";			
		}

		if($day_8 < $a1["ctime"]){
			$a1["new"]=1;

		}elseif($day_8 == $a1["ctime"]){
			$a1["new"]=2;

		}elseif(strtotime($day_8) - strtotime($a1["ctime"])<=2592000){
			$a1["new"]=3;
		}
		$dat[$a1["id"]]=$a1;
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

include_once('./header.php');
?>
<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
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
<? for($e=0;$e<7;$e++){?><div id="d<?=$cast_id[$e]?>" class="cast_tag_box <?=$cl[$e]?><?if($e == 0){?> cast_tag_box_sel<?}?>"><?=$cast_tag[$e]?></div><?}?>
</div>
<div class="main_d">
<? foreach($sort as $b1=> $b2){?>
	<a href="./person.php?cast=<?=$b1?>" id="i<?=$b1?>" class="main_d_1">
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
<?include_once('./footer.php'); ?>
