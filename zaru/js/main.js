$(function(){
	$('.pg_n').on('click', function(){
		Tmp=$(this).attr('id').replace('p','');
		$('#h_pd').val(Tmp);
		$('#jump').submit();
	});

});
