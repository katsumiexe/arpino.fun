<?php
include_once('./library/sql.php');

$sql="SELECT * FROM komamemo_base";

if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){
		$base[$res["id"]]=$res;
	}
}


$sql="SELECT * FROM komamemo_log WHERE host='2' ORDER BY id DESC LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
<script src="./js/main.js?t=<?=time()?>"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/style.css?t=<?=time()?>">
<style>

.body{
	text-align			:center;
	margin				:0;
	padding				:0;
	line-height			:1.2;
	color				:#333;
	font-size			:0;
	font-family			:"Hiragino Kaku Gothic ProN","Hiragino Sans",Meiryo,sans-serif;
	text-align			:center;
	width				:100vw;
}
.main{

}


.ban{
	display:block;
	position:relative;
	width	:77vw;
	height	:86vw;
	background			:linear-gradient(100deg, #D49E68, #DFB892 40%,#DEB690 100%);
	background:#000000;
}

.masu{
	position		:absolute;
	display			:block;
	width			:8vw;
	height			:9vw;
	background			:linear-gradient(100deg, #D49E68, #DFB892 40%,#DEB690 100%);
}

.koma{
	display			:inline-block;
	position		:absolute;
	width			:8vw;
	height			:9vw;
	overflow		:hidden;
}

.koma_on{
	background:rgba(200,100,100,0.5);
}

.koma_img{
	position		:absolute;
	top				:0;
	left			:0;
	right			:0;
	bottom			:0;
	margin			:auto;
	width			:8vw;
}

.koma_img_r{
	width			:6vw;
}

.m_koma{
	display			:inline-block;
	position		:relative;
	width			:8vw;
	height			:7vw;
	margin-bottom	:1.5vw;
	text-align		:left;
}

.m_koma_c{
	position		:absolute;
	bottom			:0;
	right			:0;
	display			:inline-block;
	width			:4.5vw;
	height			:4.5vw;
	line-height		:4.5vw;
	text-align		:center;
	border-radius	:2vw;
	color			:#fafafa;
	font-weight		:600;
	background		:rgba(120,40,60,0.6);
	font-size		:3vw;

}

<?for($e=1;$e<10;$e++){?>
<?$e1=69.5-8.5*($e-1);?>
.c<?=$e?>{left:<?=$e1?>vw;}
<?}?>

<?for($e=1;$e<10;$e++){?>
<?$e1=0.5+9.5*($e-1);?>
.l<?=$e?>{top:<?=$e1?>vw;}
<?}?>

.u2{
	transform:rotate(180deg);
}

td{
	padding	:0;

}
.waku{
	margin: 0 auto;
	border-collapse: collapse;
	border-spacing: 0px;
	font-size:0;
	padding:0;
}

.waku_top,.waku_bottom{
	height:8vw;
	background:#ff0000;
}

.waku_left,.waku_right{
	width		:8vw;
	background	:#ff00ff;
	position	:relative;
}

.waku_left{
	vertical-align:top;
}

.waku_right{
	vertical-align:bottom;
}

.waku_column{
	height		:4vw;
	line-height	:5vw;
	font-size	:3vw;
	font-weight	:600;
	color		:#303030;
	background	:#D49E68;
}

.waku_line{
	width		:4vw;
	font-size	:3vw;
	font-weight	:600;
	color		:#303030;
	background	:#D49E68;
	text-align	:center;
}

.waku_main{
	width	:77vw;
	height	:86vw;
}

</style>
</head>
<body class="body">
<div class="main">
<table class="waku">
<tr>
<td class="waku_top" colspan="13"></td>
</tr>
<tr>
	<td class="waku_left" rowspan="10">
		<span class="m_koma"><img src="koma/k91.png" class="koma_img_r u2"><span class="m_koma_c">6</span></span>
		<span class="m_koma"><img src="koma/k81.png" class="koma_img_r u2"></span>
		<span class="m_koma"><img src="koma/k71.png" class="koma_img_r u2"><span class="m_koma_c">2</span></span>
		<span class="m_koma"><img src="koma/k61.png" class="koma_img_r u2"></span>
		<span class="m_koma"><img src="koma/k51.png" class="koma_img_r u2"></span>
		<span class="m_koma"><img src="koma/k41.png" class="koma_img_r u2"></span>
		<span class="m_koma"><img src="koma/k31.png" class="koma_img_r u2"></span>
	</td>
	<td class="waku_column">九</td>
	<td class="waku_column">八</td>
	<td class="waku_column">七</td>
	<td class="waku_column">六</td>
	<td class="waku_column">五</td>
	<td class="waku_column">四</td>
	<td class="waku_column">三</td>
	<td class="waku_column">二</td>
	<td class="waku_column">一</td>
	<td></td>
	<td class="waku_right" rowspan="10">
		<span class="m_koma"><img src="koma/k31.png" class="koma_img_r"></span>
		<span class="m_koma"><img src="koma/k41.png" class="koma_img_r"></span>
		<span class="m_koma"><img src="koma/k51.png" class="koma_img_r"></span>
		<span class="m_koma"><img src="koma/k61.png" class="koma_img_r"></span>
		<span class="m_koma"><img src="koma/k71.png" class="koma_img_r"><span class="m_koma_c">2</span></span>
		<span class="m_koma"><img src="koma/k81.png" class="koma_img_r"></span>
		<span class="m_koma"><img src="koma/k91.png" class="koma_img_r"><span class="m_koma_c">6</span></span>
	</td>
</tr>
<tr>
<td class="waku_main" colspan="9" rowspan="9">
<div class="ban">
<?for($n=1;$n<10;$n++){?>
<?for($s=1;$s<10;$s++){?>
<div class="masu" style="top:<?=($n-1)*9.5+0.5?>vw; left:<?=($s-1)*8.5+0.5?>vw;" ></div>
<?}?>
<?}?>
<?for($t=1;$t<41;$t++){?>
<span cc="<?=$row["column_".$t]?>" ll="<?=$row["line_".$t]?>" class="koma c<?=$row["column_".$t]?> l<?=$row["line_".$t]?> s<?=$row["style_".$t]?> u<?=$row["user_".$t]?>"><img src="koma/<?=$base[$t]["img"]?><?=$row["style_".$t]?>.png" class="koma_img"></span>
<? } ?>
</div>
</td>
	<td class="waku_line">1</td>
</tr>
<tr>
	<td class="waku_line">2</td>
</tr>
<tr>
	<td class="waku_line">3</td>
</tr>
<tr>
	<td class="waku_line">4</td>
</tr>
<tr>
	<td class="waku_line">5</td>
</tr>
<tr>
	<td class="waku_line">6</td>
</tr>
<tr>
	<td class="waku_line">7</td>
</tr>
<tr>
	<td class="waku_line">8</td>
</tr>
<tr>
	<td class="waku_line">9</td>
</tr>

<tr>
<td class="waku_bottom" colspan="13"></td>
</tr>
<tr>
<td class="waku_comm" colspan="13"></td>
</tr>
</table>
</div>
</body>
</html>
