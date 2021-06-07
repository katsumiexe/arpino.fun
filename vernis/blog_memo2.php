<?
$mysqli = mysqli_connect("210.150.110.204", "blue_db", "0909", "blue_db");
if(!$mysqli){
	die('ERROR!');
}
mysqli_set_charset($mysqli,'UTF8'); 

$pg=$_POST["pg"];
if(!$pg) $pg=1;
$p_st=($pg-1)*10;
$p_ed=($pg-1)*10+10;

$ope_sel	=$_POST["ope_sel"];
$memo_del	=$_POST["memo_del"];

if($_POST["new_ope"]){
	$new_date		=$_POST["new_date"];
	$new_category	=$_POST["new_category"];
	$new_page		=$_POST["new_page"];
	$new_color		=$_POST["new_color"];
	$new_log		=$_POST["new_log"];
	$new_memo		=$_POST["new_memo"];
	$new_ttl		=$_POST["new_ttl"];
	$new_ope		=$_POST["new_ope"];
	$date_time		=date("Y-m-d H:i:s");

	$sql="INSERT INTO blog_memo_master(`ope_id`)VALUES('{$new_ope}')"; 
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli);

	$sql="INSERT INTO blog_memo_slave(`m_id`,`date_time`,`date`,`category`,`page`,`title`,`color`,`log`,`memo_1`)VALUES"; 
	$sql.="('{$tmp_auto}','{$date_time}','{$new_date}','{$new_category}','{$new_page}','{$new_ttl}','{$new_color}','{$new_log}','{$new_memo}')"; 
	mysqli_query($mysqli,$sql);

}elseif($_POST["set_id"]){
	$set_id			=$_POST["set_id"];
	$set_date		=$_POST["set_date"];
	$set_category	=$_POST["set_category"];
	$set_page		=$_POST["set_page"];
	$set_color		=$_POST["set_color"];
	$set_log		=$_POST["set_log"];
	$set_memo		=$_POST["set_memo"];
	$set_title		=$_POST["set_ttl"];
	$date_time		=date("Y-m-d H:i:s");

	$sql="INSERT INTO blog_memo_slave(`m_id`,`date_time`,`date`,`category`,`page`,`title`,`color`,`log`,`memo_1`)VALUES"; 
	$sql.="('{$_POST["set_id"]}','{$date_time}','{$_POST["set_date"]}','{$_POST["set_category"]}','{$_POST["set_page"]}','{$_POST["set_ttl"]}','{$_POST["set_color"]}','{$_POST["set_log"]}','{$_POST["set_memo"]}')"; 
	mysqli_query($mysqli,$sql);

}elseif($memo_del){
	$sql	 ="UPDATE blog_memo_master SET"; 
	$sql	.=" del=1"; 
	$sql	.=" WHERE id='{$memo_del}'"; 
	mysqli_query($mysqli,$sql);
}

$cnt=0;
$sql="SELECT * FROM blog_memo_master"; 
$sql.=" WHERE del=0"; 
$sql.=" ORDER BY id DESC"; 
if($res = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($res)){

		if($ope_sel == $row["ope_id"] || !$ope_sel){
			if($cnt>=$p_st && $p_ed>$cnt){
				$dat[]=$row;
				$sql="SELECT * FROM blog_memo_slave"; 
				$sql.=" WHERE m_id='{$row["id"]}' "; 
				$sql.=" ORDER BY id DESC"; 

				$s=0;
				if($res2 = mysqli_query($mysqli,$sql)){
					while($row2 = mysqli_fetch_assoc($res2)){
						$sub[$row["id"]][$s]=$row2;
						$s++;
					}
				}
				$count_dat++;
			}
			$cnt++;
		}
		$ope_id[$row["ope_id"]]++;
	}
}

$page_max=ceil($cnt/10)+1;

ksort($ope_id);
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
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

.wrap{
	display			:flex;
	
}
.main_box{
	display			:inline-block;
	flex-basis		:890px;
	min-height		:calc(100vh - 80px);
	margin:10px;
}

.sub_box{
	display			:inline-block;
	flex-basis		:300px;
	min-height		:calc(100vh - 80px);	
	margin:10px;
}

.cate_title{
	display			:inline-block;
	width			:260px;
	height			:30px;
	line-height		:30px;
	font-size		:15px;
	padding-left	:5px;
	text-align		:left;
	margin-left		:5px;
	color			:#fafafa;
	font-weight		:600;
}

.cate_top{
	width			:1100px;
	margin			:0px;
	padding			:5px;
}

.cate_ul{
	width			:290px;
	margin			:20px 10px;
	border-radius	:5px;
	box-shadow		:3px 3px 3px rgba(30,30,30,0.5);
	padding			:5px;
}


.cate_li{
	display			:inline-block;
	position		:relative;
	width			:275px;
	height			:30px;
	line-height		:30px;
	margin			:0 0 1px 10px;
	padding-left	:5px;
	font-size		:0;
	color			:#ffffff;	
}

.li_id{
	display			:inline-block;
	position		:absolute;
	bottom			:0;
	top				:0;
	left			:2px;
	margin			:auto;
	width			:90px;
	height			:30px;
	line-height		:30px;
	font-size		:15px;
}

.li_name{
	display			:inline-block;
	position		:absolute;
	bottom			:0;
	top				:0;
	left			:95px;
	margin			:auto;
	width			:140px;
	height			:30px;
	line-height		:30px;
	font-size		:15px;
	background		:#ffffff;
}

.li_cnt{
	display			:inline-block;
	position		:absolute;
	bottom			:0;
	top				:0;
	right			:2px;
	margin			:auto;
	width			:35px;
	height			:25px;
	line-height		:25px;
	font-size		:15px;
	background		:linear-gradient(135deg,#3030ff,#0000ff);
	text-align		:center;
	border-radius	:5px;
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
	background:#90a080;
}

.c_green2:hover{
	background:#00b020;
}


.notice_table{
	border-collapse: collapse;
	margin			:5px auto;
	background		:#fafafa;
	border			:1px solid #303030;
}

.notice_table2{
	border-collapse: separate;
	margin			:5px auto;
	background		:#fafafa;
	border			:1px solid #303030;
	
}

.notice_top{
	background		:#b0c0d0;
	border			:1px solid #303030;
	color			:#fafafa;
	height			:18px;
	line-height		:18px;
	padding-left	:5px;
	font-size		:13px;
}

.notice_list{
	border			:1px solid #303030;
	color			:#202020;
	height			:20px;
	line-height		:20px;
	max-height		:20px;
	padding			:2px 5px;
	font-size		:14px;
	overflow		:hidden;
}

.notice_hidden{
	display:none;
}

.w30{width:30px;}
.w50{width:50px;}
.w80{width:80px;}
.w100{width:100px;}
.w120{width:120px;}
.w130{width:130px;}
.w150{width:150px;}
.w160{width:160px;}
.w200{width:200px;}
.w220{width:220px;}
.w240{width:240px;}
.w250{width:250px;}
.w260{width:260px;}
.w300{width:300px;}


.tr_list{
	cursor			:pointer;
}

.tr_list:hover{
	background		:#f0e8d0;
}

.notice_log{
	margin			:0px;
	width			:890px;
	height			:400px;
	padding			:10px;
	font-size		:14px;
	line-height		:24px;
	border			:1px solid #303030;
	border-radius	:5px;
	background		:#fafafa;
	overflow-y		:scroll;
	resize			:none;
}

.notice_st{
	padding:3px;
	background:#e0e0e0;
}

.notice_tag_title{
	display		:inline-block;
	width		:55px;
	height		:24px;
	line-height	:24px;
	text-align	:right;
	font-size	:13px;
	margin		:3px 0 3px 3px; 
	padding-right:5px;
}

.status_text{
	height		:24px;
	font-size	:13px;
	margin		:3px 3px 3px 0; 
}

.status_color{
	height		:24px;
	font-size	:13px;
	margin		:3px 3px 3px 0; 
	width		:60px;
}


.status_date{
	height		:24px;
	font-size	:13px;
	margin		:3px 3px 3px 0; 
	width		:125px
}

.status_title{
	height		:24px;
	font-size	:13px;
	margin		:3px 3px 3px 0; 
	width		:450px
}

.copy_box{
	display:block;
	width			:890px;
	margin:10px auto 0px auto;
}

.copy{
	height:24px;
	background:#d0d8ff;
}

.del_btn{
	position	:absolute;
	top			:0;
	bottom		:0;
	right		:5px;
	margin		:auto;
	height		:24px;
	width		:50px;
	background	:#ff6080;
}

.submit_btn{
	position	:absolute;
	top			:0;
	bottom		:0;
	right		:70px;
	margin		:auto;
	height		:24px;
	width		:50px;
}
.title_in{
	width	:260px;
	height	:20px;
	overflow:hidden;
}
.cate_in{
	width	:150px;
	height	:20px;
	overflow:hidden;
}

.n_no{
	text-align:right;
}

.n_page{
	text-align:right;
}


.tr_cr{
	background	:#ff6060;

}

.tr_cs{
	background	:#f5deb3;
}

.pg_btn{
	display		:inline-block;
	width		:30px;
	height		:26px;
	line-height	:26px;
	text-align	:center;
	background	:linear-gradient(135deg,#eeeeee,#c0c0c0);
	color		:#303030;
	margin		:2px;
	font-size	:14px;
	font-weight	:600;
	cursor		:pointer;
}

.sl{
	background:linear-gradient(135deg,#fa9090,#d07070);
	color:#fafafa;
}


.notice_ttl{
	background		:#b0c0d0;
	border			:1px solid #303030;
	color			:#fafafa;
	height			:18px;
	line-height		:18px;
	padding-left	:5px;
	font-size		:13px;
}

.notice_memo{
	resize		:none;
	width		:300px;
	height		:300px;
	font-size	:15px;
	padding		:10px;
	border:1px solid #303030;
	margin-bottom:15px;
}

.revision{
	display		:block;
	width		:300px;
	min-height	:200px;
	font-size	:00;
	border		:1px solid #303030;
	background:#fafafa;
}

.revision_box{
	display			:block;
	width			:280px;
	height			:30px;
	line-height		:30px;
	font-size		:15px;
	border-bottom	:1px solid #202020;
	background		:#fafafa;
	padding-left	:5px;
	margin			:0 auto 2px auto;
	cursor			:pointer;
}

.hide,.new_set{
	display:none;
}

.rev_ck{
	background:#f0f0ff;
}
-->
</style>	
<script>
$(function(){ 
	$('.tr_list').on('click',function(){ 
		$('.hide').show();
		var Tmp_log		=$(this).children('.n_log').html();
		var Tmp_ttl		=$(this).children().children('.title_in').html();
		var Tmp_date	=$(this).children('.n_date').html();
		var Tmp_id		=$(this).children('.n_id').html();
		var Tmp_opeid	=$(this).children('.n_opeid').html();
		var Tmp_opename	=$(this).children('.n_opename').html();
		var Tmp_page	=$(this).children('.n_page').html();
		var Tmp_category=$(this).children().children('.cate_in').html();
		var Tmp_color	=$(this).children('.n_color').html();
		var Tmp_memo	=$(this).children('.n_memo').html();

		$('#status_log').html(Tmp_log);
		$('#status_ttl').val(Tmp_ttl);
		$('#status_date').val(Tmp_date);
		$('#status_id').val(Tmp_id);
		$('#base_opeid').val(Tmp_opeid);
		$('#base_name').html(Tmp_opename);
		$('#status_category').val(Tmp_category);
		$('#status_page').val(Tmp_page);
		$('.status_color').val(Tmp_color);
		$('#status_memo').val(Tmp_memo);

		$.post({
			url:"./post/blog_memo_revision.php",
			data:{
				'id':Tmp_id,
			},
		}).done(function(data, textStatus, jqXHR){
			$('.revision').html(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.c_green2').on('click',function(){ 
		Tmp=$(this).attr('id').replace('o','');
		$('#ope_jump').val(Tmp);
		$('#form_pg').submit();
	});


	$('#new_submit').on('click',function(){ 
		if(!$('#new_opeid').val()){
			alert('占い師IDがありません');
		}else{
			$('#form_main').submit();
		}
		return false;
	});


	$('.revision').on('click','.revision_box',function(){ 
	$('.rev_ck').removeClass('rev_ck');
	$(this).addClass('rev_ck');

		Tmp=$(this).attr('id').replace('rev','');
		$.ajax({
			type: 'post',
			url:"./post/blog_memo_read.php",
			data:{
				'id':Tmp,
			},
			dataType: 'json',
		}).done(function(data, textStatus, jqXHR){
			$('#status_log').html(data.log);
			$('#status_ttl').val(data.title);
			$('#status_date').val(data.date);
			$('#status_category').val(data.category);
			$('#status_page').val(data.page);
			$('.status_color').val(data.color);
			$('#status_memo').val(data.memo_1);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});


	});


	$('.del_btn').on('click', function(){
		if (!confirm('メモを削除します。よろしいですか')) {
			return false;

		}else{
			$('#del').val($('#status_id').val());
			$('#form_pg').submit();
		}
	});

	$('.new_btn').on('click', function(){
		$('.hide').hide();
		$('.new_set').show();
	});


	$('#log_copy').on('click', function(){
		$('#status_log').select();
		document.execCommand('copy');
		alert('本文をコピーしました');
	});

	$('.pg_btn').on('click', function(){
		$('#pg_jump').val($(this).text());
		$('#form_pg').submit();
	});

	$('#title_copy').on('click', function(){
		$('#status_ttl').select();
		document.execCommand('copy');
		alert('タイトルをコピーしました');
	});
});
</script>
</head>
<body>
<header class="head">
</header>
<div class="cate_top">
<button class="new_btn" type="button">新規作成</button>
<?for($n=1;$n<$page_max;$n++){?>
<span class="pg_btn <?if($pg == $n){?>sl<?}?>"><?=$n?></span>
<?}?>
</div>

<div class="wrap">
	<div class="sub_box">
		<ul class="cate_ul c_green">
			<li class="cate_title">占い師</li>
				<li id="o" class="cate_li c_green2">
					全て
				</li>
			<?foreach($ope_id as $a1 => $a2){?>
				<li id="o<?=$a1?>" class="cate_li c_green2">
					<span class="li_id"><?=$a1?></span>
					<span class="li_name"></span>
					<span class="li_cnt"><?=$a2?></span>
				</li>
			<?}?>
		</ul>


		<ul class="cate_ul c_pink">
			<li class="cate_title">カテゴリー</li>
			<?foreach($staff_dat as $a1 => $a2){?>
			<li class="cate_li c_pink2"><?=$a2["user_name"]?></li><?}?>
		</ul>
	</div>

	<div class="main_box">
		<table class="notice_table">
			<tr>
				<td class="notice_top w30">No</td>
				<td class="notice_top w100">日時</td>
				<td class="notice_top w260">件名</td>
				<td class="notice_top w100">OPE_ID</td>
				<td class="notice_top w150">投稿者</td>
				<td class="notice_top w150">カテゴリ</td>
				<td class="notice_top w50">ページ</td>
			</tr>
			<?for($n=0;$n<$count_dat;$n++){?>
			<tr class="tr_list">
				<td class="notice_list n_no tr_c<?=$sub[$dat[$n]["id"]][0]["color"]?>"><?print($n+1)?></td>
				<td class="notice_list n_date tr_c<?=$sub[$dat[$n]["id"]][0]["color"]?>"><?=$sub[$dat[$n]["id"]][0]["date"]?></td>
				<td class="notice_list n_title tr_c<?=$sub[$dat[$n]["id"]][0]["color"]?>"><div class="title_in"><?=$sub[$dat[$n]["id"]][0]["title"]?></div></td>
				<td class="notice_list n_opeid tr_c<?=$sub[$dat[$n]["id"]][0]["color"]?>"><?=$dat[$n]["ope_id"]?></td>
				<td class="notice_list n_opename tr_c<?=$sub[$dat[$n]["id"]][0]["color"]?>"><?=$dat[$n]["ope_name"]?></td>
				<td class="notice_list n_category tr_c<?=$sub[$dat[$n]["id"]][0]["color"]?>"><div class="cate_in"><?=$sub[$dat[$n]["id"]][0]["category"]?></div></td>
				<td class="notice_list n_page tr_c<?=$sub[$dat[$n]["id"]][0]["color"]?>"><?=$sub[$dat[$n]["id"]][0]["page"]?></td>
				<td class="notice_hidden n_log"><?=$sub[$dat[$n]["id"]][0]["log"]?></td>
				<td class="notice_hidden n_id"><?=$dat[$n]["id"]?></td>
				<td class="notice_hidden n_color"><?=$sub[$dat[$n]["id"]][0]["color"]?></td>
				<td class="notice_hidden n_memo"><?=$sub[$dat[$n]["id"]][0]["memo_1"]?></td>

			</tr>
			<?}?>
		</table>

		<form id="form_main" method="post">
		<table class="notice_table2 hide">
			<tr>
				<td class="notice_st w200"><span class="notice_tag_title">日時</span><input id="status_date" name="set_date" type="date" class="mm status_date"></td>
				<td class="notice_st w300">
					<span class="notice_tag_title">IDCODE</span><input id="base_opeid" type="text" name="set_ope" class="mm status_text w80">
					<span id="base_name"></span>
				</td>
				<td class="notice_st w240"><span class="notice_tag_title">カテゴリ</span><input id="status_category" type="text" name="set_category" class="mm status_text w150"></td>
				<td class="notice_st w120"><span class="notice_tag_title">ページ</span><input id="status_page" name="set_page" type="text" class="mm status_text w50"></td>
			</tr><tr>
				<td class="notice_st" colspan="4" style="position:relative;">
					<span class="notice_tag_title">TITLE</span>
					<input id="status_ttl" name="set_ttl" type="text" class="mm status_title">
					<button id="title_copy" class="copy" type="button">COPY</button>
					<span class="notice_tag_title">色</span>
					<select id="status_color" class="status_color" name="set_color">
						<option value="">無</option>
						<option value="s">肌</option>
						<option value="r">赤</option>
					</select>
				<button id="status_submit" class="submit_btn" type="submit">更新</button>
				<button class="del_btn" type="button">削除</button>
				</td>
			</tr>
		</table>

		<table class="notice_table2 new_set">
			<tr>
				<td class="notice_st w200"><span class="notice_tag_title">日時</span><input id="new_date" name="new_date" type="date" class="mm status_date"></td>
				<td class="notice_st w300">
					<span class="notice_tag_title">IDCODE</span><input id="new_opeid" type="text" name="new_ope" class="mm status_text w80">
					<span id="base_name"></span>
				</td>
				<td class="notice_st w240"><span class="notice_tag_title">カテゴリ</span><input id="new_category" name="new_category" type="text" class="mm status_text w150"></td>
				<td class="notice_st w120"><span class="notice_tag_title">ページ</span><input id="new_page" name="new_page" type="text" class="mm status_text w50"></td>
			</tr><tr>
				<td class="notice_st" colspan="4" style="position:relative;">
					<span class="notice_tag_title">TITLE</span>
					<input id="new_ttl" name="new_ttl" type="text" class="mm status_title">

					<span class="notice_tag_title">色</span>
					<select id="new_color" class="status_color" name="new_color">
						<option value="">無</option>
						<option value="s">肌</option>
						<option value="r">赤</option>
					</select>
					<button id="new_submit" class="submit_btn" type="button">登録</button>
				</td>
			</tr>
		</table>

		<div class="copy_box hide"><button id="log_copy" class="copy" type="button">COPY</button></div>
		<textarea id="status_log" class="notice_log hide" name="set_log"></textarea>
		<textarea id="new_log" class="notice_log new_set" name="new_log"></textarea>

		<input id="status_id" type="hidden" name="set_id">
		<input type="hidden" name="pg" value="<?=$pg?>">
	</div>
	<div class="sub_box">
		<div class="notice_ttl hide new_set">メモ</div>
		<textarea id="status_memo" class="notice_memo hide" name="set_memo"></textarea>
		<textarea id="new_memo" class="notice_memo new_set" name="new_memo"></textarea>
</form>
		<div class="notice_ttl hide">変更履歴</div>
		<div class="revision hide"></div>
	</div>
</div>

<form id="form_pg" method="post">
<input id="pg_jump" type="hidden" name="pg" value="<?=$pg?>">
<input id="ope_jump" type="hidden" name="ope_sel" value="<?=$ope_sel?>">
<input id="del" type="hidden" name="memo_del" value="">
</form>
</body>
</html>
