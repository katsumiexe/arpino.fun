$(function(){ 
	$('.head_mymenu').on('click',function(){
		if($(this).hasClass('mypage_on')){
			$(this).removeClass('mypage_on');
			$('.mypage_slide').animate({'left':'-100vw'},150);
			$('.mymenu_b').fadeIn(150);

			$('.mymenu_a,.mymenu_c').animate({'left':'1vw','width':'5vw'},150);
			$('.head_mymenu').animate({'border-radius':'1vw'},150);

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
			$('.mypage_slide').animate({'left':'0'},150);
			$('.mymenu_b').fadeOut(150);
			$('.mymenu_a,.mymenu_c').animate({'left':'0vw','width':'5.6vw'},150);
			$('.head_mymenu').animate({'border-radius':'3.5vw'},150);

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

	$('.cal_prev').on('click',function () {
		$('#chg').val('prev');
		$('#chg_month').submit();
	});

	$('.cal_next').on('click',function () {
		$('#chg').val('next');
		$('#chg_month').submit();
	});

	$('.menu_1').on('click',function () {
		Tmp=$(this).attr('id').replace('m','');
		if(Tmp == 99){
			$('#logout').submit();

		}else{
			$('#pg').val(Tmp);
			$('#menu_sel').submit();
		}
	});

	$('.mypage_blog_set').on('click',function () {
		if($('.mypage_blog_write').css('display') == 'none'){
			$('.mypage_blog_write').slideDown(100);
		}else{
			$('.mypage_blog_write').slideUp(50);
		}
	});

	$('#mypage_blog_date').datepicker({
	dateFormat: 'yy/mm/dd',
	monthNames: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
	firstDay: 1,

	});


});
