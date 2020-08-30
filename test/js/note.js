$(function(){ 
	$('.exp_box0_a').on('click',function(){
		Tmp=$(this).attr('id').replace("a","b");

		$('.exp_box0_b').slideUp(150);

		if($('#'+Tmp).css('display')=='none'){

			$('.al1').css({transform:'rotate(45deg)'});
			$('.al2').css({transform:'rotate(-45deg)'});

			$('#'+Tmp).slideDown(150);
			$({deg:45}).animate({deg:-45}, {
				duration:150,
				progress:function() {
					$('#x'+Tmp).css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:-45}).animate({deg:45}, {
				duration:150,
				progress:function() {
					$('#y'+Tmp).css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

		}else{
			$({deg:-45}).animate({deg:45}, {
				duration:150,
				progress:function() {
					$('#x'+Tmp).css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:45}).animate({deg:-45}, {
				duration:150,
				progress:function() {
					$('#y'+Tmp).css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});
		}
	});

	$('.exp_box0_c').on('click',function(){
		TTL=$(this).children('.note_item').text();
		Tmp='./note/' + $(this).attr('id')+ '.php';
		$.post(
			Tmp,
			function(data){
			$('.page').show().animate({'left':0},100);
			$('.page_main').html(data);
			$('.page_title').text(TTL);
		});
	});

	$('.page_top').on('click',function(){
		$('.page').fadeOut(200).animate({'left':'100vw'},200);
	});
});
