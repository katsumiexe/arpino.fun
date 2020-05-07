<?
$list=array('名前', 'りんご', 'みかん', 'ぶどう', 'なし', 'もも');
$shop[0]=array('山田商店', '1', '1', '0', '1', '0');
$shop[1]=array('田中商店', '1', '1', '1', '0', '0');
$shop[2]=array('佐藤商店', '1', '1', '0', '1', '1');
$shop[3]=array('高橋商店', '0', '1', '1', '1', '0');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<script src="../onlyme/js/jquery-3.2.1.min.js"></script>
<script>
$(function(){ 

var AllCnt=<?=count($list)-1?>;
var NowCnt=<?=count($list)-1?>;

	$('.tag_a').on('click', function() {
		if($(this).hasClass("tag_b")){
			$(this).removeClass("tag_b");
			NowCnt--;
		}else{
			$(this).addClass("tag_b");
			NowCnt++;
		}		

//	for(var j1 in User){

		$('.box').hide();
		Tmp = $(this).attr('id');
		$('.'+Tmp).fadeIn();

		$('#max_cnt').text(AllCnt);
		$('#now_cnt').text(NowCnt);

	});


});

</script>
<style>
.cont{
	display:flex;
	align-items: flex-start;
	flex-wrap:wrap;
	width:900px;
}

.name{
	display:inline-block;
	flex-basis:200px;
	width:200px;
	background:#f0f000;
	text-align:center;
	height:30px;
	line-height:30px;
}

.box{
	flex-basis:100px;
	display:inline-flex;
	align-items: flex-start;
	flex-wrap:wrap;
	height:100px;
	line-height:30px;
	padding:0;
	margin:3px;
	border:1px solid #606060;
}

.tag_a{
	width:100px;
	display:inlinebox;
	height:30px;
	line-height:30px;
	padding:0;
	margin:3px;
	border:1px solid #000000;
	test-align:center;
}

.item{
	display:inline-block;
	flex-basis:24%;
	border:1px solid #000000;
	height:30px;
	line-height:30px;
	text-align:center;
	background:#f0f0f0;
}

.tag_b{
	background:#fff0f0 !important;
	color:#ff0000 !important;
}

</style>
<body>
<div class="cnt">
<span id="now_cnt"><?=count($list)-1?></span>/<span id="max_cnt"><?=count($list)-1?></span>
</div>

<div class="cont">
	<?for($n=1;$n<count($list);$n++){?>
		<span id="set<?=$n?>1" class="tag_a tag_b"><?=$list[$n]?></span>
	<?}?>
</div>

<div class="cont">
	<?for($s=0;$s<count($shop);$s++){?>
		<div class="box <?for($r1;$r<count($list);$r++){?> set<?=$r?><?=$shop[$s][$r]?><?}?>">
			<span class="name"><?=$shop[$s][0]?></span>
			<?for($p=1;$p<count($list);$p++){?>
				<?if($shop[$s][$p] == 1){?><span class="item"><?=$list[$p]?></span><?}?>
			<?}?>
		</div>
	<?}?>
</div>
</body>
</html>




