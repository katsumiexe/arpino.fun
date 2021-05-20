<?
/*
$start_time	=$admin_config["start_time"];
$start_week	=$admin_config["start_week"];
*/

$ck_date=$_POST["sk_date"];
if(!$ck_date) $ck_date=substr($day_8,0,4)."-".substr($day_8,4,2)."-".substr($day_8,6,2);

$tmp_d=strtotime($ck_date);
$tmp_week=date("w",$tmp_d);
$st_day=date("Ymd",$tmp_d-($tmp_week+$start_week)*86400)
$ed_day=date("Ymd",$tmp_d-($tmp_week+$start_week)*86400+604800)

$sql=" SELECT C.id, genji, ctime, stime, etime, cast_id, sort FROM wp01_0cast AS C";
$sql.=" LEFT JOIN wp01_0schedule AS S ON C.id=S.cast_id";
$sql.=" LEFT JOIN wp01_0sch_table AS T ON S.stime=T.name";
$sql.=" WHERE sche_date>='{$st_day}'";
$sql.=" AND sche_date<'{$ed_day}'";
$sql.=" AND C.del=0";

$sql.=" ORDER BY S.id ASC, C.id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($row["stime"] && $row["etime"]){
			$cast_dat[$row["id"]]["sch"]="{$row["stime"]} － {$row["etime"]}";
			$cast_dat[$row["id"]]["sort"]=$row["sort"];

		}else{
			$cast_dat[$row["id"]]["sch"]="休み";
			$cast_dat[$row["id"]]["sort"]=9999;
		}

		if (file_exists("../img/profile/{$row["id"]}/0.jpg")) {
			$cast_dat[$row["id"]]["face"]="../img/profile/{$row["id"]}/0.jpg";			


		}else{
			$cast_dat[$row["id"]]["face"]="../img/cast_no_image.jpg";			
		}



	}
}
asort($sort);

?>
<style>
<!--
input[type=text]{
	height:30px;
}

input[type="checkbox"],input[type="radio"]{
	display:none;
}

.sel_contents{
	display			:inline-block;
	background		:#bbbbbb;
	width			:150px;
	height			:30px;
	line-height		:30px;
	margin			:5px;
	border-radius	:5px;
	color			:#fafafa;
	font-size		:18px;
	font-weight		:600;
	text-align		:center;
}

input[type=radio]:checked + label{
	background		:linear-gradient(#ff0000,#d00000);
}


.head{
	display			:inline-block;
	position		:fixed;
	top				:0;
	left			:180px;
	width			:calc(100vw - 180px);
	height			:50px;
	background		:#0000d0;
	z-index:10;
}

.foot{
	display			:inline-block;
	position		:fixed;
	bottom			:0;
	left			:180px;
	width			: calc(100vw - 180px);
	height			:30px;
	background		:#00d000;
	z-index			:10;
}

.wrap{
	display			:inline-flex;
	margin			:50px 0 30px 0;
	width			:1200px;

}

.icon{
	font-family:at_icon;
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
<?foreach($cast_dat as $a1=> $a2){?>
<tr>
<td></td>
</tr>
<?}?>
</table>
	</div>
</div>
<footer class="foot"></footer> 
