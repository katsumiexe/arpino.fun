<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="./css/main.css?_<?=date("YmdHi")?>">
<style>
td{
	border:1px solid #303030;
	height:26px;
	max-height:26px;
	width:50px;
	text-align:center;
}
.tag{
	display:inline-block;
	overflow:hidden;
	max-height:20px;
	line-height:20px;
}
</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script src="./js/main.js?_<?=date("YmdHi")?>"></script>
<script>
$(function(){ 
$('.box').on('click',function(){
	Tmp=$(this).text();
	$('#num').val(Tmp);
});
});
</script>
</head>
<body>
<div class="box">10</div>
<div class="box">11</div>
<div class="box">12</div>
<div class="box">13</div>
<div class="box">14</div>

<input id="num" type="number" value="" class="form-control" name="stage">


</body>
</html>
