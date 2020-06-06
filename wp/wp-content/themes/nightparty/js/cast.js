$(function(){ 
	var VwBase	=$(window).width()/100;

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
/*
		$.post(Dir + "/post/mail_read_check.php",{'res_mail_id':Tmp},
			function(data){
		});
*/
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
						cvs_W=800;
						cvs_H=img_H*(cvs_W/img_W);
						cvs_A=Math.ceil(cvs_H);

						cvs_X=(cvs_H-cvs_W)/2;
						cvs_Y=0;

						css_W=60*VwBase;
						css_H=img_H*(css_W/img_W);

						css_A=css_H;
						css_B=10*VwBase-(css_A-60*VwBase)/2;

					}else{
						cvs_H=800;
						cvs_W=img_W*(cvs_H/img_H);
						cvs_A=Math.ceil(cvs_W);

						cvs_Y=(cvs_W-cvs_H)/2;
						cvs_X=0;

						css_H=80*VwBase;
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

	$('.sch_set_in,.sch_set_out').on('click',function(){

		Tmp=$(this).attr('id').replace('set','sel');

		$('.sch_set_in,.sch_set_out').css('color','#fafafa');
		$('.sch_sel_in,.sch_sel_out').slideUp(100);

		if($('#'+Tmp).css('display') == 'none'){
			$(this).css('color','#d00000');
			$('#'+Tmp).slideDown(100);
		}
	});

	$('.cal_set_btn').on('click',function(){
		$('.cal_weeks').animate({'top':'18vw'},500);
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

			$.post(Dir + ".post/blog_img_set.php",
			{
				'img_url':IdTmp,
				'img_code':ImgCode.replace(/^data:image\/jpeg;base64,/, ""),
				'img_top':ImgTop,
				'img_left':ImgLeft,
				'img_width':cvs_W,
				'img_height':cvs_H,
				'vw_base':VwBase,
				'img_zoom':ImgZoom,
				'img_rote':Rote
				},
			function(data){

				$('.pop00,.pop05').hide();
				var cvs = document.getElementById('cvs1');
				var ctx = cvs.getContext('2d');
				ctx.clearRect(0, 0, cvs_A,cvs_A);
				$('.config_img_a1, #my_face, #sumb' + IdTmp).attr('src',data + '?t=<?=time()?>');

				$('#s1, #s2, #s3').removeClass('img_sel');
				$('#s' +IdTmp).addClass('img_sel btn_chg');
				$('#d' +IdTmp).addClass('btn_del');
				$('#wait').hide();

				$('.zoom_box').text('100');
				$('#img_zoom').val('100');
				$('#input_zoom').val('100');
			});
		}
	});



	$('.mail_detail_img_box').on('mail_detail_tmp','click',function(){
		
	});

	$('.img_rote').on('click',function(){
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

	$('.img_reset').on( 'click', function () {
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



	$('.mypage_cal').on('click','.cal_prev',function () {
		$('.mypage_cal').animate({'left':'0'},200);
		$.post({
			url:Dir + "/post/calendar_set.php",
			data:{
				'c_month':$('#c_month').val(),
				'week_start':$('#week_start').val(),
				'pre':'1',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.mypage_cal').prepend(data.html).css('left','-100vw');
			$(".mypage_cal").children().last().remove();
			$('#c_month').val(data.date);
		});
	});


	$('.sch_set').on('click',function () {
		$.post({
			url:Dir + "/post/sch_set.php",
			data:{
				'cast_id':$('#cast_id').val(),
				'base_day':$('#base_day').val(),

				'sel_in[0]':$('#sel_in0').val(),
				'sel_in[1]':$('#sel_in1').val(),
				'sel_in[2]':$('#sel_in2').val(),
				'sel_in[3]':$('#sel_in3').val(),
				'sel_in[4]':$('#sel_in4').val(),
				'sel_in[5]':$('#sel_in5').val(),
				'sel_in[6]':$('#sel_in6').val(),

				'sel_out[0]':$('#sel_out0').val(),
				'sel_out[1]':$('#sel_out1').val(),
				'sel_out[2]':$('#sel_out2').val(),
				'sel_out[3]':$('#sel_out3').val(),
				'sel_out[4]':$('#sel_out4').val(),
				'sel_out[5]':$('#sel_out5').val(),
				'sel_out[6]':$('#sel_out6').val(),

			},
			dataType: 'json',
		}).done(function(data, textStatus, jqXHR){
			console.log(data);
		});
	});

	$('.mypage_cal').on('click','.cal_next',function () {
		$('.mypage_cal').animate({'left':'-200vw'},200);
		$.post({
			url:Dir + "/post/calendar_set.php",
			data:{
				'c_month':$('#c_month').val(),
				'week_start':$('#week_start').val(),
				'pre':'2',
			},
			dataType: 'json',
		}).done(function(data, textStatus, jqXHR){
			$('.mypage_cal').append(data.html).css('left','-100vw');
			$(".mypage_cal").children().first().remove();
			$('#c_month').val(data.date);
		});
	});

	$('.cal_weeks_box_2').draggable({

		axis: 'y',
		start: function( event, ui ) {
			startPosition = ui.position.top;
		},

		drag: function( event, ui ) {
/*
			if(ui.position.top < startPosition){
				ui.position.top = startPosition;
			}
*/
			console.log(ui.position.top+"■"+VwBase*(-70));
		},
	
		stop: function( event, ui ) {
			if(ui.position.top < VwBase*(-95)){
				$('.cal_weeks_box_2').animate({'top':'0vh'},100);

				$.post({
					url:Dir + "/post/chg_weeks.php",
					data:{
						'c_month':$('#c_month').val(),
						'base_day':$('#base_day').val(),
						'pre':'1',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){
					$('.cal_weeks_box_2').prepend(data.html).css('top','76vw');
					$('.cal_weeks_box_2').children().slice(-7,0).remove();
					$('#base_day').val(data.date);
					console.log(data.html)
				});

			}else if(ui.position.top > VwBase*(-65)){
				$('.cal_weeks_box_2').animate({'top':'148vw'},100);

				$.post({
					url:Dir + "/post/chg_weeks.php",
					data:{
						'c_month':$('#c_month').val(),
						'base_day':$('#base_day').val(),
						'pre':'2',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){
					$('.cal_weeks_box_2').prepend(data.html).css('top','76vw');
					$('.cal_weeks_box_2').children().slice(0,7).remove();
					$('#base_day').val(data.date);
					console.log(data.html)
				});

			}else{
				$('.mypage_cal').animate({'top':'80vw'},100);
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
						'pre':'1',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){
					$('.mypage_cal').prepend(data.html).css('left','-100vw');
					$(".mypage_cal").children().last().remove();
					$('#c_month').val(data.date);

					console.log(data.html)
				});

			}else if(ui.position.left < VwBase*(-120)){
				$('.mypage_cal').animate({'left':'-200vw'},100);

				$.post({
					url:Dir + "/post/calendar_set.php",
					data:{
						'c_month':$('#c_month').val(),
						'week_start':$('#week_start').val(),
						'pre':'2',
					},
					dataType: 'json',
				}).done(function(data, textStatus, jqXHR){
					$('.mypage_cal').append(data.html).css('left','-100vw');
					$(".mypage_cal").children().first().remove();
					$('#c_month').val(data.date);
				});
			}else{
				$('.mypage_cal').animate({'left':'-100vw'},100);
			}
		},
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

