<?
$post_id=$_POST["post_id"];

$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE del=0";
$sql	.=" AND page='{$page}'";
$sql	.=" ORDER BY sort DESC";
if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){
		$res["d_yy"]=substr($res["display_date"],0,4);
		$res["d_mm"]=substr($res["display_date"],5,2);
		$res["d_dd"]=substr($res["display_date"],8,2);
		$dat[]=$res;
	}
	if(is_array($dat)){
		$count_dat=count($dat);
	}
}


?>
<style>
<!--
input[type=text]{
	height:30px;
}

input[type="checkbox"],input[type="radio"]{
	display:none;
}

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


.head{
	display			:inline-block;
	position		:fixed;
	top				:0;
	left			:180px;
	width			:calc(100vw - 180px);
	height			:50px;
	background		:#0000d0;
	z-index:10;
}

.foot{
	display			:inline-block;
	position		:fixed;
	bottom			:0;
	left			:180px;
	width			: calc(100vw - 180px);
	height			:30px;
	background		:#00d000;
	z-index:10;

}
.wrap{
	display			:inline-flex;
	margin			:50px 0 30px 0;
	width			:1200px;

}

.icon{
	font-family:at_icon;
}
-->
</style>
<script>
$(function(){ 
});
</script>
<header class="head">
<input id="sel_contents_0" value="event" type="radio" name="sel_contents" checked="checked"><label id="label_contents_0" for="sel_contents_0" class="sel_contents">イベント</label>

<input id="sel_contents_1" value="news" type="radio" name="sel_contents"><label id="label_contents_1" for="sel_contents_1" class="sel_contents">NEWS</label>

<input id="sel_contents_2" value="info" type="radio" name="sel_contents"><label id="label_contents_2" for="sel_contents_2" class="sel_contents">お知らせ</label>

<input id="sel_contents_3" value="sysyem" type="radio" name="sel_contents"><label id="label_contents_3" for="sel_contents_3" class="sel_contents">SYSTEM</label>

<input id="sel_contents_4" value="access" type="radio" name="sel_contents"><label id="label_contents_4" for="sel_contents_4" class="sel_contents">ACCESS</label>

<input id="sel_contents_5" value="recruit" type="radio" name="sel_contents"><label id="label_contents_5" for="sel_contents_5" class="sel_contents">REQRUIT</label>

</header>
<div class="wrap">
	<div class="main_box">
	</div>
</div>
<footer class="foot"></footer> 
