<?
$dat=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FONT_DEMO</title>
<style>
@font-face {
	font-family: at_border1;
	src: url(./font/border/bordc1__.ttf) format('truetype');
}

@font-face {
	font-family: at_border2;
	src: url(./font/border/bordc___.ttf) format('truetype');
}

@font-face {
	font-family: at_cat;
	src: url(./font/border/tenderkittens.ttf) format('truetype');
}

.icon{
	display			:inline-block;
	height			:100px;
	width			:100px;
	line-height		:100px;
	border			:1px solid #303030;
	background		:#fafafa;
	font-size		:60px;
	color			:#303030;
	text-align		:center;
}

.b1{
	font-family		:at_border1;
}
.b2{
	font-family		:at_border2;
}
.b3{
	font-family		:at_cat;
}

</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script>
</script>
</head>
<body style="text-align:center;background:#303030">
<div>
<table>
<?for($n=0;$n<26;$n++){?>
<tr>
<td class="icon"><?=$dat[$n]?></td>
<td class="icon b1"><?=$dat[$n]?></td>
<td class="icon b2"><?=$dat[$n]?></td>
<td class="icon b3"><?=$dat[$n]?></td>

<td class="icon"><?=mb_strtolower($dat[$n])?></td>
<td class="icon b1"><?=mb_strtolower($dat[$n])?></td>
<td class="icon b2"><?=mb_strtolower($dat[$n])?></td>
<td class="icon b3"><?=mb_strtolower($dat[$n])?></td>
</tr>
<? } ?>
</table>

</div>
</body>
</html>


