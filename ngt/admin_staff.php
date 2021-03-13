<?
$sql	 ="SELECT id,staff_id,genji,genji_kana,cast_id,cast_status,name,kana FROM wp01_0staff AS S";
$sql	.=" LEFT JOIN wp01_0cast AS C ON S.staff_id=C.id";
$sql	.=" WHERE S.del=0";
$sql	.=" ORDER BY staff_id DESC";
if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){
		if (file_exists("./img/profile/{$res["id"]}/0.webp")) {
			$res["face"]="./img/profile/{$res["id"]}/0.webp";			

		}elseif (file_exists("./img/profile/{$res["id"]}/0.jpg")) {
			$res["face"]="./img/profile/{$res["id"]}/0.jpg";			

		}else{
			$res["face"]="./img/cast_no_image.jpg";			
		}
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



.w000{
	width:100%;
	margin-bottom:5px;
}

.w400{
	width:400px;
}

.w50{
	width:60px;
}

.w40{
	width:40px;
}

.tbox{
	height:100px;
	resize:none;
}
.tbox2{
	height:70px;
	resize:none;
}

td{
	border:1px solid #303030;
}


.td_1{
	width:60px;
}

.td_2{
	width:200px;
}

.td_3{
	width:100px;
}

.td_4{
	width:100px;
}

.td_5{
	width:80px;
}

.up_box{
	display		:block;
	margin		:10px 20px;
	font-size	:14px;
}

.img_up_box{
	display		:flex;
	justify-content: space-around;
	flex-wrap	:wrap;
	width		:400px;
	height		:650px;
	margin		:10px;
}

.img_up_box_in{
	display		:block;
	background	:#fafafa;
	width		:190px;
	height		:305px;
	position	:relative;
	border:2px solid #906000;
}

.img_up_img{
	display		:inline-block;
	position	:absolute;
	top			:20px;
	left		:20px;
	background	:#009000;
	width		:150px;
	height		:200px;
}

.img_up_comm{
	display		:inline-block;
	position	:absolute;
	top			:240px;
	left		:0;
	background	:#906000;
	width		:190px;
	height		:65px;
}

.img_up_file{
	display		:inline-block;
	background	:linear-gradient(#c0c0c0,#909090);
	position	:absolute;
	top			:7px;
	left		:15px;
	height		:25px;
	line-height	:25px;
	width		:75px;
	font-size	:16px;
	text-align	:center;
	color		:#fafafa;
	overflow	:hidden;
	padding		:0 5px;
	border-radius:3px;
}

.img_up_rote{
	display		:inline-block;
	background	:linear-gradient(#c0c0c0,#909090);
	position	:absolute;
	top			:7px;
	left		:105px;
	height		:25px;
	line-height	:25px;
	width		:20px;
	text-align	:center;
	color		:#fafafa;
	border-radius:3px;
	cursor		:pointer;
}

.img_up_reset{
	display		:inline-block;
	background	:linear-gradient(#c0c0c0,#909090);
	position	:absolute;
	top			:7px;
	left		:130px;
	height		:25px;
	line-height	:25px;
	width		:20px;
	text-align	:center;
	color		:#fafafa;
	border-radius:3px;
	cursor		:pointer;
}

.img_up_del{
	display		:inline-block;
	background	:linear-gradient(#c0c0c0,#909090);
	position	:absolute;
	top			:7px;
	left		:155px;
	height		:25px;
	line-height	:25px;
	width		:20px;
	text-align	:center;
	color		:#fafafa;
	border-radius:3px;
	cursor		:pointer;
}

#sel_staff,#sel_cast{
	display:none;
}

#staff_l{
	border-radius:10px 0 0 10px;
}

#cast_l{
	border-radius:0 10px 10px 0;
}

.c_s_box{
	display				:inline-block;
	height				:30px;
	line-height			:30px;
	width				:180px;
	font-size			:0;
	color				:#fafafa;
	text-align			:left;
	margin 0 50px;
}

.c_s_btn{
	display				: inline-block;
	height				:30px;
	line-height			:30px;
	width				:80px;
	font-size			:16px;
	text-align			:center;
	background			:#cccccc;
	color				:#fafafa;
}

.on_1{
	background:#0000c0;
}

.on_2{
	background:#c00000;
}

.ck_off:checked + label{
	background		:linear-gradient(#c0c0f0,#8080ff);
}

.ck_box{
	display			:inline-block;
	width			:100px;
	margin			:3px;
	padding			:4px;
	border-radius	:5px;
	background		:#c0c0c0;
	color			:#fafafa;
	font-size		:14px;
	text-align		:left;
}

.sel_status{
	display			:inline-block;
	background		:#d0d0d0;
	width			:80px;
	height			:30px;
	line-height		:30px;
	margin			:5px;
	border-radius	:5px;
	color			:#fafafa;
	font-size		:18px;
	font-weight		:600;
	text-align		:center;
}

input[type=checkbox]:checked + label{
	background		:linear-gradient(#c0c0f0,#8080ff);
}


.table_title{
	background		:linear-gradient(#e0e0e0,#d0d0d0);
	padding			:5px;
	font-size		:14px;
}

.img_box_out1{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:0;
	left		:0;
	width		:20px;
	height		:20px;
	z-index		:5;
}

.img_box_out2{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:0;
	left		:20px;
	width		:150px;
	height		:20px;
	border-bottom:1px solid #ff0000;
	z-index		:5;
}

.img_box_out3{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:0;
	right		:0;
	width		:20px;
	height		:20px;
	z-index		:5;
}

.img_box_out4{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:20px;
	left		:0;
	width		:20px;
	height		:200px;
	border-right:1px solid #ff0000;
	z-index		:5;
}

.img_box_out5{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:20px;
	right		:0;
	width		:20px;
	height		:200px;
	border-left	:1px solid #ff0000;
	z-index		:5;
}

.img_box_out6{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	bottom		:0;
	left		:0;
	width		:20px;
	height		:20px;
	z-index		:5;
}

.img_box_out7{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	bottom		:0;
	left		:20px;
	width		:150px;
	height		:20px;
	border-top	:1px solid #ff0000;
	z-index		:5;
}

.img_box_out8{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	bottom		:0;
	right		:0;
	width		:20px;
	height		:20px;
	z-index		:5;
}

.cvw_0{
	position	:absolute;
	background	:#f0f0f0;
}

input[type=range] {
	-webkit-appearance:none;
	background		:#f17766;
	height			:6px;
	width			:80px;
	display			:inline-block;
	border			:none;
	margin			:8px 5px;
	border-radius	:0;
}

input[type=range]::-webkit-slider-thumb{
	-webkit-appearance	:none;
	background			:#f17766;
	height				:14px;
	width				:14px;
	border-radius		:50%;
	border				:2px solid #ffffff;
}

input[type=range]::-ms-tooltip{
	display:none;
}

input[type=range]::-moz-range-track{
	height:0;
}

input[type=range]::-moz-range-thumb{
	background		:#f17766;
	height			:14px;
	width			:14px;
	border-radius	:50%;
	border			:2px solid #ffffff;
}

.zoom_mi{
	display				:inline-block;
	height				:20px;
	flex-basis			:15px;
	border				:1px solid #f17766;
	border-radius		:5px 0 0 5px;
	line-height			:20px;
	text-align			:center;
	cursor				:pointer;
	background			:#ffe0f0;
	color				:#f17766;
	font-size			:14px;
	font-weight			:600;
}		

.zoom_pu{
	display				:inline-block;
	height				:20px;
	flex-basis			:15px;
	border				:1px solid #f17766;
	border-radius		:0 5px 5px 0;
	line-height			:20px;
	text-align			:center;
	cursor				:pointer;
	background			:#ffe0f0;
	color				:#f17766;
	font-size			:14px;
	font-weight			:600;
}

.zoom_rg{
	display				:inline-block;
	height				:20px;
	line-height			:20px;
	flex				:1;
	border				:1px solid #f17766;
	background			:#ffe0f0
}

.zoom_box{
	border				:1px solid #f17766;
	color				:#f17766;
	display				:inline-block;
	height				:20px;
	flex-basis			:35px;
	line-height			:20px;
	text-align			:center;
	margin-left			:5px;
	background			:#ffffff;
	font-weight			:600;
	font-size			:14px;
}

.img_box_in{
	position		:absolute;
	top				:0;
	left			:0;
	width			:190px;
	height			:240px;
	overflow		:hidden;
}


.img_box_in3{
	display			:flex;
	flex-wrap		:nowrap;
	font-size		:0;
	position		:absolute;
	top				:38px;
	left			:15px;
	width			:160px;
	height			:25px;
}

.sex_box{
	position		:relative;
	display			:inline-block;
	height			:30px;
	width			:70px;
}

.sex_box_ck{
	position:absolute;
	top:0;
	left:3px;
	bottom:0;
	margin:auto !important; 
}

.sex_box_txt{
	position:absolute;
	display	:inline-block;
	top		:0px;
	left	:25px;
	bottom	:0;
	margin	:auto;
	height:30px;
	line-height:30px;

}

.cvs0{
	width:150px;
	height:200px;

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
	margin:50px 0 30px 0;
	width:1200px;

}

.icon{
	font-family:at_icon;
}
-->
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/image.js?_<?=time()?>"></script>
<script>
$(function(){ 
	$('#staff_l').on('click',function () {
		$(this).addClass('on_1');
		$('#cast_l').removeClass('on_2');
		$('.cast_table').fadeOut(100);
	});

	$('#cast_l').on('click',function () {
		$(this).addClass('on_2');
		$('#staff_l').removeClass('on_1');
		$('.cast_table').fadeIn(100);
	});
});
</script>

<header class="head">
<h2>スタッフ一覧</h2>
<input id="sel_staff" value="1" type="radio" name="c_s"><label id="staff_l" for="staff" class="c_s_btn">STAFF</label>
<input id="sel_cast" value="2" type="radio" name="c_s" checked="checked"><label id="cast_l" for="cast" class="c_s_btn on_2">CAST</label>

<input id="sel_staff" value="1" type="radio" name="c_s"><label id="label_staff" for="sel_staff" class="c_s_btn">STAFF</label>
<input id="sel_cast" value="2" type="radio" name="c_s" checked="checked"><label id="label_cast" for="sel_cast" class="c_s_btn on_2">CAST</label>

<input id="sel_sort" value="1" type="radio" name="sort"><label id="label_sort" for="sel_sort" class="c_s_btn">昇順</label>
<input id="sel_ksort" value="2" type="radio" name="sort" checked="checked"><label id="label_ksort" for="sel_ksort" class="c_s_btn on_2">降順</label>

<input id="sel_status_0" value="1" type="checkbox" name="sel_status_0"><label id="label_status_0" for="sel_status_0" class="sel_status">通常</label>
<input id="sel_status_1" value="1" type="checkbox" name="sel_status_1"><label id="label_status_1" for="sel_status_1" class="sel_status">準備</label>
<input id="sel_status_2" value="1" type="checkbox" name="sel_status_2"><label id="label_status_2" for="sel_status_2" class="sel_status">休職</label>
<input id="sel_status_3" value="1" type="checkbox" name="sel_status_3"><label id="label_status_3" for="sel_status_3" class="sel_status">退職</label>
<input id="sel_status_4" value="1" type="checkbox" name="sel_status_4"><label id="label_status_4" for="sel_status_4" class="sel_status">停止</label>
</header>

<div class="wrap">
<div class="main_box">
<table>
<tr>
<td class="td_top"></td>
<td class="td_top">源氏名[フリガナ]</td>
<td class="td_top">ID</td>
<td class="td_top">登録日</td>
<td class="td_top">状態</td>
<td class="td_top">変更</td>
</tr>
<?for($n=0;$n<$count_dat;$n++){?>
<tr>
<td class="td_1"><img src="<?=$dat[$n]["face"]?>" style="width:60px; height:80px;"></td>
<td class="td_2"><?=$dat[$n]["genji"]?><br>[<?=$dat[$n]["genji_kana"]?>]</td>
<td class="td_3"><?=$dat[$n]["cast_id"]?></td>
<td class="td_4"><?=$dat[$n]["ctime"]?></td>
<td class="td_5"><?=$cast_status[$dat[$n]["cast_status"]]?></td>

<td class="td_5"><form method="post"><button type="submit">変更</button><input type="hidden" value="staff_fix" name="menu_post"><input type="hidden" name="staff_id" value="<?=$dat[$n]["staff_id"]?>"></form></td>


</tr>
<?}?>
</table>
<footer class="foot"></footer> 
