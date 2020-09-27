<?php
include_once("./library/session.php");
$st_month="2020-07-01 00:00:00";
$st_month=date("Y-m--01 00:00:00",time()-21600);
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
	
			$rank_charm[1]+=$unit[$row0["unit_p"]]["status_1"];
			$rank_charm[2]+=$unit[$row0["unit_p"]]["status_2"];
			$rank_charm[3]+=$unit[$row0["unit_p"]]["status_3"];
			$rank_charm[4]+=$unit[$row0["unit_p"]]["status_4"];
			$rank_charm[5]+=$unit[$row0["unit_p"]]["status_5"];
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
arsort($rank_charm);


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
<div class="main_ana">
<div class="analytics">analytics(<?=date("Y年m月",time()-21600)?>)</div>

<table class="rank_table">
<tr>
<td class="rank_ttl" colspan="8">ランク別順位</td>
</tr>
<tr>
	<td class="rank_ttl">Lev.</td>
	<td class="rank_ttl">合計</td>
	<td class="rank_ttl">1位</td> 
	<td class="rank_ttl">2位</td>
	<td class="rank_ttl">3位</td>
	<td class="rank_ttl">4位</td>
	<td class="rank_ttl">5位</td>
	<td class="rank_ttl">リタ</td>
</tr>
<?for($s=0;$s<3;$s++){ ?>
	<tr>
		<td class="rank_t"><?=$tag[$s]?></td>
		<td class="rank_p"><?=$rank_all[$s]+0?></td>
	<?for($n=1;$n<7;$n++){ ?>
		<td class="rank_p"><?=$rank[$s][$n]+0?></td>
	<? } ?>
	</tr>
<? } ?>
</table>
<table class="rank_table">
<tr>
<td class="rank_ttl" colspan="4">ユニット別使用数</td>
</tr>
<tr>
<td class="rank_ttl">順位</td>
<td class="rank_ttl" colspan="2">ユニット</td>
<td class="rank_ttl">使用数</td>
</tr>
<?foreach($rank_unit as $a3 => $a4){ ?>
<?$cnt++;?>
<tr>
<td class="rank_u1"><?=$cnt?></td>
<td class="rank_u2"><img src="./img/unit/unit_<?=$a3?>.png?t=<?=time()?>" class="rank_u2i"></td>
<td class="rank_u3"><?=$unit[$a3]["name"]?></td>
<td class="rank_u4"><?=$a4+0?></td>
</tr>
<?}?>
</table>

<table class="rank_table">
<tr>
<td class="rank_ttl" colspan="3">魅力別使用数</td>
</tr>
<tr>
<td class="rank_ttl">順位</td>
<td class="rank_ttl">魅力</td>
<td class="rank_ttl">使用数</td>
</tr>
<?foreach($rank_charm as $a3 => $a4){ ?>
<?$cnt2++;?>
<tr>
<td class="rank_c1"><?=$cnt2?></td>
<td class="rank_c3"><?=$status[$a3]["name"]?></td>
<td class="rank_c4"><?=$a4?></td>
</tr>
<?}?>
</table>


<table class="rank_table">
<tr>
<td class="rank_ttl" colspan="3">日別使用数</td>
</tr>
<tr>
<td class="rank_ttl">日</td>
<td class="rank_ttl">件数</td>
</tr>

<?for($n=1;$n<date("t")+1;$n++){ ?>
<?$tmp_date=substr("0".$n,-2,2)?>

<tr>
<td class="rank_d1"><?=$tmp_date?></td>
<td class="rank_d2"><?=$dat["p_day"][$tmp_date]+0?></td>
</tr>
<?}?>
</table>

<table class="rank_table">
<tr>
<td class="rank_ttl" colspan="3">時間帯別使用数</td>
</tr>
<tr>
<td class="rank_ttl">時間</td>
<td class="rank_ttl">件数</td>
</tr>
<?for($n=0;$n<24;$n++){ ?>
<?$tmp_time=substr("0".$n,-2,2)?>
<tr>
<td class="rank_h1"><?=$tmp_time?></td>
<td class="rank_h2"><?=$dat["p_hour"][$tmp_time]+0?></td>
</tr>
<?}?>
</table>
<br>
</div>
</body>
</html>
