$(function(){ 
	$('.main_b_11').on('click',function () {
		TMP=$(this).attr('id').replace('i','');
		$('#val_p').val(TMP);
		$('#form_p').submit();
	});

	$('.person_img_sub').hover(function () {

		TMP=$(this).attr('src');
		$('.person_img_main').hide().fadeIn(300).attr('src',TMP);
	});

	$('.main_b_1').hover(
	function(){
		$(this).children('.main_b_1_3').fadeIn(100);
	  },
	function () {
		$(this).children('.main_b_1_3').fadeOut(0);
	});
});


