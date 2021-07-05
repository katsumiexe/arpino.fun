<?
$tag["cast_group"][0]		="全て";
$tag["notice_category"][0]	="全て";

if($notice_set){

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
$sql	.=" AND( tag_group='cast_group' OR tag_group='notice_category')";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["tag_group"]][$row["id"]]=$row["tag_name"];
	}
}

$sql	 ="SELECT * FROM wp01_0notice";
$sql	.=" WHERE del=0";
$sql	.=" ORDER BY `date` DESC";
$sql	.=" LIMIT 10";
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
	width			:760px;
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


.check_on{
	background:#d00000;
}


-->
</style>
<script>
$(function(){ 
	$('.tr_list').on('click',function(){ 
		var Tmp=$(this).children('.notice_hidden').html();
		$('.notice_log').html(Tmp);
	});

	$('.gp_check').on('click',function(){ 
		var Tmp=$(this).attr('id');

		if(Tmp=='p_check0'){
			if($('#gp_check0').val()==0){
				$(this).siblings().addClass('check_on');
				$('#gp_check0').siblings().val('');
				$('#gp_check0').val('1');
			}

		}else{

			if($(this).hasClass('check_on')){
				Cnt--;
				if(Cnt>0){
					$(this).removeClass('check_on');
					$('#g'+Tmp).val('0');
				}else{
					$('#p_check0').siblings().removeClass('check_on');
					$('#p_check0').addClass('check_on');
					$('#gp_check0').siblings().val('');
					$('#gp_check0').val('1');
				}

			}else{
				Cnt++;
				if( Cnt >= <?=$ck_cnt+0?>){
					$('#p_check0').siblings().removeClass('check_on');
					$('#p_check0').addClass('check_on');
					$('#gp_check0').siblings().val('');
					$('#gp_check0').val('1');
	
				}else{
					$(this).addClass('check_on');
					$('#p_check0').removeClass('check_on');

					$('#g'+$(this).attr('id')).val('1');
					$('#gp_check0').val('0');
				}
			}
		}

	});



});
</script>

<header class="head">
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
			<?for($n=0;$n<$count_dat;$n++){?>
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
			<span class="event_tag">日付</span>
			<input type="datetime-local" name="display_date" class="w200" value="<?=date("Y-m-d")?>T<?=date("H:i")?>" autocomplete="off">
			<span class="event_tag">TITLE</span>
			<input type="text" name="notice_title" style="width:350px;" value="">
			<button  type="submit" class="event_reg_btn">登録</button>

			<div class="group_box">
				<?foreach($tag["cast_group"] as $a1 => $a2){?>
					<span id="p_check<?=$a1?>" class="p_check_btn"><?=$a2?></span>
				<?}?>
			</div>
			<div>
				<?foreach($tag["cast_group"] as $a1 => $a2){?>
					<input id="gp_check<?=$a1?>" type="hidden" value="" name="gp_check[<?=$a1?>]" class="gp_check">
				<?}?>
			</div>




			<textarea name="notice_contents" class="event_td_4_in"></textarea>
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

