$(function(){
	$('.koma').on('click',function(){
		if($('.koma_on').hasClass('u1') && $(this).hasClass('u2')){
			Tmp_T=$(this).css('top');
			Tmp_L=$(this).css('left');
			$('.koma_on').animate({'left':Tmp_L,'top':Tmp_T},400);
			$(this).fadeOut(400);
			$('.koma').removeClass('koma_on');

		}else if($('.koma_on').hasClass('u2') && $(this).hasClass('u1')){
			Tmp_T=$(this).css('top');
			Tmp_L=$(this).css('left');
			$('.koma_on').animate({'left':Tmp_L,'top':Tmp_T},300);
			$(this).fadeOut(200);
			$('.koma').removeClass('koma_on');

		}else if($(this).hasClass('koma_on')){
			$(this).removeClass('koma_on');

		}else{
			$('.koma').removeClass('koma_on');
			$(this).addClass('koma_on');
		}
	});

	$('.masu').on('click',function(){
		if($('.koma').hasClass('koma_on')){
			Tmp_T=$(this).css('top');
			Tmp_L=$(this).css('left');
			$('.koma_on').animate({'left':Tmp_L,'top':Tmp_T},300);
			$('.koma').removeClass('koma_on');
		}
	});
});
