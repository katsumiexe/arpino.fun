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

			Tmp=$(this).attr('id');
			var Cnt = 1;

			if(Tmp == 'staff_sort'){
				$(this).children('.tr').each(function(){
					$(this).children('.w40').children('.box_sort').val(Cnt);
					Cnt++;
				});

			}else if(Tmp == 'contents_sort'){
				$(this).children('.sort_item').each(function(){
					$(this).find('.box_sort').val(Cnt);
					Cnt++;
				});
			}

			$.ajax({
				url:'./post/admin_sort.php',
				type: 'post',
				data:{
					'list[]':ChgList,
					'group':Tmp,
				},
//				dataType: 'json',

			}).done(function(data, textStatus, jqXHR){
				console.log(data)

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);

		
			});
		}
	});
});

