$(function(){ 
	var Width_l	=$('.img_box_out2').width();
	var Width_s	=$('.img_box_out1').width();
	
	var Fav			=0;
	var cvs_A		=0;
	var Rote		=0;
	var Zoom		=100;
	var Zoom		=100;
	var Chg			='';

	Tmp=$('.main_mail').height();
	$('.main_mail').scrollTop(Tmp);

	$('#send_mail').on('click',function(){
		$.post({
			url:"./post/easytalk_send.php",
			data:{
				'send'		:'2',
				'cast_id'	:CastId,
				'log'		:$('#send_msg').val(),
				'sid'		:$('#ssid').val(),
				'img_code'	:$('#img_code').val(),
			},

		}).done(function(data, textStatus, jqXHR){
			$('.main_mail').append(data);
			$('#send_msg').val('');

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$(window).scroll(function () {
		if ($(this).scrollTop() < 50) {
			$.post({
				url:"./post/easytalk_hist.php",
				data:{
					'pg':$('#easytalk_page').val()
				},

			}).done(function(data, textStatus, jqXHR){
				Pg=$('#easytalk_page').val()-1+2;
				$('#easytalk_page').val(Pg);
				$('.mail_detail_in').prepend(data);
			});
		}
	});

	$('#upd').on('change', function(e){
		var file = e.target.files[0];	
		var reader = new FileReader();

		if(file.type.indexOf("image") < 0){
			alert("NO IMAGE FILES");
			return false;
		}
		Base_l=$(".img_box_out2").width();
		Base_s=$(".img_box_out1").width();

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
					img_S2=Base_l;

					if(img_H > img_W){
						cvs_W=600;
						cvs_H=img_H*(cvs_W/img_W);
						cvs_A=Math.ceil(cvs_H);

						cvs_X=(cvs_H-cvs_W)/2;
						cvs_Y=0;

						css_W=Base_l;
						css_H=img_H*(css_W/img_W);

						css_A=css_H;
						css_B=Base_s-(css_A-Base_l)/2;

					}else{
						cvs_H=600;
						cvs_W=img_W*(cvs_H/img_H);
						cvs_A=Math.ceil(cvs_W);

						cvs_Y=(cvs_W-cvs_H)/2;
						cvs_X=0;

						css_H=Base_l;
						css_W=img_W*(css_H/img_H);

						css_A=css_W;
						css_B=Base_s-(css_A-Base_l)/2;

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


	$('#img_set').on('click',function(){	
		if(ImgCode){
			$('#wait').show();
			$.post({
				url:"./post/img_set.php",
				data:{
					'img_code'		:ImgCode.replace(/^data:image\/jpeg;base64,/, ""),
					'img_top'		:ImgTop,
					'img_left'		:ImgLeft,
					'img_width'		:cvs_W,
					'img_height'	:cvs_H,
					'img_zoom'		:$('.zoom_box').text(),
					'img_rote'		:Rote,
					'width_s'		:Width_s,
					'width_l'		:Width_l,
				},
			}).done(function(data, textStatus, jqXHR){
				base_64=data;

				$('.img_box').animate({'top':'120vh'},200);
				var cvs = document.getElementById('cvs1');
				var ctx = cvs.getContext('2d');
				ctx.clearRect(0, 0, cvs_A,cvs_A);

				if(base_64){
					$('.mail_img_view').attr('src',"data:image/jpg;base64,"+base_64);
					$('#img_code').val(base_64);

				}else{
					$('.mail_img_view').attr('src','blog_no_image.png');
					$('#img_code').val('');

				}
				$('.set_back').fadeOut(200);	

				$('#wait').hide();
				$('.zoom_box').text('100');
				$('#input_zoom').val('100');
				Rote=0;

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

		}else{
			$('.img_box').animate({'top':'120vh'},200);
			var cvs = document.getElementById('cvs1');
			var ctx = cvs.getContext('2d');
			ctx.clearRect(0, 0, cvs_A,cvs_A);
			$('.set_back').fadeOut(200);
			$('#img_code').val('');
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
		$('.img_box	').animate({'top':'120vh'},200);

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

	$('#send_img').on('click',function(){
		$('.img_box').animate({'top':'10vw'},200);
		$('.set_back').fadeIn(100);
		$('#img_code').val('');
	});

	$('#img_close').on('click',function(){
		$('#img_code').val('')
		$('.img_box').animate({'top':'120vh'},200);
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, cvs_A,cvs_A);
		$('.set_back').fadeOut(200);
	});
});
