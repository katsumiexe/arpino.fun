<?
include_once("./library/session.php");

$date_val	=$_POST["date_val"];
if(!$date_val) $date_val=date("Ymd");

$new_id		=$_POST["new_id"];
$new_name	=$_POST["new_name"];
$new_pass	=$_POST["new_pass"];
$new_rank	=$_POST["new_rank"];

if($_POST["set_id"]){
	$set_id		=$_POST["set_id"];
	$set_month	=$_POST["set_month"];
	$stime		=$_POST["stime"];
	$etime		=$_POST["etime"];

	$sql="INSERT INTO `schedule`(sche_date, cast_id, stime, etime) VALUES";
	for($n=1;$n<count($stime)+1;$n++){
		$tmp_month=$set_month*100+$n;
		$sql.="('{$tmp_month}', '{$set_id}', '{$stime[$n]}', '{$etime[$n]}'),";
	}
	$sql=substr($sql,0,-1);
	mysqli_query($mysqli,$sql);
	print($sql);
}




if($new_id && $new_name && $new_pass && $new_rank){
	$sql="INSERT INTO `cast`(cast_id, name, pass, rank)";
	$sql.=" VALUES('{$new_id}', '{$new_name}', '{$new_pass}', '{$new_rank}')";
	mysqli_query($mysqli,$sql);
}


$sql ="SELECT * FROM cast";
$dat0 = mysqli_query($mysqli,$sql);
while($dat1 = mysqli_fetch_assoc($dat0)){
	$cast[$dat1["cast_id"]]=$dat1;

	$tmp_max[$dat1["cast_id"]]=$dat1["cast_id"];
}
$max_id=max($tmp_max)+1;

$sql ="SELECT * FROM schedule";
$sql.=" WHERE sche_date='{$date_val}'";

$dat_a0 = mysqli_query($mysqli,$sql);
while($dat_a1 = mysqli_fetch_assoc($dat_a0)){

	if($dat_a1["etime"]+0 ==0 && $dat_a1["etime"]){
		$dat_a1["etime"]=2400;
	}

	if($dat_a1["stime"]+0 ==2400){
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
	padding			:5px;
	font-size		:13px;
	border-bottom	:1px solid #806000;
	background		:#fff0d0;
	font-weight		:600;
	color			:#605040;
	text-align		:left;
}
.menu4{
	display:none;
	width			:215px;
	background		:#806000;
	padding			:0px;
	text-align		:right;
}


.menu5{
	display			:inline-block;
	width			:195px;
	padding			:5px;
	background		:#fafafa;
	border-bottom	:1px solid #303030;
	color			:#303030;
	font-size		:13px;
	text-align		:left;
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
	text-align:center;
	background:#f0f0f0;
}

.td_name{
	border:1px solid #303030;
	width:160px;
	text-align:center;
	background:#f0f0f0;
}

.td_time{
	border:1px solid #303030;
	width:40px;
	text-align:center;
	background:#f0f0f0;
}

.td_time2{
	width:20px;
	background:#f0f0f0;
	border-bottom:1px solid #303030;

}

.td_hour{
	width:30px;
	text-align:center;
	border-bottom:1px solid #303030;
	background:#f0f0f0;
}

.td_hour2{
	width:15px;
	text-align:center;
	border-bottom:1px solid #303030;
	background:#f0f0f0;
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

.box2{
	width			:50px;
	height			:20px;
	font-size		:15px;
	border			:none;
	text-align		:center;
	margin:0;
}


.td_b{
	border-left		:1px solid #303030;	
	border-bottom	:1px solid #303030;	
}

.td_c{
	border-left		:1px solid #d0d0d0;	
	border-bottom	:1px solid #303030;	
}

.td_d{
	border-left		:1px solid #303030;	
	border-bottom	:1px solid #303030;	
	background:#303030;
}

.td_right{
	text-align:right;
}

.td_sch{
	text-align:right;
	border:1px solid #303030;
	background:#ffffff;
}

#set{
	display:none;
}
.sch_id{
	display		:inline-block;
	width		:50px;
	height		:22px;
	line-height	:22px;

	font-size	:14px;
	border		:1px solid #303030;
	margin		:5px 0;
	padding-left:5px;
}

.sch_name{
	display		:inline-block;
	width		:152px;
	height		:22px;
	line-height	:22px;
	font-size	:14px;
	border		:1px solid #303030;
	margin		:5px 0;
	padding-left:5px;
}
.sch_set{
	width		:50px;
	height		:24px;
	font-size	:14px;
	margin		:5px 10;
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script>
</script>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>  

<script>
$(function() {

<?if($date_val){?>
	$(".ui-state-default").removeClass("ui-state-highlight");
	console.log(<?=$date_val?>);
/*
var printDate='';
var index = $('li.some-item').index(this);
$('td').attr('data-handler')=='selectDay'
*/


<?}?>

	$("#datepicker").datepicker({
		firstDay: 1,
		setDate: '<?=$date_val?>',
		dateFormat:'yymmdd',
		onSelect: function(dateText, inst) {
			$("#date_val").val(dateText);
			$("#forms").submit();
		}
	});

	$("#set_cast").on('click',function(){
		$("#set").show()
		$("#sche,#person").hide()
		$("list_#person").slideUp(100);
	});

	$("#set_list").on('click',function(){
		$("#set,#person").hide()
		$("#sche").show()
		$("#list_person").slideUp(100);
	});

	$("#set_person").on('click',function(){
		$("#set,#sche").hide()
		$("#person").show()
		if($("#list_person").css('display') == 'none'){
			$(this).css({'background':'#806000','color':'#fafafa'})
			$("#list_person").slideDown(100);

		}else{
			$(this).css({'background':'#fff0d0','color':'#605040'})
			$("#list_person").slideUp(100);
		}
	});

	$(".menu5").on('click',function(){
		CastId=$(this).attr('id').replace('l','');
		Name=$(this).attr('name');

		$(".menu5").css({'background':'#fafafa','color':'#303030'})
		$(this).css({'background':'#d0e0ff','color':'#0000d0'})

		$.post("post_set_sche.php",
			{
				'cast_id':CastId,
				'name':Name,
				'month':'<?=$date_val?>',
			},
			function(data){
				$('#person').html(data);				
		});
	});


});


</script>
</head>
<body class="body">
<form id="forms" action="index.php" method="post">
<div class="menu">
	<div class="menu1">スケジュール</div>
	<div class="menu2">
	<div id="datepicker"></div>
	<input type="hidden" id="date_val" name="date_val" value="<?=$date_val?>"></p>
	</div>
	<div class="menu1">CAST情報</div>
	<div id="set_cast" class="menu3">登録</div>
	<div id="set_list" class="menu3">一覧</div>
	<div id="set_person" class="menu3">個別</div>
	<div id="list_person" class="menu4">
	<?foreach($cast as $a1 => $a2){?>
	<div id="l<?=$cast[$a1]["cast_id"]?>" class="menu5" name="<?=$cast[$a1]["name"]?>"><?=$cast[$a1]["cast_id"]?>　<?=$cast[$a1]["name"]?></div>
	<?}?>
	</div>
</div>
</form>




<div class="main">
<div id="set">
<form id="chg" action="index.php" method="post">
<input type="hidden" name="new_id" value="<?=$max_id?>">
<table class="table">
<tr>
<td class="td_ttl">ID</td><td class="td_box"><?=$max_id?></td>
</tr>

<tr>
<td class="td_ttl">名前</td><td class="td_box"><input type="text" name="new_name" class="box"></td>
</tr>

<tr>
<td class="td_ttl">PASS</td><td class="td_box"><input type="text" name="new_pass" class="box"></td>
</tr>

<tr>
<td class="td_ttl">ランク</td><td class="td_box"><input type="text" name="new_rank" class="box" style="text-align:right;"></td>
</tr>
</table>
<button class="ttl_btn" type="submit">登録</button>
</form>
</div>
<div id="person">

</div>

<div id="sche">
<table class="table">
<tr>
<td class="td_id">ID</td>
<td class="td_name">名前</td>
<td class="td_time">時間</td>
<td class="td_time2"></td>
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
<td class="td_hour2"><span class="td_in">00</span></td>
</tr>

<?foreach((array)$cast as $a1 => $a2){?>
<tr>
<td class="td_b"><?=$cast[$a1]["cast_id"]?></td>
<td class="td_b"><?=$cast[$a1]["name"]?></td>

<td class="td_b td_right"><?=$all[$a1]?></td>
<td class="td_d"></td>
<?for($n=0;$n<24;$n++){?>
<td class="td_c <?=$sche[$cast[$a1]["cast_id"]][$n]?>"></td>
<?}?>
<td class="td_d"></td>

</tr>
<?}?>
</table>
</div>
</div>
</body>
</html>
