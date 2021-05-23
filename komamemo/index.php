<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
.ban{
	table-layout	:fixed;
	border-collapse	:collapse;
	border			:2px solid #000000;
	background		:linear-gradient(90deg, #D49E68, #DFB892 40%,#DEB690,100%)
	
}

.masu{
	border			:1px solid #000000;
	width			:8vw;
	height			:9vw;
}
</style>

</head>

<body>
<table class="ban">
<?for($n=1;$n<10;$n++){?>
<tr>
<?for($s=1;$s<10;$s++){?>
<td id="c<?=$s?><?=$n?>" class="masu"></td>
<?}?>
</tr>
<?}?>
</table>
</body>
</html>
