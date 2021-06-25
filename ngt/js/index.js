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

	$('.slide_img_cv').draggable({
		axis: 'x',
		start: function( event, ui ) {
			startPosition = ui.position.left;
			clearInterval(timerId);
			TmpWidth=$('#slide_img0').width();

			if(TopCnt == Cnt-1){
				NowCnt=0;
			}else{
				NowCnt=TopCnt+1;
			}

			if(TopCnt == 0){
				OldCnt=Cnt-1;

			}else{
				OldCnt=TopCnt-1;
			}
		},

		drag: function( event, ui ){
			if(ui.position.left>0){
				$('#slide_img'+TopCnt).css({'left':ui.position.left});
				$('#slide_img'+NewCnt).css({'left':TmpWidth});

			}else{
				$('#slide_img'+NewCnt).css({'left':ui.position.left});
				$('#slide_img'+TopCnt).css({'left':0});
			}
/*
			if($('.dot_on').attr('id').replace('dot','')==0 && ui.position.left>0) ui.position.left = 0;
			if($('.dot_on').attr('id').replace('dot','')==Cnt && ui.position.left>TopW*Cnt) ui.position.left = TopW*Cnt;
*/
	console.log(ui.position.left);
		},

		stop: function( event, ui ) {
			if(startPosition - ui.position.left< -100){//■左へ
				$('#slide_img'+NewCnt).animate({'left':0},200);
				$('.slide_dot').removeClass('dot_on');
				$('#dot'+NewCnt).addClass('dot_on');

				TopCnt=NewCnt;
				if(TopCnt == 0){
					OldCnt=Cnt-1;
				}else{
					OldCnt=TopCnt-1;
				}

				for(var i=0;i<Cnt;i++){
					if(i == OldCnt){
						$('#slide_img'+i).css({'left':'0','zIndex':'0'});

					}else if(i == TopCnt){
						$('#slide_img'+i).css({'zIndex':'1'});

					}else{
						$('#slide_img'+i).css({'left':TopW,'zIndex':'2'});
					}
				}
				timerId = setInterval(Fnc_s,TMR);

			}else if(startPosition - ui.position.left> 100){//■右へ
				$('#slide_img'+TopCnt).animate({'left':TmpWidth},200);
				$('.slide_dot').removeClass('dot_on');
				$('#dot'+OldCnt).addClass('dot_on');

				TopCnt=OldCnt;
				if(TopCnt == 0){
					OldCnt=Cnt-1;
				}else{
					OldCnt=TopCnt-1;
				}

				for(var i=0;i<Cnt;i++){
					if(i == OldCnt){
						$('#slide_img'+i).css({'left':'0','zIndex':'0'});

					}else if(i == TopCnt){
						$('#slide_img'+i).css({'zIndex':'1'});

					}else{
						$('#slide_img'+i).css({'left':TopW,'zIndex':'2'});
					}
				}
				timerId = setInterval(Fnc_s,TMR);
			}else{

				$('#slide_img'+TopCnt).animate({'left':0},200);
				$('#slide_img'+NewCnt).animate({'left':TmpWidth},200);
				$('.slide_img_cv').css({'left':0});

				timerId = setInterval(Fnc_s,TMR);
			}
		}
	});


	$('.slide_dot').on('click',function () {
		var TMP=$(this).attr('id').replace('dot','');

		$('.slide_dot').removeClass('dot_on');
		$(this).addClass('dot_on');

		if(TopCnt != TMP){
			var TmpWidth=$('#slide_img'+TMP).width();

			$.when(
				$('#slide_img'+TMP).css({'left':TmpWidth,'z-index':'2'}).stop(true,true).delay(0).animate({'left':'0'},1000)
			).done(function() {

				if(TMP == 0){
					OldCnt=Cnt-1;
				}else{
					OldCnt=TMP-1;
				}

				for(var i=0;i<Cnt;i++){

					if(i == OldCnt){
						$('#slide_img'+i).css({'left':'0','zIndex':'0'});

					}else if(i == TMP){
						$('#slide_img'+i).css({'zIndex':'1'});

					}else{
						$('#slide_img'+i).css({'left':TopW,'zIndex':'2'});
					}

				}
				TopCnt=TMP;
				clearInterval(timerId);
				timerId = setInterval(Fnc_s,TMR);
			});
		}
	});
});


var zIndex=0;
function Fnc_s(){
	NowCnt=TopCnt;
	TopCnt++;
	if(TopCnt>Cnt-1){
		TopCnt=0;
	}

	for(var i=0;i<Cnt;i++){
		if(i == NowCnt){
			$('#slide_img'+i).css({'left':'0','zIndex':'0'});

		}else if(i == TopCnt){
			$('#slide_img'+i).stop(true,true).animate({'left':'0','zIndex':'1'},1000);

		}else{
			$('#slide_img'+i).css({'left':TopW,'zIndex':'2'});
		}
	}

	$('.slide_dot').removeClass('dot_on');
	$('#dot'+TopCnt).addClass('dot_on');
}

