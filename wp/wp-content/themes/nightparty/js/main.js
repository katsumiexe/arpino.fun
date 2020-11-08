var TopCnt=0;
var Vw	=$(window).width();
var Vh	=$(window).height();

$(document).ready(function () {

var timerId = setInterval(Fnc,4000);
if(Vw <1200){
	var TopW=Vw;

}else{
	var TopW=1200;
}

$('.main').fadeIn(2000);
	$('.head_menu').on('click',function(){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
			$('.menu').animate({'left':'-46vw'},150);
			$('.menu_b').fadeIn(150);

			$('.menu_a,.menu_c').animate({'left':'1vw','width':'8vw'},150);
			$('.head_menu').animate({'border-radius':'1vw'},150);

			$({deg:-23}).animate({deg:0}, {
				duration:150,
				progress:function() {
					$('.menu_a').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:23}).animate({deg:0}, {
				duration:150,
				progress:function() {
					$('.menu_c').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

		}else{
			$(this).addClass('on');
			$('.menu').animate({'left':'-0.5vw'},150);
			$('.menu_b').fadeOut(150);
			$('.menu_a,.menu_c').animate({'left':'0.5vw','width':'7vw'},150);
			$('.head_menu').animate({'border-radius':'5vw'},150);

			$({deg:0}).animate({deg:-45}, {
				duration:150,
				progress:function() {
					$('.menu_a').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:0}).animate({deg:45}, {
				duration:150,
				progress:function() {
					$('.menu_c').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});
		}
	});
	

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
				timerId = setInterval(Fnc,4000);

			}else if(startPosition - ui.position.left> 100){//■右へ
				TMP=$('.dot_on').attr('id').replace('dot','')-0+1;
				Left=(TMP) * (-100);
				$('.slide_img').animate({'left':Left+"%"},200);
				$('.slide_dot').removeClass('dot_on');
				$('#dot'+TMP).addClass('dot_on');
				TopCnt=TMP;
				clearInterval(timerId);
				timerId = setInterval(Fnc,4000);

			}else{
				TMP=$('.dot_on').attr('id').replace('dot','');
				Left=TMP * (-100);
				$('.slide_img').animate({'left':Left+"%"},200);
				clearInterval(timerId);
				setInterval(timerId,4000);
			}
		}
	})

	$('.main_b_11').on('click',function () {
		TMP=$(this).attr('id').replace('i','');
		$('#val_p').val(TMP);
		$('#form_p').submit();
	});

	$('.slide_dot').on('click',function () {
		TMP=$(this).attr('id').replace('dot','');
		Left=TMP * (-100);
		$('.slide_img').animate({'left':Left+"%"},1000);
		$('.slide_dot').removeClass('dot_on');
		$(this).addClass('dot_on');
		TopCnt=TMP;
		clearInterval(timerId);
		timerId = setInterval(Fnc,4000);
	});


	$('.person_img_sub').hover(function () {
		TMP=$(this).attr('src');
		$('.person_img_main').hide().fadeIn(300).attr('src',TMP);
	});

	$(document).on({
		'mouseenter': function() {	
			$(this).children('.main_b_1_3').fadeIn(100);
		},
		'mouseleave': function() {
			$(this).children('.main_b_1_3').fadeOut(0);
		}
	}, '.main_b_1');

	$(document).on({
		'mouseenter': function() {	
			$(this).children('.main_d_1_3').fadeIn(100);
		},
		'mouseleave': function() {
			$(this).children('.main_d_1_3').fadeOut(0);
		}
	}, '.main_d_1');


	$('.cast_tag_box').on('click',function(){
		if(!$(this).hasClass('cast_tag_box_sel')){
			$('.cast_tag_box_sel').removeClass('cast_tag_box_sel');		
			$(this).addClass('cast_tag_box_sel');		
			Tmp=$(this).attr('id').replace('d','');
			$.post({
				url:Dir + "/post/cast_tag_box.php",
				data:{
					'date':Tmp,
				},
			}).done(function(data, textStatus, jqXHR){
				$('.main_d').html(data);		
			});
		};
	});

});
function Fnc() {
	TopCnt++;
	if(TopCnt>4){
		TopCnt=0;
		clearInterval(timerId);
		timerId = setInterval(Fnc,4000);
	}

	Left=TopCnt * (-100);
	$('.slide_img').animate({'left':Left+"%"},1000);
	$('.slide_dot').removeClass('dot_on');
	$('#dot'+TopCnt).addClass('dot_on');
}



