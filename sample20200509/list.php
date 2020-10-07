<?
$mysqli = mysqli_connect("localhost", "tiltowait_tmpl", "kk1941", "tiltowait_tmpl");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 


$st_day=$_POST["st_day"];
$ed_day=$_POST["ed_day"];

if($st_day){
	$st=date("Y-m-d 00:00:00",strtotime($st_day));
	$app.=" AND regist_time>='{$st}'";
}

if($ed_day){
	$ed=date("Y-m-d 00:00:00",strtotime($ed_day));
	$app.=" AND regist_time<'{$ed}'";
}


$sql ="SELECT * FROM zlog_20200509";
$sql.=" WHERE user_id IS NOT NULL";
$sql.=$app;


if($dat0 = mysqli_query($mysqli,$sql)){
	while($dat1 = mysqli_fetch_assoc($dat0)){
		$dat[]	 =$dat1;
		$csv	.=$dat1["regist_time"].",".$dat1["user_id"].",".$dat1["user_name"].",".$dat1["user_kana"].",".$dat1["user_mail"].",\n";
	}
}

$csv=mb_convert_encoding($csv,"SJIS", "UTF-8");
file_put_contents("./data.csv",$csv);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="robots" content="noindex">
<style>


.menu{
	display			:inline-block;
	position		:absolute;
	top				:5px;
	left			:5px;	
	width			:220px;
	height			:95vh;
	padding			:5px;
	background		:#ffeeee;
	text-align		:center;
}

.menu2{
	width		:140px;
	font-size	:13px;
	color		:#303030;
	font-weight	:600;
	text-align	:left;
}

.box{
	width:80px;
	height:20px;
	font-size:14px;
	margin:2px 2px 5px 5px;
}



.menu1{
	width		:210px;
	text-align	:center;
	margin		:0 auto;
}


.menu_btn{
	display			:inline-block;
	height			:30px;
	line-height		:30px;
	width			:180px;
	background		:linear-gradient(#ffe0d0, #ffc0a0);
	font-weight		:800;
	color			:#fafafa;
	text-shadow		:1px 1px 0px rgba(30,30,30,1);
	font-size		:15px;
	margin			:10px auto;
	text-decoration	:none;
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


.table{
	border:1px solid #303030;
	border-collapse: collapse;
}

td{
	position		:relative;
	padding			:3px;
	font-size		:12px;
	border			:1px solid #303030;
	height			:20px;
	line-height		:20px;
	text-align		:left;
	overflow		:hidden;
}


.td{
	background:#f0f0f0;
	text-align:center;
}


.td_date{
	width			:150px;
}

.td_id{
	width			:80px;
}


.td_name{
	width			:120px;
}


.td_kana{
	width			:120px;
}


.td_mail{
	width			:300px;
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
<form action="./list.php" method="post" >
	<div class="menu1">
		<span class="menu2">期間(YYYYMMDD)　</span>
		<button type="submit">変更</button>
		<input type="text" name="st_day" class="box" value="<?=$st_day?>"> - <input type="text" name="ed_day" class="box" value="<?=$ed_day?>">
	</div>
</form>
	<a href="./data.csv" class="menu_btn" download>CSVダウンロード</a>

</div>
<div class="main">

<table class="table">
<tr>
<td class="td td_date">date</td>
<td class="td td_id">USER_ID</td>
<td class="td td_name">USER_NAME</td>
<td class="td td_kana">USER_KANA</td>
<td class="td td_mail">USER_MAIL</td>
</tr>
<?for($n=0;$n<count($dat);$n++){?>
<tr>
<td class="td_b"><?=$dat[$n]["regist_time"]?></td>
<td class="td_b"><?=$dat[$n]["user_id"]?></td>
<td class="td_b"><?=$dat[$n]["user_name"]?></td>
<td class="td_b"><?=$dat[$n]["user_kana"]?></td>
<td class="td_b"><?=$dat[$n]["user_mail"]?></td>
</tr>
<?}?>
</table>
</div>
</body>
</html>

