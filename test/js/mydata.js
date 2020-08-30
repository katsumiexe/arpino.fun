$(function(){ 
	$('.album_box, .fav_b_box, .fav_c_box').hide();

	$('#id_notice').on('click',function () {
		$('.album_tag').removeClass('album_tag_sel');
		$(this).addClass('album_tag_sel');
		$('.notice_box').fadeIn(100);
		$('.album_box,.fav_b_box,.fav_c_box').hide();

		$.post("post_read_notice.php",
			{
				'user_id':User_id,
				'next_notice':Next_notice,
			},
			function(data){
				$('#notice_in').html(data);				
			}
		);
	});

	$('#notice_in').on('click','.next_n',function () {
		Next_notice	= $(this).attr('id').replace("next_n", "");
		$.post("post_read_notice.php",
			{
				'user_id':User_id,
				'next_notice':Next_notice,
			},
			function(data){
				$('#next_n' + Next_notice).after(data).hide();				
			}
		);
	});

	$('#id_album').on('click',function () {
		$('.album_tag').removeClass('album_tag_sel');
		$(this).addClass('album_tag_sel');
		$('.album_box').fadeIn(100);
		$('.notice_box,.fav_b_box,.fav_c_box').hide();
		$.post("post_read_album.php",
			{
				'user_id':User_id,
				'next_album':0,
			},
			function(data){
				$('#album_in').html(data);				
			}
		);
	});

	$('#album_in').on('click','.next_a',function () {
		Next_album	= $(this).attr('id').replace("next_a", "");
		$.post("post_read_album.php",
			{
				'user_id':User_id,
				'next_album':Next_album,
			},
			function(data){
				$('#next_a' + Next_album).after(data).hide();				

				TopNow=$(window).scrollTop();
				TopNow2=TopNow+360+"vw";
				$('body,html').animate({scrollTop:TopNow2},300);
			}
		);
	});

	$('.p_page').on('click','.print_back',function () {
		$('.print_page').fadeOut(100).animate({'left':'105vw'},200);				
	});

	$('#fav_b').on('click',function () {
		$('.album_tag').removeClass('album_tag_sel');
		$(this).addClass('album_tag_sel');
		$('.fav_b_box').fadeIn(100);
		$('.album_box,.notice_box,.fav_c_box').hide();

		$.post("post_read_fav.php",
			{
				'tag':'b',
				'user_id':User_id,
				'next_fav_b':Next_fav_b,
			},
			function(data){
				$('#fav_in_b').html(data);				
			}
		);
	});

	$('#fav_in_b').on('click','.next_b',function () {
		Next_fav_b	= $(this).attr('id').replace("next_b", "");
		$.post("post_read_fav.php",
			{
				'tag':'b',
				'user_id':User_id,
				'next_fav_b':Next_fav_b,
			},
			function(data){
				$('#fav_in_b').html(data);				
				$('#next_b' + Next_fav_b).after(data).hide();				
			}
		);
	});

	$('#fav_c').on('click',function () {
		$('.album_tag').removeClass('album_tag_sel');
		$(this).addClass('album_tag_sel');
		$('.fav_c_box').fadeIn(100);
		$('.album_box,.notice_box,.fav_b_box').hide();

		$.post("post_read_fav.php",
			{
				'tag':'c',
				'user_id':User_id,
				'next_fav_c':Next_fav_c,
			},
			function(data){
				$('#fav_in_c').html(data);				
			}
		);
	});

	$('#fav_in_c').on('click','.next_c',function () {
		Next_fav_c	= $(this).attr('id').replace("next_c", "");
		$.post("post_read_fav.php",
			{
				'tag':'c',
				'user_id':User_id,
				'next_fav_c':Next_fav_c,
			},
			function(data){
				$('#fav_in_c').html(data);				
				$('#next_c' + Next_fav_c).after(data).hide();				
			}
		);
	});
	
	$('#notice_in').on('click','.prof_jump',function () {
		TmpP=$(this).attr('id').replace('p','');
		$('#p_jump_id').val(TmpP);
		$('#p_jump').submit();
	});

	$('#notice_in').on('click','.prof_jump2',function () {
		Img_id	=$(this).attr('id').replace('c','');
		$.post({
			url:'post_check_notice.php',
			data:{'user_id':User_id,'img_id':Img_id},
			dataType: 'json',

		}).done(function(data){
			console.log(data);
			Pritty=parseInt(data.s_pritty)+0;
			Smart=parseInt(data.s_smart)+0;
			Funny=parseInt(data.s_funny)+0;
			Sexy=parseInt(data.s_sexy)+0;
			All=parseInt(data.s_all)+0;
			Pict	=data.url;
			Mdate	= data.mdate;

			$('#e_all').text(All);
			$('#e_pritty').text(Pritty);
			$('#e_smart').text(Smart);
			$('#e_funny').text(Funny);
			$('#e_sexy').text(Sexy);
			$('#tmpl').attr({'src':Pict});
			$('.p_date').text(Mdate);
			$('.p_page').animate({'left': '0.5vw'},50);

			$.post({
				url:'post_read_cheer.php',
				data:{'user_id':User_id,'card_id':Img_id},
				dataType: 'json',

			}).done(function(data2){				
				$('.cheer_list').html(data2);
			});
		});

		TopNow=$(window).scrollTop();
		var Pict	= $(this).children('input:hidden[name="pict"]').val();
		var Mdate	= $(this).children('input:hidden[name="mdate"]').val();

		$('#pict_face').attr({'src':Pict});
		Img_Url	=$(this).children('.index_img').attr('src');

		$('#tmpl').attr({'src':Img_Url});
		$('.p_date').text(Mdate);
		$('#p_pict').attr('src',Pict);
		$('.p_page').animate({'left': '0.5vw'},150);
	});

	$('#p_page_out,#p_pict').on('click',function () {
		$('.p_page').animate({'left': '105vw','height': '110vh'},100);
		$('#a_page_comment').removeClass('p_page_on');
		$('.p_cheer_box').val('');
		$(window).scrollTop(TopNow);
	});

	$('#a_page_comment').on('click',function () {
		if($(this).hasClass('p_page_comment_on')){
			$(this).removeClass('p_page_comment_on');
			$('.p_page_img').animate({'top': '7.5vw'},150);
			$('.p_cheer').animate({'top': '100vh'},150);
			$('.btm_flex').animate({'top': '115vw'},150);
			$('.tbl_p_page_msg').animate({'top': '118.5vw'},150);
						
		}else{
			$(this).addClass('p_page_comment_on');
			$('.p_page_img').animate({'top': '-100vh'},150);
			$('.p_cheer').animate({'top': '12vw'},150);
			$('.btm_flex').animate({'top': '1.5vw'},150);
			$('.tbl_p_page_msg').animate({'top': '7.5vw'},150);

			$.post("post_read_cheer.php",
			{
				'user_id':User_id,
				'card_id':Img_id,
				'pg':'1'
			},
			function(data){
				$('.cheer_list').html(data);
			});
		}
	});

	$('#fav_in_b,#fav_in_c').on('click', '.fav_member', function(){
	Tmp_Fav=$(this).attr('id').replace("mb_", "");
		$('#f_jump_id').val(Tmp_Fav);
		$('#f_jump').submit();
	});

	$('#p_page_del').on('click',function(){
		$('.pop07, .pop07_a').fadeIn(300);
		$('.pop01_d1, .pop01_d2').show();
		$('.pop01_d3, .pop01_d4').hide();
	});

	$('#del_no').on('click',function(){
		$('.pop07, .pop07_a,.main').fadeOut(500);
	});

	$('#del_back').on('click',function(){
		$('.pop07, .pop07_a').fadeOut(500);

		$('.p_page').animate({'left': '105vw','height': '110vh'},100);

		$.post("post_read_album.php",
			{
				'user_id':User_id,
				'next_album':0,
			},
			function(data){
				$('#album_in').html(data);				

				$('#a_page_comment').removeClass('p_page_on');
				$('.p_cheer_box').val('');
				$('.main').show();
				$(window).scrollTop(TopNow);
			}
		);

	});

	$('#del_yes').on('click',function(){
		$('.pop01_d1, .pop01_d2').hide();
		$('.pop01_d3, .pop01_d4').show();
		
		$.post("post_image_del.php",
			{
				'img_url':Img_Url,
				'img_id':Img_id,
			},
			function(){

			}
		);
	});
});
