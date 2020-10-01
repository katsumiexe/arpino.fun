<?
include_once("./library/session.php");
$sql	  ="SELECT *, sum(tarot_maker_b.regist) AS cnt FROM tarot_maker";
$sql	 .=" LEFT JOIN tarot_maker_b ON id=base_no";
if($res0 = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($res0)){
		$dat[]=$row0;
	}
}

$sql	  ="SELECT * FROM tarot_maker_t";
$sql	  .=" WHERE main_id={$dat[0]["id"]}";
$sql	  .=" ORDER BY type_id ASC";

if($res1 = mysqli_query($mysqli,$sql)){
	while($row1 = mysqli_fetch_assoc($res1)){
		$ttl[]=$row1;
	}
}


$sql	  ="SELECT no_r, name_j FROM tarot_base";
$sql	  .=" ORDER BY id ASC";

if($res2 = mysqli_query($mysqli,$sql)){
	while($row2 = mysqli_fetch_assoc($res2)){
		$tarot[]=$row2;
	}
}



?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>TAROT</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script></script>
<style>
table{
	border:1px solid #303030;
	border-collapse: collapse;
	background:#fafafa;
	margin:5px;
}

td{
	border:1px solid #303030;
	font-size:13px;
	padding:2px 5px;
}

.top{
	background:#f0f0f0;
	text-align:center;

}
.left{
	text-align:left;
}

.right{
	text-align:right;
}

.w60{
	width:60px;
}

.w120{
	width:120px;
}

.w160{
	width:160px;
}

.w240{
	width:240px;
}

.w40{
	width:40px;
}


</style>
</head>
<body style="text-align:center;background:#fafafa">
<div class="main">
<div class="left">
<table>
<tr>
<td class="top w160">日</td>
<td class="top w160">占い名</td>
<td class="top w40">占数</td>
<td class="top w40">工数</td>
<td class="top w40">進捗</td>
<td class="top w40">完了率</td>
<td class="top w40">　</td>
</tr>
<?for($n=0;$n<count($dat);$n++){?>
<tr>
<td><?=$dat[$n]["date"]?></td>
<td><?=$dat[$n]["title"]?></td>
<td class="right"><?=$dat[$n]["rank"]?></td>
<td class="right"><?=$dat[$n]["rank"]*44?></td>
<td class="right"><?=$dat[$n]["cnt"]?></td>
<td class="right"><?=floor($dat[$n]["cnt"]*10000/($dat[$n]["rank"]*44))/100?>%</td>
<td><button id="b<?=$n?>" type="button">開</button></td>
</tr>
<?}?>
</table>

<table>
<?for($n=0;$n<count($ttl);$n++){?>
<tr>
<td class="w40"><?=$ttl[$n]["type_id"]?></td>
<td class="w160"><?=$ttl[$n]["type_name"]?></td>
</tr>
<?}?>
</table>

<table>
<tr>
<td class="top w40">番号</td>
<td class="top w120">カード名</td>
<?for($n=0;$n<count($ttl);$n++){?>
<td class="top" colspan="2"><?=$ttl[$n]["type_id"]?></td>
<?}?>
</tr>
<?for($n=0;$n<22;$n++){?>
<tr>
<td class="right w40"><?=$n?></td>
<td><?=$tarot[$n]["name_j"]?></td>
<?for($s=0;$s<count($ttl);$s++){?>
<td class="w40"><button type="button">正</button></td>
<td class="w40"><button type="button">逆</button></td>
<?}?>
</tr>
<?}?>
</table>
</div>
<div class="right">
</div>
</div>
</body>
</html>
