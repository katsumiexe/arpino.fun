<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="./css/main.css?_<?=date("YmdHi")?>">
<style>
</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script src="./js/main.js?_<?=date("YmdHi")?>"></script>


</head>
<body style="text-align:center;background:#303030">
<div class="score">
	<div class="score_top">
	High Score Bord(2020/05)
	</div>

	<div class="score_top_lv">easy</div>

	<table class="score_table">
		<tr>
			<td class="score_table_ttl">Rank</td>
			<td class="score_table_ttl">Unit</td>
			<td class="score_table_ttl">Date/Name</td>
			<td class="score_table_ttl">Score</td>
			<td class="score_table_ttl">SNS</td>
		</tr>
	<?for($n=1;$n<11;$n++){?>
		<tr>
			<td class="score_table_rank" rowspan="2"><?=$n?></td>
			<td class="score_table_unit" rowspan="2"></td>
			<td class="score_table_date">2020/05/01 06:00:00</td>
			<td class="score_table_score" rowspan="2">20</td>
			<td class="score_table_sns" rowspan="2">t</td>
		</tr>
		<tr>
			<td class="score_table_name">いなぞーぞ</td>
		</tr>
	<? } ?>
	</table>
</div>
</body>
</html>
