<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>

.main{
	position:relative;
	width	:77.5vw;
	height	:86.5vw;
}

.ban{
	position			:absolute;
	table-layout		:fixed;
	border-collapse		:collapse;
	border-top			:0.5vw solid #000000;
	border-left			:0.5vw solid #000000;
	border-right		:1vw solid #000000;
	border-bottom		:1vw solid #000000;
	background			:linear-gradient(100deg, #D49E68, #DFB892 40%,#DEB690 100%)
}

.masu{
	border			:0.5vw solid #000000;
	width			:8vw;
	height			:9vw;
}

.koma{
	width	:8vw;
}
</style>
</head>
<body>
<div class="main">
<table class="ban">
<?for($n=1;$n<10;$n++){?>
<tr>
<?for($s=1;$s<10;$s++){?>
<td id="c<?=$s?><?=$n?>" class="masu"></td>
<?}?>
</tr>
<?}?>
</table>
<img src="./img/koma/k<?=$s?>a.png" class="koma">
</div>
</body>
</html>

