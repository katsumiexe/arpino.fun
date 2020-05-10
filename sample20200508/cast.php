<?
include_once("./library/session.php");


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
<div class="box">


</div>
</body>
</html>




