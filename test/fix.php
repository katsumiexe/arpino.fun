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
    width:100vw;
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
}


.bottom{
    position:fixed;
    bottom:0;
    left:0;
    width:100vw;
    height:10vh;
    line-height:10vh;
    background:#e0e0e0;
    text-align:center;
	z-index:20;
}

.main{
    position:fixed;
    top:0;
    left:0;
    width:100vw;
    height:200vh;
    background:linear-gradient(#fff0fa,#ff8090);
    overflow-y: auto;
	z-index:10;
    text-align:center;
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
    height:10vw;
    width:19vw;
    border-bottom:0.5vw solid #fafafa;
    font-size:3.5vw;
}

</style>

<script>
$(function(){ 
	$('.menu').on('click', function(){
       $('.left').animate({'left':'0'},200);
    });
});
</script>
</head>
<body>
<div class="head"><div class="menu"></div>header</div> 
<div class="main">
<?for($n=0;$n<100;$n++){?>
<?=$n?>行目。<br>
<?}?>
</div> 
<div class="left">
<div class="box">01ばん</div>
<div class="box">02ばん</div>
<div class="box">03ばん</div>
<div class="box">04ばん</div>
<div class="box">05ばん</div>
<div class="box">06ばん</div>
<div class="box">07ばん</div>
<div class="box">08ばん</div>
<div class="box">09ばん</div>
<div class="box">10ばん</div>
</div> 
<div class="bottom">footer</div> 
</body>
</html>

