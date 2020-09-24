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
var Id=0;
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
			$('#pvp_'+data.sort).children('img').attr('src','./img/unit/unit_'+data.unit+'.png');
			$('#pvp_'+data.sort).children('.pvp_member_name').text(data.name);
			$('#cnt').val(data.face);
			$('#myid').val(data.tmp_auto);
			$('.sel_table,.sel_td').fadeOut(300);
		});
	});



	$('.pvp_remove').on('click',function(){
		$.post({
			url:'post_pvp_remove.php',
			dataType: 'json',
			data:{
				'myid':$('#myid').val(),
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('#host').val(data[0].id);
			$('#cnt').val(data.length+1);
			$('#myid').val('');
			$('.sel_table').show();

			for(i=0;i<5;i++){
				if(data.length>i){
					$('#pvp_'+i).addClass('pvp_member_in0');
					$('#pvp_'+i).children('img').attr('src',data[i].img);
					$('#pvp_'+i).children('.pvp_member_name').text(data[i].name);
				}else{
					$('#pvp_'+i).removeClass('pvp_member_in0');
					$('#pvp_'+i).children('img').attr('src','./img/chr/chr0.png');
					$('#pvp_'+i).children('.pvp_member_name').text('');
				}
			}
		});
	});

/*
    setInterval(function(){
		$.post({
			url:'post_pvp_auto.php',
			data:{
				'myid':$('#myid').val(),
			},
			dataType: 'json',
		}).done(function(data, textStatus, jqXHR){
			console.log(data);

			for(i=0;i<5;i++){
				if(data.length>i){
					$('#pvp_'+i).addClass('pvp_member_in0');
					$('#pvp_'+i).children('img').attr('src',data[i].img);
					$('#pvp_'+i).children('.pvp_member_name').text(data[i].name);
					$('#cnt').val(i+1);
				}else{
					$('#pvp_'+i).removeClass('pvp_member_in0');
					$('#pvp_'+i).children('img').attr('src','./img/chr/chr0.png');
					$('#pvp_'+i).children('.pvp_member_name').text('');
				}
			}
		});

		Id +=1;
		if(Id>9) Id=0; 
		$('#count').text(Id);
    },10000);
*/

});
</script>
</head>

<body style="text-align:center;background:#888888">
<div class="main">
	<input id="cnt" type="hidden" value="<?=count($dat)?>">
	<input id="host" type="hidden" value="<?=$host?>">
	<input id="myid" type="hidden" value="">
	<div class="pvp_ttl">
		<span>婚活戦争Aigis</span><span id="count"></span><span class="pvp_remove">■</span>
	</div>
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
	<ul class="pvp_member">
		<?for($n=0;$n<5;$n++){?>
		<li id="pvp_<?=$n?>" class="pvp_member_in pvp_member_in<?=$dat[$n]["turn"]?>">
			<img src="./img/chr/chr<?=$dat[$n]["face"]?>.png" class="pvp_member_img">
			<span class="pvp_member_name"><?=$dat[$n]["name"]?></span>
			<span class="pvp_member_comm"><?=$dat[$n]["comm"]?></span>
		</li>
		<? } ?>
	</ul>
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