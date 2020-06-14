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

$check[1]="";
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
<script>
</script>
</head>
<body style="text-align:center;background:#303030">
<div class="main">

<div class="page_00">
	<div class="first_play">
		<div class="first_play_ttl">
			<span>アイギスカードゲーム(仮)</span>
		</div>
		<div id="lv0" class="first_play_level">
			<span class="first_icon"></span>
			<span class="first_comm">★☆☆</span>
			<span class="first_comm">-easy-</span>
		</div>
		<div id="lv1" class="first_play_level">
			<span class="first_icon"></span>
			<span class="first_comm">★★☆</span>
			<span class="first_comm">-normal-</span>
		</div>
		<div id="lv2" class="first_play_level">
			<span class="first_icon"></span>
			<span class="first_comm">★★★</span>
			<span class="first_comm">-ONI!-</span>
		</div>
		<div id="lv4" class="first_play_level">
			<span class="first_icon"></span>
			<span class="first_comm">ランキング</span>
			<span class="first_comm">-Ranking-</span>
		</div>
		<div id="lv5" class="first_play_level">
			<span class="first_icon"></span>
			<span class="first_comm">遊び方</span>
			<span class="first_comm">-Howto-</span>
		</div>
		<div id="lv6" class="first_play_level">
			<span class="first_icon"></span>
			<span class="first_comm">問合せ</span>
			<span class="first_comm">-AskMe-</span>
		</div>
		<div class="first_play_btm">
			作った人:Katsumi　<a href="https://twitter.com/serra_geddon" class="icon_twitter"></a>
		</div>
	</div>
</div>

<div class="page_01">
<?for($e=1;$e<11;$e++){?>
	<div id="s<?=$e?>" class="sel">
	<img src="./img/unit/unit_<?=$e?>.png" class="sel_a">
	<span class="sel_b">
	<span class="sel_b_1 <?if($unit[$e]["status_1"]==1){?>sel_on<?}?>"><?=$status[1]["name"]?></span>
	<span class="sel_b_1 <?if($unit[$e]["status_2"]==1){?>sel_on<?}?>"><?=$status[2]["name"]?></span>
	<span class="sel_b_1 <?if($unit[$e]["status_3"]==1){?>sel_on<?}?>"><?=$status[3]["name"]?></span>
	<span class="sel_b_1 <?if($unit[$e]["status_4"]==1){?>sel_on<?}?>"><?=$status[4]["name"]?></span>
	<span class="sel_b_1 <?if($unit[$e]["status_5"]==1){?>sel_on<?}?>"><?=$status[5]["name"]?></span>
	</span>
	<span class="sel_c"><?=$unit[$e]["name"]?></span>
	</div>
<?}?>
<a href="https://twitter.com/serra_geddon" class="icon_twitter"></a>
<a href="./post.php" class="icon_mail"></a>
</div>
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
			<div class="player_f fa f11"></div>
			<div class="player_f fa f10"></div>
			<div class="player_f fa f9"></div>
			<div class="player_f fa f8"></div>
			<div class="player_f fa f7"></div>
			<div class="player_f fa f6"></div>
			<div class="player_f fa f5"></div>
			<div class="player_f fa f4"></div>
			<div class="player_f fa f3"></div>
			<div class="player_f fa f2"></div>
			<div class="player_f fa f1"></div>
			<div class="player_f fa f0"></div>
		</div>

		<div id="set_b" class="player_c"></div>
		<div id="down_b1" class="player_e">
			<div class="player_f fb f11"></div>
			<div class="player_f fb f10"></div>
			<div class="player_f fb f9"></div>
			<div class="player_f fb f8"></div>
			<div class="player_f fb f7"></div>
			<div class="player_f fb f6"></div>
			<div class="player_f fb f5"></div>
			<div class="player_f fb f4"></div>
			<div class="player_f fb f3"></div>
			<div class="player_f fb f2"></div>
			<div class="player_f fb f1"></div>
			<div class="player_f fb f0"></div>
		</div>

		<div id="set_c" class="player_c"></div>
		<div id="down_c1" class="player_e">
			<div class="player_f fc f11"></div>
			<div class="player_f fc f10"></div>
			<div class="player_f fc f9"></div>
			<div class="player_f fc f8"></div>
			<div class="player_f fc f7"></div>
			<div class="player_f fc f6"></div>
			<div class="player_f fc f5"></div>
			<div class="player_f fc f4"></div>
			<div class="player_f fc f3"></div>
			<div class="player_f fc f2"></div>
			<div class="player_f fc f1"></div>
			<div class="player_f fc f0"></div>
		</div>

		<div id="set_d" class="player_c"></div>
		<div id="down_d1" class="player_e">
			<div class="player_f fd f11"></div>
			<div class="player_f fd f10"></div>
			<div class="player_f fd f9"></div>
			<div class="player_f fd f8"></div>
			<div class="player_f fd f7"></div>
			<div class="player_f fd f6"></div>
			<div class="player_f fd f5"></div>
			<div class="player_f fd f4"></div>
			<div class="player_f fd f3"></div>
			<div class="player_f fd f2"></div>
			<div class="player_f fd f1"></div>
			<div class="player_f fd f0"></div>
		</div>
	</div>

<?for($n=0;$n<12;$n++){?>
<span id="rest<?=$n?>" class="rest_card"></span>
<?}?>

<div class="guard3"></div>
<div class="turn_start_main">START</div>
<div class="main_card"></div>
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
			<span id="i<?=$s?>" class="p_pts p_pts_on"><?=$item[$s]?></span>
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

<div class="score">
	<div class="score_top">
	Ranking(<?=$now?>)　　
<span id="s_lv2" class="score_lv score_lv_on">★★★</span>
<span id="s_lv1" class="score_lv">★★☆</span>
<span id="s_lv0" class="score_lv">★☆☆</span>
<span class="score_back"></span>
	</div>

	<table id="tbl_lv0" class="score_table">
		<tr>
			<td class="score_table_ttl">Rank</td>
			<td class="score_table_ttl">Unit</td>
			<td class="score_table_ttl">Date/Name</td>
			<td class="score_table_ttl">Score</td>
		</tr>
	<?for($n=1;$n<11;$n++){?>
		<tr>
			<td class="score_table_rank" rowspan="2"><?=$n?></td>
			<td class="score_table_unit" rowspan="2"><?=$rank0[$n]["img"]?></td>
			<td class="score_table_date"><?=$rank0[$n]["date"]?></td>
			<td class="score_table_score" rowspan="2"><?=$rank0[$n]["score"]?></td>
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
		</tr>
	<?for($n=1;$n<11;$n++){?>
		<tr>
			<td class="score_table_rank" rowspan="2"><?=$n?></td>
			<td class="score_table_unit" rowspan="2"><?=$rank1[$n]["img"]?></td>
			<td class="score_table_date"><?=$rank1[$n]["date"]?></td>
			<td class="score_table_score" rowspan="2"><?=$rank1[$n]["score"]?></td>
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
		</tr>
	<?for($n=1;$n<11;$n++){?>
		<tr>
			<td class="score_table_rank" rowspan="2"><?=$n?></td>
			<td class="score_table_unit" rowspan="2"><?=$rank2[$n]["img"]?></td>
			<td class="score_table_date"><?=$rank2[$n]["date"]?></td>
			<td class="score_table_score" rowspan="2"><?=$rank2[$n]["score"]?></td>
		</tr>
		<tr>
			<td class="score_table_name"><?=$rank2[$n]["name"]?></td>
		</tr>
	<? } ?>
	</table>
</div>


<div class="howto">
	<div class="howto_page">
		<span class="howto_back"></span>
		<span id="ibox0" class="howto_page_tag">準備</span>
		<span id="ibox1" class="howto_page_tag">進行</span>

		<span id="ibox2" class="howto_page_tag">ユニット</span>
		<span id="ibox3" class="howto_page_tag">アイテム</span>
		<span id="ibox4" class="howto_page_tag">魅力</span>

		<span id="ibox5" class="howto_page_ttl">カード種類</span>

	</div>

	<div class="howto_main">
		<div id="box0" class="howto_in" style="display:block;">
			<div class="howto_title">準備</div>
			各プレイヤーに1枚、<span style="color:#a04030">『ユニットカード』</span>を裏向きで1枚配ります。<bR>
			配られた<span style="color:#a04030">『ユニットカード』</span>は見ることが可能ですが、他のプレイヤーにはゲーム終了まで見せないようにしてください。<br>
			<span style="color:#a04030">『アイテムカード』</span>を各1枚づつ、計12枚を各プレイヤーに配ります。<bR>
			<span style="color:#a04030">『魅力カード』</span>をシャッフルし、裏向けに置いてゲームスタートです。<br>
		</div>
		
		<div id="box1" class="howto_in">
			<div class="howto_title">進行</div>
			ターンのはじめに<span style="color:#a04030">『魅力カード』</span>が一枚提示されます。<br>
			各プレイヤーはそれぞれ<span style="color:#a04030">『アイテムカード』</span>を一枚捧げます。<br>
			このときに、最も価値の高いものを出した人が<span style="color:#a04030">『魅力カード』</span>を獲得できます。<br>
			ただし、同じ<span style="color:#a04030">『アイテムカード』</span>を出した人がいた場合はブッキングとなり、対象は次に高い人になります。<br>
			全員がブッキングした場合、その魅力はだれも受け取ることが出来ません。<br>
			一度使った<span style="color:#a04030">『アイテムカード』</span>は再度使うことはできません。<br>
			これを12ターン行い、【魅力ポイント】が最も高いプレイヤーの勝利です。<br>
			<br>
			同点の場合は、<br>
			▼「副官任命」を持っているユニット<br>
			▼「リング」を持っているユニット<br>
			の順に順位がつけられます。<br>
			それでも同じ場合は、同点となります。
		</div>

		<div id="box2" class="howto_in">
			<div class="howto_title">ユニットカード（10種類）</div>
			王子を慕う10人の女性ユニットです。<br>
			各プレイヤーはスタート時に1枚選択します。<br>
			各ユニットは『巨乳』『幼女』『知的』『清楚』『天使』の5つのチャームポイントのうち、2つを有しています。<br>
			他のプレイヤーがどのユニットを選択したかは、ゲーム終了までわかりません。<br>
		</div>

		<div id="box3" class="howto_in">
			<div class="howto_title">アイテムカード（12種類）</div>
			王子から頂いたプレゼントでこれを捧げることで、<span style="color:#a04030">【魅力ポイント】</span>を獲得することができます。<br>
			スタート時は各1つづつ、計12個を所持しています。<br>
			アイテムの価値は<br>
			<span class="howto_item"></span>ダイヤ3<br>
			<span class="howto_item"></span>ダイヤ2<br>
			<span class="howto_item"></span>ダイヤ1<br>
			<span class="howto_item"></span>ルビー3<br>
			<span class="howto_item"></span>ルビー2<br>
			<span class="howto_item"></span>ルビー1<br>
			<span class="howto_item"></span>パール3<br>
			<span class="howto_item"></span>パール2<br>
			<span class="howto_item"></span>パール1<br>
			<span class="howto_item"></span>花束3<br>
			<span class="howto_item"></span>花束2<br>
			<span class="howto_item"></span>花束1<br>
			の順となります。<br>
		</div>


		<div id="box4" class="howto_in">
			<div class="howto_title">魅力カード（12種類）</div>
			『魅力カード』には、それぞれ【魅力ポイント】が設定されており、それを他のプレイヤーより多く獲得することが目的となります。<br>
			選んだ<span style="color:#a04030">『ユニットカード』</span>が持つチャームポイントによって、獲得ポイントが変わるものもあります。<br>
			<br>
			▼副官任命（1枚）<br>
			魅力ポイント+3<br>
			<br>
			▼リング（1枚）<br>
			魅力ポイント+2<br>
			<br>
			▼ボーナスカード（5枚）<br>
			魅力ポイント+1、対象の魅力を所持しているユニットだと+3となります。<br>
			<br>
			▼アンチカード（5枚）<br>
			魅力ポイント+2、対象の魅力を所持しているユニットだと逆効果となり-2となります。<br>
		</div>
	</div>
</div>

</body>
</html>