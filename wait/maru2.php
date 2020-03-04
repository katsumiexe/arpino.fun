<html>
<head>
<style>
.main_circle {
	position		:relative;
	width			:150px;
	height			:150px;
	border-radius	:50%;
	background		:linear-gradient(135deg, #aaaaaa, #888888);
	z-index			:100;
}

 .circle {
	position		: absolute;
	top				:0;
	left			:0;
	right			:0;
	bottom			:0;
	margin			:auto;
	border-radius	:50%;
	width			:120px;
	height			:120px;
	background		:linear-gradient(135deg, #00a000, #004000);
	border			:4px solid #fffff0;
	z-index			:101;
}

/*----------------------------------
svg {
	transform: rotate(-90deg);
}

circle {
    fill: transparent;
    stroke: #ffffe0;
    stroke-width: 4;
    animation: circle 2s;
}

@keyframes circle {
	0% { stroke-dasharray: 0 377; }
	99.9%{ stroke-dasharray: 377 377; }
}
/*----------------------------------*/

.box_1{
  position:relative;
  width:100px;
  height:100px;
  background:#000000;
}
.point_2{
	position	:absolute;
	top			:0;
	left		:0;
	right		:0;
	bottom		:0;
	margin		:auto;
	height		:8px;
	width		:8px;
	border-radius:50%;
	background	:#ffff00;
	box-shadow	:0px 0px 4px 4px rgba(255,255,255,0.5);
	z-index		:112;
}

.point{
	position	:absolute;
	top			:0;
	left		:0;
	right		:0;
	bottom		:0;
	margin		:auto;
	z-index		:111;

	border		:1px solid #ffffff;
	display		:inline-block;
	height		:6px;
	width		:6px;
	border-radius:50%;
	box-shadow	:0 0 2px 4px rgba(255,255,255,0.5),0 0 1px 2px rgba(255,255,255,0.5) inset;
}

.line_a{
	position	:absolute;
	top			:13px;
	left		:0;
	right		:0;
	margin		:auto;
	z-index		:102;
	height		:0px;
	width		:4px;
	background	:#fffff0;
	box-shadow:0px 0px 10px 5px rgba(255,255,250,0.8);

}

.line_b{
	position	:absolute;
	bottom		:28px;
	left		:36px;
	z-index		:102;
	height		:0px;
	width		:4px;
	background	:#fffff0;
	box-shadow:0px 0px 10px 5px rgba(255,255,250,0.8);
}

.line_c{
	position	:absolute;
	bottom		:28px;
	right		:36px;
	z-index		:102;
	height		:0px;
	width		:4px;
	background	:#fffff0;
	box-shadow:0px 0px 10px 5px rgba(255,255,250,0.8);
}


.line_d{
	position	:absolute;
	bottom		:75px;
	right		:73px;
	z-index		:102;
	height		:0px;
	width		:4px;
	transform: rotate(-39deg);
	background	:#fffff0;
	transform-origin:right bottom;
	box-shadow:0px 0px 10px 5px rgba(255,255,250,0.8);
}

.line_e{
	position	:absolute;
	top			:75px;
	left		:73px;
	z-index		:102;
	height		:0px;
	width		:4px;
	transform: rotate(39deg);
	background	:#fffff0;
	transform-origin:right top;
	box-shadow:0px 0px 10px 5px rgba(255,255,250,0.8);
}

.line_f{
	position	:absolute;
	top			:75px;
	left		:73px;
	z-index		:102;
	height		:0px;
	width		:4px;
	transform	: rotate(-39deg);
	background	:#fffff0;
	transform-origin:left top;
	box-shadow:0px 0px 10px 5px rgba(255,255,250,0.8);
}

.line_g{
	position	:absolute;
	bottom		:27px;
	left		:36px;
	z-index		:102;
	height		:4px;
	width		:0px;
	background	:#fffff0;
	box-shadow:0px 0px 10px 5px rgba(255,255,250,0.8);
}


</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script>
var N=1000;
$(function(){
	$('.cover1').addClass('cover0');
	$('.cover2').delay(500).queue(function(){
		$(this).addClass('cover0').dequeue();
		$('.cover3').addClass('cover3_a');
		$('.cover1').hide();
	});

	setInterval(function(){
		N=N-100;
		if(N<50) N=100;
		$('.point').animate({width:'30px',height:'30px', opacity: 0}, 1000).animate({width:'4px',height:'4px', opacity: 1}, 1);
	},N);

	$('.line_a').animate({height:'124px'}, 1000);
	$('.line_c,.line_b').delay(500).animate({height:'94px'}, 1000);
	$('.line_d,.line_e,.line_f').delay(1000).animate({height:'60px'}, 1000);
	$('.line_g').delay(1600).animate({width:'78px'}, 1200);

});
</script>
</head>
<Body style="background:#f0e0ff;">

<!--div class="main_circle">
  <div class="circle">
    <span class="cover1"></span>
    <span class="cover2"></span>

    <span class="cover3"></span>
    <span class="cover4"></span>
  </div>
</div>
<br><br>

<div class="box_1">
  <div class="point"></div>
  <div class="point_2"></div>

		<svg width="124" height="124">
		  <circle cx="62" cy="62" r="60" />
		</svg>
</div-->
<div class="main_circle">
	<div class="line_a"></div>
	<div class="line_b"></div>
	<div class="line_c"></div>
	<div class="line_d"></div>
	<div class="line_e"></div>
	<div class="line_f"></div>
	<div class="line_g"></div>
	<div class="point"></div>
	<div class="point_2"></div>
	<div class="circle">
	</div>
</div>
</body>
</html>
