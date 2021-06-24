var TopCnt=0;
var Vw	=$(window).width();
var Vh	=$(window).height();
if(Vw <1200){
	TopW=Vw;

}else{
	TopW=1200;
}


const TMR=4000;

$(function(){ 
	timerId = setInterval(Fnc_s,TMR);


/*
	$('.slide_img').draggable({
		axis: 'x',
		start: function( event, ui ) {
			startPosition = ui.position.left;
		},

		drag: function( event, ui ) {
			if($('.dot_on').attr('id').replace('dot','')==0 && ui.position.left>0) ui.position.left = 0;
			if($('.dot_on').attr('id').replace('dot','')==Cnt && ui.position.left>TopW*Cnt) ui.position.left = TopW*Cnt;
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
*/
	$('.slide_dot').on('click',function () {
		var TMP=$(this).attr('id').replace('dot','');
		
		console.log(TMP);
		if(TopCnt != TMP){

			$('.top_img').css({'z-index':'0'});

			$('#slide_img'+TMP).css({'z-index':'1'}).animate({'left':'0'},1000);

			$('.slide_dot').removeClass('dot_on');
			$(this).addClass('dot_on');

			TopCnt=TMP;
/*
			clearInterval(timerId);
			var timerId = setInterval(Fnc_s,TMR);
*/

		}
	});


});

var Zindex=0;

function Fnc_s(){

	NowCnt=TopCnt;
	TopCnt++;
	if(TopCnt>Cnt-1){
		TopCnt=0;
	}

/*
	$('#slide_img'+NowCnt).siblings().css({'left':'1200px','z-index':'2'});
	$('#slide_img'+NowCnt).css('z-index','1');
	$('#slide_img'+TopCnt).animate({'left':'0'},1000);
*/


//console.log(NowCnt);
//console.log(TopCnt);


	for(var i=0;i<Cnt;i++){
		if(i == NowCnt){
			$('#slide_img'+i).css({'left':'0','z-index':'0'});

		}else if(i == TopCnt){
			$('#slide_img'+i).animate({'left':'0'},1000);

		}else{
			$('#slide_img'+i).css({'left':TopW,'z-index':'1'});

		}
	}

	$('.slide_dot').removeClass('dot_on');
	$('#dot'+TopCnt).addClass('dot_on');
}

