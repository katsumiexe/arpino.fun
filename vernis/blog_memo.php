<?
$mysqli = mysqli_connect("210.150.110.204", "blue_db", "0909", "blue_db");
if(!$mysqli){
	die('ERROR!');
}
mysqli_set_charset($mysqli,'UTF8'); 

$sql="SELECT * FROM blog_memo_master AS M"; 
$sql.=" ORDER BY id DESC"; 
$sql.=" LIMIT 20"; 

if($res = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($res)){

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
}

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
	flex-basis		:800px;
	background		:#e0e000;
	min-height		:calc(100vh - 80px);
}

.sub_box{
	display			:inline-block;
	flex-basis		:350px;
	background		:#f0f0f0;
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
	margin			:20px 10px;
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


.notice_table,.list_table{
	border-collapse: collapse;
	margin			:2px auto;
	background		:#fafafa;
	border			:1px solid #303030;
}

.list_table{
	cursor			:pointer;
}

.list_table:hover{
	background		:#f0e8d0;
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
	padding-left	:5px;
	font-size		:14px;
	overflow		:hidden;
}

.notice_hidden{
	display:none;
}

.w30{width:30px;}
.w80{width:80px;}
.w100{width:100px;}
.w130{width:130px;}
.w150{width:150px;}
.w160{width:160px;}
.w200{width:200px;}
.w220{width:220px;}
.w250{width:250px;}

.n_title{
	width:310px;
	overflow:hidden;
}


.notice_log{
	margin			:0 42px;
	width			:716px;
	height			:500px;
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
	width		:60px;
	height		:24px;
	line-height	:24px;
	text-align	:center;
	font-size	:13px;
	margin		:3px 0 3px 3px; 
}

.status_text{
	height		:24px;
	font-size	:13px;
	margin		:3px 3px 3px 0; 
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
	width			:716px;
	margin:10px auto 0px auto;
}

.copy{
	height:24px;
	background:#d0d8ff;
}

.del_btn{
	position:absolute;
	top		:0;
	bottom	:0;
	right	:5px;
	margin	:auto;
	height	:24px;
	width	:50px;
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
-->
</style>	
<script>
$(function(){ 
	$('.list_table').on('click',function(){ 


		<table class="list_table">
			<tr class="tr_list">
				<td class="notice_list n_no"><?=$dat[$n]["id"]?></td>
				<td class="notice_list n_date"><?=$sub[$dat[$n]["id"]][0]["date"]?></td>
				<td class="notice_list n_opeid"><?=$dat[$n]["ope_id"]?></td>
				<td class="notice_list n_opename"><?=$dat[$n]["ope_name"]?></td>
			</tr><tr>
				<td class="notice_list n_title"><?=$sub[$dat[$n]["id"]][0]["title"]?></td>
				<td class="notice_hidden"><?=$sub[$dat[$n]["id"]][0]["log"]?></td>
			</tr>
		</table>


		var Tmp_no=$(this).children().children('.n_no').html();
		var Tmp_date=$(this).children().children('.n_date').html();
		var Tmp_opeid=$(this).children().children('.n_opeid').html();
		var Tmp_opename=$(this).children().children('.n_opename').html();

		var Tmp_ttl=$(this).children().children('.n_title').html();
		var Tmp_log=$(this).children().children('.notice_hidden').html();

		$('#status_no').val(Tmp_no);
		$('#status_date').val(Tmp_date);
		$('#base_opeid').val(Tmp_opeid);
		$('#base_name').html(Tmp_opename);

		$('#status_ttl').val(Tmp_ttl);
		$('#status_log').html(Tmp_log);
	});

	$('#log_copy').on('click', function(){
		$('#status_log').select();
		document.execCommand('copy');
		alert('本文をコピーしました');
	});

	$('#title_copy').on('click', function(){
		$('#status_title').select();
		document.execCommand('copy');
		alert('タイトルをコピーしました');
	});
});

</script>
</head>
<body>
<header class="head">
</header>
<div class="wrap">
	<div class="sub_box">
		<table class="notice_table">
			<tr>
				<td class="notice_top w30">No</td>
				<td class="notice_top w100">日時</td>
				<td class="notice_top w80">OPE_ID</td>
				<td class="notice_top w100">投稿者</td>
			</tr><tr>
				<td class="notice_top" colspan="4">件名</td>
			</tr>
		</table>
		
	<?for($n=0;$n<$count_dat;$n++){?>
		<table class="list_table">
			<tr class="tr_list">
				<td class="notice_list w30 n_no"><?=$dat[$n]["id"]?></td>
				<td class="notice_list w100 n_date"><?=$sub[$dat[$n]["id"]][0]["date"]?></td>
				<td class="notice_list w80 n_opeid"><?=$dat[$n]["ope_id"]?></td>
				<td class="notice_list w100 n_opename"><?=$dat[$n]["ope_name"]?></td>
			</tr><tr>
				<td class="notice_list n_title" colspan="4"><?=$sub[$dat[$n]["id"]][0]["title"]?></td>
				<td class="notice_hidden" colspan="4"><?=$sub[$dat[$n]["id"]][0]["log"]?></td>
			</tr>
		</table>
	<?}?>

<!--
		<ul class="cate_ul c_blue">
			<li class="cate_title">MENU</li>
			<li class="cate_li c_blue2">投稿</li>
			<li class="cate_li c_blue2">検索</li>
			<li class="cate_li c_blue2">チェック</li>
		</ul>

		<ul class="cate_ul c_green">
			<li class="cate_title">占い師</li>
			<?foreach($tag["cast_group"] as $a1 => $a2){?>
			<li class="cate_li c_green2"><?=$a2?></li><?}?>
		</ul>

		<ul class="cate_ul c_pink">
			<li class="cate_title">カテゴリー</li>
			<?foreach($staff_dat as $a1 => $a2){?>
			<li class="cate_li c_pink2"><?=$a2["user_name"]?></li><?}?>
		</ul>
-->
	</div>

	<div class="main_box">
		<table class="notice_table2">
		<tr>
			<td class="notice_st w100"><input id="status_no" type="text" class="status_text w80"></td>
			<td class="notice_st w180"><span class="notice_tag_title">日時</span><input id="status_date" type="date" class="status_date"></td>
			<td class="notice_st w150"><span class="notice_tag_title">IDCODE</span><input id="base_opeid" type="text" class="status_text w80"></td>
			<td id="base_name" class="notice_st w150"></td>
		</tr><tr>

			<td class="notice_st" colspan="3" style="position:relative;"><span class="notice_tag_title">TITLE</span><input id="status_title" type="text" class="status_title"><button id="title_copy" class="copy" type="button">COPY</button>
			<button class="submit_btn" type="button">登録</button>
			<button class="del_btn" type="button">削除</button>
			</td>
		</tr>
		</table>
		<div class="copy_box"><button id="log_copy" class="copy" type="button">COPY</button></div>
		<textarea id="status_log" class="notice_log"></textarea>
	</div>
</div>
</body>
</html>
