<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
<style>
.box2{
	display		:inline-block;
	position	:relative;
	width		:74vw;
	height		:106vw;
	background	:linear-gradient(135deg,#ff3030,#e00000);
	margin		:1vw  auto;
}

.box{
	display		:inline-block;
	position	:absolute;
	top			:0;
	left		:0;
	right		:0;
	bottom		:0;
	width		:68vw;
	height		:100vw;
	background	:linear-gradient(135deg,#fff0e8,#f0e0e0,#fff0e8);
	background	:#fff0e0;
	margin		:auto;
}

.item{
	position:absolute;
	width	:20vw;
	height	:42vw;
}

.sox_img{
	position:absolute;
	bottom	:0;
	left	:0;
	width:20vw;
	height:40vw;
}
.santa_img{
	position:absolute;
	display	:none;
	bottom	:10vw;
	left	:0;
	width	:20vw;
	height	:24vw;
}

#i0{
	left:2vw;
	top:7vw;
}

#i1{
	left:24vw;
	top:7vw;
}

#i2{
	left:46vw;
	top:7vw;
}

#i3{
	left:2vw;
	top:53vw;
}

#i4{
	left:24vw;
	top:53vw;
}

#i5{
	left:46vw;
	top:53vw;
}
.cover{
	display		:none;
	position	:fixed;
	top			:-5vh;
	left		:-5vh;
	height		:110vh;
	width		:110vw;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function(){ 
var N		=500;
var Santa	=0;
var Tona	=0;
var Rnd		=[]

var ORZ=4

for(s=0;s<6;s++){
	Rnd[s]= Math.floor(Math.random() * 2)+3;

	if(Rnd[s]==3){
		Santa++;
	}else{
		Tona++;
	}

	if(Santa>2){
		Rnd[s]=4;
	}else 	if(Tona>4){
		Rnd[s]=3;
	}
}

$('.item').on('click',function(){
	$('.cover').show();
	Tmp=$(this).attr('id').replace('i','');
	$(this).animate({'top':'+=2vw'},50).animate({'top':'-=2vw'},50);
	for(i=0;i<6;i++){
		if(i != Tmp){
			$('#t'+i).delay(N).attr('src','./item'+Rnd[i]+'.png').fadeIn(50).animate({'bottom':'26vw'},50).animate({'bottom':'24vw'},10);
			N+=300;
		}	
	}
	$('#t'+Tmp).delay(2400).attr('src','./item'+ORZ+'.png').fadeIn(50).animate({'bottom':'26vw'},50).animate({'bottom':'24vw'},10);
});
});
</script>

</head>

<body>
<div class="box2">
<div class="box">
<div id="i0" class="item">
<img src="./item1.png" class="sox_img">
<img id="t0" src="./item3.png" class="santa_img">
<img src="./item2.png" class="sox_img">
</div>
<div id="i1" class="item">
<img src="./item1.png" class="sox_img">
<img id="t1" src="./item4.png" class="santa_img">
<img src="./item2.png" class="sox_img">
</div>

<div id="i2" class="item">
<img src="./item1.png" class="sox_img">
<img id="t2" src="./item4.png" class="santa_img">
<img src="./item2.png" class="sox_img">
</div>
<div id="i3" class="item">
<img src="./item1.png" class="sox_img">
<img id="t3" src="./item3.png" class="santa_img">
<img src="./item2.png" class="sox_img">
</div>
<div id="i4" class="item">
<img src="./item1.png" class="sox_img">
<img id="t4" src="./item3.png" class="santa_img">
<img src="./item2.png" class="sox_img">
</div>
<div id="i5" class="item">
<img src="./item1.png" class="sox_img">
<img id="t5" src="./item3.png" class="santa_img">
<img src="./item2.png" class="sox_img">
</div>
</div>
</div>
<div class="cover"></div>
</body>
</html>
