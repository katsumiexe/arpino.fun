$(document).ready(function () {
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

	$('.main_b_11').on('click',function () {
		TMP=$(this).attr('id').replace('i','');
		$('#val_p').val(TMP);
		$('#form_p').submit();
	});

	$('.person_img_sub').hover(function () {
		TMP=$(this).attr('src');
		$('.person_img_main').hide().fadeIn(300).attr('src',TMP);
	});

	$('.cast_tag_box').on('click',function(){
		if(!$(this).hasClass('cast_tag_box_sel')){
			$('.cast_tag_box_sel').removeClass('cast_tag_box_sel');		
			$(this).addClass('cast_tag_box_sel');		
			Tmp=$(this).attr('id').replace('d','');
			$.post({
				url:"./post/cast_tag_box.php",
				data:{
					'date':Tmp,
				},
			}).done(function(data, textStatus, jqXHR){
				$('.main_d').html(data);		
			});
		};
	});

	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('.to_top').slideDown(100);
		} else {
			$('.to_top').slideUp(100);
		}
	});

	$('.to_top').on('click',function () {
		$('body, html').animate({ scrollTop: 0 }, 500);
		return false;
	});

});
