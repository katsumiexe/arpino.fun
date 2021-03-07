$(function(){ 
	$('.menu').on('click',function () {
		Tmp=$(this).attr('id');
		$('#menu_post').val(Tmp);
		$('#form_menu').submit();
	});
});
