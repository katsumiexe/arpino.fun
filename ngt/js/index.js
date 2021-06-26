var TopCnt=0;
var Vw	=$(window).width();
var Vh	=$(window).height();
if(Vw <1200){
	TopW=Vw;

}else{
	TopW=1200;
}


const TMR=6000;

$(function(){ 
	timerId = setInterval(Fnc_s,TMR);

	$('.slide_img_cv').on('click',function () {
		console.log($('#slide_img'+TopCnt).attr('s_link'));
		if($('#slide_img'+TopCnt).attr('s_link')){

			$('#s_code').val($('#slide_img'+TopCnt).attr('s_code'));
			$('#form_1').attr('action',$('#slide_img'+TopCnt).attr('s_link')).submit();

		}
	});

	$('.slide_img_cv').draggable({
		axis: 'x',
		start: function( event, ui ) {

			startPosition = ui.position.left;
			clearInterval(timerId);
			TmpWidth=$('#slide_img0').width();

			Lim_l=$('#slide_img0').width()/(-5);
			Lim_r=$('#slide_img0').width()/5;

			if(TopCnt == Cnt-1){
				NewCnt=0;
			}else{
				NewCnt=TopCnt+1;
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
				$('#slide_img'+NewCnt).css({'left':ui.position.left+TmpWidth});
				$('#slide_img'+TopCnt).css({'left':0});
			}
		},

		stop: function( event, ui ) {
			if(ui.position.left< Lim_l){//■左へ
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
				$('.slide_img_cv').css({'left':0});
				timerId = setInterval(Fnc_s,TMR);

			}else if(ui.position.left>Lim_r){//■右へ

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
				$('.slide_img_cv').css({'left':0});
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
			$('#slide_img'+i).stop(true,true).animate({'left':'0','zIndex':'1'},500);

		}else{
			$('#slide_img'+i).css({'left':TopW,'zIndex':'2'});
		}
	}
	$('.slide_dot').removeClass('dot_on');
	$('#dot'+TopCnt).addClass('dot_on');
}

