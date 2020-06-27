$(function(){ 
	var VwBase	=$(window).width()/100;
	var VhBase	=$(window).height()/100;

	var Fav=0;
	$('.head_mymenu').on('click',function(){
		if($(this).hasClass('mypage_on')){
			$(this).removeClass('mypage_on');
			$('.mypage_slide').animate({'left':'-70vw'},150);
			$('.mymenu_b').fadeIn(150);

			$('.mymenu_a,.mymenu_c').animate({'left':'1vw','width':'8vw'},150);
			$('.head_mymenu').animate({'border-radius':'1vw'},150);

			$({deg:-23}).animate({deg:0}, {
				duration:150,
				progress:function() {
					$('.mymenu_a').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:23}).animate({deg:0}, {
				duration:150,
				progress:function() {
					$('.mymenu_c').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

		}else{
			$(this).addClass('mypage_on');
			$('.mypage_slide').animate({'left':'0'},150);
			$('.mymenu_b').fadeOut(150);
			$('.mymenu_a,.mymenu_c').animate({'left':'0.5vw','width':'7vw'},150);
			$('.head_mymenu').animate({'border-radius':'5vw'},150);

			$({deg:0}).animate({deg:-45}, {
				duration:150,
				progress:function() {
					$('.mymenu_a').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:0}).animate({deg:45}, {
				duration:150,
				progress:function() {
					$('.mymenu_c').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});
		}
	});

	$('.tag_set').on('click',function () {
		if($(this).hasClass('tag_set_ck')!='true'){

			Tmp_tr=$(this).attr('id')+"_tbl";
			$('.tag_set_ck').removeClass('tag_set_ck').animate({'top':'3vw','height':'5.5vw'},200);
			$(this).addClass('tag_set_ck').animate({'top':'0.5vw','height':'8vw'},200);

			$('.customer_memo').fadeOut(300);
			$('#'+Tmp_tr).fadeIn(300);

			Tmp=$(this).attr('id').replace("tag_","");
			$('#h_customer_page').val(Tmp);
		}
	});

	$('.customer_fav').on('click',function () {
		if(Fav == 0){
			Fav=$(this).attr('id').replace('fav_','');
			$('.customer_base_fav').children().slice(0,Fav).css('color','#ff3030');

		}else{
			Fav=0;
			$('.customer_fav').css('color','#cccccc');
		}
		$('#h_customer_fav').val(Fav);
		$('#clist'+C_Id).children('.customer_hidden_fav').val(Fav);

		if(Fav>0){
			$('#fav_'+C_Id+'_1').addClass('fav_in');
		}else{
			$('#fav_'+C_Id+'_1').removeClass('fav_in');
		}

		if(Fav>1){
			$('#fav_'+C_Id+'_2').addClass('fav_in');
		}else{
			$('#fav_'+C_Id+'_2').removeClass('fav_in');
		}

		if(Fav>2){
			$('#fav_'+C_Id+'_3').addClass('fav_in');
		}else{
			$('#fav_'+C_Id+'_3').removeClass('fav_in');
		}

		if(Fav>3){
			$('#fav_'+C_Id+'_4').addClass('fav_in');
		}else{
			$('#fav_'+C_Id+'_4').removeClass('fav_in');
		}

		if(Fav>4){
			$('#fav_'+C_Id+'_5').addClass('fav_in');
		}else{
			$('#fav_'+C_Id+'_5').removeClass('fav_in');
		}
	});


	$('.mail_al').on('click',function () {
		$('.mypage_mail_detail').animate({'right':'0'},150);
		Tmp=$(this).attr('id').replace('mail','');
		Dir=$('#dir').val();

		$('.mail_detail_name').html($('#mail_name' + Tmp).text());
		$('.mail_detail_title').html($('#mail_title' + Tmp).text());
		$('.mail_detail_log').html($('#mail_log' + Tmp).val());
		$('.mail_detail_address').html($('#mail_address' + Tmp).val());
		$('.mail_detail_date').html($('#mail_date' + Tmp).text());
		$('.mail_detail_icon').html($('#mail_icon' + Tmp).html());
		$('.mail_detail_img').attr('src',$('#mail_img' + Tmp).attr('src'));

		if($('#img_a' + Tmp).val() != ''){
			$('#sum_img_a').css('background-image','url('+$('#img_a' + Tmp).val() +')');
			$('.detail_modal_link').html('<span id="point_img_a" class="modal_link_point"></span>');
		}

		if($('#img_b' + Tmp).val() != ''){
			$('#sum_img_b').css('background-image','url('+$('#img_b' + Tmp).val() +')');
			$('.detail_modal_link').append('<span id="point_img_b" class="modal_link_point"></span>');
		}

		if($('#img_c' + Tmp).val() != ''){
			$('#sum_img_c').css('background-image','url('+$('#img_c' + Tmp).val() +')');
			$('.detail_modal_link').append('<span id="point_img_c" class="modal_link_point"></span>');
		}
	});

	$('.detail_modal_link').on('click','.modal_link_point',function () {
		Img=$(this).attr('id').replace('point_','');
		$('.link_point_on').removeClass('link_point_on');
		$(this).addClass('link_point_on');
		$('.detail_modal_img').attr('src',$('#' +Img + Tmp).val()).hide().fadeIn(100);
	});

	$('.mail_detail_tmp').on('click',function () {
		Img=$(this).attr('id').replace('sum_','');
		$('.detail_modal').animate({'top':'0'},100);
		$('.detail_modal_img').attr('src',$('#' +Img + Tmp).val());
		$('#point_'+Img).addClass('link_point_on');
	});

	$('.detail_modal_out').on('click',function () {
		$('.detail_modal').animate({'top':'110vh'},100);
		$('.link_point_on').removeClass('link_point_on');
	});

	$('.mail_detail_back').on('click',function () {
		$('.mypage_mail_detail').animate({'right':'-100vw'},100);
		$('.detail_modal_link').html();
	});

	$('.menu_1').on('click',function () {
		Tmp=$(this).attr('id').replace('m','');
		if(Tmp == 99){
			$('#logout').submit();

		}else{
			$('#cast_page').val(Tmp);
			$('#menu_sel').submit();
		}
	});

	$('#regist_customer').on('click',function () {
		$('.customer_regist_back').show();
	});

	$('.mypage_blog_set').on('click',function () {
		if($('.mypage_blog_write').css('display') == 'none'){
			$('.mypage_blog_write').slideDown(100);
		}else{
			$('.mypage_blog_write').slideUp(50);
		}
	});

	$('#mypage_blog_date').datepicker({
		dateFormat: 'yy/mm/dd',
		monthNames: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
		firstDay: 1,
	});

	$('#upd').on('change', function(e){
		var file = e.target.files[0];
		var reader = new FileReader();

		if(file.type.indexOf("image") < 0){
			alert("NO IMAGE FILES");
			return false;
		}

		Rote	=0;
		Zoom	=100;

		var img = new Image();
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');

		reader.onload = (function(file){
			return function(e){

				img.src = e.target.result;
				$("#view").attr("src", e.target.result);
				$("#view").attr("title", file.name);

				img.onload = function() {
					img_W=img.width;
					img_H=img.height;

					img_S2=60*VwBase;

					if(img_H > img_W){
						cvs_W=600;
						cvs_H=img_H*(cvs_W/img_W);
						cvs_A=Math.ceil(cvs_H);

						cvs_X=(cvs_H-cvs_W)/2;
						cvs_Y=0;

						css_W=60*VwBase;
						css_H=img_H*(css_W/img_W);

						css_A=css_H;
						css_B=10*VwBase-(css_A-60*VwBase)/2;


					}else{
						cvs_H=600;
						cvs_W=img_W*(cvs_H/img_H);
						cvs_A=Math.ceil(cvs_W);

						cvs_Y=(cvs_W-cvs_H)/2;
						cvs_X=0;

						css_H=60*VwBase;
						css_W=img_W*(css_H/img_H);

						css_A=css_W;
						css_B=10*VwBase-(css_A-60*VwBase)/2;

					}				

					$("#cvs1").attr({'width': cvs_A,'height': cvs_A}).css({'width': css_A,'height': css_A,'left': css_B,'top': css_B});

					ctx.drawImage(img, 0,0, img_W, img_H,cvs_X, cvs_Y, cvs_W, cvs_H);
					ImgCode = cvs.toDataURL("image/jpeg");

					$('#img_top').val(css_B);
					$('#img_left').val(css_B);

				}
			};
		})(file);
		reader.readAsDataURL(file);

		$('#upd').fileExif(function(exif) {

			if (exif['Orientation']) {

				switch (exif['Orientation']) {
				case 3:
					Rote = 180;
					$('#cvs1').css({
						'transform':'rotate(180deg)',
					});
					break;

				case 8:
					Rote = 270;
					$('#cvs1').css({
						'transform':'rotate(270deg)',

					});
					break;

				case 6:
					Rote = 90;
					$('#cvs1').css({
						'transform':'rotate(90deg)',
					});
					break;
				}
			}
		});
	});

	$("#cvs1").draggable();
	$("#cvs1").on("mousemove", function() {

		Left = $("#cvs1").css("left");
		Top = $("#cvs1").css("top");

		$('#img_top').val(Top);
		$('#img_left').val(Left);
	});

	$('.mypage_head').on('click','.arrow_customer',function(){
		$('.head_mymenu_comm').removeClass('arrow_customer');
		$('.customer_detail').animate({'left':'100vw'},300);
		$('.head_mymenu_ttl').html('顧客リスト');

		$('.customer_sns_box').hide();
		$('.customer_sns_tr').hide();
		$('.sns_arrow_a').hide();
		$('.sns_text').val('');

		$('.customer_sns_box,.sns_arrow_a,.customer_sns_btn').removeClass('c_customer_twitter c_customer_facebook c_customer_insta c_customer_web c_customer_blog c_customer_tel c_customer_mail');
		$('.sns_jump').removeClass('jump_on');
	});


	$('.customer_list').on('click',function(){
		$('.head_mymenu_ttl').html('顧客リスト(詳細)');
		$('.head_mymenu_comm').addClass('arrow_customer');

		var TmpHgt=VhBase*100-VwBase*81;
		$('.customer_body').css('height',TmpHgt);

		C_Id=$(this).attr('id').replace('clist','');

		Tmp=$(this).children('.mail_img').attr('src');
		$('.customer_detail_img').attr('src',Tmp);

		Tmp=$(this).children('.customer_list_name').html().replace(' 様','');
		$('#customer_detail_name').val(Tmp);

		Tmp=$(this).children('.customer_list_nickname').html();
		$('#customer_detail_nick').val(Tmp);

		Tmp=$(this).children('.customer_hidden_fav').val();
			if(Tmp>0){
				$('#fav_1').css('color','#ff3030');
			}
			if(Tmp>1){
				$('#fav_2').css('color','#ff3030');
			}

			if(Tmp>2){
				$('#fav_3').css('color','#ff3030');
			}

			if(Tmp>3){
				$('#fav_4').css('color','#ff3030');
			}

			if(Tmp>4){
				$('#fav_5').css('color','#ff3030');
			}
		Fav=Tmp;

		$('#area').val(1);

		$('#h_customer_id').val(C_Id);
		$('#h_customer_set').val("1");
		$('#h_customer_page').val("1");

		Tmp=$(this).children('.customer_hidden_group').val();
		$('#customer_group').val(Tmp);

		Tmp=$(this).children('.customer_hidden_yy').val();
		$('#customer_detail_yy').val(Tmp);

		Tmp=$(this).children('.customer_hidden_mm').val();
		$('#customer_detail_mm').val(Tmp);

		Tmp=$(this).children('.customer_hidden_dd').val();
		$('#customer_detail_dd').val(Tmp);

		Tmp=$(this).children('.customer_hidden_ag').val();
		$('#customer_detail_ag').text(Tmp);

		Tmp=$(this).children('.customer_hidden_face').val();
		$('#img_url').val(Tmp);

		Tmp=$(this).children('.customer_hidden_fav').val();
		$('#h_customer_fav').val(Tmp);



		Tmp=$(this).children('.customer_hidden_tel').val();
		$('#h_customer_tel').val(Tmp);
		if(Tmp){
			$('#customer_tel').addCla
			ss('c_customer_tel');		
		}

		Tmp=$(this).children('.customer_hidden_mail').val();
		$('#h_customer_mail').val(Tmp);
		if(Tmp){
			$('#customer_mail').addClass('c_customer_mail');		
		}

		Tmp=$(this).children('.customer_hidden_twitter').val();
		$('#h_customer_twitter').val(Tmp);
		if(Tmp){
			$('#customer_twitter').addClass('c_customer_twitter');		
		}

		Tmp=$(this).children('.customer_hidden_facebook').val();
		$('#h_customer_facebook').val(Tmp);
		if(Tmp){
			$('#customer_facebook').addClass('c_customer_facebook');		
		}

		Tmp=$(this).children('.customer_hidden_insta').val();
		$('#h_customer_insta').val(Tmp);
		if(Tmp){
			$('#customer_insta').addClass('c_customer_insta');		
		}

		Tmp=$(this).children('.customer_hidden_blog').val();
		$('#h_customer_blog').val(Tmp);
		if(Tmp){
			$('#customer_blog').addClass('c_customer_blog');		
		}

		Tmp=$(this).children('.customer_hidden_web').val();
		$('#h_customer_web').val(Tmp);
		if(Tmp){
			$('#customer_web').addClass('c_customer_web');		
		}

		$('.customer_detail').animate({'left':'0'},300);

		$.post({
			url:Dir + "/post/customer_detail_read.php",
			data:{
				'c_id':C_Id,
			},
/*			dataType: 'json',*/
		}).done(function(data, textStatus, jqXHR){
			$('#tag_1_tbl').html(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});


		$.post({
			url:Dir + "/post/customer_memo_read.php",
			data:{
				'c_id':C_Id,
			},
/*			dataType: 'json',*/
		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('#tag_2_tbl').html(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});




	});

	$('.sns_btn').on('click',function(){
		$.post({
			url:Dir + "/post/customer_sns_set.php",
			data:{
				'c_id':C_Id,
				'text':$('.sns_text').val(),
				'kind':Tmp.replace('customer_',''),
			},

		}).done(function(data, textStatus, jqXHR){

			if($('.sns_text').val()){
				$('#customer_'+data).addClass('c_customer_'+data);		
				$('.customer_sns_box').addClass('c_customer_'+data);		
				$('#a_customer_'+data).addClass('c_customer_'+data);
				$('#customer_'+data).addClass('c_customer_'+data);
				$('.sns_jump').addClass('jump_on');

			}else{
				$('#customer_'+data).removeClass('c_customer_'+data);		
				$('.customer_sns_box').removeClass('c_customer_'+data);		
				$('#a_customer_'+data).removeClass('c_customer_'+data);
				$('#customer_'+data).removeClass('c_customer_'+data);
				$('.sns_jump').removeClass('jump_on');
			}
			$('#h_customer_'+data).val($('.sns_text').val());
			$('#clist'+C_Id).children('.customer_hidden_'+data).val($('.sns_text').val());

		});
	});

	$('.customer_sns_btn').on('click',function(){
		if($('.customer_sns_box').css('display') !== 'none'){
			$('.customer_sns_box').slideUp(100);
			$('.customer_sns_tr').slideUp(100);
			$('.sns_arrow_a').hide();
			$('.sns_text').val('');
			$('.customer_sns_box').removeClass('c_'+Tmp);
			$('.sns_jump').removeClass('jump_on');
		}

		if(Tmp != $(this).attr('id')){
			Tmp=$(this).attr('id');
			$('#a_'+Tmp).show();
			TmpH=$('#h_'+Tmp).val();
			
			if(TmpH){
				$('.sns_text').val($('#h_'+Tmp).val());
				$('#a_'+Tmp).addClass('c_'+Tmp);
				$('.customer_sns_box').addClass('c_'+Tmp);
				$('.sns_jump').addClass('jump_on');
			}

			$('.customer_sns_box').slideDown(200);
			$('.customer_sns_tr').slideDown(200);

		}else{
			Tmp='';
		}
	});

	$('.customer_base_img').on('click',function(){
		$('.img_box').animate({'top':'20vw'},200);
		$('.img_back').fadeIn(100);
	});

	$('.schedule_regist').on('click',function(){
		$('.cal_weeks').animate({'top':'18vw'},200);
		$('.cal_back').fadeIn(100);
	});

	$('#yes_5').on('click',function(){
		if($('#upd').val() == '') {
			$('#err').text('画像の登録がありません');
			$('#err').fadeIn(100).delay(500).fadeOut(500);
			return false;

		}else{
			$('#wait').show();
			var ImgTop		=$('#img_top').val();
			var ImgLeft		=$('#img_left').val();
			var ImgWidth	=$('#img_width').val();
			var ImgHeight	=$('#img_Height').val();
			var ImgZoom		=$('#img_zoom').val();
			var ImgUrl		=$('#img_url').val();

			$.post({
				url:Dir + "/post/img_set.php",
				data:{
					'cast_id'	:CastId,
					'img_code'	:ImgCode.replace(/^data:image\/jpeg;base64,/, ""),
					'img_url'	:ImgUrl,
					'img_top'	:ImgTop,
					'img_left'	:ImgLeft,
					'img_width'	:cvs_W,
					'img_height':cvs_H,
					'vw_base'	:VwBase,
					'img_zoom'	:ImgZoom,
					'img_rote'	:Rote,
					'c_id'		:C_Id
				},
	/*			dataType: 'json',*/

			}).done(function(data, textStatus, jqXHR){
				console.log(data);
				$('.img_back').fadeOut(200);

				var cvs = document.getElementById('cvs1');
				var ctx = cvs.getContext('2d');
				ctx.clearRect(0, 0, cvs_A,cvs_A);
				$('.customer_detail_img, #sumb' + C_Id).attr('src',data + '?t=<?=time()?>');
				$('#clist'+C_Id).children('.mail_img').attr('src',data + '?t=<?=time()?>');



				$('#wait').hide();

				$('.zoom_box').text('100');
				$('#img_zoom').val('100');
				$('#input_zoom').val('100');
				Rote=0;

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});

	$('.mail_detail_img_box').on('mail_detail_tmp','click',function(){
		
	});

	$('.upload_rote').on('click',function(){
		$({deg:Rote}).animate({deg:-90 + Rote}, {
			duration:500,
			progress:function() {
				$('#cvs1').css({
					'transform':'rotate(' + this.deg + 'deg)',
				});
			},
		});
		Rote -=90;
		if(Rote <0){
			Rote+=360;
		}
	});

	$('.c1').on('click',function(){
		$('.back').fadeOut(150);
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, cvs_A,cvs_A);
	});

	$('.zoom_mi').on( 'click', function () {
		Zoom--;
		if(Zoom <100){
			Zoom=100;
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);
	});

	$( '.zoom_pu' ).on( 'click', function () {
		Zoom++;
		if(Zoom >300){
			Zoom=300;
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);
	});

	$( '#input_zoom' ).on( 'input', function () {
		Zoom=$(this).val();
		if(Zoom > 300){
			Zoom=300;
		}
		if(Zoom < 100){
			Zoom=100;	
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
	});

	$('.upload_reset').on( 'click', function () {
		Zoom=100;
		Left=css_B;
		Right=css_B;
		Rote=0;
		$("#cvs1").css({'width': css_A,'height': css_A,'left': css_B,'top': css_B, 'transform':'rotate(0deg)'});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);
	});

	$('.img_open').on( 'click', function () {
		$('.back').fadeIn(500);
	});

	$('.sch_set').on('click',function () {
		$.post({
			url:Dir + "/post/sch_set.php",
			data:{
				'cast_id':$('#cast_id').val(),
				'base_day':$('#base_day').val(),

				'sel_in[0]':$('.cal_weeks_box_2').children().eq(7).children('.sch_time_in').val(),
				'sel_in[1]':$('.cal_weeks_box_2').children().eq(8).children('.sch_time_in').val(),
				'sel_in[2]':$('.cal_weeks_box_2').children().eq(9).children('.sch_time_in').val(),
				'sel_in[3]':$('.cal_weeks_box_2').children().eq(10).children('.sch_time_in').val(),
				'sel_in[4]':$('.cal_weeks_box_2').children().eq(11).children('.sch_time_in').val(),
				'sel_in[5]':$('.cal_weeks_box_2').children().eq(12).children('.sch_time_in').val(),
				'sel_in[6]':$('.cal_weeks_box_2').children().eq(13).children('.sch_time_in').val(),

				'sel_out[0]':$('.cal_weeks_box_2').children().eq(7).children('.sch_time_out').val(),
				'sel_out[1]':$('.cal_weeks_box_2').children().eq(8).children('.sch_time_out').val(),
				'sel_out[2]':$('.cal_weeks_box_2').children().eq(9).children('.sch_time_out').val(),
				'sel_out[3]':$('.cal_weeks_box_2').children().eq(10).children('.sch_time_out').val(),
				'sel_out[4]':$('.cal_weeks_box_2').children().eq(11).children('.sch_time_out').val(),
				'sel_out[5]':$('.cal_weeks_box_2').children().eq(12).children('.sch_time_out').val(),
				'sel_out[6]':$('.cal_weeks_box_2').children().eq(13).children('.sch_time_out').val(),
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('.sch_set_done').fadeIn(500).delay(1500).fadeOut(1000);
			$('.cal_weeks').animate({'top':'100vh'},200);
			$('.cal_back').fadeOut(100);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#sch_set_arrow').on('click',function () {
		$('.cal_weeks').animate({'top':'100vh'},200);
		$('.cal_back').fadeOut(100);
	});

	$('#sch_set_trush').on('click',function () {
//		$('.sch_time_in,.sch_time_out').val("");
		$('.cal_weeks_box_2').children().slice(7,14).children('.sch_time_in,.sch_time_out').val("");
	});

	$('#tag_2_tbl').on('click','.customer_memo_del',function () {
		Tmp=$(this).attr('id').replace("m_chg","m_txt");
		$('#'+Tmp).val("");
	console.log("■");
	});

	$('#tag_2_tbl').on('click','.customer_memo_chg',function () {
		Tmp=$(this).attr('id').replace("m_txt","");
		$('#'+Tmp).val("");
	});

	$('#tag_2_tbl').on('click','.customer_memo_set',function () {
		Log=$('.customer_memo_txt_new').val();
		$.post({
			url:Dir + "/post/customer_memo_set.php",
			data:{
				'cast_id'	:CastId,
				'c_id'		:C_Id,
				'log'		:Log,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('#memo_top').after(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});


	$('.mypage_cal').on('click','.cal_prev',function () {
/*		$('.mypage_cal').animate({'left':'0'},200);*/
		$.post({
			url:Dir + "/post/calendar_set.php",
			data:{
				'c_month'	:$('#c_month').val(),
				'week_start':$('#week_start').val(),
				'cast_id'	:CastId,
				'pre'		:'1',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.mypage_cal').prepend(data.html).animate({'left':'-100vw'},200);
			$(".mypage_cal").children().last().remove();
			$('#c_month').val(data.date);
		});
	});

	$('.mypage_cal').on('click','.cal_next',function () {
//		$('.mypage_cal').animate({'left':'-200vw'},200);
		$.post({
			url:Dir + "/post/calendar_set.php",
			data:{
				'c_month':$('#c_month').val(),
				'week_start':$('#week_start').val(),
				'cast_id':CastId,	
				'pre':'2',
			},
			dataType: 'json',
		}).done(function(data, textStatus, jqXHR){
			$('.mypage_cal').append(data.html).animate({'left':'-100vw'},200);
			$(".mypage_cal").children().first().remove();
			$('#c_month').val(data.date);
		});
	});

	$('.cal_weeks_prev').on('click',function (){
		$('.cal_weeks_box_2').stop(false,true).animate({'top':'0'},200);
		$.post({
			url:Dir + "/post/chg_weeks.php",
			data:{
				'c_month':$('#c_month').val(),
				'base_day':$('#base_day').val(),
				'cast_id':CastId,
				'pre':'1',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.cal_weeks_box_2').prepend(data.html).css('top','-73.5vw');
			$('.cal_weeks_box_2').children().slice(-7,0).remove();
			$('#base_day').val(data.date);
		});
	});

	$('.cal_weeks_next').on('click',function (){
		$('.cal_weeks_box_2').animate({'top':'-147vw'},200);

		$.post({
			url:Dir + "/post/chg_weeks.php",
			data:{
				'c_month':$('#c_month').val(),
				'base_day':$('#base_day').val(),
				'cast_id':CastId,
				'pre':'2',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.cal_weeks_box_2').prepend(data.html).css('top','-73.5vw');
			$('.cal_weeks_box_2').children().slice(0,7).remove();
			$('#base_day').val(data.date);
		});
	});

	$('.cal_weeks_box_2').draggable({
		axis: 'y',
		start: function( event, ui ) {
			startPosition = ui.position.top;
		},
		drag: function( event, ui ) {
		},
		stop: function( event, ui ) {//前週
			if(ui.position.top > VwBase*(-65)){
				$('.cal_weeks_box_2').animate({'top':'0'},100);

				$.post({
					url:Dir + "/post/chg_weeks.php",
					data:{
						'c_month':$('#c_month').val(),
						'base_day':$('#base_day').val(),
						'cast_id':CastId,
						'pre':'1',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){
					$('.cal_weeks_box_2').prepend(data.html).css('top','-73.5vw');
					$('.cal_weeks_box_2').children().slice(-7,0).remove();
					$('#base_day').val(data.date);
				});

			}else if(ui.position.top < VwBase*(-95)){//翌週
				$('.cal_weeks_box_2').animate({'top':'-147vw'},100);

				$.post({
					url:Dir + "/post/chg_weeks.php",
					data:{
						'c_month':$('#c_month').val(),
						'base_day':$('#base_day').val(),
						'cast_id':CastId,
						'pre':'2',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){
					$('.cal_weeks_box_2').append(data.html).css('top','-73.5vw');
					$('.cal_weeks_box_2').children().slice(0,7).remove();
					$('#base_day').val(data.date);
				});

			}else{
				$('.cal_weeks_box_2').animate({'top':'-73.5vw'},100);
			}
		},
	});

	$('.mypage_cal').draggable({
		axis: 'x',
		drag: function( event, ui ) {
		},

		stop: function( event, ui ) {
			if(ui.position.left > VwBase*(-80)){
				$('.mypage_cal').animate({'left':'0'},100);

				$.post({
					url:Dir + "/post/calendar_set.php",
					data:{
						'c_month':$('#c_month').val(),
						'week_start':$('#week_start').val(),
						'cast_id':CastId,
						'pre':'1',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){
					$('.mypage_cal').prepend(data.html).css('left','-100vw');
					$(".mypage_cal").children().last().remove();
					$('#c_month').val(data.date);
					console.log(data.sql);
					console.log(data.html);
				});

			}else if(ui.position.left < VwBase*(-120)){
				$('.mypage_cal').animate({'left':'-200vw'},100);

				$.post({
					url:Dir + "/post/calendar_set.php",
					data:{
						'c_month':$('#c_month').val(),
						'week_start':$('#week_start').val(),
						'cast_id':CastId,
						'pre':'2',
					},
					dataType: 'json',
				}).done(function(data, textStatus, jqXHR){
					$('.mypage_cal').append(data.html).css('left','-100vw');
					$(".mypage_cal").children().first().remove();
					$('#c_month').val(data.date);
					console.log(data.sql);
					console.log(data.html);
				});
			}else{
				$('.mypage_cal').animate({'left':'-100vw'},100);
			}
		},
	});

	$('.mypage_cal').on('click','.cal_td',function (){
		$('.cal_td').removeClass('cc8');
		$(this).addClass('cc8');

		ToMon=$(this).attr('id').substr(5,2);
		ToDay=$(this).attr('id').substr(7,2);
		ToWeek=$(this).attr('week');
		$('.cal_days_date').text(ToMon+"月"+ToDay+"日["+ToWeek+"]");
	});

	$('.mypage_slide').draggable({
		axis: 'x',
		start: function( event, ui ) {
			startPosition = ui.position.left;
		},
		drag: function( event, ui ) {
			if(ui.position.left > startPosition) ui.position.left = startPosition;
		},

		stop: function( event, ui ) {
			if(ui.position.left < -50){
				$('.mypage_slide').animate({'left':'-70vw'},200);

				$('.head_mymenu').removeClass('mypage_on');
				$('.mymenu_b').fadeIn(150);

				$('.mymenu_a,.mymenu_c').animate({'left':'1vw','width':'8vw'},100);
				$('.head_mymenu').animate({'border-radius':'1vw'},100);

				$({deg:-23}).animate({deg:0}, {
					duration:100,
					progress:function() {
						$('.mymenu_a').css({
							transform:'rotate(' + this.deg + 'deg)'
						});
					},
				});

				$({deg:23}).animate({deg:0}, {
					duration:100,
					progress:function() {
						$('.mymenu_c').css({
							transform:'rotate(' + this.deg + 'deg)'
						});
					},
				});
			}else{
				$('.mypage_slide').animate({'left': '0vw'},100);
			}
		}
	});
});

