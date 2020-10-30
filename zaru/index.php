<?php
$pg=$_REQUEST["pg"];
$lg=$_REQUEST["lg"];
$ps=$_REQUEST["ps"];

//■■初期設定--------------------
$max="499";
$t_day="20150923";
$t_lg ="0923";
$t_ps ="0909";

//--------------------------------

$fp=fopen("./st_list.csv","r");
if($fp){
	while($f1=fgets($fp)){
		$f2=explode(",", $f1);
		if($lg == $f2[1]){
			$dat["id"]=$f2[0];
			$dat["lg"]=$f2[1];
			$dat["ps"]=$f2[2];
			$dat["date"]=$f2[3];
			$dat["max"]=$f2[4];
			$dat["zip"]=$f2[5];
			if($dat["ps"] === $ps) $in=1;
		}
	}
}
if(!$pg) $pg=1;
if(!$in && $lg){
	$msg="<span style=\"color:#ff0000\">コマンドまたはファイル名が違います</span>";
}

$cs[$pg]=1;

$pg_s=1+($pg-1)*30;
$pg_e=31+($pg-1)*30;
if($pg_e>$dat["max"]+1) $pg_e=$dat["max"]+1;

$pg_max=ceil($dat["max"]/30)+1;
?>
<html>
<head>
<title>ZARU BOX 写真用ストレージ</title>
<meta http-equiv="CONTENT-TYPE" content="text/html; CHARSET=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="./css/main.css?_<?=date("YmdHi")?>">
<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/main.js"></script>
<style type="text/css">
<!--
-->
</style>
</head>
<body class="body">
<div class="main">
<?if(!$in){?>
	<div align="center">
	<br><?=$msg?>

	<form>
	<div class="top1">
<span class="kei">お写真倉庫<br>「ZARU BOX」</span><br>
<span class="moji">スマホでもみれる画像専用ストレージ</span>
	</div>

	<div class="top2">
		ID<br>
		<input type="text" name="lg" maxlength="10" class="box"><br>
		PASS<br>
		<input type="password" name="ps" maxlength="10" class="box"><br><br>

		<button type="submit" name="log" value="LOGIN" class="btn_loign"><span class="icon_img1 "></span><span style="height:30px ;line-height:30px; display:inline-block;vertical-align:middle">LOGIN</span></button><br>
		<br>
	</div>
	</form>
<br>
<br>
	<div class="top3">	
<strong>お写真★倉庫について</strong><br>
現在、開発は停止しています。<br>
ごめんなさい。<br>
	</div>
	</div>

<?}else{?>
	<table class="table_top">
		<tr>
			<td class="td_top">
				撮影：<?=substr($dat["date"],0,4)?>/<?=substr($dat["date"],4,2)?>/<?=substr($dat["date"],6,2)?><br>
				枚数：<?=$dat["max"]?>枚<br>
			</td>
			<td class="td_top">
			<?for($d=0;$d<$dat["zip"];$d++){?>
				<a href="./st/<?=$dat["id"]?>/zip/zip_<?=$dat["date"]?>_<?=$d+1?>.zip" class="btn">ダウンロード<?=$d+1?></a><br>
			<? } ?>
			</td>
			<td class="td_top2">
				<a href="./index.php" class="logout"><span class="icon_img2"></span>LOG OUT</a><br>
			</td>
		</tr><tr>
			<td class="td_top3" colspan="3">
				<a href="./notice.php">【notice】ご利用に関するお願い</a><br>
			</td>
		</tr>
	</table>
	
	<div class="box_pg">
	<?for($n=1;$n<$pg_max;$n++){?>
	<div id="p<?=$n?>" class="pg_n <?if($pg==$n){?>sel<?}?>">
	<?=$n?>
	</div>
	<?}?>
	</div>
<hr>
<?for($i=$pg_s;$i<$pg_e;$i++){?>
<table class="album">
	<tr>
		<td class="album_ttl">
			No.<?=$i?>
			<a href="./st/<?=$dat["id"]?>/img/img_<?=$dat["date"]?>_<?=sprintf("%04d", $i)?>.jpg" class="pic_link"><span></span></a>
		</td>
	</tr>

	<tr>
		<td class="album_img"><a href="./st/<?=$dat["id"]?>/img/img_<?=$dat["date"]?>_<?=sprintf("%04d", $i)?>.jpg"><img src="./st/<?=$dat["id"]?>/img/img_<?=$dat["date"]?>_<?=sprintf("%04d", $i)?>.jpg" class="img_size"></a></td>
	</tr>
</table>
<? } ?>

<table class="table_pg">
	<tr>
		<?for($n=1;$n<$pg_max;$n++){?>
			<td class="s<?=$cs[$n]?>"><a href="./index.php?pg=<?=$n?>&lg=<?=$lg?>&ps=<?=$ps?>"><?=$n?></a></td>
			<?if(($n % 10 )== 0){?></tr><tr><?}?>
		<?}?>
	</tr>
</table>

<form id="jump" action="./index.php" method="post">
<input type="hidden" name="lg" value="<?=$lg?>">
<input type="hidden" name="ps" value="<?=$ps?>">
<input id="h_pd" type="hidden" name="pg" value="">
</form>
<?}?>
<br>
</body>
</html>

