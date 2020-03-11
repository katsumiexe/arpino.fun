$(function(){
	$('.gp_dt:not(:first)').hide();

	$('.sub_slide_sel').on('click',function(){
		Sel= $(this).attr("id").replace('s','');
		Col= $(this).css('color');
		SelHtml= $(this).html();
		$('.sub_slide_top').html(SelHtml);
		$('.bk4').css({'border-color':Col});

		$.post("post_chg_fav.php",
			{
				'chg':Sel,
				'uid':Uid,
				'log_id':LogId,
			},
			function(data){
		});
	});

	$('.todo_tag_ckb').click(function(){
		var ck_count = $(".todo_div :checked").length;

		if (ck_count  > 0 ){
			$('#todo_send').prop("disabled", false);
			$('#todo_send').css('background','#ff90b0');
		} else {
			$("#todo_send").prop("disabled", true);
			$('#todo_send').css('background','#e0e0e0');
		}
	});
	$('#logdel').click(function(){
		if(!confirm('本当に削除しますか？')){
			return false;
		}else{
			location.href = './index.php?del_id=<?=$log[$c_view]["id"]?>';
		}
	});

	$('tbody tr[data-href]').addClass('clickable').click( function() {
		window.location = $(this).attr('data-href');
	}).find('a').hover( function() {
		$(this).parents('tr').unbind('click');

	}, function() {
		$(this).parents('tr').click( function() {
			window.location = $(this).attr('data-href');
		});
	});
/**/
	$('#cat').on('change',function() {
		var val = $(this).val();
		$('.gp_dt').hide();
		$('#gp_dt' + val).show();
	})


	$('.sub_slide3').hide();
	$('.sub_slide').hide();
	$('.sub_slide2').hide();

	$('.main_slide').on('click',function(){
		$('.sub_slide').slideUp(100);
		if($(this).children('.sub_slide').css('display') == 'none'){
			$(this).children('.sub_slide').slideDown(100);
		}
	});


	$('a[href^=#]').click(function(){ 
		var speed = 500; 
		var href= $(this).attr("href"); 
		var target = $(href == "#" || href == "" ? 'html' : href); 
		var position = target.offset().top; 
		$("html, body").animate({scrollTop:position}, speed, "swing"); 
		return false; 
	}); 

	$(document).click(function(e){
		if(!$(e.target).closest('.main_slide','sub_slide').length) {
			$('.sub_slide').slideUp(100);
		}
	});

	$('#d1').on('click',function() {
		$(this).fadeOut(700);
	}); 

	$('.table_list_a,.table_list_b').on('click',function() {
		Tmp=$(this).attr('id').replace('l','');
		$('#submit_id').val(Tmp);
		$('#submit_form').submit();
	}); 

	$('#res_send').on('click',function(){
		$('#res_form').submit();
	});

	$('.fav2').on('click',function() {
		var TMPL =$(this).attr('id').replace("fn", "");
		var TMPL2=$(this).html();
		$('#slide3').html(TMPL2);
		$('#hidden_fav').val(TMPL);
		$('.sub_slide3').slideUp(100);
	});

	$('.log_del').on('click',function() {
		$('.act').val('del');
		$('#submit_form').submit();
	}); 

	$('.set_chg').on('click',function() {
		$('.act').val('chg');
		$('#submit_form').submit();
	}); 

	$('.set_res').on('click',function() {
		$('.act').val('res');
		$('#submit_form').submit();
	}); 
});

