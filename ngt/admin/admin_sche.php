<?
/*
$start_time	=$admin_config["start_time"];
$start_week	=$admin_config["start_week"];
*/

$week[0]="日";
$week[1]="月";
$week[2]="火";
$week[3]="水";
$week[4]="木";
$week[5]="金";
$week[6]="土";

/*
<input id="ck_b" type="checkbox" name="cl_b" class="ck_box" value="1"><label for="ck_b" class="ck_label">通常</label>
<input id="ck_c" type="checkbox" name="cl_c" class="ck_box" value="1"><label for="ck_c" class="ck_label">準備</label>
<input id="ck_d" type="checkbox" name="cl_d" class="ck_box" value="1"><label for="ck_d" class="ck_label">休職</label>
<input id="ck_e" type="checkbox" name="cl_e" class="ck_box" value="1"><label for="ck_e" class="ck_label">退職</label>
<input id="ck_f" type="checkbox" name="cl_f" class="ck_box" value="1"><label for="ck_f" class="ck_label">停止</label>
*/

$ck_date=$_POST["ck_date"];
if(!$ck_date) $ck_date=$day_8;

$tmp_d=strtotime($ck_date);

if($_POST["page"]=="n"){
	$tmp_d+=604800;

}elseif($_POST["page"]=="p"){
	$tmp_d-=604800;
}
$tmp_week=date("w",$tmp_d);

$st_day		=date("Ymd",$tmp_d-($tmp_week-$start_week)*86400);
$ed_day		=date("Ymd",$tmp_d-($tmp_week-$start_week)*86400+518400);
$ck_date	=date("Y-m-d",$tmp_d-($tmp_week-$start_week)*86400);

$cl_b=$_POST["cl_b"];
$cl_c=$_POST["cl_c"];
$cl_d=$_POST["cl_d"];
$cl_e=$_POST["cl_e"];
$cl_f=$_POST["cl_f"];

if(!$cl_b && !$cl_c && !$cl_d && !$cl_e && !$cl_f){
	$cl_b=1;
	$cl_c=1;
}

if($cl_b == 1){
	$app.=" OR ( cast_status =0 AND ctime<='{$ed_day}')";
}

if($cl_c == 1){
	$app.=" OR ( cast_status =0 AND ctime>'{$ed_day}')";
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

$sql =" SELECT * FROM wp01_0sch_table";
$sql .=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sch_table[$row["in_out"]][$row["sort"]]=$row["name"];
	}
}

$sql =" SELECT id, ctime, genji,genji_kana FROM wp01_0cast";
$sql.=" WHERE (cast_status=99";
$sql.=$app;
$sql.=")";
$sql.=" AND del=0";
$sql.=" ORDER BY cast_sort ASC";
echo $sql;
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if (file_exists("../img/profile/{$row["id"]}/0.jpg")) {
			$row["face"]="../img/profile/{$row["id"]}/0.jpg";			

		}else{
			$row["face"]="../img/cast_no_image.jpg";			
		}
		$row["sch"]="休み";
		$cast_dat[$row["id"]]=$row;
	}
}

$sql ="SELECT cast_id, stime, etime, sche_date FROM wp01_0schedule";
$sql.=" WHERE sche_date>='{$st_day}'";
$sql.=" AND sche_date<='{$ed_day}'";
$sql.=" ORDER BY id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["stime"] && $row["etime"]){
			$stime[$row["cast_id"]][$row["sche_date"]]=$row["stime"];
			$etime[$row["cast_id"]][$row["sche_date"]]=$row["etime"];
	
		}else{
			$stime[$row["cast_id"]][$row["sche_date"]]="休み";
			$etime[$row["cast_id"]][$row["sche_date"]]="";
		}
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
}

-->
</style>
<script>
$(function(){ 

});
</script>
<header class="head">
<form id="wform" method="post">
<button id="p_week" type="button" class="sche_submit">翌週</button>

<input id="sel_date" type="date" name="ck_date" value="<?=$ck_date?>" class="w140">
<button id="n_week" type="button" class="sche_submit">翌週</button>
<input id="page" type="hidden" value="" name="page">
<input type="hidden" value="sche" name="menu_post">

<div class="sche_ck">
<input id="ck_b" type="checkbox" name="cl_b" class="ck_box" value="1"<?if($cl_b==1){?> checked="checked"<?}?>><label for="ck_b" class="ck_label">通常</label>
<input id="ck_c" type="checkbox" name="cl_c" class="ck_box" value="1"<?if($cl_c==1){?> checked="checked"<?}?>><label for="ck_c" class="ck_label">準備</label>
<input id="ck_d" type="checkbox" name="cl_d" class="ck_box" value="1"<?if($cl_d==1){?> checked="checked"<?}?>><label for="ck_d" class="ck_label">休職</label>
<input id="ck_e" type="checkbox" name="cl_e" class="ck_box" value="1"<?if($cl_e==1){?> checked="checked"<?}?>><label for="ck_e" class="ck_label">退職</label>
<input id="ck_f" type="checkbox" name="cl_f" class="ck_box" value="1"<?if($cl_f==1){?> checked="checked"<?}?>><label for="ck_f" class="ck_label">停止</label>
</div>
</form>
</header>
<div class="wrap">
<table>
	<tr>
		<td class="td_top" colspan="2">キャスト名</td>
		<?for($n=0;$n<7;$n++){?>
		<td class="td_top<?if($day_8 == date("Ymd",strtotime($st_day)+($n*86400))){ ?> back_now<? } ?>">
			<?=date("m年d月",strtotime($st_day)+($n*86400))?>
			[<?=$week[date("w",strtotime($st_day)+($n*86400))]?>]

		</td>
		<?}?>
	</tr>

<?foreach($cast_dat as $a1=> $a2){?>
	<tr>
		<td style="width:70px" class="td_top"><img src="<?=$a2["face"]?>?t=<?=time()?>" style="width:60px; height:80px;margin:5px;"></td>

		<td class="td_castname w160">
			<div class="td_castname_in">
			<?=$a2["genji"]?><br>
			[<?=$a2["genji_kana"]?>]
			</div>
			<button id="ch_<?=$a2["id"]?>" type="button" class="sche_submit">更新</button><button id="rs_<?=$a1?>" type="button" class="sche_reset">RESET</button>
		</td>
		<?for($n=0;$n<7;$n++){?>
			<?
				$tmp_day=date("Ymd",strtotime($st_day)+($n*86400));
				if(!$stime[$a2["id"]][$tmp_day]) $stime[$a2["id"]][$tmp_day]="休み";
			?>

			<td class="td_inout w120<?if($day_8 == $tmp_day){ ?> line_now<? } ?> <?if($cast_dat[$a2["id"]]["ctime"] > $tmp_day){?> disabled<?}?>">
				<div class="box_inout">
					<span class="tag_inout">入</span>
					<select id ="s_<?=$a2["id"]?>_<?=$n?>" class="sel_inout" <?if($cast_dat[$a2["id"]]["ctime"] > $tmp_day){?> disabled<?}?>>
					<option value="休み" <?if($stime[$a2["id"]][$tmp_day]== "休み"){?> selected="selected"<?}?>>休み</option>
						<?foreach($sch_table["in"] as $b2){?>
							<option value="<?=$b2?>" <?if($b2 == $stime[$a2["id"]][$tmp_day]){?> selected="selected"<?}?>><?=$b2?></option>
						<?}?>
					</select>
					<input type="hidden" id="hs_<?=$a2["id"]?>_<?=$n?>" value="<?=$stime[$a2["id"]][$tmp_day]?>">
				</div>
				<div class="box_inout">
					<span class="tag_inout">退</span>
					<select id ="e_<?=$a2["id"]?>_<?=$n?>" class="sel_inout" <?if($cast_dat[$a2["id"]]["ctime"] > $tmp_day){?> disabled<?}?>>
						<option value="" <?if($stime[$a2["id"]][$tmp_day]== "休み"){?> selected="selected"<?}?>>　</option>
						<?foreach($sch_table["out"] as $b2){?>
							<option value="<?=$b2?>" <?if($b2 == $etime[$a2["id"]][$tmp_day]){?> selected="selected"<?}?>><?=$b2?></option>
						<?}?>
					</select>
					<input type="hidden" id="he_<?=$a2["id"]?>_<?=$n?>" value="<?=$etime[$a2["id"]][$tmp_day]?>">
				</div>
				<input type="hidden" id="d_<?=$a2["id"]?>_<?=$n?>" value="<?=$tmp_day?>">

			</td>
		<?}?>
	</tr>
<?}?>
</table>
</div>
<footer class="foot"></footer> 
