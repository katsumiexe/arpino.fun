<?php
include_once("./library/session.php");

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
<title>婚活戦争Aigis PVP</title>
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

<input type="text" value="" name="pvp_name"><button type="button" value="">●</button>
<table class="pvp_table">
<tr>
<td class="pvp_td_face"></td>
<td class="pvp_td_main"></td>
</tr>
</table>

<button type="button" value="">落ち</button>
<div class="pvp_gate_msg">5人揃い次第自動スタートします</div>

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