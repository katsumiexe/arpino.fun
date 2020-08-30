var Direction="";
var Position="";
var TopNow="";
var TopNow2="";

$(function(){ 
	$('.p_cheer_com').hide();
	$('.btn_login').on('click',function () {
		$('#user_login').submit();	
	});

	$('#p_page_prof').on('click',function () {
		$('#jump_id').val(Own);
		$('#jump_p').submit();
	});

	$('.h1_item').on('click', function(){
		Chg	= $(this).attr('id').replace("sel_", "");
		$('#chg').val(Chg);
		$('#chg_jump').submit();
	});

	$('.h1_main_slide').on('click', function(){
		if($('.h1_sub_slide').css('display') == 'none'){
			$('.h1_sub_slide').slideDown(50);
		}else{
			$('.h1_sub_slide').slideUp(50);
		}	
	});
	

	$('.index_box').on('click', '.next', function(){
		Last_card	= $(this).attr('id').replace("next_", "");
		$.post("post_read_main.php",
			{
				'nextck':NextCk,
				'chg':Chg,
				'date_30':Date_30,
				'last_card':Last_card,
			},
			function(data){
				$('#next_' + Last_card).after(data).fadeOut(10);				

				TopNow=$(window).scrollTop();
				TopNow2=TopNow+360+"vw";

				console.log(TopNow);
				console.log(TopNow2);
				$('body,html').animate({scrollTop:TopNow2},300);
			}
		);
/*		$(window).animate({scrollTop:TopNow2});*/
/*		$(window).animate({scrollTop:TopNow2},200);*/



	});

	$(document).on('click', '.index_frame', function(){
		TopNow=$(window).scrollTop();
		Img_id	= $(this).attr('id').replace("f", "");

		MySel	= $(this).children('input:hidden[name="mysel"]').val();
		Minus	= $(this).children('input:hidden[name="minus"]').val();

		Alert	= $(this).children('input:hidden[name="alert"]').val();

		Own		= $(this).children('input:hidden[name="own"]').val();
		Pict	= $(this).children('input:hidden[name="pict"]').val();
		Mdate	= $(this).children('input:hidden[name="mdate"]').val();
		Cheer_ct= $(this).children('input:hidden[name="cheer_ct"]').val();

		Pritty	= $(this).children('input:hidden[name="pritty"]').val();
		Smart	= $(this).children('input:hidden[name="smart"]').val();
		Funny	= $(this).children('input:hidden[name="funny"]').val();
		Sexy	= $(this).children('input:hidden[name="sexy"]').val();
		Tlink	= $(this).children('input:hidden[name="tlink"]').val();


		AllIine	= $(this).children('input:hidden[name="all"]').val();
		$('#e_pritty').text(Pritty);
		$('#e_smart').text(Smart);
		$('#e_funny').text(Funny);
		$('#e_sexy').text(Sexy);

		Img_Url	=$(this).children('.index_img').attr('src');
		Img_Name=$(this).children('.index_img').attr('alt');

		$('#tmpl').attr('src',Img_Url);
		$('.p_name').text(Img_Name);
		$('.p_date').text(Mdate);
		$('#p_pict').attr('src',Pict);
		$('#cheer_ct').text('(' + Cheer_ct +')');

		$('.iine_twitter').attr('href',Tlink);
		
		
		$('.p_page').animate({'left': '0.5vw'},150);

		if(Own == User_id){
			$('.p_page_msg_a').addClass('iine_my_a');
			$('.p_page_msg_c').addClass('iine_my_c2');
			$('.set_cheer').addClass('cheer_no');
	
		}else if(MySel){	
			$('#'+MySel).addClass('ii_'+MySel);
			$('#e_'+MySel).addClass('iine_my_c1');
		}

		if(Alert=="1"){	
			$('#p_page_alert').addClass('alert_done');

		}else if(Own == User_id){
			$('#p_page_alert').addClass('alert_mine');

		}else{
			$('#p_page_alert').addClass('alert_yet');

		}	
		$('.p_cheer_cld').hide();
		$('.i'+Img_id).show();
		$('.prof_table').hide();
	});

	$('.p_page').draggable({
		axis: 'x',
		start: function( event, ui ) {
			startPosition = ui.position.left;
		},
		drag: function( event, ui ) {
			if(ui.position.left < startPosition) ui.position.left = startPosition;
		},

		stop: function( event, ui ) {
			if(ui.position.left < 100){
				$('.p_page').animate({'left':'0.5vw'},200);
			}else{
				$('.p_page').animate({'left': '105vw'},100);
				$('.prof_table').show();
		
				$('#p_page_comment').removeClass('p_page_comment_on');
				$('.p_cheer').css({'top': '105vh'});
				$('.p_page_img').animate({'top': '7.5vw'},150);
				$('.tbl_p_page_msg').animate({'top': '118.5vw'},150);
				$('.btm_flex').animate({'top': '115vw'},150);
		
				$('.p_cheer_box').val('');
				$('.main').show();
				if(MySel){
					$('#'+MySel).removeClass('ii_'+MySel);
					$('#e_'+MySel).removeClass('iine_my_c1');
				}
				$('.p_page_msg_a').removeClass('iine_my_a');
				$('.p_page_msg_c').removeClass('iine_my_c2');
				$('.set_cheer').removeClass('cheer_no');
				$('#p_page_alert').removeClass('alert_yet alert_mine alert_done');
		
				$(window).scrollTop(TopNow);
			}
		}
	});

	$('.p_page_msg_a').on('click',function () {
		if(Own == User_id){
			$('.pop02').stop(true,true).fadeIn(50).delay(1000).fadeOut(800);
			return FALSE;
		}

		Name=$(this).attr('id');

		if($(this).hasClass('ii_'+Name)){//■　ON→OFF
			TMP=$(this).children('.p_page_msg_c').text();
			TMP=parseFloat(TMP)+0 - parseFloat(Minus);
			$('#e_'+Name).val(TMP);

			$(this).removeClass('ii_'+Name);
			$(this).children('.p_page_msg_c').text(TMP).removeClass('iine_my_c1');

			$.post("post_set_iine.php",
				{
					'mode':'2',
					'user_id':User_id,
					'card_id':Img_id,
					'own':Own,
					'iine_nm':Name,
					'iine_pt':'0'
				},
			);

			MySel="";
			$('#mm'+Img_id).val('');
			$('#mi'+Img_id).val('0');
		}else{

			if(MySel){//■　OFF→ON
				$('#'+MySel).removeClass('ii_'+MySel);
				TMP1=$('#'+MySel).children('.p_page_msg_c').text();
				Minus=$('#mi'+Img_id).val();
				TMP2=parseFloat(TMP1) - parseFloat(Minus);

				$('#'+MySel).children('.p_page_msg_c').text(TMP2).removeClass('iine_my_c1');
				$('#f'+Img_id).children('input:hidden[name="'+ MySel +'"]').val(TMP2);
			}

			$(this).addClass('ii_'+Name);

			TMP=$(this).children('.p_page_msg_c').text();
			TMP=parseFloat(TMP) + iine_Pt;
			$(this).children('.p_page_msg_c').text(TMP).addClass('iine_my_c1');

			$('#f'+Img_id).children('input:hidden[name="'+ Name +'"]').val(TMP);
			$('#mi'+Img_id).val(iine_Pt);

			MySel=Name;
			$('#mm'+Img_id).val(Name);
			$.post("post_set_iine.php",
				{
					'mode':'2',
					'user_id':User_id,
					'card_id':Img_id,
					'own':Own,
					'iine_nm':Name,
					'iine_pt':iine_Pt
				},
				function(dat){
					if(dat){
						TMP	=parseInt(dat);
						LV	=Math.floor(TMP/100)+1;
						$('.mypage_level').text(LV);
						$('.mypage_exp').text(TMP);
					}
				}
			);
		}
	});

	$('#p_page_out').on('click',function () {
		$('.p_page').animate({'left': '105vw'},100);
		$('.prof_table').show();

		$('#p_page_comment').removeClass('p_page_comment_on');
		$('.p_cheer').css({'top': '105vh'});
		$('.p_page_img').animate({'top': '7.5vw'},150);
		$('.tbl_p_page_msg').animate({'top': '118.5vw'},150);
		$('.btm_flex').animate({'top': '115vw'},150);

		$('.p_cheer_box').val('');
		$('.main').show();
		if(MySel){
			$('#'+MySel).removeClass('ii_'+MySel);
			$('#e_'+MySel).removeClass('iine_my_c1');
		}
		$('.p_page_msg_a').removeClass('iine_my_a');
		$('.p_page_msg_c').removeClass('iine_my_c2');
		$('.set_cheer').removeClass('cheer_no');
		$('#p_page_alert').removeClass('alert_yet alert_mine alert_done');

		$(window).scrollTop(TopNow);
	});

	$('#p_cheer_del').on('click',function () {
		$('#p_cheer_box').val('');
	});

	$('.p_page').on('click','.alert_mine',function () {
		$('.pop05').stop(true,true).fadeIn(50).delay(1000).fadeOut(800);
		return false;
	});

	$('.p_page').on('click','.alert_done',function () {
		$('.pop04').stop(true,true).fadeIn(50).delay(1000).fadeOut(800);
		return false;
	});

	$('.p_page').on('click','.alert_yet',function () {
		$('.pop01,.pop01_a').fadeIn(200);
	});

	$('#no_1, p_cheer_not').on('click',function () {

		$('.pop01,.pop07').fadeOut(200);
		$('.pop01_c').val();
	});

	$('#yes_1').on('click',function (){
		$.post("post_set_alert.php",
			{
			'user_id':User_id,
			'card_id':Img_id,
			'log':$('.pop01_c').val()
			},

		function(){
			$('.pop01_a').hide()
			$('.pop01_e').fadeIn(100).delay(2000).fadeOut(500);
			$('.pop01').delay(1300).fadeOut(500);
			$('.pop01_c').val();
		});
	});

	$('#p_page_comment').on('click',function () {
		if($(this).hasClass('p_page_comment_on')){
			$(this).removeClass('p_page_comment_on');
			$('.p_page_img').animate({'top': '7.5vw'},150);
			$('.tbl_p_page_msg').animate({'top': '118.5vw'},150);
			$('.p_cheer').animate({'top': '105vh'},150);
			
		}else{
			$.post("post_read_cheer.php",
			{
				'user_id':User_id,
				'card_id':Img_id,
				'pg':'1'
			},
			function(data){
				$('.cheer_list').html(data);
			});

			$(this).addClass('p_page_comment_on');
			$('.p_page_img').animate({'top': '-100vh'},150);
			$('.tbl_p_page_msg').animate({'top': '7.5vw'},150);
			$('.p_cheer').animate({'top': '13.5vw'},150);
		}
	});

	$(document).on('click','.set_cheer',function () {
		if(Own == User_id){
			$('.pop06').stop(true,true).fadeIn(50).delay(1000).fadeOut(800);
			return false;
		}else{
			var Tmp_C= $('input:hidden[name="tmpcheer"]').val();
			$('#p_cheer_box').val(Tmp_C);
			$('.pop07').show();
		}
	});


	$('#p_cheer_sub').on('click',function () {
		var Com=$('.p_cheer_box').val();
		$.post("post_set_cheer.php",
			{
			'user_id':User_id,
			'card_id':Img_id,
			'host_id':Own,
			'status':'1',
			'com':Com
			},

		function(data1){
			console.log(data1);
			N1=parseInt(data1);
			Lv=Math.floor(N1/100)+1;
			$('.mypege_level').html(Lv);
			$('.mypege_exp').html(data1);
		
			$('.pop07').fadeOut(100);
			$.post("post_read_cheer.php",
				{
					'user_id':User_id,
					'card_id':Img_id,
					'pg':'1'
				},
				function(data){
					$('.cheer_list').html(data);
				}
			);
		});
	});
});

