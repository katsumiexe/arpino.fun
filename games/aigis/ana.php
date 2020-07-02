<?php
include_once("./library/session.php");
$st_month="2020-07-01 00:00:00";

$tag[0]="★☆☆";
$tag[1]="★★☆";
$tag[2]="★★★";

$sql	 ="SELECT * FROM log_data";
$sql	.=" WHERE start>='{$st_month}'";
if($res0 = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($res0)){
		$p_day	=substr($row0["start"],8,2);
		$p_hour	=substr($row0["start"],11,2);
		$p_time	=strtotime($row0["end"])-strtotime($row0["start"]);

		$dat["p_day"][$p_day]++;
		$dat["p_hour"][$p_hour]++;

		$dat["p_time"]+=$p_time;
		$dat["p_time_cnt"]++;

		if($row0["turn_11"]){
			$order[0]=$row0["pts_p"];
			$order[1]=$row0["pts_a"];
			$order[2]=$row0["pts_b"];
			$order[3]=$row0["pts_c"];
			$order[4]=$row0["pts_d"];

			arsort($order);
			$n=1;
			foreach($order as $a1 => $a2){
				if($a1 == 0){
					$rank[$row0["level"]][$n]++;		
				}
				$n++;
			}
		}else{
			$rank[$row0["level"]][6]++;		
		}
		$rank_all[$row0["level"]]++;		
		if($row0["unit_p"]>0){
			$rank_unit[$row0["unit_p"]]++;		
		}
	}
}

$rank_all_bar[0]=floor(($rank_all[0]/($rank_all[0]+$rank_all[1]+$rank_all[2]))*100);
$rank_all_bar[1]=floor(($rank_all[1]/($rank_all[0]+$rank_all[1]+$rank_all[2]))*100);
$rank_all_bar[2]=floor(($rank_all[2]/($rank_all[0]+$rank_all[1]+$rank_all[2]))*100);


for($s=0;$s<3;$s++){
for($t=1;$t<7;$t++){
$rank_bar[$s][$t]=floor(($rank[$s][$t]/$rank_all[$s])*100);
}
}

arsort($rank_unit);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Card_Game_Aigis</title>
<link rel="stylesheet" href="./css/main.css?_<?=date("YmdHi")?>">
<style>
</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script src="./js/main.js?_<?=date("YmdHi")?>"></script>
<script>
</script>
</head>
<body style="text-align:center;background:#888888">
<div class="main">

<table class="rank_m">
<?for($s=0;$s<3;$s++){ ?>
<tr>
<td class="rank_t"><span id="d<?=$s?>" class="rank_detail">▼</span>　<?=$tag[$s]?></td>
<td class="rank_p"><?=$rank_all[$s]?></td>
<td class="rank_g"><span class="rank_bar" style="width:<?=$rank_all_bar[$s]?>%"></td>
</tr>
<?for($n=1;$n<6;$n++){ ?>
<tr class="tr<?=$s?>">
<td class="rank_t"><?=$n?>位</td>
<td class="rank_p"><?=$rank[$s][$n]?></td>
<td class="rank_g"><span class="rank_bar_s" style="width:<?=$rank_bar[$s][$n]?>%"></td>
</tr>
<? } ?>
<tr class="tr<?=$s?>">
<td class="rank_t">リタ</td>
<td class="rank_p"><?=$rank[$s][6]?></td>
<td class="rank_g"><span class="rank_bar_s" style="width:<?=$rank_bar[$s][6]?>%"></td>
</tr>
<? } ?>
</table>


<table class="rank_m">
<?foreach($rank_unit as $a3 => $a4){ ?>
<?$cnt++;?>
<tr>
<td class="rank_t"><?=$cnt?></td>
<td class="rank_t"><img src="./img/unit/unit_<?=$a3?>.png" style="width:30px;"></td>
<td class="rank_p"><?=$a4?></td>
<td class="rank_g"><span class="rank_bar" style="width:<?=$rank_all_bar[$s]?>%"></td>
</tr>
<?}?>
</table>

<table class="rank_m">
<?foreach($dat["p_day"] as $a1 => $a2){ ?>
<tr>
<td class="rank_t"><?=$a1?></td>
<td class="rank_p"><?=$a2?></td>
</tr>
<?}?>
</table>

<table class="rank_m">
<?foreach($dat["p_hour"] as $a1 => $a2){ ?>
<tr>
<td class="rank_t"><?=$a1?></td>
<td class="rank_p"><?=$a2?></td>
</tr>
<?}?>
</table>

</div>
</body>
</html>
