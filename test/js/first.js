$(function(){ 
/*
	$(window).resize(function() {
		var w = $(window).width();
		var h = $(window).height();
		if (w < h) {
		    $('.blind').hide();

		}else{
		    $('.blind').show();
		}

	});
	console.log(w);
	console.log(h);
*/
	$('.head_mymenu').on('click',function(){
		if($(this).hasClass('mypage_on')){
			$(this).removeClass('mypage_on');
			$('.mypage').animate({'left':'-100vw'},150);
			$('.mymenu_b').fadeIn(150);
			$('.mymenu_a,.mymenu_c').animate({'left':'0.8vh'},150);
			$('.head_mymenu').animate({'border-radius':'1vh'},150);

			$({deg:-23}).animate({deg:0}, {
				duration:150,
				progress:function() {
					$('.mymenu_a').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:23}).animate({deg:0}, {
				duration:150,
				progress:function() {
					$('.mymenu_c').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

		}else{
			$(this).addClass('mypage_on');
			$('.mypage').animate({'left':'0'},150);
			$('.mymenu_b').fadeOut(150);
			$('.mymenu_a,.mymenu_c').animate({'left':'0.4vh'},150);
			$('.head_mymenu').animate({'border-radius':'2.5vh'},150);

	

			$({deg:0}).animate({deg:-45}, {
				duration:150,
				progress:function() {
					$('.mymenu_a').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:0}).animate({deg:45}, {
				duration:150,
				progress:function() {
					$('.mymenu_c').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});
		}
	});
});

