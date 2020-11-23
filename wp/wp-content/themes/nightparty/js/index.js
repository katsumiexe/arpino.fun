var TopCnt=0;
var Vw	=$(window).width();
var Vh	=$(window).height();
var TMR=4000;

$(function(){ 
	timerId = setInterval(Fnc_s,TMR);
	if(Vw <1200){
		var TopW=Vw;

	}else{
		var TopW=1200;
	}

	$('.slide_img').draggable({
		axis: 'x',
		start: function( event, ui ) {
			startPosition = ui.position.left;
		},

		drag: function( event, ui ) {
			if($('.dot_on').attr('id').replace('dot','')==0 && ui.position.left>0) ui.position.left = 0;
			if($('.dot_on').attr('id').replace('dot','')==4 && ui.position.left>TopW*4) ui.position.left = TopW*4;
		},

		stop: function( event, ui ) {
			if(startPosition - ui.position.left< -100){//■左へ
				TMP=$('.dot_on').attr('id').replace('dot','')-1;
				Left=(TMP) * (-100);
				$('.slide_img').animate({'left':Left+"%"},200);
				$('.slide_dot').removeClass('dot_on');
				$('#dot'+TMP).addClass('dot_on');
				TopCnt=TMP;
				clearInterval(timerId);
				timerId = setInterval(Fnc_s,TMR);

			}else if(startPosition - ui.position.left> 100){//■右へ
				TMP=$('.dot_on').attr('id').replace('dot','')-0+1;
				Left=(TMP) * (-100);
				$('.slide_img').animate({'left':Left+"%"},200);
				$('.slide_dot').removeClass('dot_on');
				$('#dot'+TMP).addClass('dot_on');
				TopCnt=TMP;
				clearInterval(timerId);
				timerId = setInterval(Fnc_s,TMR);

			}else{
				TMP=$('.dot_on').attr('id').replace('dot','');
				Left=TMP * (-100);
				$('.slide_img').animate({'left':Left+"%"},200);
				clearInterval(timerId);
				setInterval(timerId,TMR);
			}
		}
	})

	$('.slide_dot').on('click',function () {
		TMP=$(this).attr('id').replace('dot','');
		Left=TMP * (-100);
		$('.slide_img').animate({'left':Left+"%"},500);
		$('.slide_dot').removeClass('dot_on');
		$(this).addClass('dot_on');
		TopCnt=TMP;
		clearInterval(timerId);
		timerId = setInterval(Fnc_s,TMR);
	});
});

function Fnc_s() {
	TopCnt++;
	if(TopCnt>4){
		TopCnt=0;
//		clearInterval(timerId);
//		timerId = setInterval(Fnc_s,TMR);
	}
	Left=TopCnt * (-100);
		$('.slide_img').animate({'left':Left+"%"},1000)
		$('.slide_dot').removeClass('dot_on'),
		$('#dot'+TopCnt).addClass('dot_on')

console.log(Left)
}


