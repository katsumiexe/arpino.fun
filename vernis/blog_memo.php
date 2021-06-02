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
	flex-basis		:250px;
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
	padding-left	:5px;
	font-size		:14px;
}

.notice_hidden{
	display:none;
}

.w30{width:30px;}
.w100{width:100px;}
.w130{width:130px;}
.w150{width:150px;}
.w160{width:160px;}
.w200{width:200px;}
.w220{width:220px;}
.w250{width:250px;}


.tr_list{
	cursor			:pointer;
}

.tr_list:hover{
	background		:#f0e8d0;
}

.notice_log{
	margin			:10px 42px;
	width			:716px;
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


-->
</style>	
<script>
$(function(){ 
	$('.tr_list').on('click',function(){ 
		var Tmp=$(this).children('.notice_hidden').html();
		$('.notice_log').html(Tmp);
	});
});
</script>
</head>
<body>
<header class="head">
</header>
<div class="wrap">

	<div class="sub_box">
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
	</div>

	<div class="main_box">
		<table class="notice_table">
			<tr>
				<td class="notice_top w30">No</td>
				<td class="notice_top w130">日時</td>
				<td class="notice_top w220">件名</td>
				<td class="notice_top w160">投稿者</td>
				<td class="notice_top w100">カテゴリ</td>
				<td class="notice_top w30"></td>
			</tr>
			<?for($n=0;$n<$count_dat;$n++){?>
			<tr class="tr_list">
				<td class="notice_list"><?print($n+1)?></td>
				<td class="notice_list"><?=$dat[$n]["date"]?></td>
				<td class="notice_list"><?=$dat[$n]["title"]?></td>
				<td class="notice_list"><?=$dat[$n]["writer"]?></td>
				<td class="notice_list"><?=$dat[$n]["category"]?></td>
				<td class="notice_list"></td>
				<td class="notice_hidden"><?=$dat[$n]["log"]?></td>
			</tr>
			<?}?>
		</table>

		<table class="notice_table2">
		<tr>
			<td class="notice_st w200"><span class="notice_tag_title">日時</span><input id="status_date" type="date" class="status_text"></td>
			<td class="notice_st w250"><span class="notice_tag_title">占い師名</span><input id="status_name" type="text" class="status_text"></td>
			<td class="notice_st w250"><span class="notice_tag_title">カテゴリ</span><input id="status_cate" type="text" class="status_text"></td>
		</tr><tr>
			<td class="notice_st" colspan="3"><span class="notice_tag_title">TITLE</span><input id="status_text" type="text" class="status_text"></td>
		</tr>
		</table>

		<textarea class="notice_log"></textarea>
	</div>
</div>
</body>
</html>

