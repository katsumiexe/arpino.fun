$(function(){ 
	$('.menu').on('click',function () {
		Tmp=$(this).attr('id');
		$('#menu_post').val(Tmp);
		$('#form_menu').submit();
	});

	$('.list_sort').sortable({
		axis: 'y',
        handle: '.handle',
		stop : function(){
			ChgList=$(this).sortable("toArray");
			console.log(ChgList);
			var Cnt = 1;
			$(this).children('.tr').each(function(){
				$(this).children('.w40').children('.box_sort').val(Cnt);
				Cnt++;
			});

			$.ajax({
				url:'./post/admi_sort.php',
				type: 'post',
				data:{
					'list[]':ChgList,
					'group':$(this).attr('id'),
				},
				dataType: 'json',

			}).done(function(data, textStatus, jqXHR){
		
			});
		}
	});
});

