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
<body style="text-align:center">
<div class="main">
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
</div>

<div class="page_02">
	<div class="player">
		<div class="player_0 pl1">
			<img src="" id="p1" class="player_a">
			<span id="sub_a" class="get_sub"><?=$check[1]?></span>
			<span id="ring_a" class="get_ring"><?=$check[2]?></span>

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
			<div id="set_a" class="player_c"></div>
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
			<div id="set_b" class="player_c"></div>
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
			<div id="set_c" class="player_c"></div>
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
			<div id="set_d" class="player_c"></div>
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
	</div>

<span id="rest0" class="rest_card"></span>
<span id="rest1" class="rest_card"></span>
<span id="rest2" class="rest_card"></span>
<span id="rest3" class="rest_card"></span>
<span id="rest4" class="rest_card"></span>
<span id="rest5" class="rest_card"></span>
<span id="rest6" class="rest_card"></span>
<span id="rest7" class="rest_card"></span>
<span id="rest8" class="rest_card"></span>
<span id="rest9" class="rest_card"></span>
<span id="rest10" class="rest_card"></span>
<span id="rest11" class="rest_card"></span>
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


<table class="table_res">
<?for($n=0;$n<5;$n++){?>
<tr>
<td class="td_res">
<div id="res_rank<?=$n?>" class="res_a"></div>
<img id="res_img<?=$n?>" src="" class="res_b">

<img id="res_unit<?=$n?>" src="" class="res_c">
<div id="res_name<?=$n?>" class="res_d"></div>
<div id="res_hist<?=$n?>" class="res_e"></div>
<div id="res_pts<?=$n?>" class="res_f"></div>
</td>
</tr>
<?}?>
</table>


<img id="myicon" src="" class="myimg">
<table class="table_b">
	<tr>
		<td class="td_b1">
			<span id="myname" class="p_name">みりあ</span>
			<span id="status_1" class="p_status"><?=$status[1]["name"]?></span>
			<span id="status_2" class="p_status"><?=$status[2]["name"]?></span>
			<span id="status_3" class="p_status"><?=$status[3]["name"]?></span>
			<span id="status_4" class="p_status"><?=$status[4]["name"]?></span>
			<span id="status_5" class="p_status"><?=$status[5]["name"]?></span>
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

</body>
</html>