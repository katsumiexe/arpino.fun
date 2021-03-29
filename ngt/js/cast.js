$(function(){ 

	var Width_l	=$('.img_box_out2').width();
	var Width_s	=$('.img_box_out1').width();
	var VwBase	=$(window).width()/100;

	var Fav			=0;
	var cvs_A		=0;
	var Rote		=0;
	var Zoom		=100;
	var Zoom		=100;
	var Chg			='';
	var base_64		='';

	$('.color_picker,.icon_picker').hide();
	$('.head_mymenu').on('click',function(){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
			$('.slide').animate({'left':'-70vw'},150);
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
			$(this).addClass('on');
			$('.slide').animate({'left':'0'},150);
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
			$('.tag_set_ck').removeClass('tag_set_ck').animate({'height':'5.5vw'},200);
			$(this).addClass('tag_set_ck').animate({'height':'8vw'},200);

			$('.customer_memo').hide();
			$('#'+Tmp_tr).fadeIn(300);

			Tmp=$(this).attr('id').replace("tag_","");
			$('#h_customer_page').val(Tmp);

			if(Tmp == 2){
				$('.customer_memo_set').show();
				$.post({
					url:"./post/customer_memo_read.php",
					data:{
						'cast_id'	:CastId,
						'c_id':C_Id,
					},
				}).done(function(data, textStatus, jqXHR){
					if(data){
						$('#tag_2_tbl').html(data);
					}
				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});

			}else{
				$('.customer_memo_set').hide();
			}

			if(Tmp == 3){
				$('.customer_log_set').show();
				$.post({
					url:"./post/customer_log_read.php",
					data:{
						'cast_id'	:CastId,
						'c_id':C_Id,
					},
				}).done(function(data, textStatus, jqXHR){
					if(data){
						$('#tag_3_tbl').html(data);
					}
				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});
			}else{
				$('.customer_log_set').hide();
			}
		}
	});


	$('.blog_list').on('click','.blog_hist',function () {

		if($(this).next('.hist_log').css('display')=='none'){

			var TMp=$(this).children('.hidden_tag').val();

			$('.blog_hist').not(this).hide();
			$(this).next('.hist_log').slideDown(200);

			$('#regist_blog').fadeOut(200);
			$('.blog_ad,.blog_next').hide();

			$('#h_blog_tag').val($(this).children('.hidden_tag').val());
			$('#h_blog_status').val($(this).children('.hidden_status').val());
			$('#blog_chg').val($(this).attr('id').replace('blog_hist_',''));

			$('#h_blog_yy').val($(this).children('.hist_date').text().substr(0,4));
			$('#h_blog_mm').val($(this).children('.hist_date').text().substr(5,2));
			$('#h_blog_dd').val($(this).children('.hist_date').text().substr(8,2));
			$('#h_blog_hh').val($(this).children('.hist_date').text().substr(11,2));
			$('#h_blog_ii').val($(this).children('.hist_date').text().substr(14,2));

			$('#h_blog_title').val($(this).children('.hist_title').text());
			$('#h_blog_log').val($(this).next('.hist_log').children('.blog_log').html());
			$('#h_blog_img').val($(this).children('.hist_img').attr('id').replace('b_img_',''));
	
			if($(this).children('.hidden_status').val() ==2){
				$('.blog_open_no').addClass('no_on');
				$('.blog_open_yes').removeClass('yes_on');
			
			}else{
				$('.blog_open_no').removeClass('no_on');
				$('.blog_open_yes').addClass('yes_on');
			}

		}else{
			$('#blog_open').val('0');
			$('.hist_log').slideUp(200);
			$('.blog_hist').slideDown(200);
			$('#regist_blog').fadeIn(200);
			$('#blog_chg').val('');
			$('.blog_ad,.blog_next').show();
		}
	});

	$('.blog_list').on('click','.hist_log',function () {
		$('.hist_log').slideUp(200);
		$('.blog_hist').slideDown(200);
		$('#regist_blog').fadeIn(200);
		$('#blog_chg').val('');
	});


	$('.blog_open_yes').on('click',function () {
		$(this).addClass('yes_on');
		$('.blog_open_no').removeClass('no_on');
		$('#blog_open').val('0');
	});


	$('.blog_open_no').on('click',function () {
		$(this).addClass('no_on');
		$('.blog_open_yes').removeClass('yes_on');
		$('#blog_open').val('2');
	});

	$('.blog_list').on('click','.blog_next',function () {
		$('.blog_ad,.blog_next').hide();
		bId=$(this).attr('id').replace('blog_next_','');

		$.post({
			url:"./post/blog_reload.php",
			data:{
				'cast_id':CastId,
				'blog_id':bId,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			if(data){
				$('.blog_list').append(data);
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.customer_fav').on('click',function () {
		if(Fav == 0){
			Fav=$(this).attr('id').replace('fav_','');
			$('.customer_base_fav').children().slice(0,Fav).css('color','#ff3030');
		}else{
			Fav=0;
			$('.customer_fav').css('color','#cccccc');
		}

		$.post({
			url:"./post/customer_detail_set3.php",
			data:{
			'c_id'		:C_Id,
			'fav'		:Fav,
			},

		}).done(function(data, textStatus, jqXHR){
/*			colsole.log(data);*/
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
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#tag_1_tbl').on('change','.item_textbox,.rd',function(){
		$.post({
			url:"./post/customer_detail_set4.php",
			data:{
				'c_id'		:C_Id,
				'cast_id'	:CastId,
				'value'		:$(this).val(),
				'item'		:$(this).attr('name').replace('cus',''),
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);


		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.mail_hist').on('click',function () {
		$('.mail_detail').animate({'right':'0'},150);
		Customer_id=$(this).attr('id').replace('mail_hist','');
		Customer_Name=$(this).children('.mail_name').text();
		Customer_mail=$(this).children('.mail_address').val();

		$.post({
			url:"./post/easytalk_hist.php",
			data:{
				'cast_id'	:CastId,
				'c_id'		:Customer_id
			},

		}).done(function(data, textStatus, jqXHR){
			$.when(
				$('.mail_detail_in').html(data),

			).done(function(){
				TMP_H=$('.mail_write').offset().top;
/*
				if(TMP_H ==0){
					TMP_H=$('.mail_detail_in').height();
				}
*/
				$('.mail_detail').scrollTop(TMP_H);

				$('.head_mymenu_ttl').text(Customer_Name),
				$('.head_mymenu_comm').addClass('arrow_mail')

			});
		});
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


	$('.regist_mail_set').on('click',function () {
		$('.mail_write').slideDown();
	});

	$('.head').on('click','.arrow_mail',function () {
		$(this).removeClass('arrow_mail');
		$('.mail_detail').animate({'right':'-100vw'},200);
		$('.head_mymenu_ttl').text('Easy Talk');
	});

	$('.reg_fav').on('click',function () {
		if($('#regist_fav').val()== 0){
			Tmp=$(this).attr('id').replace('reg_fav_','');
			$('.regist_fav').children().slice(0,Tmp).css('color','#ff3030');
			$('#regist_fav').val(Tmp);

		}else{
			$('.reg_fav').css('color','#cccccc');
			$('#regist_fav').val('0');
		}
	});

	$('#customer_regist_set').on('click',function () {
		$.post({
			url:"./post/customer_regist_set.php",
			data:{
				'group'		:$('#regist_group').val(),
				'name'		:$('#regist_name').val(),
				'nick'		:$('#regist_nick').val(),
				'fav'		:$('#regist_fav').val(),

				'yy'		:$('#reg_yy').val(),
				'mm'		:$('#reg_mm').val(),
				'dd'		:$('#reg_dd').val(),
				'ag'		:$('#reg_ag').val(),
				'img_code'	:base_64,
			},


		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('.customer_all_in').append(data);
			$('.customer_regist').animate({'top':'100vh'},200);
			$('.set_back').fadeOut(100);

			$('#regist_group').val('0');
			$('#regist_name').val('');
			$('#regist_nick').val('');
			$('#regist_fav').val('0');

			$('#reg_yy').val('1980');
			$('#reg_mm').val('01');
			$('#reg_dd').val('01');
			$('#reg_ag').val('30');
			$('.reg_fav').css('color','#cccccc');

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#reg_yy,#reg_mm,#reg_dd').on('change', function(){
		var Tmp=$('#reg_mm').val()+$('#reg_dd').val();
		if(Now_md <Tmp){
			Tmp2= Now_Y - parseInt($('#reg_yy').val(), 10)-1;

		}else{
			Tmp2= Now_Y - parseInt($('#reg_yy').val(), 10);
		}
		$('#reg_ag').val(Tmp2);
	});

	$('#reg_ag').on('change', function(){
		var Tmp=$('#reg_mm').val()+$('#reg_dd').val();

		if(Now_md <Tmp){
			Tmp2= Now_Y - parseInt($('#reg_ag').val(), 10)-1;

		}else{
			Tmp2= Now_Y - parseInt($('#reg_ag').val(), 10);
		}
		$('#reg_yy').val(Tmp2);
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
		$('.set_back').fadeIn(100);
		$('.customer_regist').animate({'top':'20vh'},200);
		C_Id_Tmp=C_Id;
		C_Id=0;	
	});

	$('.customer_regist_no').on('click',function () {
		$('.customer_regist').animate({'top':'100vh'},200);
		$('.set_back').fadeOut(100);
	});

	$('#regist_blog').on('click',function () {
		if($('.blog_write').css('display') == 'none'){
			$('.blog_write').slideDown(100);
			$('.blog_list').hide();


		}else{
			$('.blog_write').slideUp(50);
			$('.blog_list').show();
		}
	});

	$('#regist_blog_fix').on('click',function () {

		if($('.blog_write').css('display') == 'none'){
			$('.blog_write').slideDown(100);
			$('.blog_list').hide();

			TmpLog=$('#h_blog_log').val().replace(/(<br>|<br \/>)/gi, '\n');

			$('#blog_yy').val($('#h_blog_yy').val());
			$('#blog_mm').val($('#h_blog_mm').val());
			$('#blog_dd').val($('#h_blog_dd').val());
			$('#blog_hh').val($('#h_blog_hh').val());
			$('#blog_ii').val($('#h_blog_ii').val());
			$('#blog_title').val($('#h_blog_title').val());
			$('#blog_log').val(TmpLog);

			if($('#h_blog_img').val()){
			$('.blog_img').attr('src','./img/profile/'+ CastId +'/' + $('#h_blog_img').val() + '_s.png');
			}
			$('#blog_tag').val($('#h_blog_tag').val());
			$("#cvs1").css({'width':'60vw','height':'60vw','top':'10vw','left':'10vw'});



			var ChgImg = new Image();
			var cvs = document.getElementById('cvs1');
			var ctx = cvs.getContext('2d');
/*
			ChgImg.src=$('#h_blog_img').val();
			ChgImg.onload = ()=>{
				ctx.drawImage(ChgImg, 0, 0, 600,600,0,0,600, 600);
			};
*/
		}else{
			$('.blog_write').slideUp(50);
			$('.blog_list').show();
		}
	});

	$('#upd').on('change', function(e){
		var Zoom		=100;
		var Left		=css_B;
		var Right		=css_B;
		var Rote		=0;
		$("#cvs1").css({'width': css_A,'height': css_A,'left': css_B,'top': css_B, 'transform':'rotate(0deg)'});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);

		var file = e.target.files[0];	
		var reader = new FileReader();

		if(file.type.indexOf("image") < 0){
			alert("NO IMAGE FILES");
			return false;
		}

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
						cvs_H=Math.ceil(img_H*(cvs_W/img_W));
						cvs_A=cvs_H;

						cvs_X=Math.ceil((cvs_H-cvs_W)/2);
						cvs_Y=0;

						css_W=Width_l;
						css_H=Math.ceil(img_H*(css_W/img_W));
						css_A=css_H;

						css_B=Math.ceil(Width_s - (css_A-Width_l)/2);


					}else{
						cvs_H=600;
						cvs_W=Math.ceil(img_W*(cvs_H/img_H));
						cvs_A=cvs_W;

						cvs_Y=Math.ceil((cvs_W-cvs_H)/2);
						cvs_X=0;

						css_H=Width_l;
						css_W=Math.ceil(img_W*(css_H/img_H));
						css_A=css_W;

						css_B=Math.ceil(Width_s - (css_A-Width_l)/2);

					}				

					$("#cvs1").attr({'width': cvs_A,'height': cvs_A}).css({'width': css_A,'height': css_A,'left': css_B,'top': css_B});
					ctx.drawImage(img, 0,0, img_W, img_H,cvs_X, cvs_Y, cvs_W, cvs_H);
					ImgCode = cvs.toDataURL("image/jpeg");

					$('#img_top').val(css_B);
					$('#img_left').val(css_B);

						ImgWidth	=css_A;
						ImgHeight	=css_A;
						ImgTop		=css_B;
						ImgLeft		=css_B;
						Rote		=0;
						Zoom		=100;
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

		ImgLeft = $("#cvs1").css("left");
		ImgTop = $("#cvs1").css("top");

		$('#img_top').val(ImgTop);
		$('#img_left').val(ImgLeft);

	});

	$('.head').on('click','.arrow_customer',function(){
		$('.head_mymenu_comm').removeClass('arrow_customer');
		$('.customer_detail').animate({'left':'100vw'},150);
		$('.head_mymenu_ttl').html('顧客リスト');
		$('.menu').css({'heigh':'auto'});
		$('.pg3').hide();
		$('.pg2').show();

		$('.customer_sns_box').hide();
		$('.customer_sns_tr').hide();
		$('.sns_arrow_a').hide();
		$('.sns_text').val('');

		$('.customer_sns_box,.sns_arrow_a,.customer_sns_btn').removeClass('c_customer_twitter c_customer_facebook c_customer_insta c_customer_web c_customer_line c_customer_tel c_customer_mail');
		$('.sns_jump').removeClass('jump_on');

		$('.tag_set').removeClass('tag_set_ck').animate({'height':'5.5vw'},300);
		$('#tag_1').addClass('tag_set_ck').animate({'height':'8vw'},300);

		$('.customer_memo').hide();
		$('#tag_1_tbl').show();
		$('.customer_fav').css('color','#cccccc');
		$('.main').css('position','static');

		$('#h_customer_id,#h_customer_set,#h_customer_page,#h_customer_fav,#h_customer_tel,#h_customer_mail,#h_customer_twitter,#h_customer_facebook,#h_customer_insta,#h_customer_web,#h_customer_line').val('');
		$('#tag_2_tbl,#tag_3_tbl').empty();
	});

/*
	$('.customer_detail').draggable({
		axis: 'x',
		start: function( event, ui ) {
			startPosition = ui.position.left;
		},
		drag: function( event, ui ) {
			if(ui.position.left < startPosition) ui.position.left = startPosition;
		},
		stop: function( event, ui ) {
			if(ui.position.left > 50){
				$('.customer_detail').animate({'left':'100vw'},200);

				$('.head_mymenu_comm').removeClass('arrow_customer');
				$('.head_mymenu_ttl').html('顧客リスト');

				$('.customer_sns_box').hide();
				$('.customer_sns_tr').hide();
				$('.sns_arrow_a').hide();
				$('.sns_text').val('');

				$('.customer_sns_box,.sns_arrow_a,.customer_sns_btn').removeClass('c_customer_twitter c_customer_facebook c_customer_insta c_customer_web c_customer_blog c_customer_tel c_customer_mail');
				$('.sns_jump').removeClass('jump_on');

				$('.tag_set').removeClass('tag_set_ck').animate({'top':'3vw','height':'5.5vw'},300);
				$('#tag_1').addClass('tag_set_ck').animate({'top':'0.5vw','height':'8vw'},300);

				$('.customer_memo').hide();
				$('#tag_1_tbl').show();
				$('.customer_fav').css('color','#cccccc');

			}else{
				$('.customer_detail').animate({'left':'0vw'},200);
				$('.menu').css({'heigh':'auto'});
			}
		}
	});
*/

	$('.main').on('click','.customer_list',function(){
		$('.head_mymenu_ttl').html('顧客リスト(詳細)');
		$('.head_mymenu_comm').addClass('arrow_customer');

//		$('.main').css('position','fixed');
		$('.pg2').delay(200).fadeOut(0);
		$('.pg3').delay(200).fadeIn(0);

		C_Id=$(this).attr('id').replace('clist','');

		Tmp=$(this).children('.mail_img').attr('src');
		$('#customer_img').attr('src',Tmp);

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
		$('#customer_detail_ag').val(Tmp);

		Tmp=$(this).children('.customer_hidden_face').val();
		$('#img_url').val(Tmp);

		Tmp=$(this).children('.customer_hidden_fav').val();
		$('#h_customer_fav').val(Tmp);

		Tmp=$(this).children('.customer_hidden_tel').val();
		$('#h_customer_tel').val(Tmp);
		if(Tmp){
			$('#customer_tel').addClass('c_customer_tel');		
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

		Tmp=$(this).children('.customer_hidden_line').val();
		$('#h_customer_line').val(Tmp);
		if(Tmp){
			$('#customer_line').addClass('c_customer_line');		
		}

		Tmp=$(this).children('.customer_hidden_web').val();
		$('#h_customer_web').val(Tmp);
		if(Tmp){
			$('#customer_web').addClass('c_customer_web');		
		}

		$('.customer_detail').animate({'left':'0'},200);
		$('.menu').css({'heigh':'100vh'});

		$.post({
			url:"./post/customer_detail_read.php",
			data:{
				'c_id':C_Id,
			},

		}).done(function(data, textStatus, jqXHR){
			$('#tag_1_tbl').html(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#blog_set').on('click',function(){

		$('#blog_hist_'+$('#blog_chg').val()).remove();
		$.post({
			url:"./post/blog_set.php",
			data:{
				'cast_id':CastId,
				'ttl':$('#blog_title').val(),
				'log':$('#blog_log').val(),
				'tag':$('#blog_tag').val(),
				'chg':$('#blog_chg').val(),
				'status':$('#blog_status').val(),

				'yy':$('#blog_yy').val(),
				'mm':$('#blog_mm').val(),
				'dd':$('#blog_dd').val(),
				'hh':$('#blog_hh').val(),
				'ii':$('#blog_ii').val(),

				'img_code':base_64
			},

		}).done(function(data, textStatus, jqXHR){
			$('.blog_write').slideUp(300);
			$('.blog_list').show().prepend(data);
			var base_64='';

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.sns_btn').on('click',function(){
		$.post({
			url:"./post/customer_sns_set.php",
			data:{
				'c_id':C_Id,
				'text':$('.sns_text').val(),
				'kind':Tmp.replace('customer_',''),
			},

		}).done(function(data, textStatus, jqXHR){

			if($('.sns_text').val()){
				$('#customer_'+data).addClass('c_customer_'+data);		
				$('.customer_sns_box').addClass('c1_customer_'+data);		
				$('#a_customer_'+data).addClass('c_customer_'+data);
				$('.sns_jump').addClass('jump_on c2_customer_'+data);

			}else{
				$('#customer_'+data).removeClass('c_customer_'+data);		
				$('.customer_sns_box').removeClass('c1_customer_'+data);		
				$('#a_customer_'+data).removeClass('c_customer_'+data);
				$('.sns_jump').removeClass('jump_on c2_customer_'+data);
			}
			$('#h_customer_'+data).val($('.sns_text').val());
			$('#clist'+C_Id).children('.customer_hidden_'+data).val($('.sns_text').val());

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.customer_sns_btn').on('click',function(){
		if($('.customer_sns_box').css('display') !== 'none'){
			$('.pg3').animate({'margin-top':'82vw'},200);

			$('.customer_sns_box').slideUp(100);
			$('.customer_sns_tr').slideUp(100);
			$('.sns_arrow_a').hide();
			$('.sns_text').val('');

			$('.customer_sns_box').removeClass('c1_'+Tmp);
			$('.sns_jump').removeClass('jump_on c2_'+Tmp);
		}

		if(Tmp != $(this).attr('id')){
			Tmp=$(this).attr('id');
			$('#a_'+Tmp).show();
			TmpH=$('#h_'+Tmp).val();

			if(TmpH){
				SnsColor=$(this).css('background');
				
				$('.sns_text').val($('#h_'+Tmp).val());
				$('#a_'+Tmp).addClass('c_'+Tmp);
				$('.customer_sns_box').addClass('c1_'+Tmp);


				if(Tmp == 'customer_mail'){
					$('.sns_jump').addClass('jump_on c2_'+Tmp).attr('href',SNS_LINK[Tmp]);

					$('#sns_form').attr('action',SNS_LINK[Tmp]);
					$('#sns_form_hidden').val('3');
					$('#sns_form_customer').val(C_Id);

				}else{
					$('.sns_jump').addClass('jump_on c2_'+Tmp);
					$('#sns_form').attr('action',SNS_LINK[Tmp]+$('#h_'+Tmp).val());
				}

				$('.customer_sns_ttl').css('color',SnsColor).text($('#n_'+Tmp).val());
			}

			$('.customer_sns_box').slideDown(200);
			$('.customer_sns_tr').slideDown(200);
			$('.pg3').animate({'margin-top':'102vw'},200);

		}else{
			Tmp='';
		}
	});


	$('.customer_detail').on('click','.jump_on',function(){
		$('#sns_form').submit();
	});

	$('.blog_td_img').on('click',function(){
		$('.img_box').animate({'top':'10vw'},200);
		$('.set_back').fadeIn(100);
		$('#img_code').val('');
		Task="blog";
	});

	$('#set_new_img').on('click',function(){
		$('.img_box').animate({'top':'10vw'},200);
		$('.set_back').fadeIn(100);
		$('#img_code').val('');
		Task="regist";
	});

	$('.customer_detail_img').on('click',function(){
		$('.img_box').animate({'top':'10vw'},200);
		$('.set_back').fadeIn(100);
		$('#img_code').val('');

		Task="chg";

		Img=$(this).attr("src");
		var ChgImg = new Image();
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');

		ChgImg.src=Img;
		cvs_A=300;
		cvs_W=300;
		cvs_H=300;

		cvs_X=300;
		cvs_Y=300;
		cvs_B=50;

		css_l=300;
		css_p=50;

		css_A=60*VwBase;
		css_B=10*VwBase;


		ImgTop		=css_p;
		ImgLeft		=css_p;

		$("#cvs1").attr({'width': 300,'height': 300}).css({'width': '60vw','height': '60vw','left': '10vw','top': '10vw'});
		ctx.drawImage(ChgImg, 0, 0, 300,300,0,0,300, 300);
		ImgCode = cvs.toDataURL("image/jpeg");
	});


	$('.mail_detail_btn_img').on('click',function(){
		$('.img_box').animate({'top':'10vw'},200);
		$('.set_back').fadeIn(100);
		Task="mail";

		if($('.mail_img_view').css('display') === 'inline'){

			Img=$('.mail_img_view').attr("src");
			var ChgImg = new Image();
			var cvs = document.getElementById('cvs1');
			var ctx = cvs.getContext('2d');

			ChgImg.src=Img;
			cvs_A=300;
			cvs_W=300;
			cvs_H=300;

			cvs_X=300;
			cvs_Y=300;
			cvs_B=50;

			css_l=300;
			css_p=50;

			css_A=60*VwBase;
			css_B=10*VwBase;


			ImgTop		=css_p;
			ImgLeft		=css_p;

			$("#cvs1").attr({'width': 300,'height': 300}).css({'width': '60vw','height': '60vw','left': '10vw','top': '10vw'});
			ctx.drawImage(ChgImg, 0, 0, 600,600,0,0,300, 300);
			ImgCode = cvs.toDataURL("image/jpeg");
		}
	});

	$('#regist_schedule').on('click',function(){
		$('.cal_weeks').animate({'top':'18vw'},200);
		$('.set_back').fadeIn(100);
	});


	$('#img_set').on('click',function(){	
		if(ImgCode){
			$('#wait').show();
		
			$.post({
				url:"./post/img_set.php",
				data:{
					'cast_id'	:CastId,
					'img_code'	:ImgCode.replace(/^data:image\/jpeg;base64,/, ""),

					'img_top'	:ImgTop,
					'img_left'	:ImgLeft,

					'img_width'	:cvs_W,
					'img_height':cvs_H,

					'img_zoom'	:Zoom,
					'img_rote'	:Rote,

					'width_s'	:Width_s,
					'width_l'	:Width_l,
					'task'		:Task,
				},

			}).done(function(data, textStatus, jqXHR){

console.log(ImgTop);
console.log(ImgLeft);

console.log(cvs_W);
console.log(cvs_H);

console.log(Width_s);
console.log(Width_l);

				base_64=data;
				$('.img_box').animate({'top':'120vh'},200);
				var cvs = document.getElementById('cvs1');
				var ctx = cvs.getContext('2d');
				ctx.clearRect(0, 0, cvs_A,cvs_A);

				if(Task=="blog"){
					$('.blog_img').attr('src',"data:image/jpg;base64,"+base_64);
					$('.set_back').fadeOut(200);

				}else if(Task=="regist"){
					$('.regist_img').attr('src',"data:image/jpg;base64,"+base_64);

				}else if(Task=="chg"){
					$('.customer_detail_img').attr('src',ImgCode);
					$('.set_back').fadeOut(200);


				}else if(Task=="mail"){
					if(base_64){
						$('.mail_img_view').show().attr('src',"data:image/jpg;base64,"+base_64);
					}else{
						$('.mail_img_view').hide().attr('src',"");
					}
					$('.set_back').fadeOut(200);
				}

				$('#img_hidden').val(base_64);
				$('#wait').hide();
				$('.zoom_box').text('100');
				$('#img_zoom').val('100');
				$('#input_zoom').val('100');
				Rote=0;

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

			console.log("cvs_w:"+cvs_W);
			console.log("cvs_h:"+cvs_H);
			console.log("css_A:"+css_A);
			console.log("css_B:"+css_B);	
			console.log("ImgLeft:"+ImgLeft);	
			console.log("ImgTop:"+ImgTop);	
			console.log("width_l:"+Width_l);
			console.log("width_s:"+Width_s);
			console.log("Zoom:"+Zoom);
			$('#img_code').val(ImgCode)

		}else{
			$('#img_code').val('')
			$('.img_box').animate({'top':'120vh'},200);
			var cvs = document.getElementById('cvs1');
			var ctx = cvs.getContext('2d');
			ctx.clearRect(0, 0, cvs_A,cvs_A);
			$('.set_back').fadeOut(200);
		}
	});

	$('.upload_trush').on('click',function(){	
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, cvs_A,cvs_A);
		$('.mail_img_view').hide().attr('src',"");
		ImgCode='';
	});


	$('#img_close').on('click',function(){	
		$('.set_back').fadeOut(200);
		$('.img_box	').animate({'top':'100vh'},200);

		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, cvs_A,cvs_A);
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

	$('#img_reset').on( 'click', function () {
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
		  $.ajax({
				url:'./post/sch_set.php',
				type: 'post',
				data:{
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
				dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$.each(data, function(a1, a2){
				if(a2){
					$('#c'+a1).children('.cal_i2').addClass('n2');
				}else{
					$('#c'+a1).children('.cal_i2').removeClass('n2');
				}
			  console.log(a1 + ':' + a2);
			})
			$('.sch_set_done').fadeIn(500).delay(1500).fadeOut(1000);
			$('.cal_weeks').animate({'top':'100vh'},200);
			$('.set_back').fadeOut(100);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#sch_set_arrow').on('click',function () {
		$('.cal_weeks').animate({'top':'100vh'},200);
		$('.set_back').fadeOut(100);
	});

	$('#sch_set_trush').on('click',function () {
//		$('.sch_time_in,.sch_time_out').val("");
		$('.cal_weeks_box_2').children().slice(7,14).children('.sch_time_in,.sch_time_out').val("");
	});

	$('#memo_del').on('click',function () {
		$('.customer_memo_new_txt').val("");
	});

	$('#memo_reset').on('click',function () {
		$('.set_back').fadeOut(200);
		$('.customer_memo_in').animate({'top':'100vh'},200);
		$('#memo_chg_id').val('');
	});

	$('.customer_memo_set').on('click',function () {
		if($('.set_back').css('display') ==='none'){
			$('.set_back').fadeIn(200);
			$('.customer_memo_in').animate({'top':'20vh'},200);
		
		}else{
			$('#memo_chg_id').val('');
			$('.set_back').fadeOut(200);
			$('.customer_memo_in').animate({'top':'100vh'},200);
		}
	});

	$('.customer_log_set').on('click',function () {
		if($('.set_back').css('display') ==='none'){
			$('.set_back').fadeIn(200);
			$('.customer_log_in').animate({'top':'20vh'},200);
		
		}else{
			$('.set_back').fadeOut(200);
			$('.customer_log_in').animate({'top':'100vh'},200);
		}
	});

	$('#tag_3_tbl').on('click','.customer_log_chg',function () {
		if($('.set_back').css('display') ==='none'){
			Chg=$(this).attr('id').replace('l_chg','');
			$('.set_back').next()
			$('.set_back').fadeIn(200);
			$('.customer_log_in').animate({'top':'20vh'},200);

			TmpLog=$(this).parents().next('.customer_log_memo').html().replace(/(<br>|<br \/>)/gi, '\n');
			TmpTag=$(this).parents().next().next('.customer_log_list').html();
			console.log($(this).prev('.customer_log_date_detail').text());

			$('#logset_yy').val($(this).prev('.customer_log_date_detail').text().substr(0,4));
			$('#logset_mm').val($(this).prev('.customer_log_date_detail').text().substr(5,2));
			$('#logset_dd').val($(this).prev('.customer_log_date_detail').text().substr(8,2));
			$('#logset_hh_s').val($(this).prev('.customer_log_date_detail').text().substr(11,2));
			$('#logset_ii_s').val($(this).prev('.customer_log_date_detail').text().substr(14,2));

			$('#logset_hh_e').val($(this).prev('.customer_log_date_detail').text().substr(17,2));
			$('#logset_ii_e').val($(this).prev('.customer_log_date_detail').text().substr(20,2));

			$('#sel_log_area').val(TmpLog);
			$('.customer_log_right').html(TmpTag);
			$('.customer_log_right div').removeClass('customer_log_item').addClass('sel_log_option_s').append('<span class=\"sel_log_del_s\"></span>');

		}else{
			Chg='';
			$('.set_back').fadeOut(200);
			$('.customer_log_in').animate({'top':'100vh'},200);
		}
	});



	$('#memo_set').on('click',function () {
		Log=$('.customer_memo_new_txt').val();
		var TmpMemoId=$('#memo_chg_id').val()
		$.post({
			url:"./post/customer_memo_set.php",
			data:{
				'cast_id'	:CastId,
				'c_id'		:C_Id,
				'log'		:Log,
				'memo_id'	:TmpMemoId,

			},
		}).done(function(data, textStatus, jqXHR){

			if($('#memo_chg_id').val('')){
				$('#tr_memo_detail'+TmpMemoId).remove();
				$('#tr_memo_log'+TmpMemoId).remove();
				$('#memo_chg_id').val('');
			}

			$('.set_back').fadeOut(200);
			$('.customer_memo_in').animate({'top':'100vh'},200);
			$('#tag_2_tbl').prepend(data);
			$('.customer_memo_new_txt').val('');


		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#tag_2_tbl').on('click','.customer_memo_chg',function () {

		Tmp=$(this).attr('id').replace("m_chg","");
		$('.set_back').fadeIn(200);
		$('.customer_memo_in').animate({'top':'20vh'},200);
		$('#memo_chg_id').val(Tmp);
		TmpLog=$('#m_log'+Tmp).html().replace(/(<br>|<br \/>)/gi, '\n')
		$('.customer_memo_new_txt').val(TmpLog);
	});


	$('#item_sort').on('click','.log_td_del',function () {
		$('.set_back,.log_list_del').fadeIn(200);
		Tmp_DelList=$(this).parents('tr').attr('id').replace("i","");

		$('.log_list_del_icon').text($(this).next().next().next().children('.item_icon').text());
		$('.log_list_del_name').text($(this).next().next().next().next().children('.item_name').val());
		$('.log_list_del_price').text($(this).next().next().next().next().next().children('.item_price').val());
		$('.log_list_del_item').css({'color':$(this).next().next().next().css('color'),'border-color':$(this).next().next().next().css('color')});
	});

	$('.tmpl_sel').on('change',function (){
		Tmp=$(this).val();
		Tmp_2=$('#tmpl_hidden'+Tmp).val()
		$('#tmpl_send').val(Tmp_2)
	});




	$('.mail_detail_btn_send').on('click',function(){
		$.post({
			url:"./post/easytalk_send.php",
			data:{
				'log'			:$('.mail_write_text').val(),
				'send'			:'1',
				'img_code'		:$('.mail_img_view').attr('src').replace("data:image/jpg;base64,", ""),

				'cast_id'		:CastId,
				'cast_name'		:CastName,

				'customer_id'	:Customer_id,
				'customer_name'	:Customer_Name,
				'customer_mail'	:Customer_mail,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('.mail_detail_in').append(data)
			$('.mail_write_text').val('');
//			$('.mail_img_view').attr('src','./img/customer_no_img.jpg');




		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#log_list_del_set').on('click',function () {
		$.post({
			url:"./post/log_item_del.php",
			data:{
				'cast_id'	:CastId,
				'list_id'	:Tmp_DelList,
			},

		}).done(function(data, textStatus, jqXHR){
			$('.set_back,.customer_memo_del_back_in').fadeOut(500);
			$("#i"+Tmp_DelList).remove();
			$('#memo_chg_id').val('');

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#log_list_del_back').on('click',function () {
		$('.set_back,.log_list_del').fadeOut(100);
	});

	$('#memo_del_back').on('click',function () {
		$('.set_back,.customer_memo_del_back_in').fadeOut(100);
		$('#memo_chg_id').val('');
	});


	$('#tag_2_tbl').on('click','.customer_memo_del',function () {
		$('.set_back,.customer_memo_del_back_in').fadeIn(200);

		Tmp=$(this).attr('id').replace("m_del","");
		$('#memo_chg_id').val(Tmp);
	});


	$('#memo_del_back').on('click',function () {
		$('.set_back,.customer_memo_del_back_in').fadeOut(100);
	});


	$('.cas_set').on('change',function () {
		if($(this).attr('id')=='customer_detail_name'){
			$('#clist'+C_Id).children('.customer_list_name').html($(this).val()+' 様');

		}else if($(this).attr('id')=='customer_detail_nick'){
			$('#clist'+C_Id).children('.customer_list_nickname').html($(this).val());

		}else if($(this).attr('id')=='customer_group'){
			$('#clist'+C_Id).children('.customer_hidden_group').val($(this).val());

		}

		$.post({
			url:"./post/customer_detail_set.php",
			data:{
			'c_id'		:C_Id,
			'id'		:$(this).attr('id'),
			'param'		:$(this).val(),
			},
		}).done(function(data, textStatus, jqXHR){
		});
	});

	$('.cas_set2').on('change',function () {
		$.post({
			url:"./post/customer_detail_set2.php",
			data:{
			'c_id'		:C_Id,
			'id'		:$(this).attr('id'),
			'yy'		:$('#customer_detail_yy').val(),
			'mm'		:$('#customer_detail_mm').val(),
			'dd'		:$('#customer_detail_dd').val(),
			'ag'		:$('#customer_detail_ag').val(),
			},
			dataType: 'json',
		}).done(function(data, textStatus, jqXHR){
			$('#customer_detail_yy').val(data.yy),
			$('#customer_detail_mm').val(data.mm),
			$('#customer_detail_dd').val(data.dd),
			$('#customer_detail_ag').val(data.ag),
			$('#clist'+C_Id).children('.customer_hidden_yy').val(data.yy);
			$('#clist'+C_Id).children('.customer_hidden_mm').val(data.mm);
			$('#clist'+C_Id).children('.customer_hidden_dd').val(data.dd);
			$('#clist'+C_Id).children('.customer_hidden_ag').val(data.ag);
		});
	});

	$('#memo_del_set').on('click',function () {
		$.post({
			url:"./post/customer_memo_del.php",
			data:{
				'cast_id'	:CastId,
				'c_id'		:C_Id,
				'memo_id'	:$('#memo_chg_id').val(),
			},

		}).done(function(data, textStatus, jqXHR){
			$('.set_back,.customer_memo_del_back_in').fadeOut(500);
			$('#tag_2_tbl').html(data);
			$('#memo_chg_id').val('');


		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.cal').on('click','.cal_btn_on1',function () {
		$('.cal_circle').animate({'left':'0vw'},200);
		$('.cal_btn_on1').animate({'color':'#f17766'},200);
		$('.cal_btn_on2').animate({'color':'#b0b0a0'},200);
	});

	$('.cal').on('click','.cal_btn_on2',function () {
		$('.cal_circle').animate({'left':'12vw'},200);
		$('.cal_btn_on2').animate({'color':'#f17766'},200);
		$('.cal_btn_on1').animate({'color':'#b0b0a0'},200);
	});

	$('.cal').on('click','.cal_prev',function () {
		$.post({
			url:"./post/calendar_set.php",
			data:{
				'c_month'	:$('#c_month').val(),
				'week_start':$('#week_start').val(),
				'cast_id'	:CastId,
				'pre'		:'1',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.cal').prepend(data.html).animate({'left':'-100vw'},200);
			$(".cal").children().last().remove();
			$('#c_month').val(data.date);
		});
	});

	$('.notice_ttl_in').on('click',function(){
		if(!$(this).hasClass('notice_sel')){
			Tmp=$(this).attr('id');
			$('#h_'+Tmp).val();
			$('#notice_day').hide().fadeIn(800).text($('#h_'+Tmp).val());

			Tmp2=$(this).attr('id').replace('ttl','box');
			$('.notice_ttl_in').removeClass('notice_sel');
			$(this).addClass('notice_sel');
			$('.notice_box').hide();
			$('#'+Tmp2).fadeIn(0);
		}
	});


	$('.notice_box_item2').on('click',function (){
		Tmp=$(this).attr('id').replace("title","hidden");
		$('.notice_box_log').html($('#'+Tmp).val());
		$('.notice_box_item1,.notice_box_item2').removeClass('notice_box_sel');
		$(this).addClass('notice_box_sel');
	});

	$('.notice_box_item1').on('click',function (){
		Nid=$(this).attr('id').replace("notice_box_title","");
		Tmp=$(this).attr('id').replace("title","hidden");
		$(this).removeClass('notice_box_item1').addClass('notice_box_item2');
		$(this).children('div').removeClass('notice_yet1').addClass('notice_yet2');
		$('.notice_box_log').html($('#'+Tmp).val());

		$('.notice_box_item1,.notice_box_item2').removeClass('notice_box_sel');
		$(this).addClass('notice_box_sel');

		$.post({
			url:"./post/notice_ck.php",
			data:{
				'n_id':Nid,
				'cast_id':CastId,
			},
		});
	});


	$('.cal').on('click','.cal_next',function () {
		$.post({
			url:"./post/calendar_set.php",
			data:{
				'c_month':$('#c_month').val(),
				'week_start':$('#week_start').val(),
				'cast_id':CastId,	
				'pre':'2',
			},
			dataType: 'json',
		}).done(function(data, textStatus, jqXHR){
			$('.cal').append(data.html).animate({'left':'-100vw'},200);
			$(".cal").children().first().remove();
			$('#c_month').val(data.date);
		});
	});


	$('.cal_weeks_prev').on('click',function (){
/*		$('.cal_weeks_box_2').animate({'top':'0'},2000);*/
		$.post({
			url:"./post/chg_weeks.php",
			data:{
				'c_month':$('#c_month').val(),
				'base_day':$('#base_day').val(),
				'cast_id':CastId,
				'pre':'1',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.cal_weeks_box_2').prepend(data.html).animate({'top':'-73.5vw'},2000);
			$('.cal_weeks_box_2').children().slice(-7).remove();
			$('#base_day').val(data.date);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.cal_weeks_next').on('click',function (){
/*		$('.cal_weeks_box_2').animate({'top':'-73.5vw'},200);*/
		$.post({
			url:"./post/chg_weeks.php",
			data:{
				'c_month':$('#c_month').val(),
				'base_day':$('#base_day').val(),
				'cast_id':CastId,
				'pre':'2',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.cal_weeks_box_2').children().slice(0,7).remove();
			$('.cal_weeks_box_2').append(data.html).css({'top':'-73.5vw'});
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
					url:"./post/chg_weeks.php",
					data:{
						'c_month':$('#c_month').val(),
						'base_day':$('#base_day').val(),
						'cast_id':CastId,
						'pre':'1',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){
					$('.cal_weeks_box_2').prepend(data.html).css('top','-73.5vw');
					$('.cal_weeks_box_2').children().slice(-7).remove();
					$('#base_day').val(data.date);
				});

			}else if(ui.position.top < VwBase*(-95)){//翌週
				$('.cal_weeks_box_2').animate({'top':'-147vw'},100);

				$.post({
					url:"./post/chg_weeks.php",
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

	$('.cal').draggable({
		axis: 'x',
		drag: function( event, ui ) {
			console.log(ui.position.left)

		},

		stop: function( event, ui ) {
			if(ui.position.left > VwBase*(-90)){/*■先月*/
				$('.cal').animate({'left':'0'},200);
				$.post({
					url:"./post/calendar_set.php",
					data:{
						'c_month':$('#c_month').val(),
						'week_start':$('#week_start').val(),
						'cast_id':CastId,
						'pre':'1',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){

					$('.cal').prepend(data.html).animate({'left':'-100vw'},0);
					$(".cal").children().last().remove();
					$('#c_month').val(data.date);
/*
					console.log(data.sql);
					console.log(data.html);
*/
					console.log($(".cal").children().last());

				});

			}else if(ui.position.left < VwBase*(-110)){/*■来月*/
				$('.cal').animate({'left':'-200vw'},200);
				$.post({
					url:"./post/calendar_set.php",
					data:{
						'c_month':$('#c_month').val(),
						'week_start':$('#week_start').val(),
						'cast_id':CastId,
						'pre':'2',
					},
					dataType: 'json',
				}).done(function(data, textStatus, jqXHR){
					$('.cal').append(data.html).animate({'left':'-100vw'},0);
					$(".cal").children().first().remove();
					$('#c_month').val(data.date);
					console.log(data.sql);
					console.log(data.html);
				});

			}else{
				$('.cal').animate({'left':'-100vw'},100);
			}
		},
	});

	$('.log_item_set').on('click','.item_color',function (){
		$('.color_picker,.icon_picker').slideUp(100);
		if($(this).next().css('display')=='none'){
			$(this).next().slideDown(100);
		}
	});

	$('.log_item_set').on('click','.color_picker_list',function (){
		$('.color_picker,.icon_picker').slideUp(100);
		Tmp=$(this).parent().attr('id');
		Clr=$(this).css('background');
		Cds=$(this).attr('cd');
		$(this).parent().prev().css('background',Clr);
		$(this).parent().next().val(Cds);
		$(this).parent().parent().next().css('color',Clr);

		$.post({
			url:"./post/log_item_chg.php",
			data:{
			'sort'		:Tmp,
			'cast_id'	:CastId,
			'clr'		:Cds,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(Tmp)
			console.log(data)
		});
	});

	$('.log_item_set').on('click','.item_icon',function (){
		$('.icon_picker,.color_picker').slideUp(100);
		if($(this).next().css('display')=='none'){
			$(this).next().slideDown(100);
		}
	});

	$('.log_item_set').on('click','.icon_picker_list',function (){
		Tmp=$(this).parent().attr('id');
		Cds=$(this).attr('cd');
		Clr=$(this).text();
		$(this).parent().prev().text(Clr);
		$(this).parent().next().val(Cds);
		$('.color_picker,.icon_picker').slideUp(100);

		$.post({
			url:"./post/log_item_chg.php",
			data:{
			'sort'		:Tmp,
			'cast_id'	:CastId,
			'cds'		:Cds,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(Tmp)
			console.log(data)
		});
	});

	$('.log_item_set').on('change','.item_name',function (){
		Tmp=$(this).attr('id').replace('item_name_','');
		Cds=$(this).val();
		$.post({
			url:"./post/log_item_chg.php",
			data:{
			'sort'		:Tmp,
			'cast_id'	:CastId,
			'name'		:Cds,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(Cds)
		});
	});

	$('.log_item_set').on('change','.item_price',function (){
		Tmp=$(this).attr('id').replace('item_price_','');
		Cds=$(this).val();
		$.post({
			url:"./post/log_item_chg.php",
			data:{
			'sort'		:Tmp,
			'cast_id'	:CastId,
			'price'		:Cds,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(Cds)
		});
	});

	$('#gp_set').on('click',function (){
		Tmp=$('#count_gp').val()-0+1;
		Cds=$(this).val();
		$.post({
			url:"./post/gp_set.php",
			data:{
			'sort'		:Tmp,
			'cast_id'	:CastId,
			'name'		:$('#gp_new').val(),

			},
		}).done(function(data, textStatus, jqXHR){
			$('#gp_sort').append(data);
			$('#count_gp').val(Tmp);
			$('#gp_new').val('');
		});
	});

	$('#gp_sort').on('change','.gp_name',function (){
		Tmp=$(this).attr('id').replace('gp_name_','');
		Cds=$(this).val();
		$.post({
			url:"./post/gp_chg.php",
			data:{
			'sort'		:Tmp,
			'cast_id'	:CastId,
			'name'		:Cds,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(Cds)
		});
	});

	$('#gp_sort').on('click','.gp_del_in',function (){
		Tmp=$(this).attr('id').replace('gp_name_','');
		Cds=$(this).val();
		$.post({
			url:"./post/gp_del.php",
			data:{
			'sort'		:Tmp,
			'cast_id'	:CastId,
			'name'		:Cds,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(Cds)
		});
	});

	$('#config_week_start').on('change',function (){
		Tmp=String($(this).val());
		$.post({
			url:"./post/config_week_chg.php",
			data:{
			'week'		:Tmp,
			'cast_id'	:CastId,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(Tmp)
			console.log(data)
		});
	});

	$('#config_day_start').on('change',function (){
		Tmp=String($(this).val());
		$.post({
			url:"./post/config_day_chg.php",
			data:{
			'times'		:Tmp,
			'cast_id'	:CastId,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(Tmp)
			console.log(data)
		});
	});

	$('.cal_days_memo').on('change',function (){
		TmpLog=$('.cal_days_memo').val();
		TmpCal='cal_m_'+$('#set_date').val();
		$('.'+TmpCal).removeClass(TmpCal);

		$.post({
			url:"./post/calendar_memo_set.php",
			data:{
			'set_date'	:$('#set_date').val(),
			'cast_id'	:CastId,
			'log'		:TmpLog,

			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			Tmp=$('#set_date').val().substr(0,6)
			$('#para'+Tmp).append(data);
			if(TmpLog){
				$('#c'+$('#set_date').val()).children('.cal_i3').addClass('n3');
			}else{
				$('#c'+$('#set_date').val()).children('.cal_i3').removeClass('n3');
			}
		});
	});

	$('.cal').on('click','.cal_td',function (){
		$('.cal_td').removeClass('cc8');
		$(this).addClass('cc8');

		DaySet =$(this).attr('id').replace("c","");
		$('#set_date').val(DaySet);
	
		ToMon	=$(this).attr('id').substr(5,2);
		ToDay	=$(this).attr('id').substr(7,2);
		ToMD	=$(this).attr('id').substr(5,4);
		ToWeek	=$(this).attr('week');
		$('.cal_days_date').text(ToMon+"月"+ToDay+"日["+ToWeek+"]");

		var Tmp=$(this).attr('id').replace('c','cal_s_');
		if($('.'+Tmp).val()){
			$('.days_day').text($('.'+Tmp).val());
		}else{
			$('.days_day').text('休み');
		}		

		var Tmp=$(this).attr('id').substr(5,4);
		if($('.cal_b_'+Tmp).val()){
			$('.cal_days_birth').html($('.cal_b_'+Tmp).val());
		}else{
			$('.cal_days_birth').text('');
		}

		var Tmp=$(this).attr('id').replace('c','cal_m_');
		if($('.'+Tmp).val()){
			$('.cal_days_memo').val($('.'+Tmp).val());
		}else{
			$('.cal_days_memo').val('');
		}
		console.log(Tmp);
	});

	$('.slide').draggable({
		axis: 'x',
		start: function( event, ui ) {
			startPosition = ui.position.left;
		},
		drag: function( event, ui ) {
			if(ui.position.left > startPosition) ui.position.left = startPosition;
		},

		stop: function( event, ui ) {
			if(ui.position.left < -50){
				$('.slide').animate({'left':'-70vw'},200);

				$('.head_mymenu').removeClass('on');
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
				$('.slide').animate({'left': '0vw'},100);
			}
		}
	})

	$('#item_sort').sortable({
		axis: 'y',
        handle: '.log_td_handle',
		stop : function() {
			$('.color_picker,.icon_picker').hide();
			ChgList=$(this).sortable("toArray");
			var Cnt=ChgList.length;
			console.log(ChgList);

			var N=0;
			var ItemName	=[];
			var ItemPrice	=[];
			var ItemIcon	=[];
			var ItemColor	=[];


			for(i=0;i<Cnt;i++){
				ItemName[i]=$('#item_name_'+i).val();
				ItemPrice[i]=$('#item_price_'+i).val();
				ItemIcon[i]=$('#item_icon_hidden_'+i).val();
				ItemColor[i]=$('#item_color_hidden_'+i).val();
			}
			$.post({
				url:"./post/log_item_set.php",
				data:{
				'cast_id'		:CastId,
				'chglist[]'		:ChgList,
				'item_name[]'	:ItemName,
				'item_price[]'	:ItemPrice,
				'item_icon[]'	:ItemIcon,
				'item_color[]'	:ItemColor,

				},
			}).done(function(data, textStatus, jqXHR){
				$('#item_sort').html(data);
				$('.icon_picker,.color_picker').hide();

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

        }
	});

	$('#gp_sort').sortable({
		axis: 'y',
        handle: '.gp_handle',
		stop : function() {
			ChgList=$(this).sortable("toArray");
			var Cnt=ChgList.length;
			console.log(ChgList);

			var N=0;
			var ItemName	=[];
			var ItemPrice	=[];
			var ItemIcon	=[];
			var ItemColor	=[];

			for(i=0;i<Cnt;i++){
				ItemName[i]=$('#item_name_'+i).val();
				ItemPrice[i]=$('#item_price_'+i).val();
				ItemIcon[i]=$('#item_icon_hidden_'+i).val();
				ItemColor[i]=$('#item_color_hidden_'+i).val();
			}
			$.post({
				url:"./post/gp_sort.php",
				data:{
				'cast_id'		:CastId,
				'chglist[]'		:ChgList,
				'item_name[]'	:ItemName,
				'item_price[]'	:ItemPrice,
				'item_icon[]'	:ItemIcon,
				'item_color[]'	:ItemColor,

				},
			}).done(function(data, textStatus, jqXHR){
				$('#item_sort').html(data);
				$('.icon_picker,.color_picker').hide();

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
        }
	});

/*
	$('#item_set').on('click',function(){
		var Cnt=10;
		for(i=0;i<Cnt;i++){
			ItemName[i]=$('#item_name_'+i).val();
			ItemPrice[i]=$('#item_price_'+i).val();
			ItemIcon[i]=$('#item_icon_hidden_'+i).val();
			ItemColor[i]=$('#item_color_hidden_'+i).val();
		}

		$.post({
			url:"./post/log_item_set.php",
			data:{
			'cast_id'		:CastId,
			'chglist[]'		:ChgList,
			'item_name[]'	:ItemName,
			'item_price[]'	:ItemPrice,
			'item_icon[]'	:ItemIcon,
			'item_color[]'	:ItemColor,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});
*/

	$('#new_set').on('click',function(){
		$.post({
			url:"./post/log_item_new.php",
			data:{
			'cast_id'		:CastId,
			'price'			:$('#price_new').val(),
			'item_name'		:$('#name_new').val(),
			'item_icon'		:$('#icon_new').val(),
			'item_color'	:$('#color_new').val(),
			'sort'			:$('#item_count').val(),
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('#item_count').val(data.sort);
			$('#item_sort').append(data.html);
			$('.color_picker,.icon_picker').hide();
			$('#new_color').css('background','#008080');
			$('#new_icon').css('color','#008080');

			$('#price_new').val('0');
			$('#name_new').val('');
			$('#icon_new').val('0');
			$('#color_new').val('0');

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#sel_log_box').on('click','.sel_log_option',function(){
		colorS	=$(this).css('color');
		iconS	=$(this).children('.sel_log_icon').text();
		commS	=$(this).children('.sel_log_comm').text();
		priceS	=$(this).children('.sel_log_price').text();
		$('#sel_log_box').slideUp(100);
		$('.customer_log_right').append('<div class="sel_log_option_s" style="color:'+colorS+';border:1px solid '+colorS+'"><span class="sel_log_icon_s">'+iconS+'</span><span class="sel_log_comm_s">'+commS+'</span><span class="sel_log_price_s">'+priceS+'</span><span class="sel_log_del_s"></span></div>');
	});


/*
		$.post({
			url:"./post/log_select_set.php",
			data:{
			'cast_id'	:CastId,
			'color'		:$(this).css('color'),
			'icon'		:$(this).children('.sel_log_icon').text(),
			'comm'		:$(this).children('.sel_log_comm').text(),
			'price'		:$(this).children('.sel_log_price').text()
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
*/

	$('.customer_log_right').on('click','.sel_log_del_s',function(){
		$(this).parent().remove()
	});

	$('#sel_log_reset').on('click',function(){
		$('.set_back').fadeOut(200);
		$('.customer_log_right').empty();
		$('#sel_log_area').val('');
		$('.customer_log_in').animate({'top':'100vh'},200);
		Chg='';
	});

	$('#sel_log_set').on('click',function(){
		var N=0;
		var ItemName	=[];
		var ItemPrice	=[];
		var ItemIcon	=[];
		var ItemColor	=[];

		 $('.sel_log_option_s').each(function() {
			ItemColor[N]	=$(this).css('color');
			ItemIcon[N]		=$(this).children('.sel_log_icon_s').text();
			ItemName[N]		=$(this).children('.sel_log_comm_s').text();
			ItemPrice[N]	=$(this).children('.sel_log_price_s').text();
			N++;
		});

		$.post({
			url:"./post/customer_log_set.php",
			data:{

			'chg'	:Chg,
			'log'	:$('#sel_log_area').val(),
			'yy'	:$('#logset_yy').val(),
			'mm'	:$('#logset_mm').val(),
			'dd'	:$('#logset_dd').val(),

			'hh_s'	:$('#logset_hh_s').val(),
			'ii_s'	:$('#logset_ii_s').val(),

			'hh_e'	:$('#logset_hh_e').val(),
			'ii_e'	:$('#logset_ii_e').val(),

			'cast_id'	:CastId,
			'c_id'		:C_Id,
			'item_color[]'	:ItemColor,
			'item_icon[]'	:ItemIcon,
			'item_name[]'	:ItemName,
			'item_price[]'	:ItemPrice
			},
		}).done(function(data, textStatus, jqXHR){
			if(Chg){
				$('#customer_log_td_'+Chg).remove();
			}
			$('#tag_3_tbl').prepend(data);
			$('.set_back').fadeOut(200);
			$('.customer_log_right').empty();
			$('#sel_log_area').val('');
			$('.customer_log_in').animate({'top':'100vh'},200);
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#sel_log_del').on('click',function(){
		$('.customer_log_del_back_in').fadeIn(100);
	});

	$('#tag_3_tbl').on('click','.customer_log_del',function () {
		$('.set_back,.customer_log_del_back_in').fadeIn(100);
		Chg=$(this).attr('id').replace('l_del','');

	});

	$('#log_del_set').on('click',function () {
		$.post({
			url:"./post/customer_log_set.php",
			data:{
			'del'		:Chg,
			'cast_id'	:CastId,
			'c_id'		:C_Id
			},
		}).done(function(data, textStatus, jqXHR){
			$('#customer_log_td_'+Chg).remove();
			$('.set_back,.customer_log_del_back_in').fadeOut(200);
			$('.customer_log_right').empty();
			$('#sel_log_area').val('');
			$('.customer_log_in').animate({'top':'100vh'},200);
			Chg='';
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});

	});

	$('#log_del_back').on('click',function () {
		$('.customer_log_del_back_in').fadeOut(100);
		console.log($('.customer_log_in').css('top'));
		if($('.customer_log_in').css('top')>'300'){
			$('.set_back').fadeOut(100);
		}

	});

	$('#sel_log_main').on('click',function(){
		if($('#sel_log_box').css('display')=='none'){
			$('#sel_log_box').slideDown(200);

		}else{
			$('#sel_log_box').slideUp(200);
		}
	});

	$('.customer_sort_sel').on('change',function(){
		$.post({
			url:"./post/customer_sort.php",
			data:{
			'sel'		:$('#customer_sort_sel').val(),
			'fil'		:$('#customer_sort_fil').val(),
			'asc'		:$('#customer_sort_asc').val(),
			'ext'		:$('#customer_sort_ext').val(),
			'cast_id'	:CastId,
			},
		}).done(function(data, textStatus, jqXHR){
			$('.customer_all_in').html(data);
			$('#customer_sort_ext').val(CastId);
			console.log(CastId)
			if($('#customer_sort_fil').val() > 0){
				$('.sort_alert').show();
			}else{
				$('.sort_alert').hide();
			}
		});
	});

	$('.sort_btn_on0').on('click',function () {
		$('.sort_circle').animate({'left':'0vw'},200).css('border-radius','10px 0 0 10px');
		$('.sort_btn_on0').animate({'color':'#0000d0'},200);
		$('.sort_btn_on1').animate({'color':'#b0b0a0'},200);
		$('#customer_sort_asc').val('0');

		$.post({
			url:"./post/customer_sort.php",
			data:{
			'sel'		:$('#customer_sort_sel').val(),
			'fil'		:$('#customer_sort_fil').val(),
			'asc'		:$('#customer_sort_asc').val(),
			'ext'		:$('#customer_sort_ext').val(),
			'cast_id'	:CastId,
			},

		}).done(function(data, textStatus, jqXHR){
			$('.customer_all_in').html(data);
			$('#customer_sort_ext').val(CastId);
			if($('#customer_sort_fil').val() > 0){
				$('.sort_alert').show();
			}else{
				$('.sort_alert').hide();
			}
		});
	});

	$('.sort_btn_on1').on('click',function () {
		$('.sort_circle').animate({'left':'10vw'},200).css('border-radius','0 10px 10px 0');
		$('.sort_btn_on1').animate({'color':'#0000d0'},200);
		$('.sort_btn_on0').animate({'color':'#b0b0a0'},200);
		$('#customer_sort_asc').val('1');

		$.post({
			url:"./post/customer_sort.php",
			data:{
			'sel'		:$('#customer_sort_sel').val(),
			'fil'		:$('#customer_sort_fil').val(),
			'asc'		:$('#customer_sort_asc').val(),
			'ext'		:$('#customer_sort_ext').val(),
			'cast_id'	:CastId,
			},
		}).done(function(data, textStatus, jqXHR){
			$('.customer_all_in').html(data);
			$('#customer_sort_ext').val(CastId);
			if($('#customer_sort_fil').val() > 0){
				$('.sort_alert').show();
			}else{
				$('.sort_alert').hide();
			}
		});
	});

	$('.ana_detail').on('click',function () {
		TMP=$(this).attr('id');
		$('.ana_detail').removeClass('ana_on');
		$('.ana_arrow').removeClass('ana_arrow_on');
		$('.ana_list_div').slideUp(300);

		$('.ana_list').not('#l'+TMP).delay(300).fadeOut(0);

		if($('#d'+TMP).css('display')=='none'){
			$('#l'+TMP).show();
			$(this).addClass('ana_on');
			$(this).children('.ana_arrow').addClass('ana_arrow_on');
			$('#d'+TMP).slideDown(300);
		}else{
			$('#l'+TMP).delay(300).fadeOut(0);
		}
	});

	$('.tmpl_btn').on('click', function() {
		var bN = $(this).val();
		var Str_A = $('#tmpl_send').val();
		var Str_P = $('#tmpl_send').get(0).selectionStart;
		var Str_T = Str_A.substr(0, Str_P);
		var Str_B = Str_A.substr(Str_P, Str_A.length);
		var Str_A = $('#tmpl_send').val(Str_T + bN + Str_B);
	});

});
