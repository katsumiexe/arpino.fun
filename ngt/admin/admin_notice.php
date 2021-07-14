<?
$tag["cast_group"][0]		="全て";

$pg = $_POST["pg"];
if( $pg + 0 == 0 ) $pg = 1;

$pg_st	=($pg-1) * 10;
$pg_ed	=$pg_st + 10;

$notice_month	=$_POST["notice_month"];
if(!$notice_month) $notice_month=date("Y-m");

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

		$gp[$row["group"]][$row["staff_id"]]=1;
		$staff_dat[]=$row;
	}
}

//■グループ名・カテゴリ名----
$sql	 ="SELECT id, tag_group, tag_name, sort FROM wp01_0tag";
$sql	.=" WHERE del=0";
$sql	.=" AND( tag_group='cast_group' OR tag_group='notice_category')";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["tag_group"]][$row["id"]]=$row["tag_name"];
	}
}


if($_POST["notice_set"]){
	$display_date		=$_POST["display_date"];
	$notice_category	=$_POST["notice_category"];
	$notice_title		=$_POST["notice_title"];
	$notice_contents	=$_POST["notice_contents"];
	$gp_check			=$_POST["gp_check"];

	foreach($gp_check as $a1 => $a2){
		if($a1 >0 && $a2>0){
			$cast_group.=$a1.",";
			$n_cnt++;
		}
	}

	$display_date		=substr($display_date,0,10)." ".substr($display_date,11,5).":00";
	$cast_group=substr($cast_group,0,-1);
	
	$sql	 ="INSERT INTO wp01_0notice(`date`,`title`,`log`,`category`,`cast_group`)";
	$sql	 .=" VALUES('{$display_date}','{$notice_title}','{$notice_contents}','{$notice_category}','{$cast_group}')";
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli);

	foreach($gp_check as $a1 => $a2){
		if($a1 >0 && $a2>0){
			foreach($gp[$a1] as $b1 => $b2){
				$app_ck.="('{$tmp_auto}','{$b1}','1'),";
			}
		}
	}
	$app_ck=substr($app_ck,0,-1);
		
	$sql	 ="INSERT INTO wp01_0notice_ck(`notice_id`,`cast_id`,`status`) VALUES ";
	$sql	 .=$app_ck;
	mysqli_query($mysqli,$sql);
}

$sql	 ="SELECT * FROM wp01_0notice";
$sql	.=" WHERE del=0";
$sql	.=" AND date LIKE '{$notice_month}%'";
$sql	.=" ORDER BY `date` DESC";



if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$s=explode(",",$row["cast_group"]);

		$row["group"]="";
		for($n=0;$n<count($s);$n++){
			$row["group"].="<span class=\"group_item\">{$tag["cast_group"][$s[$n]]}</span>/";
		}
		$row["group"]=substr($row["group"],0,-1);

		$row["log"]=str_replace("\n","<br>",$row["log"]);
		$row["date"]=str_replace("-",".",substr($row["date"],0,16));

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

if($pg_ed>$count_dat){
	$pg_ed	=$count_dat;
}

echo $count_dat;

$pg_max=ceil($count_dat/10);

$ck_cnt=count($tag["cast_group"])-1;

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
	display			:inline-block;
	flex-basis		:800px;
	background		:#e0e000;
	min-height		:calc(100vh - 80px);
}

.sub_box{
	display			:inline-block;
	flex-basis		:400px;
	background		:#008040;
	min-height		:calc(100vh - 80px);
}

.cate_title{
	display			:inline-block;
	width			:210px;
	height			:30px;
	line-height		:30px;
	font-size		:15px;
	padding-left	:5px;
	text-align		:left;
	margin-left		:5px;
	color			:#fafafa;
	font-weight		:600;
}

.cate_ul{
	width			:240px;
	margin			:10px 5px;
	border-radius	:5px;
	box-shadow		:3px 3px 3px rgba(30,30,30,0.5);
	padding			:5px;
}

.cate_li{
	display			:inline-block;
	width			:225px;
	height			:30px;
	line-height		:30px;
	margin			:0 0 1px 10px;
	padding-left	:5px;
	font-size		:15px;
	color			:#ffffff;	
}

.c_pink{
	background:#ff7090;
}
.c_pink2{
	background:#ffa0c0;
}
.c_pink2:hover{
	background:#ff7898;
}


.c_blue{
	background:#4068e0;
}
.c_blue2{
	background:#80a8e0;
}

.c_blue2:hover{
	background:#6088e0;
}


.c_green{
	background:#00a010;
}

.c_green2{
	background:#30e040;
}

.c_green2:hover{
	background:#00b020;
}

.notice_table{
	margin			:5px auto;
	background		:#fafafa;
	border			:1px solid #303030;
}

.notice_list{
	border			:1px solid #303030;
	color			:#202020;
	height			:20px;
	line-height		:20px;
	padding-left	:5px;
	font-size		:14px;
}

.notice_hidden{
	display:none;
}

.tr_list{
	cursor:pointer;
}

.tr_list:hover{
	background:#f0e8d0;
}

.notice_log{
	margin			:5px auto;
	width			:740px;
	height			:400px;
	padding			:10px;
	font-size		:14px;
	line-height		:24px;
	border			:1px solid #303030;
	border-radius	:5px;
	background		:#fafafa;
	overflow-y		:scroll;
}

.group_box{
	font-size	:0;
	display		:flex;
	background	:#eeeeee;
}

.gp_check{
	display		:none;
}
.notice_regist{
	background:#e0e0e0;
	width:750px;
	margin:5px auto;
	padding:5px;
	border:1px solid #303030;
}


.p_check_btn{
	display			:inline-block;
	font-size		:15px;
	padding			:5px 10px;
	margin			:2px;
	background		:#c0c0c0;
	text-align		:left;
	width			:90px;
	border-radius	:5px;
	color			:#fafafa;
	font-weight		:600;
	cursor			:pointer;
}

.gp_check:checked + label{
	background:#d00000;
}

#p_check0{
	width			:60px;
	background		:#c0c0ff;
}

#gp_check0:checked + label{
	background:#0000d0;
}

.notice_pager{
	background:#fafafa;
	font-size:14px;
	color:#202200;
}
-->
</style>
<script>
$(function(){ 
	var Cnt=0;
	$('.tr_list').on('click',function(){ 
		var Tmp=$(this).children('.notice_hidden').html();
		$('.notice_log').html(Tmp);
	});

	$('#gp_check0').on('change',function(){ 
		if($(this).prop('checked')==true){
			$('.gp_check').prop('checked', true);

		}else{
			$('.gp_check').prop('checked', false);
		}
	});
});
</script>
<header class="head">
<input id="sel_date" type="month" name="notice_month" value="<?=$notice_date?>" class="w140" style="margin:9px 1px">
　
<?for($n=0;$n<$pg_max;$n++){?>
<span class="notice_pager"><?print($n+1);?></span>
<?}?>
</header>
<div class="wrap">
	<div class="main_box">
		<table class="notice_table">
			<tr>
				<td class="td_top w150">日時</td>
				<td class="td_top w250">件名</td>
				<td class="td_top w100">カテゴリ</td>
				<td class="td_top w250">グループ</td>
			</tr>
			<?for($n=$pg_st;$n<$pg_ed;$n++){?>
			<tr class="tr_list">
				<td class="notice_list"><?=$dat[$n]["date"]?></td>
				<td class="notice_list"><?=$dat[$n]["title"]?></td>
				<td class="notice_list"><?=$tag["notice_category"][$dat[$n]["category"]]?></td>
				<td class="notice_list"><?=$dat[$n]["group"]?></td>
				<td class="notice_hidden"><?=$dat[$n]["log"]?></td>
			</tr>
			<?}?>
		</table>
		<div class="notice_regist">
			<form action="./index.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="menu_post" value="notice">
				<input type="hidden" name="notice_set" value="new">

				<span class="event_tag">日付</span>
				<input type="datetime-local" name="display_date" class="w200" value="<?=date("Y-m-d")?>T<?=date("H:i")?>" autocomplete="off">
				<span class="event_tag">カテゴリ</span>
				<select name="notice_category" style="width:150px;">
					<?foreach($tag["notice_category"] as $a1 => $a2){?>
						<option value="<?=$a1?>"><?=$a2?></option>
					<? } ?>
				</select>
				<button type="submit" class="event_reg_btn">登録</button><br>
				<span class="event_tag">TITLE</span>
				<input type="text" name="notice_title" style="width:450px;" value="">

				<div class="group_box">
					<?foreach($tag["cast_group"] as $a1 => $a2){?>
						<input id="gp_check<?=$a1?>" type="checkbox" name="gp_check[<?=$a1?>]" class="gp_check" value="1">
						<label id="p_check<?=$a1?>" for="gp_check<?=$a1?>" class="p_check_btn"><?=$a2?></label>
					<?}?>
				</div>
				<textarea name="notice_contents" class="event_td_4_in"></textarea>
			</form>
		</div>
		<div class="notice_log"></div>
	</div>

	<div class="sub_box">
		<ul class="cate_ul c_blue">
			<li class="cate_title">MENU</li>
			<li class="cate_li c_blue2">投稿</li>
			<li class="cate_li c_blue2">検索</li>
		</ul>

		<ul class="cate_ul c_green">
			<li class="cate_title">グループ</li>
			<?foreach($tag["cast_group"] as $a1 => $a2){?>
			<li id="group_<?=$a1?>" class="cate_li c_green2"><?=$a2?></li><?}?>
		</ul>

		<ul class="cate_ul c_green">
			<li class="cate_title">カテゴリー</li>
			<li id="category_0" class="cate_li c_green2">全て</li>
			<?foreach($tag["notice_category"] as $a1 => $a2){?>
			<li id="category_<?=$a1?>" class="cate_li c_green2"><?=$a2?></li><?}?>
		</ul>

		<ul class="cate_ul c_pink">
			<li class="cate_title">スタッフ</li>
			<?foreach($staff_dat as $a1 => $a2){?>
			<li class="cate_li c_pink2"><?=$a2["user_name"]?></li><?}?>
		</ul>
	</div>
</div>
<footer class="foot"></footer>
