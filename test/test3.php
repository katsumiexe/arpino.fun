<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>TEST</title>
<script>
$(function(){ 
	$(window).scroll(function(){
		let sH = $('body').scrollTop();
		let sT= $('#t').offset().top;
		if(sH > sT*2 ){
			$('body').css('background','blue');
		}else if(sH >sT ){
			$('body').css('background','yellow');
		}else{
			$('body').css('background','white')
		}
	})
});
</script>
</head>
<body>
<div style="height:200vh;"></div>
<div id="t" style="height:200vh;">きいろ</div>
<div style="height:200vh;">あお</div>
</body></html>
