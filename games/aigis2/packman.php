<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<script src="./js/jquery-3.2.1.min.js"></script>
<script>
$(function(){ 
    $('.up').on('click',function(){
	    $('.pac').css({'transform':'rotate(90deg)'}).animate({'top':'0'},2000);
    });

    $('.down').on('click',function(){
	    $('.pac').css({'transform':'rotate(270deg)'}).animate({'top':'350px'},2000);
    });

    $('.left').on('click',function(){
	    $('.pac').css({'transform':'rotate(0deg)'}).animate({'left':'0'},2000);
    });

    $('.right').on('click',function(){
	    $('.pac').css({'transform':'rotate(180deg)'}).animate({'right':'350px'},2000);
    });
});
</script>
<style>
.box{
	position:absolute;
	top:0;
	left:0;
	right:0;
	bottom:0;
	margin:auto;
	width:400px;
	height:400px;
	background:#fafafa;
}

.pac{
	position:absolute;
	top:100px;
	left:100px;
	width:50px;
	height:50px;
	background:#e0e0e0;
}

.pac_a,.pac_b,.pac_c{
	position:absolute;
	top:0px;
	right:0px;
	width:25px;
	height:50px;
	border-radius:0 25px 25px 0;
	background:#d0d000;
}

.pac_b{
	animation		:r1 0.5s linear infinite;
	transform-origin: 0px 25px;
}
.pac_c{
	animation		:r2 0.5s linear infinite;
	transform-origin: 0px 25px;
}

@keyframes r1 {
	0%   { transform: rotate(0deg); }
	50% { transform: rotate(90deg); }
	100% { transform: rotate(0deg); }
}

@keyframes r2 {
	0%   { transform: rotate(0deg); }
	50% { transform: rotate(-90deg); }
	100% { transform: rotate(0deg); }
}

.cont{
	position:absolute;
	top:0;
	left:0;
	background:#d0d0ff;
	height:90px;
	width:90px;
}
.up,.down,.left,.right{
	position:absolute;
	background:#fafafa;
	height:30px;
	line-height:30px;
	width:30px;
	text-align:center;
	font-size:20px;
}

.up{
	top:0;
	left:30px;
}

.down{
	bottom:0;
	left:30px;
}

.left{
	top:30px;
	left:0px;
}

.right{
	top:30px;
	right:0px;
}

</style>

</head>
<body>
<div class="cont">
<div class="up">↑</div>
<div class="down">↓</div>
<div class="left">←</div>
<div class="right">→</div>
</div>
<div class="box">
<div class="pac">
<div class="pac_b"></div>
<div class="pac_c"></div>
</div>
</div>

</body></html>
