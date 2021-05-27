<?php
include_once('./library/sql.php');

$masu_l[1]="一";
$masu_l[2]="二";
$masu_l[3]="三";
$masu_l[4]="四";
$masu_l[5]="五";
$masu_l[6]="六";
$masu_l[7]="七";
$masu_l[8]="八";
$masu_l[9]="九";

if($_POST["logout"]){
	session_destroy();

}elseif($_POST["set"]){
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

	$cast["id"]		=$tmp_auto;
	$cast["title"]	=$title;
	$cast["place"]	=$place;
	$cast["first"]	=$first;
	$cast["second"]	=$second;
	$cast["cast_time"]=time();
	$_SESSION=$cast;
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
<script src="./js/main.js?t=<?=time()?>"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/style.css?t=<?=time()?>">

</head>
<body class="body">
<div class="main">
<?if($base){?>

<table class="waku">
<tr>
<td class="waku_top" colspan="3"></td>
</tr>
<tr>
	<td class="waku_left">
		<span id="re19" class="m_koma"><img src="koma/k90.png" class="koma_img_r u1"><span id="ct19" class="m_koma_c"></span></span>
		<span id="re18" class="m_koma"><img src="koma/k80.png" class="koma_img_r u1"><span id="ct18" class="m_koma_c"></span></span>
		<span id="re17" class="m_koma"><img src="koma/k70.png" class="koma_img_r u1"><span id="ct17" class="m_koma_c"></span></span>
		<span id="re16" class="m_koma"><img src="koma/k60.png" class="koma_img_r u1"><span id="ct16" class="m_koma_c"></span></span>
		<span id="re15" class="m_koma"><img src="koma/k50.png" class="koma_img_r u1"><span id="ct15" class="m_koma_c"></span></span>
		<span id="re14" class="m_koma"><img src="koma/k40.png" class="koma_img_r u1"><span id="ct14" class="m_koma_c"></span></span>
		<span id="re13" class="m_koma"><img src="koma/k30.png" class="koma_img_r u1"><span id="ct13" class="m_koma_c"></span></span>
	</td>

	<td class="waku_main">
		<div class="ban">
			<?for($n=9;$n>0;$n--){?>
			<div class="masu_c"><?=$n?></div>
			<?}?>

			<div class="masu_cl"></div>
			<?for($n=1;$n<10;$n++){?>
				<?for($s=9;$s>0;$s--){?>
					<div class="masu" cc="<?=$s?>" ll="<?=$n?>"></div>
				<?}?>
				<div class="masu_l"><?=$masu_l[$n]?></div>
			<?}?>



			<?for($t=1;$t<41;$t++){?>
				<span id="koma<?=$t?>" kk="<?=substr($base[$t]["img"],-1,1)?>" cc="<?=$dat[$t]["colum"]?>" ll="<?=$dat[$t]["line"]?>" ss="<?=$dat[$t]["style"]?>" class="koma c<?=$dat[$t]["colum"]?> l<?=$dat[$t]["line"]?> s<?=$dat[$t]["style"]?> u<?=$dat[$t]["user"]?>"><img src="koma/<?=$base[$t]["img"]?><?=$dat[$t]["style"]?>.png" class="koma_img"></span>
			<? } ?>
		</div>
	</td>
	<td class="waku_right">
		<span id="re03" class="m_koma"><img src="koma/k30.png" class="koma_img_r"><span id="ct03" class="m_koma_c"></span></span>
		<span id="re04" class="m_koma"><img src="koma/k40.png" class="koma_img_r"><span id="ct04" class="m_koma_c"></span></span>
		<span id="re05" class="m_koma"><img src="koma/k50.png" class="koma_img_r"><span id="ct05" class="m_koma_c"></span></span>
		<span id="re06" class="m_koma"><img src="koma/k60.png" class="koma_img_r"><span id="ct06" class="m_koma_c"></span></span>
		<span id="re07" class="m_koma"><img src="koma/k70.png" class="koma_img_r"><span id="ct07" class="m_koma_c"></span></span>
		<span id="re08" class="m_koma"><img src="koma/k80.png" class="koma_img_r"><span id="ct08" class="m_koma_c"></span></span>
		<span id="re09" class="m_koma"><img src="koma/k90.png" class="koma_img_r"><span id="ct09" class="m_koma_c"></span></span>
	</td>
</tr>
<tr>
	<td class="waku_bottom" colspan="3"><a href="./index.php?logout=1" style="font-size:4vw;">あいうえお</a></td>
</tr>

<tr>
	<td class="waku_comm" colspan="3">
		<div class="hist">
			<div class="hist_in"></div>
		</div>
		<div class="memo">
			<div class="memo_in"></div>
		</div>
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
