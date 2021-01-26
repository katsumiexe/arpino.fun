<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./js/jquery-3.4.1.min.js"></script>
    <script src="./js/jquery-ui.min.js" defer></script>
    <script src="./js/jquery.ui.touch-punch.min.js" defer></script>
    <title>TEST_A</title>
<style>
.head{
    position:fixed;
    top:0;
    left:0;
    width:110vw;
    height:10vh;
    line-height:10vh;
    background:#e0e0e0;
    box-shadow:2px 2px 2px #303030;
	z-index:20;
    text-align:center;
}
.menu{
    position:absolute;
    top:1vw;
    left:1vw;
    width:8vh;
    height:8vh;
    background:#0000e0;
	line-height:8vh;
	text-align:center;
	color:#fafafa;
}


.bottom{
    position:fixed;
    bottom:0;
    left:0;
    width:110vw;
    height:10vh;
    line-height:10vh;
    background:#e0e0e0;
    text-align:center;
	z-index:20;
}

.main{
    position:fixed;
    overflow-y: auto;
    top:0;
    left:0;
    width:100vw;
    height:200vh;
    background:linear-gradient(#fff0fa,#ff8090);
	z-index:10;
    text-align:center;
    margin-top:10vh;
    margin-bottom:10vh;

}

.left{
    position:fixed;
    top:10vh;
    left:-100vw;
    width:20vw;
    height:100vh;
    background:#f0e090;
	z-index:15;
}

.box{
    display:inline-block;
    height:8vw;
    line-height:8vw;
    width:19vw;
    border-bottom:0.5vw solid #fafafa;
    font-size:3.5vw;
    text-align:center;
}

.com{
    border:1px solid #606060;
    padding:1vw;
    text-align:left;
    font-size:3.5vw;
    width:80vw;
    margin:2vw auto;
    background:#fafafa;
}


</style>
<script>
$(function(){ 
	$(window).scroll(function(){
		let scrollHeight = $('body').scrollTop();
		let scrollTrigger= $('#trigger1').offset().top;

		if(scrollHeight > scrollTrigger*2 ){
			$('body').css('background-color','blue');

		}else if(scrollHeight >scrollTrigger ){
			$('body').css('background-color','yellow');

		}else{
			$('body').css('background-color','white')
		}
	})
});
</script>

</head>
<body>
<div style="height:200vh;"></div>
<div id="trigger1" style="height:200vh;">あん</div>
<div style="height:200vh;">やん</div>
</body></html>
