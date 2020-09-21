<?php
include_once("./library/session.php");

$item[11]="";
$item[10]="";
$item[9]="";

$item[8]="";
$item[7]="";
$item[6]="";

$item[5]="";
$item[4]="";
$item[3]="";

$item[2]="";
$item[1]="";
$item[0]="";

$check[1]="";
$check[2]="";

$card[1]="";

$pts["1"]=2;
foreach($pts as $a1 => $a2){
	if($a2 != $tmp_a2){
		$order++;
	}
	$result=floor($a2+0);

	$app.="<table class=\"table_res\">";
	$app.="<tr><td class=\"td_res\">";
	$app.="<div class=\"res_a{$order}\">{$order}</div>";

	$app.="<img src=\"./img/chr/chr{$persona[$a1]}.jpg\" class=\"res_b\">";
	$app.="<img src=\"./img/unit/unit_{$doll[$a1]}.png\" class=\"res_c\">";
	$app.="<div class=\"res_d\">{$unit[$a1]}</div>";

	$app.="<table class=\"res_e\">";
	$app.="<tr>";
	for($d=0;$d<6;$d++){
		if($get[$a1][$d]>0){
			$app.="<td class=\"res_e_1\">{$get[$a1][$d]}</td>";

		}elseif($get[$a1][$d]<0){
			$app.="<td class=\"res_e_2\">{$get[$a1][$d]}</td>";

		}else{
			$app.="<td class=\"res_e_3\">0</td>";
		}
	}

	$app.="</tr><tr>";
	for($d=6;$d<12;$d++){
		if($get[$a1][$d]>0){
			$app.="<td class=\"res_e_1\">{$get[$a1][$d]}</td>";

		}elseif($get[$a1][$d]<0){
			$app.="<td class=\"res_e_2\">{$get[$a1][$d]}</td>";

		}else{
			$app.="<td class=\"res_e_3\">0</td>";
		}
	}
	$app.="</table>";
	$app.="<div class=\"res_f\">{$result}</div>";
	$app.="</td></tr>";
	$app.="</table>";
	$tmp_pts=$a2;
}

$base_date=date("Y-m-01 00:00:00");
$now=date("Y/m");
$n=1;
$sql	 ="SELECT * FROM score_data";
$sql	.=" WHERE date>='{$base_date}'";
$sql	.=" AND level='0'";
$sql	.=" ORDER BY score DESC, date DESC";
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
<title>Card_Game_Aigis</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="カードゲームオンライン">


<meta charset="UTF-8">
<link rel="stylesheet" href="./css/main.css?_<?=date("YmdHi")?>">
<style>
</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script src="./js/main.js?_<?=date("YmdHi")?>"></script>
<script src="./js/pvp.js?_<?=date("YmdHi")?>"></script>
<script>
</script>

</head>
<body style="text-align:center;background:#888888">

<div class="page_02">
	<div class="player">
		<div class="player_0 pl1">
			<img src="" id="p1" class="player_a">
			<span id="sub_a" class="get_sub"><?=$check[1]?></span>
			<span id="ring_a" class="get_ring"><?=$check[2]?></span>

			<div class="player_b pc1">
				<span class="get_icon"><?=$card[1]?></span>
				<span id="count_a" class="get_count">0</span>
			</div>
			<div id="down_a" class="player_d">▼</div>
		</div>
		<div class="player_0 pl2">
			<img src="" id="p2" class="player_a">
			<span id="sub_b" class="get_sub"><?=$check[1]?></span>
			<span id="ring_b" class="get_ring"><?=$check[2]?></span>
			<div class="player_b pc2">
				<span class="get_icon"><?=$card[1]?></span>
				<span id="count_b" class="get_count">0</span>
			</div>
			<div id="down_b" class="player_d">▼</div>
		</div>
		<div class="player_0 pl3">
			<img src="" id="p3" class="player_a">
			<span id="sub_c" class="get_sub"><?=$check[1]?></span>
			<span id="ring_c" class="get_ring"><?=$check[2]?></span>
			<div class="player_b pc3">
				<span class="get_icon"><?=$card[1]?></span>
				<span id="count_c" class="get_count">0</span>
			</div>
			<div id="down_c" class="player_d">▼</div>
		</div>
		<div class="player_0 pl4">
			<img src="" id="p4" class="player_a">
			<span id="sub_d" class="get_sub"><?=$check[1]?></span>
			<span id="ring_d" class="get_ring"><?=$check[2]?></span>
			<div class="player_b pc4">
				<span class="get_icon"><?=$card[1]?></span>
				<span id="count_d" class="get_count">0</span>
			</div>
			<div id="down_d" class="player_d">▼</div>
		</div>
		<div class="player_0 pl5">
			<div class="turn">TURN</div>
			<div class="turn_count">0</div>
		</div>

		<div id="set_a" class="player_c"></div>
		<div id="down_a1" class="player_e">
			<?for($s=11;$s>-1;$s--){?>
			<div class="player_f fa f<?=$s?>"><?=$item[$s]?></div>
			<?}?>
		</div>

		<div id="set_b" class="player_c"></div>
		<div id="down_b1" class="player_e">
			<?for($s=11;$s>-1;$s--){?>
			<div class="player_f fb f<?=$s?>"><?=$item[$s]?></div>
			<?}?>
		</div>

		<div id="set_c" class="player_c"></div>
		<div id="down_c1" class="player_e">
			<?for($s=11;$s>-1;$s--){?>
			<div class="player_f fc f<?=$s?>"><?=$item[$s]?></div>
			<?}?>
		</div>

		<div id="set_d" class="player_c"></div>
		<div id="down_d1" class="player_e">
			<?for($s=11;$s>-1;$s--){?>
			<div class="player_f fd f<?=$s?>"><?=$item[$s]?></div>
			<?}?>
		</div>

		<?for($n=0;$n<12;$n++){?>
			<span id="rest<?=$n?>" class="rest_card"></span>
		<?}?>

		<div class="guard3"></div>
		<div class="turn_start_main">START</div>
		<div class="main_card"></div>
	</div>

	<table class="table_a">
		<tr>
			<td class="td_a">
				<span class="get_icon"><?=$card[1]?></span>
				<span id="count_p" class="get_count">0</span>
			</td>
			<td class="td_a">
				<span class="get_icon2"></span>
				<span id="pts_p" class="get_count">0</span>
			</td>
			<td class="td_a">
				<span id="sub_p" class="a_sub"><?=$check[1]?></span>
				<span id="ring_p" class="a_ring"><?=$check[2]?></span>
			</td>
		</tr>
	</table>

	<div class="last_res"></div>
	<img id="myicon" src="" class="myimg">
	<table class="table_b">
		<tr>
			<td class="td_b1">
				<span id="myname" class="p_name">みりあ</span><?for($n=1;$n<6;$n++){?><span id="status_<?=$n?>" class="p_status"><?=$status[$n]["name"]?></span><?}?>
			</td>
		</tr>
		<tr>
			<td class="td_b2">
				<div class="guard"></div>
				<?for($s=11;$s>-1;$s--){?>
				<span id="p_i<?=$s?>" class="p_pts pvp_pts_on"><?=$item[$s]?></span>
				<?}?>
			</td>
		</tr>
	</table>
</div>
</div>

<div class="pop_back">
	<div class="pop_a">
		<img src="" class="pop_a_1">
		<div class="pop_a_2">みりあ</div>
		<span class="pop_a_3"></span>
		<div id="reset" class="btn c1">取消</div> 
		<div id="start" class="btn c2">選択</div>
	</div>
</div>

<div class="talk_box">
<div id="talk0" class="talk_detail">こんにちは</div>
<div id="talk1" class="talk_detail">よろしく！</div>
<div id="talk2" class="talk_detail">ナイス！</div>
<div id="talk3" class="talk_detail">泣...</div>
<div id="talk4" class="talk_detail">おりゅ？</div>
<div id="talk5" class="talk_detail">m(_ _)m</div>
<div id="talk6" class="talk_detail">(*ﾟ▽ﾟ)ﾉ</div>
<div id="talk7" class="talk_detail">>ლ(ಠ益ಠ)ლ</div>
<div id="talk8" class="talk_detail"></div>
<div id="talk9" class="talk_detail">ヽ(`Д´)ﾉ</div>
<div id="talk10" class="talk_detail">(;ﾟДﾟ)!</div>
<div id="talk11" class="talk_detail">( >д<).;</div>


<form id="reset_top" action="./index.php" method="post">
</form>

</body>
</html>