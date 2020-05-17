$(function(){ 
	$('.main_b_11').on('click',function () {
		TMP=$(this).attr('id').replace('i','');
		$('#val_p').val(TMP);
		$('#form_p').submit();
	});

	$('.person_img_sub').hover(function () {
		TMP=$(this).attr('src');
		$('.person_img_main').attr('src',TMP);

	});


});
