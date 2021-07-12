<?

$cl_b=$_POST["cl_b"];
$cl_c=$_POST["cl_c"];
$cl_d=$_POST["cl_d"];
$cl_e=$_POST["cl_e"];
$cl_f=$_POST["cl_f"];

$c_s=$_POST["c_s"] +0;

if(!$cl_b && !$cl_c && !$cl_d && !$cl_e && !$cl_f){
	$cl_b=1;
	$cl_c=1;
}


if($cl_b == 1){
	$app.=" OR ( cast_status =0 AND ctime<='{$day_8}')";
}

if($cl_c == 1){
	$app.=" OR ( cast_status =0 AND ctime>'{$day_8}')";
}

if($cl_d == 1){
	$app.=" OR cast_status =2";
}

if($cl_e == 1){
	$app.=" OR cast_status =3";
}

if($cl_f == 1){
	$app.=" OR cast_status =4";
}


if($c_s == 0){
	$app2=" AND id >0";
}else{
	$app2=" AND id IS NULL";
}

$sql	 ="SELECT id,staff_id,genji,genji_kana, cast_sort, `group`, ctime, cast_id,cast_status,name,kana FROM wp01_0staff AS S";
$sql	.=" LEFT JOIN wp01_0cast AS C ON S.staff_id=C.id";
$sql	.=" WHERE (cast_status IS NULL";
$sql	.=$app;
$sql	.=")";
$sql	.=$app2;
$sql	.=" AND S.del=0";
$sql	.=" ORDER BY cast_sort ASC";

if($rawult = mysqli_query($mysqli,$sql)){
	while($raw = mysqli_fetch_assoc($rawult)){
		if($raw["id"]){
			if (file_exists("../img/profile/{$raw["id"]}/0_s.webp")) {
				$raw["face"]="../img/profile/{$raw["id"]}/0_s.webp";			

			}elseif (file_exists("../img/profile/{$raw["id"]}/0_s.jpg")) {
				$raw["face"]="../img/profile/{$raw["id"]}/0_s.jpg";			

			}else{
				$raw["face"]="../img/cast_no_image.jpg";			
			}
			if($raw["cast_status"]==0 && $raw["ctime"]>$day_8){
				$raw["cast_status"]=1;
			}
			$dat[]=$raw;
			$count_dat++;

		}else{
			$dat2[]=$raw;
			$count_dat2++;
		}
	}
}

$sql	 ="SELECT * FROM wp01_0tag";
$sql	.=" WHERE del=0";
$sql	.=" and tag_group='cast_group'";
$sql	.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$group[$row["id"]]=$row["tag_name"];
	}
}
?>
<style>
<!--
input[type=text]{
	height:30px;
}

input[type="checkbox"],input[type="radio"]{
	display:none;
}

td{
	border:1px solid #303030;
	padding:5px;
}



#sel_staff,#sel_cast{
}

#staff_l{
	border-radius:10px 0 0 10px;
	margin:10px 0 10px 10px;
}

#cast_l{
	border-radius:0 10px 10px 0;
	margin:10px 10px 10px 0;
}

.c_s_box{
	display				:inline-block;
	height				:30px;
	line-height			:30px;
	width				:180px;
	font-size			:0;
	color				:#fafafa;
	text-align			:left;
	margin 0 50px;
}

.c_s_btn{
	display				: inline-block;
	height				:30px;
	line-height			:30px;
	width				:80px;
	font-size			:16px;
	text-align			:center;
	background			:#cccccc;
	color				:#fafafa;
}

.on_1{
	background:#0000c0;
}

.on_2{
	background:#c00000;
}

.ck_off:checked + label{
	background		:linear-gradient(#c0c0f0,#8080ff);
}


.sel_status{
	display			:inline-block;
	background		:#d0d0d0;
	width			:80px;
	height			:30px;
	line-height		:30px;
	margin			:5px;
	border-radius	:5px;
	color			:#fafafa;
	font-size		:18px;
	font-weight		:600;
	text-align		:center;
}

.table_title{
	background		:linear-gradient(#e0e0e0,#d0d0d0);
	padding			:5px;
	font-size		:14px;
}

.icon{
	font-family:at_icon;
}

.box_sort{
	width		:35px;
	text-align	:right;
	padding		:3px;
	margin		:0 auto;
}
-->
</style>
<script>
$(function(){ 
	$('#staff_l').on('click',function () {
		$(this).addClass('on_1');
		$('#cast_l').removeClass('on_2');
		$('.cast_table').fadeOut(100);
	});

	$('#cast_l').on('click',function () {
		$(this).addClass('on_2');
		$('#staff_l').removeClass('on_1');
		$('.cast_table').fadeIn(100);
	});
});

</script>
<header class="head">
<form id="wform" method="post">

<input id="sel_staff" value="1" type="radio" name="c_s" class="sel_radio" <?if($c_s==1){?> checked="checked"<?}?>><label id="staff_l" for="staff" class="c_s_btn">STAFF</label>
<input id="sel_cast" value="0" type="radio" name="c_s" class="sel_radio" <?if($c_s==0){?> checked="checked"<?}?>><label id="cast_l" for="cast" class="c_s_btn on_2">CAST</label>

<div class="status_check">
<input id="ck_b" type="checkbox" name="cl_b" class="status_check_box" value="1"<?if($cl_b==1){?> checked="checked"<?}?>><label for="ck_b" class="status_check_label">通常</label>
<input id="ck_c" type="checkbox" name="cl_c" class="status_check_box" value="1"<?if($cl_c==1){?> checked="checked"<?}?>><label for="ck_c" class="status_check_label">準備</label>
<input id="ck_d" type="checkbox" name="cl_d" class="status_check_box" value="1"<?if($cl_d==1){?> checked="checked"<?}?>><label for="ck_d" class="status_check_label">休職</label>
<input id="ck_e" type="checkbox" name="cl_e" class="status_check_box" value="1"<?if($cl_e==1){?> checked="checked"<?}?>><label for="ck_e" class="status_check_label">退職</label>
<input id="ck_f" type="checkbox" name="cl_f" class="status_check_box" value="1"<?if($cl_f==1){?> checked="checked"<?}?>><label for="ck_f" class="status_check_label">停止</label>
</div>

</form>
</header>
<div class="wrap">
<div class="main_box">
<table>
<thead>
<tr>
<td class="td_top w40">替</td>
<td class="td_top w40">順</td>
<td class="td_top w50"></td>
<td class="td_top w140">源氏名[フリガナ]</td>
<td class="td_top w100">ID</td>
<td class="td_top w100">Staff Code</td>
<td class="td_top w100">入店日</td>
<td class="td_top w80">グループ</td>
<td class="td_top w80">状態</td>
<td class="td_top w80">タグ</td>
<td class="td_top w60">変更</td>
</tr>
</thead>
<tbody id="staff_sort" class="list_sort">
<?for($n=0;$n<$count_dat;$n++){?>
<tr id="sort_item<?=$dat[$n]["staff_id"]?>" class="tr b<?=$dat[$n]["cast_status"]?>">
<td class="td_sort handle"></td>
<td ><input type="text" value="<?=$dat[$n]["cast_sort"]?>" class="box_sort" disabled></td>
<td><img src="<?=$dat[$n]["face"]?>?t=<?=time()?>" style="width:48px; height:64px;"></td>
<td><?=$dat[$n]["genji"]?><br>[<?=$dat[$n]["genji_kana"]?>]</td>
<td><?=$dat[$n]["cast_id"]?></td>
<td><?=$dat[$n]["id"]?></td>
<td><?=$dat[$n]["ctime"]?></td>
<td><?=$group[$dat[$n]["group"]]?></td>
<td><?=$cast_status_select[$dat[$n]["cast_status"]]?></td>
<td><?=$dat[$n]["cast_tag"]?></td>

<td style="position:relative;">
	<form method="post">
		<button type="submit" class="staff_submit">変更</button>
		<input type="hidden" value="staff_fix" name="menu_post">
		<input type="hidden" name="staff_id" value="<?=$dat[$n]["staff_id"]?>">
	</form>
</td>
</tr>
<?}?>
</tbody>
</table>
<footer class="foot"></footer> 

