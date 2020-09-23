<?php
include_once("./library/session.php");

$sql	 ="SELECT id, `date`, sort,	name,face,turn FROM pvp_data";
$sql	.=" WHERE turn='0'";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 5";

if($res0 = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($res0)){
		$dat[]=$row0;
	}
}
$host=$dat[0]["id"]+0;
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
<script>
$(function(){ 
	$('.pvp_btn').on('click',function(){
		$('.sel_td,.page_01_guide').show();
	});
	$('.sel_td').on('click',function(){
		$.post({
			url:'post_pvp_start.php',
			dataType: 'json',
			data:{
				'host':$('#host').val(),
				'sort':$('#cnt').val(),
				'unit':$(this).attr('id'),
				'name':$('.pvp_name').val(),
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('#pvp_'+data.sort).addClass('pvp_member_in0');
			$('#pvp_'+data.sort).children('img').attr('src','./img/chr/chr'+data.face+'.png');
			$('#pvp_'+data.sort).children('.pvp_member_name').text(data.name);
			$('#cnt').val(data.face);
			$('#myid').val(data.tmp_auto);
			$('.sel_table').fadeOut(300);

		});
	});
});
</script>
</head>

<body style="text-align:center;background:#888888">
<div class="main">
	<input id="cnt" type="hidden" value="<?=count($dat)?>">
	<input id="host" type="hidden" value="<?=$host?>">
	<input id="myid" type="hidden" value="">
	<div class="pvp_ttl">
		<span>婚活戦争Aigis</span>
	</div>
	<ul class="pvp_member">
		<?for($n=0;$n<5;$n++){?>
		<li id="pvp_<?=$n?>" class="pvp_member_in<?=$dat[$n]["turn"]?>">
			<img src="./img/chr/chr<?=$dat[$n]["face"]?>.png" class="pvp_member_img">
			<span class="pvp_member_name"><?=$dat[$n]["name"]?></span>
			<span class="pvp_member_comm"><?=$dat[$n]["comm"]?></span>
		</li>
		<? } ?>
	</ul>
	<table class="sel_table">
	<tr>
		<td colspan="2" class="pvp_box">
			<span class="pvp_tag">Handle</span>
			<input type="text" value="名無し王子" name="pvp_name" class="pvp_name">
			<button type="button" value="" class="pvp_btn">●</button><br>
		</td>
		<?for($e=1;$e<11;$e++){?>
		<?if($e % 2 == 1){?>
		</tr><tr>
		<? } ?>
		<td id="s<?=$e?>" class="sel_td">				
			<img src="./img/unit/unit_<?=$e?>.png" class="sel_a">
			<div class="sel_b">
			<span class="sel_b_1 <?if($unit[$e]["status_1"]==1){?>sel_on<?}?>"><?=$status[1]["name"]?></span>
			<span class="sel_b_1 <?if($unit[$e]["status_2"]==1){?>sel_on<?}?>"><?=$status[2]["name"]?></span>
			<span class="sel_b_1 <?if($unit[$e]["status_3"]==1){?>sel_on<?}?>"><?=$status[3]["name"]?></span>
			<span class="sel_b_1 <?if($unit[$e]["status_4"]==1){?>sel_on<?}?>"><?=$status[4]["name"]?></span>
			<span class="sel_b_1 <?if($unit[$e]["status_5"]==1){?>sel_on<?}?>"><?=$status[5]["name"]?></span>
			</div>
			<span class="sel_c"><?=$unit[$e]["name"]?></span>
			</div>
		<?}?>
		</tr>
		<tr>
			<td class="page_01_guide" colspan="2">
				お好きなユニットを一つ選んでください。
			</td>
		</tr>
	</table>
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