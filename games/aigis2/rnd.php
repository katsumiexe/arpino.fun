<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<script src="./js/jquery-3.2.1.min.js"></script>
<script>
var Res=['一等賞','二等賞','三等賞','参加賞','ハズレ'];
var Done=0;
$(function(){ 
	$('.box_1').on('click',function(){
		if(Done ==0){
			var rnd = Math.floor(Math.random()* 5);
			$(this).text(Res[rnd]);
			Done=1;
		}
	});
	$('.box_2').on('click',function(){
		Done=0;
		$('#b1').text('箱1');
		$('#b2').text('箱2');
		$('#b3').text('箱3');
	});
});
</script>
<style>.box_1,.box_2{
	display:inline-block;
	width:100px;
	height:50px;
	line-height:50px;
	margin:10px;
	text-align:center;
	cursor:pointer;
	border:1px solid #303030;
	background:#fafafa;
}

.box_2{
	background:#202020;
	color:#fafafa;
}


</style>

</head>
<body>
<div id="b1" class="box_1">箱1</div>
<div id="b2" class="box_1">箱2</div>
<div id="b3" class="box_1">箱3</div>
<div id="b4" class="box_2">RESET</div>


</body></html>
