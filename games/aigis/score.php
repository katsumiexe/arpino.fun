<?
include_once("./library/session.php");
$base_date=date("Y-m-01 00:00:00");
$now=date("Y/m");

$n=1;
$sql	 ="SELECT * FROM score_data";
$sql	.=" WHERE date>='{$base_date}'";
$sql	.=" AND level='0'";
$sql	.=" ORDER BY score DESC";
$sql	.=" LIMIT 10";
if($res0 = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($res0)){
		if($row0["name"]){
			$rank0[$n]["name"]=$row0["name"];
		}else{
			$rank0[$n]["name"]="名無し王子";
		}
		$rank0[$n]["date"]	=$row0["date"];
		$rank0[$n]["score"]	=$row0["score"];
		$rank0[$n]["img"]	="<img src=\"./img/unit/unit_{$row0["unit"]}.png\" class=\"score_img\">";
		$n++;	
	}
}

$n=1;
$sql	 ="SELECT * FROM score_data";
$sql	.=" WHERE date>='{$base_date}'";
$sql	.=" AND level='1'";
$sql	.=" ORDER BY score DESC";
$sql	.=" LIMIT 10";

if($res0 = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($res0)){
		if($row0["name"]){
			$rank1[$n]["name"]=$row0["name"];
		}else{
			$rank1[$n]["name"]="名無し王子";
		}
		$rank1[$n]["date"]	=$row0["date"];
		$rank1[$n]["score"]	=$row0["score"];
		$rank1[$n]["img"]	="<img src=\"./img/unit/unit_{$row0["unit"]}.png\" class=\"score_img\">";
		$n++;	
	}
}

$n=1;
$sql	 ="SELECT * FROM score_data";
$sql	.=" WHERE date>='{$base_date}'";
$sql	.=" AND level='2'";
$sql	.=" ORDER BY score DESC";
$sql	.=" LIMIT 10";
if($res0 = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($res0)){
		if($row0["name"]){
			$rank2[$n]["name"]=$row0["name"];
		}else{
			$rank2[$n]["name"]="名無し王子";
		}
		$rank2[$n]["date"]	=$row0["date"];
		$rank2[$n]["score"]	=$row0["score"];
		$rank2[$n]["img"]	="<img src=\"./img/unit/unit_{$row0["unit"]}.png\" class=\"score_img\">";
		$n++;	
	}
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="./css/main.css?_<?=date("YmdHi")?>">
<style>
</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script src="./js/main.js?_<?=date("YmdHi")?>"></script>
</head>
<body style="text-align:center;background:#303030">
<div class="score">
	<div class="score_top">
	Ranking(<?=$now?>)　　
<span id="lv2" class="score_lv score_lv_on">★★★</span>
<span id="lv1" class="score_lv">★★☆</span>
<span id="lv0" class="score_lv">★☆☆</span>
<span class="score_back"></span>
	</div>

	<table id="tbl_lv0" class="score_table">
		<tr>
			<td class="score_table_ttl">Rank</td>
			<td class="score_table_ttl">Unit</td>
			<td class="score_table_ttl">Date/Name</td>
			<td class="score_table_ttl">Score</td>
			<td class="score_table_ttl"></td>
		</tr>
	<?for($n=1;$n<11;$n++){?>
		<tr>
			<td class="score_table_rank" rowspan="2"><?=$n?></td>
			<td class="score_table_unit" rowspan="2"><?=$rank0[$n]["img"]?></td>
			<td class="score_table_date"><?=$rank0[$n]["date"]?></td>
			<td class="score_table_score" rowspan="2"><span class="score_in"><?=$rank0[$n]["score"]?></span></td>
			<td class="score_table_sns" rowspan="2"></td>
		</tr>
		<tr>
			<td class="score_table_name"><?=$rank0[$n]["name"]?></td>
		</tr>
	<? } ?>
	</table>
	<table id="tbl_lv1" class="score_table">
		<tr>
			<td class="score_table_ttl">Rank</td>
			<td class="score_table_ttl">Unit</td>
			<td class="score_table_ttl">Date/Name</td>
			<td class="score_table_ttl">Score</td>
			<td class="score_table_ttl"></td>
		</tr>
	<?for($n=1;$n<11;$n++){?>
		<tr>
			<td class="score_table_rank" rowspan="2"><?=$n?></td>
			<td class="score_table_unit" rowspan="2"><?=$rank1[$n]["img"]?></td>
			<td class="score_table_date"><?=$rank1[$n]["date"]?></td>
			<td class="score_table_score" rowspan="2"><span class="score_in"><?=$rank1[$n]["score"]?></span></td>
			<td class="score_table_sns" rowspan="2"></td>
		</tr>
		<tr>
			<td class="score_table_name"><?=$rank1[$n]["name"]?></td>
		</tr>
	<? } ?>
	</table>
	<table id="tbl_lv2" class="score_table">
		<tr>
			<td class="score_table_ttl">Rank</td>
			<td class="score_table_ttl">Unit</td>
			<td class="score_table_ttl">Date/Name</td>
			<td class="score_table_ttl">Score</td>
			<td class="score_table_ttl"></td>
		</tr>
	<?for($n=1;$n<11;$n++){?>
		<tr>
			<td class="score_table_rank" rowspan="2"><?=$n?></td>
			<td class="score_table_unit" rowspan="2"><?=$rank2[$n]["img"]?></td>
			<td class="score_table_date"><?=$rank2[$n]["date"]?></td>
			<td class="score_table_score" rowspan="2"><span class="score_in"><?=$rank2[$n]["score"]?></span></td>
			<td class="score_table_sns" rowspan="2"></td>
		</tr>
		<tr>
			<td class="score_table_name"><?=$rank2[$n]["name"]?></td>
		</tr>
	<? } ?>
	</table>
</div>


<div class="thanks">
<span class="thanks_ttl">
Thanks for Your Playing!
</span>
<span class="thanks_tag">H.N.</span> <input type="text" value="名無し王子" name="score_name" class="thanks_name">
<button id="thanks_set" type="button" class="thanks_btn">SET</button>
<button id="thanks_back" type="button" class="thanks_btn">BACK</button>
</div>


</body>
</html>


