<?
include_once("./library/session.php");

$t_day=$_POST["t_day"];
if(!$t_day) $t_day=date("Ymd");

$sql.="SELECT * FROM cast";
$dat0 = mysqli_query($mysqli,$sql);
while($dat1 = mysqli_fetch_assoc($dat0)){
	$cast[$dat1["cast_id"]]=$dat1;
	$tmp_max[$dat1["cast_id"]]=$dat1["cast_id"];
}
$max_id=max($tmp_max);

$sql ="SELECT * FROM schedule";
$sql.=" WHERE sche_date='{$t_day}'";

$dat_a0 = mysqli_query($mysqli,$sql);
while($dat_a1 = mysqli_fetch_assoc($dat_a0)){

	if($dat_a1["etime"]+0 ==0 ){
		$dat_a1["etime"]=2400;
	}

	if($dat_a1["stime"]+0 ==2400 ){
		$dat_a1["stime"]=0;
	}

	for($n=0;$n<24;$n++){
		if($n*100+30 ==$dat_a1["stime"]+0){
			$sche[$dat_a1["cast_id"]][$n]="in1";

		}elseif($n*100 >=$dat_a1["stime"]+0 && $n*100 <$dat_a1["etime"]+0){

			if($n*100+30 ==$dat_a1["etime"]+0){
				$sche[$dat_a1["cast_id"]][$n]="in3";

			}else{
				$sche[$dat_a1["cast_id"]][$n]="in2";
			}
		}
	}
	$all[$dat_a1["cast_id"]]=($dat_a1["etime"]-$dat_a1["stime"])/100;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="robots" content="noindex">
<style>

.in1{
	background: linear-gradient(to right, #ffffff 50%, #ffe0e0 50% 100%);

}

.in2{
	background:#ffe0e0;
}

.in3{
	background: linear-gradient(to left, #ffffff 50%, #ffe0e0 50% 100%);
}



.menu{
	display			:inline-block;
	position		:absolute;
	top				:5px;
	left			:5px;	
	width			:210px;
	height			:95vh;
	padding			:5px;
	background		:#ffffee;
	text-align		:center;
}

.menu1{
	width			:205px;
	height			:24px;
	line-height		:24px;
	padding			:3px 5px;
	font-size		:16px;
	border-bottom	:3px solid #806000;
	background		:#f5deb3;
	background		:linear-gradient(#f5deb3, #d2b48c);
	font-weight		:800;
	color			:#ffffff;
	text-shadow		:1px 1px 2px #604000;;
}

.menu2{
	text-align:center;
	padding:5px;
	height:260px;
}

.menu3{
	width			:205px;
	padding			:3px 5px;
	font-size		:12px;
	border-bottom	:1px solid #806000;
	background		:#fff0d0;
	font-weight		:600;
	color			:#605040;
	text-align		:right;
}


.menu4{
	display			:inline-block;
	width			:205px;
	padding			:3px 5px;
	font-size		:12px;
	border-bottom	:1px solid #806000;
	background		:#fff0d0;
	font-weight		:600;
	color			:#605040;
	text-align		:right;
}

.menu_btn{
	width			:120px;
	background		:linear-gradient(#d0d0d0, #b0b0b0);
	font-weight		:800;
	color			:#f5f5ff;
	text-shadow		:1px 1px 0px rgba(0,0,5,1);
	font-size		:13px;
	margin			:10px 7px;
}

.ttl_btn{
	width			:220px;
	background		:linear-gradient(#d0d0d0, #b0b0b0);
	font-weight		:800;
	color			:#f5f5ff;
	text-shadow		:1px 1px 0px rgba(0,0,5,1);
	font-size		:15px;
	margin			:10px 7px;
}

.main{
	display			:inline-block;
	position		:absolute;
	top				:5px;
	left			:230px;	
	width			:1000px;
	height			:95vh;
	padding			:5px;
	background		:#fafafa;
	overflow-y		:scroll;
}


.td_id{
	border:1px solid #303030;
	height:20px;
	width:60px;
}

.td_name{
	border:1px solid #303030;
	width:160px;
}

.td_time{
	border:1px solid #303030;
	width:60px;
}

.td_hour{
	width:30px;
	text-align:center;
	border-bottom:1px solid #303030;
}


.table{
	border:1px solid #303030;
	border-collapse: collapse;
}

td{
	position:relative;
	padding:3px;
	font-size:12px;
}


.td_in{
	display:inline-block;
	position:absolute;
	top:3px;
	left:-15px;
	width:30px;
	height:20px;
}
.ui-datepicker {
	width:200px !important;

}

.td_ttl{
	width			:80px;
	background		:#fff0d0;
	border			:1px solid #806000;
}

.td_box{
	width			:150px;
	background		:#fafafa;
	border			:1px solid #806000;
}


.box{
	width			:148px;
	height			:30px;
	font-size		:16px;
	border			:none;
}

.td_c{
	border-left		:1px solid #d0d0d0;	
	border-bottom	:1px solid #303030;	
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>  
<script>
$(function() {
	$("#datepicker").datepicker({
		onSelect: function(dateText, inst) {
			$("#date_val").val(dateText);
		}
	});
});
</script>
</head>

<body class="body">
<div class="menu">
	<div class="menu1">スケジュール</div>
	<div class="menu2">
	<div id="datepicker"></div>
	<input type="hidden" id="date_val"/></p>
	</div>
	<div class="menu1">CAST情報</div>
	<div class="menu3">登録</div>
	<div class="menu3">一覧</div>
</div>
<div class="main">

<form action="index.php" method="post">
<table class="table">
<tr>
<td class="td_ttl">ID</td><td class="td_box"></td>
</tr>

<tr>
<td class="td_ttl">名前</td><td class="td_box"><input type="text" name="new_name" class="box"></td>
</tr>

<tr>
<td class="td_ttl">PASS</td><td class="td_box"><input type="text" name="new_name" class="box"></td>
</tr>

<tr>
<td class="td_ttl">ランク</td><td class="td_box"><input type="text" name="new_name" class="box" style="text-align:right;"></td>
</tr>
</table>
<button class="ttl_btn" type="submit">登録</button>
</form>

<table class="table">
<tr>
<td class="td_id">ID</td>
<td class="td_name">名前</td>
<td class="td_time">時間</td>
<td class="td_hour"><span class="td_in">00</span></td>
<td class="td_hour"><span class="td_in">01</span></td>
<td class="td_hour"><span class="td_in">02</span></td>
<td class="td_hour"><span class="td_in">03</span></td>
<td class="td_hour"><span class="td_in">04</span></td>
<td class="td_hour"><span class="td_in">05</span></td>
<td class="td_hour"><span class="td_in">06</span></td>
<td class="td_hour"><span class="td_in">07</span></td>
<td class="td_hour"><span class="td_in">08</span></td>
<td class="td_hour"><span class="td_in">09</span></td>
<td class="td_hour"><span class="td_in">10</span></td>
<td class="td_hour"><span class="td_in">11</span></td>
<td class="td_hour"><span class="td_in">12</span></td>
<td class="td_hour"><span class="td_in">13</span></td>
<td class="td_hour"><span class="td_in">14</span></td>
<td class="td_hour"><span class="td_in">15</span></td>
<td class="td_hour"><span class="td_in">16</span></td>
<td class="td_hour"><span class="td_in">17</span></td>
<td class="td_hour"><span class="td_in">18</span></td>
<td class="td_hour"><span class="td_in">19</span></td>
<td class="td_hour"><span class="td_in">20</span></td>
<td class="td_hour"><span class="td_in">21</span></td>
<td class="td_hour"><span class="td_in">22</span></td>
<td class="td_hour"><span class="td_in">23</span></td>
<td class="td_hour"><span class="td_in">00</span></td>
</tr>

<?foreach((array)$cast as $a1 => $a2){?>
<tr>
<td class="td_b"><?=$cast[$a1]["cast_id"]?></td>
<td class="td_b"><?=$cast[$a1]["name"]?></td>

<td class="td_b"><?=$all[$a1]?></td>
<?for($n=0;$n<24;$n++){?>
<td class="td_c <?=$sche[$cast[$a1]["cast_id"]][$n]?>"></td>
<?}?>
<td></td>
</tr>
<?}?>

</table>


</div>
</body>
</html>

