<?php
include_once('./library/sql.php');

if($_REQUEST["logout"]){
	session_destroy();
	$cast="";

}elseif($_POST["set"] && !$cast["id"]){
	$title	=$_POST["title"];
	$place	=$_POST["place"];
	$first	=$_POST["first"];
	$second	=$_POST["second"];
	$kami	=$_POST["kami"];

	if(!$title) $title="対局";
	if(!$place) $place="将棋会館";
	if(!$first) $first="名無しさん";
	if(!$second) $second="名無し先生";
	include_once('./library/start.php');

	$cast["id"]			=$tmp_auto;
	$cast["title"]		=$title;
	$cast["place"]		=$place;
	$cast["first"]		=$first;
	$cast["second"]		=$second;
	$cast["cast_time"]	=time();
	$_SESSION			=$cast;
}
if($cast["id"]){
	$sql="SELECT * FROM komamemo_base";
	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			$base[$res["id"]]=$res;
		}
	}

	$sql="SELECT * FROM komamemo_log WHERE host_id='{$cast["id"]}' ORDER BY log_id ASC";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$dat[$row["koma_id"]]=$row;
		}
	}
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

<?for($e=1;$e<10;$e++){?>
<?$e1=69.5-8.5*($e-1);?>
.c<?=$e?>{left:<?=$e1?>vw;}
<?}?>

<?for($e=1;$e<10;$e++){?>
<?$e1=0.5+9.5*($e-1);?>
.l<?=$e?>{top:<?=$e1?>vw;}
<?}?>
</style>
</head>
<body class="body">
<div class="main">
<?if($cast["id"]){?>
<table class="waku">
<tr>
<td class="waku_top" colspan="12"></td>
</tr>
<tr>
	<td></td>
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
	<td></td>
</tr>
<tr>
	<td class="waku_left">
		<span class="m_koma"><img src="koma/k90.png" class="koma_img_r u2"><span class="m_koma_c">6</span></span>
		<span class="m_koma"><img src="koma/k80.png" class="koma_img_r u2"></span>
		<span class="m_koma"><img src="koma/k70.png" class="koma_img_r u2"><span class="m_koma_c">2</span></span>
		<span class="m_koma"><img src="koma/k60.png" class="koma_img_r u2"></span>
		<span class="m_koma"><img src="koma/k50.png" class="koma_img_r u2"></span>
		<span class="m_koma"><img src="koma/k40.png" class="koma_img_r u2"></span>
		<span class="m_koma"><img src="koma/k30.png" class="koma_img_r u2"></span>
	</td>

	<td class="waku_main" colspan="9">
		<div class="ban">
			<?for($n=1;$n<10;$n++){?>
				<?for($s=1;$s<10;$s++){?>
					<div class="masu" style="top:<?=($n-1)*9.5+0.5?>vw; left:<?=($s-1)*8.5+0.5?>vw;"></div>
				<?}?>
			<?}?>
			<?for($t=1;$t<41;$t++){?>
				<span id="koma<?=$t?>"  cc="<?=$dat[$t]["column"]?>" ll="<?=$dat[$t]["line"]?>" class="koma c<?=$dat[$t]["colum"]?> l<?=$dat[$t]["line"]?> s<?=$dat[$t]["style"]?> u<?=$dat[$t]["user"]?>"><img src="koma/<?=$base[$t]["img"]?><?=$dat[$t]["style"]?>.png" class="koma_img"></span>
			<? } ?>
		</div>
	</td>


	<td class="waku_line">
		<span class="waku_line_in">1</span>
		<span class="waku_line_in">2</span>
		<span class="waku_line_in">3</span>
		<span class="waku_line_in">4</span>
		<span class="waku_line_in">5</span>
		<span class="waku_line_in">6</span>
		<span class="waku_line_in">7</span>
		<span class="waku_line_in">8</span>
		<span class="waku_line_in">9</span>
	</td>
	<td class="waku_right">
		<span class="m_koma"><img src="koma/k30.png" class="koma_img_r"></span>
		<span class="m_koma"><img src="koma/k40.png" class="koma_img_r"></span>
		<span class="m_koma"><img src="koma/k50.png" class="koma_img_r"></span>
		<span class="m_koma"><img src="koma/k60.png" class="koma_img_r"></span>
		<span class="m_koma"><img src="koma/k70.png" class="koma_img_r"><span class="m_koma_c">2</span></span>
		<span class="m_koma"><img src="koma/k80.png" class="koma_img_r"><span class="m_koma_c">4</span></span>
		<span class="m_koma"><img src="koma/k90.png" class="koma_img_r"><span class="m_koma_c">18</span></span>
	</td>
</tr>
<tr>
<td class="waku_bottom" colspan="12"><a href="./index.php?logout=1;" style="font-size:4vw;">あいうえお</a></td>
</tr>
<tr>
<td class="waku_comm" colspan="12">
<div class="hist"></div>
<div class="memo"></div>
</td>
</tr>
</table>	

<?}else{?>
<form id="set_form" method="post">
<div class="top_box">
<span class="box_tag">タイトル</span><input type="text" name="title" value="対局" class="box_text"><br>
<span class="box_tag">場所</span><input type="text" name="place" value="将棋会館" class="box_text"><br>
<span class="box_tag">先手</span><input type="text" name="first" value="名無しさん" class="box_text"><br>
<span class="box_tag">後手</span><input type="text" name="second" value="名無し先生" class="box_text"><br>
<span class="box_tag">上座</span>
<select name="kami" class="box_text">
<option value="1">先手</option>
<option value="2" selected>後手</option>
</select>
<br>
<input type="hidden" value="set" name="set">
<button id="send_btn" type="submit">開始</button>
</div>
</form>
<?}?>
</div>
</body>
</html>