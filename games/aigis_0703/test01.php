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
$(".btn").on('click',function(){
	$('.box').animate({"width":"toggle"},100);
});
});
</script>
</head>
<body>
<button type="button" class="btn">BUTTON</button>

<table style="border:1px solid #303030;">
<tr>
<td>商品</td>
<td>価格</td>
<td class="box"><span class="tag">送料</span></td>
<td class="box"><span class="tag">消費税</span></td>
</tr>

<tr>
<td>みかん</td>
<td>200</td>
<td class="box"><span class="tag">100</span></td>
<td class="box"><span class="tag">20</span></td>
</tr>
<tr>
<td>りんご</td>
<td>500</td>
<td class="box"><span class="tag">150</span></td>
<td class="box"><span class="tag">50</span></td>
</tr>
</table>
</body>
</html>
