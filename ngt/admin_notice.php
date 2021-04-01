<?
$sql	 ="SELECT * FROM wp01_0notice";
$sql	.=" WHERE N.del=0";
$sql	.=" ORDER BY `date` DESC";
$sql	.=" LIMIT 10";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$sql	 ="SELECT id, genji, cast_group, K.status FROM wp01_0notice_ck AS K";
		$sql	.=" LEFT JOIN  wp01_0cast AS C ON K.cast_id=C.id";
		$sql	.=" WHERE C.del=0";
		$sql	.=" AND notice_id=$row["id"]";

		if($result2 = mysqli_query($mysqli,$sql)){
			while($row2 = mysqli_fetch_assoc($result2)){
				$dat2[$row["id"]][]=$row2;
			}
		}

		$dat[]=$row;
		$count_dat++;
	}
}

//■キャストリスト----
$sql	 ="SELECT id, genji, cast_group, cast_status FROM wp01_0cast";
$sql	.=" WHERE del=0";
$sql	.=" ORDER BY id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cast_dat[]=$row;
	}
}

//■グループ名・カテゴリ名----
$sql	 ="SELECT id, genji, cast_group, cast_status FROM wp01_0cast";
$sql	.=" WHERE del=0";
$sql	.=" ORDER BY id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cast_dat[]=$row;
	}
}


?>

<style>
<!--

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

.main_box{
	display:inline-block;
	flex-basis:800px;
	background:#e0e000;
	min-height:calc(100vh - 80px);
}

.sub_box{
	display:inline-block;
	flex-basis:400px;
	background:#008040;
	min-height:calc(100vh - 80px);
}

-->
</style>
<script>
$(function(){ 
});
</script>
<header class="head">
<input id="sel_contents_0" value="1" type="radio" name="sel_contents" checked="checked"><label id="label_contents_0" for="sel_contents_0" class="sel_contents">イベント</label>
<input id="sel_contents_1" value="2" type="radio" name="sel_contents"><label id="label_contents_1" for="sel_contents_1" class="sel_contents">NEWS</label>
<input id="sel_contents_2" value="3" type="radio" name="sel_contents"><label id="label_contents_2" for="sel_contents_2" class="sel_contents">お知らせ</label>
<input id="sel_contents_3" value="4" type="radio" name="sel_contents"><label id="label_contents_3" for="sel_contents_3" class="sel_contents">SYSTEM</label>
<input id="sel_contents_4" value="5" type="radio" name="sel_contents"><label id="label_contents_4" for="sel_contents_4" class="sel_contents">ACCESS</label>
<input id="sel_contents_5" value="6" type="radio" name="sel_contents"><label id="label_contents_5" for="sel_contents_5" class="sel_contents">REQRUIT</label>
</header>
<div class="wrap">
	<div class="main_box">

<table>
<tr>
<td>日時</td>
<td>カテゴリ</td>
<td>投稿者</td>
<td>件名</td>
<td>グループ</td>
</tr>

<?for($n=0;$n<$count_dat;$N++){?>
<tr>
<td><?=$dat[$n]["date"]?></td>
<td>カテゴリ</td>
<td>投稿者</td>
<td>件名</td>
<td>グループ</td>
</tr>



	</div>
	<div class="sub_box">


	</div>
</div>
<footer class="foot"></footer>
