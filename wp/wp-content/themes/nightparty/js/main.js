$(document).ready(function () {
var TopCnt=0;
$('.main').fadeIn(2000);
	$('.main_b_11').on('click',function () {
		TMP=$(this).attr('id').replace('i','');
		$('#val_p').val(TMP);
		$('#form_p').submit();
	});


	$('.slide_dot').on('click',function () {
		TMP=$(this).attr('id').replace('dot','');
		Left=TMP * (-1200);
		$('.slide_img').animate({'left':Left},1000);
		$('.slide_dot').removeClass('dot_on');
		$(this).addClass('dot_on');
		TopCnt=TMP;

	});

	setInterval(function(){
		TopCnt++;
		if(TopCnt>4) TopCnt=0;
		Left=TopCnt * (-1200);
		$('.slide_img').animate({'left':Left},1000);
		$('.slide_dot').removeClass('dot_on');
		$('#dot'+TopCnt).addClass('dot_on');
	},6000);

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

