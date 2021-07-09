<?php 
include_once('./library/sql.php');
$sort=array();

$sql  ="SELECT id, tag_name, tag_icon,sort FROM wp01_0tag ";
$sql .=" WHERE tag_group='ribbon'";
$sql.=" AND del='0'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$ribbon_sort[$row["sort"]]=$row["id"];
		$ribbon[$row["id"]]["name"]=$row["tag_name"];

		$tmp=hexdec(str_replace("#","",$row["tag_icon"]));
		$tmp+=2631720;
		$tmp=dechex($tmp);
	
		$ribbon[$row["id"]]["c1"]="#".$tmp;
		$ribbon[$row["id"]]["c2"]=$row["tag_icon"];
	}
}

$sql=" SELECT id, genji,ctime,ribbon_use,cast_ribbon FROM wp01_0cast";
$sql.=" WHERE cast_status=0";
$sql.=" AND id>0";
$sql.=" AND genji IS NOT NULL";
$sql.=" ORDER BY cast_sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($row["ribbon_use"] ==0){
			if($day_8 < $row["ctime"] && $admin_config["coming_soon"]==1){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[1]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[1]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[1]]["c2"];

			}elseif($day_8 == $row["ctime"] && $admin_config["today_commer"]==1){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[2]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[2]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[2]]["c2"];

			}elseif((strtotime($day_8) - strtotime($row["ctime"]))/86400<$admin_config["new_commer_cnt"]){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[3]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[3]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[3]]["c2"];

			}elseif($row["cast_ribbon"]>0){
				$row["ribbon_name"]	=$ribbon[$row["cast_ribbon"]]["name"];
				$row["ribbon_c1"]	=$ribbon[$row["cast_ribbon"]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$row["cast_ribbon"]]["c2"];
			}
		}

		if (file_exists("./img/profile/{$row["id"]}/0.jpg")) {
			$row["face"]="./img/profile/{$row["id"]}/0.jpg";		

		}else{
			$row["face"]="./img/cast_no_image.jpg";			
		}
		$row["sch"]		="休み";
		$row["sort"]	=9999;

		$cast_dat[$row["id"]]=$row;
	}
}

$sql=" SELECT stime, etime, cast_id,sort FROM wp01_0schedule AS S";
//$sql.=" LEFT JOIN wp01_0sch_table AS T ON S.stime=T.name";
$sql.=" WHERE sche_date='{$day_8}'";
//$sql.=" AND in_out='in'";
$sql.=" ORDER BY S.id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($row["stime"] && $row["etime"]){
			$cast_dat[$row["cast_id"]]["sch"]="{$row["stime"]} － {$row["etime"]}";
			$cast_dat[$row["cast_id"]]["sort"]=$row["sort"];

		}else{
			$cast_dat[$row["cast_id"]]["sch"]="休み";
			$cast_dat[$row["cast_id"]]["sort"]=9999;
		}
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
	$cast_tag[$e]="<span class=\"tag_pc\">".date("m月d日",$day_time+86400*$e).$week[date("w",$day_time+86400*$e)]."</span><span class=\"tag_sp\">".date("m/d",$day_time+86400*$e)."<br>".$week[date("w",$day_time+86400*$e)]."</span>";
	$cast_id[$e]=date("Ymd",$day_time+86400*$e);
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
<? foreach($cast_dat as $b1=> $b2){?>
	<a href="./person.php?post_id=<?=$b1?>" id="i<?=$b1?>" class="main_d_1">
		<img src="<?=$b2["face"]?>" class="main_d_1_1">
		<span class="main_d_1_2">
			<span class="main_b_1_2_h"></span>
			<span class="main_b_1_2_f f_tr"></span>
			<span class="main_b_1_2_f f_tl"></span>
			<span class="main_b_1_2_f f_br"></span>
			<span class="main_b_1_2_f f_bl"></span>

			<span class="main_d_1_2_name"><?=$b2["genji"]?></span>
			<span class="main_d_1_2_sch"><?=$b2["sch"]?></span>
		</span>

		<?if($b2["ribbon_name"]){?>
			<span class="main_b_1_ribbon" style="background:linear-gradient(<?=$b2["ribbon_c1"]?>,<?=$b2["ribbon_c2"]?>);box-shadow	:0 -5px 0 <?=$b2["ribbon_c1"]?>,0 5px 0 <?=$b2["ribbon_c2"]?>;"><?=$b2["ribbon_name"]?></span>
		<?}?>
	</a>
<? } ?>
</div>
<?include_once('./footer.php'); ?>
