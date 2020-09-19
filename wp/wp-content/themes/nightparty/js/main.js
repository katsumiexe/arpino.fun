$(document).ready(function () {
$('.main').fadeIn(1500);

	$('.main_b_11').on('click',function () {
		TMP=$(this).attr('id').replace('i','');
		$('#val_p').val(TMP);
		$('#form_p').submit();
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

	$('.cal1').on('click',function(){
		Tmp=$(this).text();
		$.post({
			url:Dir + "/post/blog_calendar.php",
			data:{
				't_tag':Tag,
				't_month':Tmp,
				't_day':Tmp,
			},
		}).done(function(data, textStatus, jqXHR){
			$('.main_d').html(data);		
		});

	});

});

