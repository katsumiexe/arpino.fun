<?
$sql	 ="SELECT * FROM wp01_0notice";
$sql	.=" WHERE del=0";
$sql	.=" ORDER BY `date` DESC";
$sql	.=" LIMIT 10";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sql	 ="SELECT id, genji, cast_group, K.status FROM wp01_0notice_ck AS K";
		$sql	.=" LEFT JOIN  wp01_0cast AS C ON K.cast_id=C.id";
		$sql	.=" WHERE C.del=0";
		$sql	.=" AND notice_id={$row["id"]}";
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
$sql	 ="SELECT * FROM wp01_0staff AS S ";
$sql	.=" LEFT JOIN wp01_0cast AS C ON S.staff_id=C.id";
$sql	.=" WHERE S.del=0";
$sql	.=" ORDER BY S.sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["genji"]){
			$row["user_name"]=$row["genji"];

		}else{
			$row["user_name"]=$row["name"];
		
		}
		$staff_dat[]=$row;
	}
}

//■グループ名・カテゴリ名----
$sql	 ="SELECT id, tag_group, tag_name, sort FROM wp01_0tag";
$sql	.=" WHERE del=0";
$sql	.=" AND( tag_group='cast_group' OR tag_group='category')";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["tag_group"]][$row["id"]]=$row["tag_name"];
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
	display			:inline-block;
	flex-basis		:400px;
	background		:#008040;
	min-height		:calc(100vh - 80px);
}

.cate_title{
	display			:inline-block;
	width			:200px;
	height			:40px;
	line-height		:40px;
	font-size		:15px;
	background		:#d00000;
	padding-left	:5px;
	text-align		:left;
	margin			:10px 3px 0 3px;
	color			:#fafafa;
}

.cate_box{
	display			:inline-block;
	width			:200px;
	height			:40px;
	line-height		:40px;
	font-size		:15px;
	background		:#d00000;
	padding-left	:5px;
	text-align		:left;
	margin			:10px 3px 0 3px;
	color			:#fafafa;
}
.cate_list{
	display			:inline-block;
	width			:200px;
	height			:35px;
	line-height		:40px;
	font-size		:15px;
	background		:#fafafa;
	padding-left	:5px;
	text-align		:left;
	border-bottom	:1px solid #202020;
	margin			:3px;
}

-->
</style>
<script>
$(function(){ 
});
</script>
<header class="head">
</header>
<div class="wrap">
	<div class="main_box">
		<table class="notice_table">
			<tr>
				<td class="notice_top">日時</td>
				<td class="notice_top">カテゴリ</td>
				<td class="notice_top">投稿者</td>
				<td class="notice_top">件名</td>
				<td class="notice_top">グループ</td>
			</tr>
			<?for($n=0;$n<$count_dat;$n++){?>
			<tr>
				<td class="notice_140"><?=$dat[$n]["date"]?></td>
				<td class="notice_80"><?=$dat[$n]["date"]?></td>
				<td class="notice_140"><?=$dat[$n]["date"]?></td>
				<td class="notice_250"><?=$dat[$n]["date"]?></td>
				<td class="notice_80"><?=$dat[$n]["date"]?></td>
			</tr>
			<?}?>
		</table>
	</div>
	<div class="sub_box">
		<div class="cate_title">カテゴリー</div>
		<?foreach($tag["cast_group"] as $a1 => $a2){?>
			<span class="cate_list"><?=$a1?><?=$a2?></span><br>
		<?}?>
		<div class="cate_title">スタッフ</div>
		<?foreach($staff_dat as $a1 => $a2){?>
			<span class="cate_list"><?=$a1?><?=$a2["user_name"]?></span><br>
		<?}?>
	</div>
</div>
<footer class="foot"></footer>
