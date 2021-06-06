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

$ck_date=$_POST["sk_date"];
if(!$ck_date) $ck_date=substr($day_8,0,4)."-".substr($day_8,4,2)."-".substr($day_8,6,2);

$tmp_d=strtotime($ck_date);
$tmp_week=date("w",$tmp_d);
$st_day=date("Ymd",$tmp_d-($tmp_week-$start_week)*86400);
$ed_day=date("Ymd",$tmp_d-($tmp_week-$start_week)*86400+518400);

$sql =" SELECT * FROM wp01_0sch_table";
$sql .=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sch_table[$row["in_out"]][$row["sort"]]=$row["name"];
	}
}

$sql =" SELECT id, genji,genji_kana FROM wp01_0cast";
$sql.=" WHERE cast_status<2";
$sql.=" AND del=0";
$sql.=" ORDER BY id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if (file_exists("../img/profile/{$row["id"]}/0.jpg")) {
			$row["face"]="../img/profile/{$row["id"]}/0.jpg";			

		}else{
			$row["face"]="../img/cast_no_image.jpg";			
		}
		$row["sch"]="休み";
		$cast_dat[]=$row;
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


.td_top{
	background	:#f0f0ff;
	text-align	:center;
	font-size	:14px;
}

.td_sort{
	width		:30px;
	text-align	:center;
	background	:#a06000;
	color		:#fafafa;
}

.td_40{
	width		:40px;
	background	:#fafafa;
	text-align	:center;
}

.td_60{
	width		:60px;
	background	:#fafafa;
}

.td_100{
	width		:100px;
	background	:#fafafa;
	text-align	:center;
}

.td_200{
	width		:200px;
	background	:#fafafa;
}


.td_sort_up,.td_sort_down{
	display		:inline-block;
	position	:absolute;
	left		:0;
	right		:0;
	margin		:auto;
	width		:30px;
	height		:22px;
	line-height	:22px;
	background	:#d0d0d0;
	text-align	:center;
}

.td_sort_down{
	bottom:5px;
}

.td_sort_up{
	top:5px;
}

.td_sort_middle{
	display		:inline-block;
	position	:absolute;
	left		:0;
	right		:0;
	margin		:auto;
	top			:0;
	bottom		:0;
	height		:26px;
	background	:#fafafa;
	border		:1px solid #303030;
	text-align	:right;
	width		:24px;
	padding		:2px;
}
.box_inout{
	display			:block;
	height			:30px;
	width			:100%;
	margin			:10px 3px;
}

.tag_inout{
	display			:inline-block;
	height			:30px;
	line-height		:30px;
	width			:20px;
	font-size		:15px;
	font-weight		:700;
	text-align		:center;
	vertical-align	:top;
}

.sel_inout{
	width:80px;
}
-->
</style>
<script>
$(function(){ 
});
</script>
<header class="head">
<input id="sel_date" type="date" name="sche_date" value="<?=$sel_date?>" class="sel_date">
<?=$st_day?> - <?=$ed_day?><br>
</header>
<div class="wrap">
<div class="main_box">
<table>
	<tr>
		<td class="td_top" colspan="2">キャスト名</td>
		<?for($n=0;$n<7;$n++){?>
		<td class="td_top">
			<?=date("m年d月",strtotime($st_day)+($n*86400))?>
			[<?=$week[date("w",strtotime($st_day)+($n*86400))]?>]
		</td>
		<?}?>
	</tr>
<?foreach($cast_dat as $a1=> $a2){?>
<tr>
	<td class="w60"><img src="<?=$a2["face"]?>?t=<?=time()?>" style="width:60px; height:80px;"></td>
	<td class="w200"><?=$a2["genji"]?><br>[<?=$a2["genji_kana"]?>]</td>
	<?for($n=0;$n<7;$n++){?>
		<?
			$tmp_day=date("Ymd",strtotime($st_day)+($n*86400));
			if(!$stime[$a2["id"]][$tmp_day]) $stime[$a2["id"]][$tmp_day]="休み";
		?>
		<td class="td_inout w120">
			<div class="box_inout">
				<span class="tag_inout">入</span>
				<select class="sel_inout">
				<option value="" <?if($stime[$a2["id"]][$tmp_day]== "休み"){?> selected="selected"<?}?>>休み</option>
					<?foreach($sch_table["in"] as $b2){?>
						<option value="<?=$b2?>" <?if($b2 == $stime[$a2["id"]][$tmp_day]){?> selected="selected"<?}?>><?=$b2?></option>
					<?}?>
				</select>
			</div>

			<div class="box_inout">
				<span class="tag_inout">退</span>
				<select class="sel_inout">
					<option value="" <?if($stime[$a2["id"]][$tmp_day]== "休み"){?> selected="selected"<?}?>>　</option>
					<?foreach($sch_table["out"] as $b2){?>
						<option value="<?=$b2?>" <?if($b2 == $etime[$a2["id"]][$tmp_day]){?> selected="selected"<?}?>><?=$b2?></option>
					<?}?>
				</select>
			</div>
		</td>
	<?}?>
</tr>
<?}?>
</table>
</div>
</div>
<footer class="foot"></footer> 
