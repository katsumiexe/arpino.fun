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
	line-height:8vh;
    background:#0000ff;
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
    position:relative;
    top:0;
    left:0;
    width:100vw;
    background:linear-gradient(#fff0fa,#ff8090);
    overflow-y: auto;
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
	$('.menu').on('click', function(){
        $('.left').animate({'left':'0'},200);
        $('.menu').css({'background':'#ff0000'});
    });
});
</script>
</head>
<body>
<div class="head"><div class="menu">MENU</div>header</div> 
<div class="main">
<p>スマホのスクロールテストです。</p>

<div class="com">
普通バージョンです。<br>
<br>
画面をスクロールさせたとき、林檎は上のアドレスバーが小さくなり、下のフッターが消えるかと思います。<br>
アンドロイドは上のアドレスバーが縮みます。<br>
その分、画面の立幅が少し長くなります。<br>
<br>
ブログ等は見やすいですが、影響で、左のメニューの見える領域もかわります。<br>
<br>
twitterも左のメニューの可視領域が変わっちゃいます。。
</div>

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
<div class="box">11ばん</div>
<div class="box">12ばん</div>
<div class="box">13ばん</div>
<div class="box">14ばん</div>
<div class="box">15ばん</div>
<div class="box">16ばん</div>
<div class="box">17ばん</div>
</div> 
<div class="bottom">footer</div> 
</body>
</html>

